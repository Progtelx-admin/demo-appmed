<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use App\Models\Package;
use App\Models\Test;
use DataTables;
use Illuminate\Http\Request;

class TestsLibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('patient.tests_library.index');
    }

    /**
     * get analyses datatable
     *
     * @var @Request
     */
    public function get_analyses(Request $request)
    {
        $model = Test::where('parent_id', 0)->orWhere('separated', true);

        return DataTables::eloquent($model)->toJson();
    }

    /**
     * get cultures datatable
     *
     * @var @Request
     */
    public function get_cultures(Request $request)
    {
        $model = Culture::query();

        return DataTables::eloquent($model)->toJson();
    }

    /**
     * get packages datatable
     *
     * @var @Request
     */
    public function get_packages(Request $request)
    {
        $model = Package::query();

        return DataTables::eloquent($model)->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
