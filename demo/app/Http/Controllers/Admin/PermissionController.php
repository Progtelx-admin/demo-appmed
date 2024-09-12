<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Module;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view_permission',     ['only' => ['index', 'show']]);
        $this->middleware('can:create_permission',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_permission',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_permission',   ['only' => ['destroy', 'bulk_delete']]);
        // $this->middleware('can:create_group',   ['only' => ['create_tests']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::with('module')->get();
        return view('admin.permissions.index' , compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::with('module')->get();
        $modules = Module::all();
        return view('admin.permissions.create', compact('permissions','modules'));
    }

    public function createModule()
    {
        $modules = Module::all();
        return view('admin.permissions.createModule', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permissions = Permission::create($request->except('_token','_method','files'));
        session()->flash('success',__('Permission created successfully'));
        return redirect()->route('admin.permissions.index');

    }

    public function storeModule(Request $request)
    {
        $modules = Module::create($request->except('_token','_method','files'));
        session()->flash('success',__('Module created successfully'));
        return redirect()->route('admin.permissions.index');
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
        $permissions = Permission::findOrFail($id);
        $modules = Module::all();
        return view('admin.permissions.edit', compact('permissions','modules'));
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
        $permissions = Permission::findOrFail($id);
        $permissions->update($request->except('_token','_method','files'));

        session()->flash('success',__('Permission updated successfully'));

        return redirect()->route('admin.permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permissions = Permission::findOrFail($id);
        $permissions->delete();

        session()->flash('success',__('Permission deleted successfully'));

        return redirect()->route('admin.permissions.index');
    }
}
