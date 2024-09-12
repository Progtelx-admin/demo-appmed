<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\GroupTestResult;
use DataTables;
use Illuminate\Http\Request;

class BiochemistryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = microtime(true);
            $model = Group::query()
                ->with('patient', 'tests', 'all_tests', 'contract', 'signed_by_user', 'created_by_user')
                ->where('branch_id', session('branch_id'))
                ->whereHas('tests');

            if ($request['filter_status'] != '') {
                $model->where('done', $request['filter_status']);
            }
            if ($request['filter_result'] != '') {
                $model = GroupTestResult::query()->with('results')->where('status', $request['filter_result']);
            }
            if ($request['filter_uploaded_report'] != '') {
                $model->where('uploaded_report1', $request['filter_uploaded_report']);
            }
            if ($request['filter_sent_status'] != '') {
                $model->where('sent', $request['filter_sent_status']);
            }

            if ($request['filter_barcode'] != '') {
                $model->where('barcode', $request['filter_barcode']);
            }

            if ($request['filter_created_by'] != '') {
                $model->whereIn('created_by', $request['filter_created_by']);
            }

            if ($request['filter_signed_by'] != '') {
                $model->whereIn('signed_by', $request['filter_signed_by']);
            }

            if ($request['filter_signed_by2'] != '') {
                $model->whereIn('signed_by2', $request['filter_signed_by2']);
            }

            if ($request['filter_contract'] != '') {
                $model->whereIn('contract_id', $request['filter_contract']);
            }

            if ($request['filter_date'] != '') {
                //format date
                $date = explode('-', $request['filter_date']);
                $from = date('Y-m-d', strtotime($date[0]));
                $to = date('Y-m-d 23:59:59', strtotime($date[1]));

                //select groups of date between
                ($date[0] == $date[1]) ? $model->whereDate('created_at', $from) : $model->whereBetween('created_at', [$from, $to]);
            }

            // if($request['filter_date']!='')
            // {
            //     //format date
            //     $date=explode('-',$request['filter_date']);
            //     $from=date('Y-m-d',strtotime($date[0]));
            //     $to=date('Y-m-d 23:59:59',strtotime($date[1]));

            //     //select groups of date between
            //     ($date[0]==$date[1])?$model->whereDate('created_at',$from):$model->whereBetween('created_at',[$from,$to]);
            // }
            // else
            // {
            //     // set default filter to today's date
            //     $from = date('Y-m-d');
            //     $to = date('Y-m-d 23:59:59');

            //     $model->whereDate('created_at', $from);
            // }

            if ($request['filter_date2'] != '') {
                //format date
                $date = explode('-', $request['filter_date2']);
                $from = date('Y-m-d', strtotime($date[0]));
                $to = date('Y-m-d 23:59:59', strtotime($date[1]));

                //select groups of date between
                ($date[0] == $date[1]) ? $model->whereDate('updated_at', $from) : $model->whereBetween('updated_at', [$from, $to]);
            }

            return DataTables::eloquent($model)
                ->editColumn('patient.gender', function ($group) {
                    return __(ucwords($group['patient']['gender']));
                })
                ->editColumn('patient.dob', function ($group) {
                    return __(ucwords($group['patient']['dob']));
                })
                ->editColumn('tests', function ($group) {
                    return view('admin.biochemistrys._tests', compact('group'));
                })
                ->addColumn('signed', function ($group) {
                    return view('admin.medical_reports._signed', compact('group'));
                })
                ->addColumn('signed2', function ($group) {
                    return view('admin.medical_reports._signed2', compact('group'));
                })
                ->editColumn('uploaded_report1', function ($group) {
                    return view('admin.medical_reports._status3', compact('group'));
                })
                ->editColumn('done', function ($group) {
                    return view('admin.medical_reports._status', compact('group'));
                })
                ->editColumn('sent', function ($group) {
                    return view('admin.medical_reports._status2', compact('group'));
                })
                ->editColumn('called', function ($group) {
                    return view('admin.medical_reports._called', compact('group'));
                })
                ->addColumn('action', function ($group) {
                    return view('admin.medical_reports._action', compact('group'));
                })
                ->addColumn('bulk_checkbox', function ($item) {
                    return view('partials._bulk_checkbox', compact('item'));
                })
                ->editColumn('created_at', function ($group) {
                    return date('Y-m-d H:i', strtotime($group['created_at']));
                })
                ->editColumn('updated_at', function ($group) {
                    return date('Y-m-d H:i', strtotime($group['updated_at']));
                })
                ->toJson();
        }

        return view('admin.biochemistrys.index');
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

    public function upload_report(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if ($request->has('report')) {
            $report = $request->file('report');

            $report->move('uploaded_report/pdf', 'report_'.$group['id'].'.pdf');

            $group->update([
                'report_test_uploaded' => true,
                'report_uploaded' => url('uploaded_report/pdf/report_'.$group['id'].'.pdf'),
            ]);
        }

        session()->flash('success', __('Report uploaded successfully'));

        return redirect()->back();
    }

    public function confirm_report($id)
    {
        $group = Group::findOrFail($id);
        Group::where('id', $id)->update([
            'sent_test' => true,
        ]);

        session()->flash('success', __('Report Confirmed successfully'));

        return redirect()->back();
    }

    public function called_patient($id)
    {
        $group = Group::findOrFail($id);
        Group::where('id', $id)->update([
            'called_test' => true,
        ]);

        session()->flash('success', __('Call Confirmed successfully'));

        return redirect()->back();
    }
}
