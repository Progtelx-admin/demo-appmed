<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\CreateLaboratoryRequest;
use App\Http\Requests\Admin\UpdateLaboratoryRequest;
use App\Models\Laboratory;
use DataTables;
use Illuminate\Http\Request;

class LaboratoriesController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_laboratory', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_laboratory', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_laboratory', ['only' => ['edit', 'updae']]);
        $this->middleware('can:delete_laboratory', ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.laboratories.index');
    }

    /**
     * get users datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        // $model=Laboratory::query()->with('ResultDetailPK');
        $model = Laboratory::withTrashed();

        return DataTables::eloquent($model)
        // ->addColumn('action',function($laboratory){
        //     return view('admin.laboratories._action',compact('laboratory'));
        // })
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
        return view('admin.laboratories.create', compact('ResultDetailPK'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateLaboratoryRequest $request)
    {
        //create new user
        $laboratory = new Laboratory;
        $laboratory->ResultDetailPK = $request->ResultDetailPK;
        $laboratory->ResultMasterFK = $request->ResultMasterFK;
        $laboratory->AnalyzerNo = $request->AnalyzerNo;
        $laboratory->SampleNo = $request->SampleNo;
        $laboratory->ResultTransferDtTm = $request->ResultTransferDtTm;
        $laboratory->ResultAnalysisDtTm = $request->ResultAnalysisDtTm;
        $laboratory->AnalyzerTestParam = $request->AnalyzerTestParam;
        $laboratory->ResultValue = $request->ResultValue;
        $laboratory->ResultValue2 = $request->ResultValue2;
        $laboratory->ResultValueFlag = $request->ResultValueFlag;
        $laboratory->SampleType = $request->SampleType;
        $laboratory->ResultUnit = $request->ResultUnit;
        $laboratory->ReferenceRange = $request->ReferenceRange;
        $laboratory->IsResultValueRead = $request->IsResultValueRead;
        $laboratory->LIMSTestParam = $request->LIMSTestParam;
        $laboratory->LIMSData1 = $request->LIMSData1;
        $laboratory->LIMSData2 = $request->LIMSData2;
        $laboratory->LIMSData3 = $request->LIMSData3;
        $laboratory->save();

        session()->flash('success', __('Laboratory created successfully'));

        return redirect()->route('admin.laboratories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ResultDetailPK)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($ResultDetailPK)
    {
        $laboratory = Laboratory::findOrFail($ResultDetailPK);

        return view('admin.laboratories.edit', compact('laboratory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLaboratoryRequest $request, $ResultDetailPK)
    {
        //update laboratory
        $laboratory = Laboratory::findOrFail($ResultDetailPK);
        $laboratory->ResultMasterFK = $request->ResultMasterFK;
        $laboratory->AnalyzerNo = $request->AnalyzerNo;
        $laboratory->SampleNo = $request->SampleNo;
        $laboratory->ResultTransferDtTm = $request->ResultTransferDtTm;
        $laboratory->ResultAnalysisDtTm = $request->ResultAnalysisDtTm;
        $laboratory->AnalyzerTestParam = $request->AnalyzerTestParam;
        $laboratory->ResultValue = $request->ResultValue;
        $laboratory->ResultValue2 = $request->ResultValue2;
        $laboratory->ResultValueFlag = $request->ResultValueFlag;
        $laboratory->SampleType = $request->SampleType;
        $laboratory->ResultUnit = $request->ResultUnit;
        $laboratory->ReferenceRange = $request->ReferenceRange;
        $laboratory->IsResultValueRead = $request->IsResultValueRead;
        $laboratory->LIMSTestParam = $request->LIMSTestParam;
        $laboratory->LIMSData1 = $request->LIMSData1;
        $laboratory->LIMSData2 = $request->LIMSData2;
        $laboratory->LIMSData3 = $request->LIMSData3;
        $user->save();

        session()->flash('success', __('Laboratory updated successfully'));

        return redirect()->route('admin.laboratories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($ResultDetailPK)
    {
        if ($ResultDetailPK == 1) {
            session()->flash('failed', __('You can\'t delete super admin user'));

            return redirect()->back();
        }

        $laboratory = Laboratory::findorFail($ResultDetailPK);

        //delete user finally

        $laboratory->delete();

        session()->flash('success', __('Laboratory deleted successfully'));

        return redirect()->route('admin.laboratories.index');
    }

    /**
     * Bulk delete
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_delete(BulkActionRequest $request)
    {
        foreach ($request['ids'] as $ResultDetailPK) {
            if ($ResultDetailPK != 1) {
                $laboratory = Laboratory::find($ResultDetailPK);
                //delete user finally
                $laboratory->delete();
            }
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.laboratories.index');
    }
}
