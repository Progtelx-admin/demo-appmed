<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DoctorExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\DoctorRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Imports\DoctorImport;
use App\Models\Doctor;
use DataTables;
use Excel;
use Illuminate\Http\Request;

class DoctorsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_doctor', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_doctor', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_doctor', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_doctor', ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.doctors.index');
    }

    /**
     * get antibiotics datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = Doctor::query();

        return DataTables::eloquent($model)
            ->editColumn('commission', function ($doctor) {
                return $doctor['commission'].'%';
            })
            ->editColumn('total', function ($doctor) {
                return formated_price($doctor['total']);
            })
            ->editColumn('paid', function ($doctor) {
                return formated_price($doctor['paid']);
            })
            ->editColumn('due', function ($doctor) {
                return view('admin.doctors._due', compact('doctor'));
            })
            ->addColumn('action', function ($doctor) {
                return view('admin.doctors._action', compact('doctor'));
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
        return view('admin.doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request)
    {
        $request['code'] = doctor_code('code');

        Doctor::create($request->except('_token', '_method'));

        session()->flash('success', __('Doctor created successfully'));

        return redirect()->route('admin.doctors.index');
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
        $doctor = Doctor::findOrFail($id);

        return view('admin.doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorRequest $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->except('_token', '_method'));

        session()->flash('success', __('Doctor updated successfully'));

        return redirect()->route('admin.doctors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        session()->flash('success', __('Doctor deleted successfully'));

        return redirect()->route('admin.doctors.index');
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
            $doctor = Doctor::find($id);
            $doctor->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.doctors.index');
    }

    /**
     * Export doctors
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export()
    {

        return Excel::download(new DoctorExport, 'doctors.xlsx');
    }

    /**
     * Import doctors
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {

            Excel::import(new DoctorImport, $request->file('import'));
        }

        session()->flash('success', __('Doctor imported successfully'));

        return redirect()->back();
    }

    /**
     * Download doctors template
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download_template()
    {

        return response()->download(storage_path('app/public/doctors_template.xlsx'), 'doctors_template.xlsx');
    }
}
