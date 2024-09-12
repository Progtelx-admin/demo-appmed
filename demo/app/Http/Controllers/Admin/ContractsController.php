<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ContractRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Imports\ContractPriceImport;
use App\Models\Contract;
use App\Models\ContractPrice;
use App\Models\Culture;
use App\Models\Package;
use App\Models\Service;
use App\Models\Test;
use DataTables;
use Excel;
use Illuminate\Http\Request;

class ContractsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_contract', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_contract', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_contract', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_contract', ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.contracts.index');
    }

    /**
     * get antibiotics datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = Contract::query();

        return DataTables::eloquent($model)
            ->editColumn('discount', function ($contract) {
                return $contract['discount'].' %';
            })
            ->addColumn('action', function ($contract) {
                return view('admin.contracts._action', compact('contract'));
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
        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $packages = Package::all();
        $services = Service::all();

        return view('admin.contracts.create', compact('tests', 'cultures', 'packages', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request)
    {
        $contract = Contract::create([
            'title' => $request['title'],
            'pantheon_bp' => $request['pantheon_bp'],
            'short_description' => $request['short_description'],
            'description' => $request['description'],
            'discount_type' => $request['discount_type'],
            'discount_percentage' => $request['discount_percentage'],
        ]);

        if ($request->has('tests')) {
            foreach ($request['tests'] as $id => $price) {
                $contract->tests()->create([
                    'priceable_type' => \App\Models\Test::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $id => $price) {
                $contract->cultures()->create([
                    'priceable_type' => \App\Models\Culture::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }

        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $id => $price) {
                $contract->antibiotics()->create([
                    'priceable_type' => \App\Models\Antibiotic::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }

        if ($request->has('packages')) {
            foreach ($request['packages'] as $id => $price) {
                $contract->packages()->create([
                    'priceable_type' => \App\Models\Package::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }

        if ($request->has('services')) {
            foreach ($request['services'] as $id => $price) {
                $contract->services()->create([
                    'priceable_type' => \App\Models\Service::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }

        session()->flash('success', __('Contract created successfully'));

        return redirect()->route('admin.contracts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contract = Contract::findOrFail($id);

        return view('admin.contracts.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContractRequest $request, $id)
    {
        $contract = Contract::findOrFail($id);
        $contract->update([
            'title' => $request['title'],
            'pantheon_bp' => $request['pantheon_bp'],
            'short_description' => $request['short_description'],
            'description' => $request['description'],
            'discount_type' => $request['discount_type'],
            'discount_percentage' => $request['discount_percentage'],
        ]);

        $contract->tests()->delete();
        if ($request->has('tests')) {
            foreach ($request['tests'] as $id => $price) {
                $contract->tests()->create([
                    'priceable_type' => \App\Models\Test::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }

        $contract->cultures()->delete();
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $id => $price) {
                $contract->cultures()->create([
                    'priceable_type' => \App\Models\Culture::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }
        $contract->antibiotics()->delete();
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $id => $price) {
                $contract->antibiotics()->create([
                    'priceable_type' => \App\Models\Antibiotic::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }

        $contract->packages()->delete();
        if ($request->has('packages')) {
            foreach ($request['packages'] as $id => $price) {
                $contract->packages()->create([
                    'priceable_type' => \App\Models\Package::class,
                    'priceable_id' => $id,
                    'price' => $price,
                ]);
            }
        }

        //   $contract->services()->delete();
        //   if($request->has('services'))
        //   {
        //       foreach($request['services'] as $id=>$price)
        //       {
        //           $contract->services()->create([
        //               'priceable_type'=>'App\Models\Service',
        //               'priceable_id'=>$id,
        //               'price'=>$price
        //           ]);
        //       }
        //   }

        $contract->services()->delete();
        if ($request->has('services')) {
            foreach ($request['services'] as $id => $price) {
                $contract->services()->create([
                    'priceable_type' => \App\Models\Service::class,
                    'priceable_id' => $id,
                ], [
                    'price' => $price,
                ]);
            }
        } else {
            // Use all services as default if none are provided in the request
            $defaultServices = Service::all(); // Retrieve all services from the database
            foreach ($defaultServices as $service) {
                // Assuming you have a default price or the service model includes a price field
                $defaultPrice = $service->price; // Or use a predefined default price if necessary
                $contract->services()->create([
                    'priceable_type' => \App\Models\Service::class,
                    'priceable_id' => $service->id,
                ], [
                    'price' => $defaultPrice,
                ]);
            }
        }

        session()->flash('success', __('Contract updated successfully'));

        return redirect()->route('admin.contracts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->prices()->delete();
        $contract->delete();

        session()->flash('success', __('Contract deleted successfully'));

        return redirect()->route('admin.contracts.index');
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
            $contract = Contract::findOrFail($id);
            $contract->prices()->delete();
            $contract->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.contracts.index');
    }

    public function import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {

            Excel::import(new ContractPriceImport, $request->file('import'));
        }

        session()->flash('success', __('Prices imported successfully'));

        return redirect()->back();
    }

    // get price from Test Culture Package Service TABLE*
    public function updateAllContractPrices()
    {
        // Updating Test prices with specific conditions
        Test::where('parent_id', 0)->orWhere('separated', true)->each(function ($test) {
            ContractPrice::where('priceable_type', \App\Models\Test::class)
                ->where('priceable_id', $test->id)
                ->update(['price' => $test->price]);
        });

        // Entities without the `parent_id` condition and their corresponding class names
        $priceableEntitiesWithoutParentId = [
            \App\Models\Culture::class => Culture::class,
            \App\Models\Package::class => Package::class,
            \App\Models\Service::class => Service::class,
        ];

        // Updating prices for Culture Package and Service
        foreach ($priceableEntitiesWithoutParentId as $type => $modelClass) {
            $modelClass::all()->each(function ($instance) use ($type) {
                ContractPrice::where('priceable_type', $type)
                    ->where('priceable_id', $instance->id)
                    ->update(['price' => $instance->price]);
            });
        }

        // Optionally, add a response or a message indicating the operation's completion
        session()->flash('success', 'Contract prices updated successfully.');

        return redirect()->back();
    }
}
