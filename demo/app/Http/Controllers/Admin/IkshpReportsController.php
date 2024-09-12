<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group1\Group;
use App\Models\Group1\Test;
use DataTables;
use Illuminate\Http\Request;

class IkshpReportsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_medical_report', ['only' => ['index', 'show']]);
        $this->middleware('can:create_mediacl_report', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_medical_report', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_medical_report', ['only' => ['destroy', 'bulk_delete']]);
        $this->middleware('can:sign_medical_report', ['only' => ['sign']]);
        $this->middleware('can:sign_medical_report2', ['only' => ['sign2']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = Group::query()
                ->with('patient', 'tests', 'all_tests', 'cultures', 'contract', 'signed_by_user', 'created_by_user')
                ->where('branch_id', session('branch_id'));

            if ($request['filter_status'] != '') {
                $model->where('done', $request['filter_status']);
            }
            if ($request['filter_tests'] != '') {
                $model = Test::query()
                    ->with('patient', 'created_by_user', 'signed_by_user', 'all_tests', 'cultures')
                    ->join('group_tests', 'tests.id', '=', 'group_tests.test_id')
                    ->join('groups', 'groups.id', '=', 'group_tests.group_id')
                    ->select('groups.*', 'groups.id', 'groups.branch_id', 'groups.patient_id')
                    ->where('tests.name', 'LIKE', '%'.$request['filter_tests'].'%')
                    ->where('branch_id', session('branch_id'))
                    ->withTrashed();

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
                    return view('admin.ikshp_reports._tests', compact('group'));
                })
                ->editColumn('done', function ($group) {
                    return view('admin.ikshp_reports._status', compact('group'));
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

        return view('admin.ikshp_reports.index');
    }
}
