<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AntibioticExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Http\Requests\Admin\ServicesRequest;
use App\Imports\AntibioticImport;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Service;
use App\Models\ServicePrice;
use DataTables;
use Excel;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_service', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_service', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_service', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_service', ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.services.index');
    }

    /**
     * get antibiotics datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = Service::query();

        return DataTables::eloquent($model)
            ->addColumn('action', function ($service) {
                return view('admin.services._action', compact('service'));
            })
            ->addColumn('action', function ($service) {
                return view('admin.services._action', compact('service'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(ServicesRequest $request)
    // {
    //     Service::create($request->except('_token'));
    //     session()->flash('success','Service saved successfully');
    //     return redirect()->route('admin.services.index');
    // }
    public function store(ServicesRequest $request)
    {
        $branches = Branch::all();

        $service = Service::create($request->except('_token'));

        //assign prices to branches
        foreach ($branches as $branch) {
            ServicePrice::create([
                'branch_id' => $branch['id'],
                'service_id' => $service['id'],
                'price' => $request['price'],
            ]);
        }

        //contracts prices
        $contracts = Contract::all();
        foreach ($contracts as $contract) {
            $contract->cultures()->create([
                'priceable_type' => \App\Models\Service::class,
                'priceable_id' => $service['id'],
                'price' => ($contract['discount_type'] == 1) ? ($service['price'] * $contract['discount_percentage'] / 100) : $service['price'],
            ]);
        }

        session()->flash('success', 'Service saved successfully');

        return redirect()->route('admin.services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $service = Service::findOrFail($id);
        $currentCategoryId = $service->category_id;

        return view('admin.services.edit', compact('service', 'categories', 'currentCategoryId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServicesRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->except('_token', '_method'));
        session()->flash('success', 'Antibiotic updated successfully');

        return redirect()->route('admin.services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        session()->flash('success', 'Service deleted successfully');

        return redirect()->route('admin.services.index');
    }

    /**
     * Export antibiotics
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export()
    {
        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download(new AntibioticExport, 'antibiotics.xlsx');
    }

    /**
     * Import antibiotics
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(ExcelImportRequest $request)
    {
        Antibiotic::truncate();

        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this
            Excel::import(new AntibioticImport, $request->file('import'));
        }

        session()->flash('success', __('Antibiotics imported successfully'));

        return redirect()->back();
    }

    /**
     * Download antibiotics template
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download_template()
    {
        ob_end_clean(); // this
        ob_start(); // and this

        return response()->download(storage_path('app/public/antibiotics_template.xlsx'), 'antibiotics_template.xlsx');
    }

    /**
     * Bulk delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(BulkActionRequest $request)
    {
        foreach ($request['ids'] as $id) {
            $antibiotic = Antibiotic::findOrFail($id);
            $antibiotic->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.antibiotics.index');
    }
}
