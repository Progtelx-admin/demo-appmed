<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\CreateInstrumentRequest;
use App\Http\Requests\Admin\UpdateInstrumentRequest;
use App\Models\Branch;
use App\Models\Instrument;
use App\Models\InstrumentBranch;
use DataTables;
use Illuminate\Http\Request;

class InstrumentsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_instrument', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_instrument', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_instrument', ['only' => ['edit', 'updae']]);
        $this->middleware('can:delete_instrument', ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.instruments.index');
    }

    /**
     * get users datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = Instrument::query()->with('branches');

        return DataTables::eloquent($model)
            ->addColumn('branches', function ($instrument) {
                return view('admin.instruments._branches', compact('instrument'));
            })
            ->addColumn('action', function ($instrument) {
                return view('admin.instruments._action', compact('instrument'));
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
        $branches = Branch::all();

        return view('admin.instruments.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInstrumentRequest $request)
    {
        //create new user
        $instrument = new Instrument;
        $instrument->name = $request->name;
        $instrument->model = $request->model;
        $instrument->comment = $request->comment;
        $instrument->save();

        //assign roles to user

        if ($request->has('branches')) {
            foreach ($request['branches'] as $branch) {
                InstrumentBranch::firstOrCreate([
                    'instrument_id' => $instrument['id'],
                    'branch_id' => $branch,
                ]);

            }
        }

        session()->flash('success', __('Instrument created successfully'));

        return redirect()->route('admin.instruments.index');
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
        $instrument = Instrument::findOrFail($id);
        $branches = Branch::all();

        return view('admin.instruments.edit', compact('instrument', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInstrumentRequest $request, $id)
    {
        //update user
        $instrument = Instrument::findOrFail($id);
        $instrument->name = $request->name;
        $instrument->model = $request->model;
        $instrument->comment = $request->comment;
        $user->save();

        if ($instrument['id'] != 1) {

            //assign branches for user
            $instrument->branches()->delete();

            if ($request->has('branches')) {
                foreach ($request['branches'] as $branch) {
                    $instrument->branches()->create([
                        'instrument_id' => $instrument['id'],
                        'branch_id' => $branch,
                    ]);
                }
            }
        }

        session()->flash('success', __('Instrument updated successfully'));

        return redirect()->route('admin.instruments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            session()->flash('failed', __('You can\'t delete super admin user'));

            return redirect()->back();
        }

        $instrument = Instrument::findorFail($id);

        //delete user finally
        $instrument->branches()->delete();
        $instrument->delete();

        session()->flash('success', __('Instrument deleted successfully'));

        return redirect()->route('admin.instruments.index');
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
            if ($id != 1) {
                $instrument = Instrument::find($id);
                //delete user finally
                $instrument->branches()->delete();
                $instrument->delete();
            }
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.instruments.index');
    }
}
