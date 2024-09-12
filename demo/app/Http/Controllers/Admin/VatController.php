<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Models\Vat;
use DataTables;

class VatController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:view_vat',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_vat',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_vat',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_vat',   ['only' => ['destroy','bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            $model=Vat::query();

            return DataTables::eloquent($model)
            ->addColumn('action',function($vat){
                return view('admin.vat._action',compact('vat'));
            })
            ->addColumn('bulk_checkbox',function($item){
                return view('partials._bulk_checkbox',compact('item'));
            })
            ->toJson();
        }
       
        return view('admin.vat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vat = Vat::all();
        return view('admin.vat.create', compact('vat'));        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vat=Vat::create($request->except('_token','_method','files'));

        session()->flash('success',__('Vat created successfully'));

        return redirect()->route('admin.vat.index');
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
        $vat=Vat::findOrFail($id);
        return view('admin.vat.edit', compact('vat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vat=Vat::findOrFail($id);
        $vat->update($request->except('_token','_method','files'));

        session()->flash('success',__('Vat updated successfully'));

        return redirect()->route('admin.vat.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vat=Vat::findOrFail($id);
        $vat->delete();

        session()->flash('success',__('Vat deleted successfully'));

        return redirect()->route('admin.vat.index');
    }
}