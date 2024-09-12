<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\UpdateCultureResultRequest;
use App\Http\Requests\Admin\UploadReportRequest;
use App\Models\Antibiotic;
use App\Models\Category;
use App\Models\Group;
use App\Models\GroupCulture;
use App\Models\GroupCultureOption;
use App\Models\GroupCultureResult;
use App\Models\GroupTest;
use App\Models\GroupTestResult;
use App\Models\GroupMicrobiologyTest;
use App\Models\MicrobiologyTestOption;
use App\Models\GroupMicrobiologyTestResult;
use App\Models\GroupMicrobiologyTestAntibioticResult;
use App\Models\Laboratory;
use App\Models\Patient;
use App\Models\Test;
use App\Models\MicrobiologyTest;
use App\Models\TestOption;
use DataTables;
use Illuminate\Http\Request;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class MedicalReportsController extends Controller
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
        $this->middleware('can:sign_medical_report3', ['only' => ['sign3']]);
        $this->middleware('can:sign_medical_report4', ['only' => ['sign4']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  ->where('created_at', '>', now()->subDays(30)->endOfDay())
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $model = microtime(true);
            $model = Group::query()
                ->with('patient', 'all_tests', 'tests', 'cultures', 'all_cultures', 'microbiology_tests', 'all_microbiology_tests', 'contract', 'signed_by_user', 'created_by_user')
                ->where('branch_id', session('branch_id'));

            //                      ->
            // whereHas('all_tests', function($query) {
            //         $query->where('category_id', 2);
            // });

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
                    return view('admin.medical_reports._tests', compact('group'));
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

        return view('admin.medical_reports.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::where('branch_id', session('branch_id'))
            ->findOrFail($id);
        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();

        return view('admin.medical_reports.show', compact('group', 'next', 'previous'));
    }

    public function show2($id)
    {
        $group = Group::where('branch_id', session('branch_id'))
            ->findOrFail($id);
        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();

        return view('admin.medical_reports.show2', compact('group', 'next', 'previous'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete group
        $group = Group::findOrFail($id);
        $group->payments()->delete();

        //delete group tests
        $group_tests = GroupTest::where('group_id', $id)->get();

        //delete test results
        foreach ($group_tests as $group_test) {
            GroupTestResult::where('group_test_id', $group_test['id'])->delete();
        }
        GroupTest::where('group_id', $id)->delete();

        //delete group cultures
        $group_cultures = GroupCulture::where('group_id', $id)->get();
        foreach ($group_cultures as $group_culture) {
            GroupCultureResult::where('group_culture_id', $group_culture['id'])->delete();
        }
        GroupCulture::where('group_id', $id)->delete();

        //delete packages
        $group->packages()->delete();

        //delete consumption
        $group->consumptions()->delete();

        //delete group
        $group->delete();

        //return success
        session()->flash('success', __('Medical report deleted successfully'));

        return redirect()->route('admin.medical_reports.index');
    }

    /**
     * Generate report pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf']);
        }

        //set null if no analysis or cultures selected
        if (empty($request['tests'])) {
            $request['tests'] = [-1];
        }
        if (empty($request['cultures'])) {
            $request['cultures'] = [-1];
        }

        //categories
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->whereIn('id', $request['tests'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->whereIn('id', $request['cultures'])->get();
        }

        //find group
        $group = Group::with([
            'all_tests' => function ($q) use ($request) {
                return $q->whereIn('id', $request['tests']);
            },
            'all_cultures' => function ($q) use ($request) {
                return $q->whereIn('id', $request['cultures']);
            },
        ])->where('id', $id)->first();

        //generate pdf
        $data = ['group' => $group, 'categories' => $categories];
        $pdf = generate_pdf($data);

        return redirect($pdf); //return pdf url
    }

    /**
     * Generate report 2 pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf2(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf2']);
        }

        //set null if no analysis or cultures selected
        if (empty($request['tests'])) {
            $request['tests'] = [-1];
        }
        if (empty($request['cultures'])) {
            $request['cultures'] = [-1];
        }

        //categories
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->whereIn('id', $request['tests'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->whereIn('id', $request['cultures'])->get();
        }

        //find group
        $group = Group::with([
            'all_tests' => function ($q) use ($request) {
                return $q->whereIn('id', $request['tests']);
            },
            'all_cultures' => function ($q) use ($request) {
                return $q->whereIn('id', $request['cultures']);
            },
        ])->where('id', $id)->first();

        //generate pdf
        $data = ['group' => $group, 'categories' => $categories];
        $pdf2 = generate_pdf2($data);

        return redirect($pdf2); //return pdf url
    }

    /**
     * Generate report 3 pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf3(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf3']);
        }

        //set null if no analysis or cultures selected
        if (empty($request['tests'])) {
            $request['tests'] = [-1];
        }
        if (empty($request['cultures'])) {
            $request['cultures'] = [-1];
        }

        //categories
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->whereIn('id', $request['tests'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->whereIn('id', $request['cultures'])->get();
        }

        //find group
        $group = Group::with([
            'all_tests' => function ($q) use ($request) {
                return $q->whereIn('id', $request['tests']);
            },
            'all_cultures' => function ($q) use ($request) {
                return $q->whereIn('id', $request['cultures']);
            },
        ])->where('id', $id)->first();

        //generate pdf
        $data = ['group' => $group, 'categories' => $categories];
        $pdf3 = generate_pdf3($data);

        return redirect($pdf3); //return pdf url
    }

    public function pdf4(Request $request, $id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf4']);
        }

        //set null if no analysis or cultures selected
        if (empty($request['tests'])) {
            $request['tests'] = [-1];
        }
        if (empty($request['cultures'])) {
            $request['cultures'] = [-1];
        }

        //categories
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->whereIn('id', $request['tests'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->whereIn('id', $request['cultures'])->get();
        }

        //find group
        $group = Group::with([
            'all_tests' => function ($q) use ($request) {
                return $q->whereIn('id', $request['tests']);
            },
            'all_cultures' => function ($q) use ($request) {
                return $q->whereIn('id', $request['cultures']);
            },
        ])->where('id', $id)->first();

        //generate pdf
        $data = ['group' => $group, 'categories' => $categories];
        $pdf4 = generate_pdf4($data);

        return redirect($pdf4); //return pdf url
    }

    /**
     * Print report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_report($id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf']);
        }

        $categories = Category::get();
        $groupTests = GroupTest::where('group_id', $group['id'])->get();
        $groupCultures = GroupCulture::where('group_id', $group['id'])->get();

        foreach ($categories as $category) {
            $tests = $groupTests->where('test.category_id', $category['id'])->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['tests'] = $tests;

            $category['cultures'] = $groupCultures->where('culture.category_id', $category['id']);
        }

        $pdf = generate_pdf([
            'categories' => $categories,
            'group' => $group,
        ]);

        if (isset($pdf)) {
            $group->update(['report_pdf' => $pdf]);
        }

        return redirect($pdf); //return pdf url
    }

    public function print_report5($id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf2']);
        }

        //generate pdf
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();
        }

        $pdf2 = generate_pdf2([
            'categories' => $categories,
            'group' => $group,
        ]);

        if (isset($pdf2)) {
            $group->update(['report_pdf2' => $pdf2]);
        }

        return redirect($pdf2); //return pdf url
    }

    /**
     * Print report gr
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_reportgr($id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf3']);
        }

        //generate pdf
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();
        }

        $pdf3 = generate_pdf3([
            'categories' => $categories,
            'group' => $group,
        ]);

        if (isset($pdf3)) {
            $group->update(['report_pdf3' => $pdf3]);
        }

        return redirect($pdf3); //return pdf url
    }

    /**
     * Print report gr2
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_reportgr2($id)
    {
        $group = Group::findOrFail($id);

        if ($group['uploaded_report']) {
            return redirect($group['report_pdf3']);
        }

        //generate pdf
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();
        }

        $pdf4 = generate_pdf4([
            'categories' => $categories,
            'group' => $group,
        ]);

        if (isset($pdf3)) {
            $group->update(['report_pdf3' => $pdf4]);
        }

        return redirect($pdf4); //return pdf url
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // OLD BEFOR LARAVEL 9
    // public function edit($id)
    // {
    //     // $group=microtime(true);
    //     // $group=Group::with(['all_tests'=>function($q){
    //     //                 return $q->with('test.components');
    //     //             },'all_cultures'])->where('id',$id)
    //     //             ->where('branch_id',session('branch_id'))
    //     //             ->firstOrFail();

    //     $group = Group::with('all_tests.test.components', 'all_cultures')->where('id', $id)->where('branch_id', session('branch_id'))->firstOrFail();

    //     $laboratories = Laboratory::select(['SampleNo', 'LIMSTestParam', 'ResultValue', 'ResultTransferDtTm'])->join('tests', 'tests.id', '=', 'LIMSTestParam')->where('SampleNo', '=', $group['barcode'])->withTrashed()->get('ResultValue', 'ResultTransferDtTm');

    //     $select_antibiotics = Antibiotic::all();
    //     $categories = Category::where('category', 'Antibiotik')->get();

    //     $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
    //     $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();

    //     return view('admin.medical_reports.edit', compact('group', 'select_antibiotics', 'next', 'previous', 'laboratories', 'categories'));
    // }



    public function edit($id)
    {
        $group = Group::with('all_tests.test.components', 'all_cultures', 'patient','all_microbiology_tests.microbiologyTest.components')->where('id', $id)->where('branch_id', session('branch_id'))->firstOrFail();

        $patientId = $group->patient_id;

        $patientGroups = Group::with(['all_tests.results' => function ($query) {
            $query->with(['component']);
        }])->where('patient_id', $patientId)->get();

        $laboratories = Laboratory::select(['SampleNo', 'LIMSTestParam', 'ResultValue', 'ResultTransferDtTm'])->join('tests', 'tests.id', '=', 'LIMSTestParam')->where('SampleNo', '=', $group['barcode'])->withTrashed()->get('ResultValue', 'ResultTransferDtTm');

        $select_antibiotics = Antibiotic::all();
        $categories = Category::where('category', 'Antibiotik')->get();

        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();

        return view('admin.medical_reports.edit', compact('group', 'select_antibiotics', 'next', 'previous', 'laboratories','categories'));
    }

    public function editBiochemistry($id)
    {

        $group = Group::with('all_tests.test.components', 'all_cultures')->where('id', $id)->where('branch_id', session('branch_id'))->firstOrFail();

        $laboratories = Laboratory::select(['SampleNo', 'LIMSTestParam', 'ResultValue', 'ResultTransferDtTm'])->join('tests', 'tests.id', '=', 'LIMSTestParam')->where('SampleNo', '=', $group['barcode'])->withTrashed()->get('ResultValue', 'ResultTransferDtTm');

        $select_antibiotics = Antibiotic::all();
        $antibiotics = Antibiotic::all();
        $all_antibiotics = Antibiotic::all();

        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();
        $categories = Category::where('category', 'Antibiotik')->get();

        return view('admin.medical_reports.edit_biochemistry', compact('group', 'select_antibiotics', 'next', 'previous', 'laboratories', 'categories', 'antibiotics', 'all_antibiotics'));
    }

    public function editBlood($id)
    {
        $group = Group::with('all_tests.test.components', 'all_cultures')->where('id', $id)->where('branch_id', session('branch_id'))->firstOrFail();

        $laboratories = Laboratory::select(['SampleNo', 'LIMSTestParam', 'ResultValue', 'ResultTransferDtTm'])->join('tests', 'tests.id', '=', 'LIMSTestParam')->where('SampleNo', '=', $group['barcode'])->withTrashed()->get('ResultValue', 'ResultTransferDtTm');

        $select_antibiotics = Antibiotic::all();
        $antibiotics = Antibiotic::all();
        $all_antibiotics = Antibiotic::all();

        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();
        $categories = Category::where('category', 'Antibiotik')->get();

        return view('admin.medical_reports.edit_blood', compact('group', 'select_antibiotics', 'next', 'previous', 'laboratories', 'categories', 'antibiotics', 'all_antibiotics'));
    }

    public function editPCR($id)
    {
        $group = Group::with('all_tests.test.components', 'all_cultures')->where('id', $id)->where('branch_id', session('branch_id'))->firstOrFail();

        $laboratories = Laboratory::select(['SampleNo', 'LIMSTestParam', 'ResultValue', 'ResultTransferDtTm'])->join('tests', 'tests.id', '=', 'LIMSTestParam')->where('SampleNo', '=', $group['barcode'])->withTrashed()->get('ResultValue', 'ResultTransferDtTm');

        $select_antibiotics = Antibiotic::all();
        $antibiotics = Antibiotic::all();
        $all_antibiotics = Antibiotic::all();

        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();
        $categories = Category::where('category', 'Antibiotik')->get();

        return view('admin.medical_reports.edit_pcr', compact('group', 'select_antibiotics', 'next', 'previous', 'laboratories', 'categories', 'antibiotics', 'all_antibiotics'));
    }

    public function editMicrobiology($id)
    {

        // $group=microtime(true);
        // $group=Group::with(['all_tests'=>function($q){
        //                 return $q->with('test.components');
        //             },'all_cultures'])->where('id',$id)
        //             ->where('branch_id',session('branch_id'))
        //             ->firstOrFail();

        $group = Group::with('all_tests.test.components', 'all_cultures')->where('id', $id)->where('branch_id', session('branch_id'))->firstOrFail();

        $laboratories = Laboratory::select(['SampleNo', 'LIMSTestParam', 'ResultValue', 'ResultTransferDtTm'])->join('tests', 'tests.id', '=', 'LIMSTestParam')->where('SampleNo', '=', $group['barcode'])->withTrashed()->get('ResultValue', 'ResultTransferDtTm');

        $select_antibiotics = Antibiotic::all();
        $antibiotics = Antibiotic::all();
        $all_antibiotics = Antibiotic::all();

        $next = Group::where('id', '>', $id)->orderBy('id', 'asc')->first();
        $previous = Group::where('id', '<', $id)->orderBy('id', 'desc')->first();
        $categories = Category::where('category', 'Antibiotik')->get();

        return view('admin.medical_reports.edit_microbiology', compact('group', 'select_antibiotics', 'next', 'previous', 'laboratories', 'categories', 'antibiotics', 'all_antibiotics'));
    }

    //SHOW NEW
    public function updateTestShow(Request $request, $id)
    {
        $group_test = GroupTest::where('id', $id)->firstOrFail();

        $group_test->update([
            'show' => $request->input('show', 0),
        ]);

        return response()->json(['message' => 'Show attribute updated successfully']);
    }

    public function updateCultureShow(Request $request, $id)
    {
        $group_culture = GroupCulture::find($id);

        $group_culture->update([
            'show' => $request->input('show', 0),
        ]);

        return response()->json(['message' => 'Show attribute updated successfully']);
    }

    public function updateShow(Request $request, $id)
    {
        $group_test = GroupTest::where('id', $id)->firstOrFail();

        $group_test->update([
            'show' => $request->input('show', 0),
        ]);

        return response()->json(['message' => 'Show attribute updated successfully']);
    }

    /**
     * Update analysis report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $group_test = GroupTest::where('id', $id)->firstOrFail();
        $group = microtime(true);

        $group = Group::where('id', $group_test['group_id'])
            ->where('branch_id', session('branch_id'))
            ->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        GroupTest::where('id', $id)->update([
            'done' => true,
            'comment' => $request['comment'],
            'eritrocitet' => $request['eritrocitet'],
            'leukocitet' => $request['leukocitet'],
            'trombocitet' => $request['trombocitet'],
            'description' => $request['description'],
        ]);

        $group = Group::find($group_test['group_id']);

        //check if all reports done
        check_group_done($group_test['group_id']);

        //update result
        if ($request->has('result')) {
            foreach ($request['result'] as $key => $result) {
                $group_test_result = GroupTestResult::where('id', $key)->first();

                $test = Test::where('id', $group_test_result['test_id'])->first();

                //add if new option created
                if (isset($test) && $test['type'] == 'select') {
                    $option = TestOption::where([
                        ['test_id', $test['id']],
                        ['name', $result['result']],
                    ])->first();

                    if (! isset($option)) {
                        TestOption::create([
                            'name' => $result['result'],
                            'test_id' => $test['id'],
                        ]);
                    }
                }

                if (! isset($result['status'])) {
                    $result['status'] = '';
                }

                if (! isset($result['result'])) {
                    $result['result'] = '';
                }
                if (! isset($result['idsnp'])) {
                    $result['idsnp'] = '';
                }

                if (! isset($result['genotype'])) {
                    $result['genotype'] = '';
                }

                //update result
                $group_test_result->update([
                    'result' => $result['result'],
                    'status' => $result['status'],
                    'idsnp' => $result['idsnp'],
                    'genotype' => $result['genotype'],
                ]);

                //update group
                $group->update([
                    'pdf_update' => $request['pdf_update'],
                ]);
            }
        }

        //generate pdf
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();
        }

        $pdf = generate_pdf([
            'categories' => $categories,
            'group' => $group,
        ]);
        // $pdf2=generate_pdf2([
        //     'categories'=>$categories,
        //     'group'=>$group,
        // ]);

        // $pdf3=generate_pdf3([
        //     'categories'=>$categories,
        //     'group'=>$group,
        // ]);

        if (isset($pdf)) {
            $group->update(['report_pdf' => $pdf]);
            // $group->update(['report_pdf2'=>$pdf2]);
            // $group->update(['report_pdf3'=>$pdf3]);
        }

        session()->flash('success', __('Test result saved successfully'));

        return redirect()->back();
    }




    public function microbiology_tests_update(Request $request, $id)
    {
        $group_microbiology_test = GroupMicrobiologyTest::where('id', $id)->firstOrFail();

        // Update the group's uploaded_report flag
        $group = Group::where('id', $group_microbiology_test->group_id)
                      ->where('branch_id', session('branch_id'))
                      ->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        // Update the group microbiology test's done flag and comment
        $group_microbiology_test->update([
            'done' => true,
            'comment' => $request->input('comment'),
        ]);

        if ($request->has('result')) {
            foreach ($request->input('result') as $key => $resultData) {
                $group_microbiology_test_result = GroupMicrobiologyTestResult::where('id', $key)->first();

                if ($group_microbiology_test_result) {
                    // Update the result data
                    $group_microbiology_test_result->update([
                        'result' => $resultData['result'],
                        'status' => $resultData['status'] ?? '',
                    ]);

                    // Delete antibiotics that are not present in the request
                    $antibioticIds = collect($request->input('antibiotic'))->pluck('id')->filter();
                    GroupMicrobiologyTestAntibioticResult::where('group_microbiology_test_result_id', $key)
                        ->whereNotIn('id', $antibioticIds)
                        ->delete();

                    // Save or update antibiotics for the current microbiology test result
                    foreach ($request->input('antibiotic') as $antibioticData) {
                        if (!empty($antibioticData['antibiotic']) && !empty($antibioticData['sensitivity']) && $antibioticData['group_microbiology_test_result_id'] == $key) {
                            if (isset($antibioticData['id'])) {
                                // Update existing antibiotic
                                $antibiotic = GroupMicrobiologyTestAntibioticResult::find($antibioticData['id']);
                                if ($antibiotic) {
                                    $antibiotic->update(['sensitivity' => $antibioticData['sensitivity']]);
                                }
                            } else {
                                // Save new antibiotic
                                GroupMicrobiologyTestAntibioticResult::create([
                                    'antibiotic_id' => $antibioticData['antibiotic'],
                                    'sensitivity' => $antibioticData['sensitivity'],
                                    'group_microbiology_test_result_id' => $key,
                                ]);
                            }
                        }
                    }
                }
            }
        }
        session()->flash('success', __('Microbiology group test updated successfully'));

        return redirect()->back();
    }

    /**
     * Update culture report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_culture(UpdateCultureResultRequest $request, $id)
    {
        $group_culture = GroupCulture::findOrFail($id);

        $group = Group::where('id', $group_culture['group_id'])
            ->where('branch_id', session('branch_id'))
            ->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        //update group
        $group->update([
            'pdf_update' => $request['pdf_update'],
        ]);

        GroupCultureResult::where('group_culture_id', $id)->delete();

        $group_culture->update([
            'done' => true,
            'comment' => $request['comment'],
            'result' => $request['result'],
        ]);

        //save options
        if ($request->has('culture_options')) {
            foreach ($request['culture_options'] as $key => $value) {
                GroupCultureOption::where('id', $key)->update([
                    'value' => $value,
                ]);
            }
        }

        //save antibiotics
        // if($request->has('antibiotic'))
        // {
        //     foreach($request['antibiotic'] as $antibiotic)
        //     {
        //         if(!empty($antibiotic['antibiotic'])&&!empty($antibiotic['sensitivity'])&&!empty($antibiotic['sensitivity2']))
        //         {
        //             GroupCultureResult::create([
        //                 'group_culture_id'=>$id,
        //                 'antibiotic_id'=>$antibiotic['antibiotic'],
        //                 'sensitivity'=>$antibiotic['sensitivity'],
        //                 'sensitivity2'=>$antibiotic['sensitivity2'],
        //                 'category_id' => $antibiotic['category_id'],
        //             ]);
        //         }
        //     }
        // }

        if ($request->has('antibiotic')) {

            $categoryId = $request->input('category_id');

            if (empty($categoryId)) {

            }

            foreach ($request['antibiotic'] as $antibiotic) {
                if (! empty($antibiotic['sensitivity'])) {
                    GroupCultureResult::create([
                        'group_culture_id' => $id,
                        'antibiotic_id' => $antibiotic['antibiotic'],
                        'sensitivity' => $antibiotic['sensitivity'],
                        'sensitivity2' => $antibiotic['sensitivity2'] ?? null,
                        'category_id' => $antibiotic['category_id'],
                    ]);
                }
            }
        }

        //check if all reports done
        check_group_done($group_culture['group_id']);

        //generate pdf
        $categories = Category::all();

        foreach ($categories as $category) {
            $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();

            $category['tests'] = $tests->sortBy(function ($test) {
                return $test->test->components->count();
            });

            $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                return $query->where('category_id', $category['id']);
            })->where('group_id', $group['id'])->get();
        }

        $pdf = generate_pdf([
            'categories' => $categories,
            'group' => $group,
        ]);

        if (isset($pdf)) {
            $group->update(['report_pdf' => $pdf]);
        }

        session()->flash('success', __('Culture result saved successfully'));

        return redirect()->back();

    }

    /**
     * Sign report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sign($id)
    {
        $group = Group::where('id', $id)->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        if (! empty(auth()->guard('admin')->user()->signature)) {
            //add signature
            $group->update([
                'signed_by' => auth()->guard('admin')->user()->id,
            ]);

            //generate pdf
            $categories = Category::all();

            foreach ($categories as $category) {
                $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                    return $query->where('category_id', $category['id']);
                })->where('group_id', $group['id'])->get();

                $category['tests'] = $tests->sortBy(function ($test) {
                    return $test->test->components->count();
                });

                $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                    return $query->where('category_id', $category['id']);
                })->where('group_id', $group['id'])->get();
            }

            $pdf = generate_pdf([
                'group' => $group,
                'categories' => $categories,
            ]);

            if (isset($pdf)) {
                $group->update(['report_pdf' => $pdf]);
            }

            //send notification to patient
            //send_notification('tests_notification',$group['patient']);

            session()->flash('success', __('Report signed successfully'));

            return redirect()->back();
        }

        session()->flash('failed', __('Please select your signature first'));

        return redirect()->back();

    }

    public function confirm_report($id)
    {
        $group = Group::findOrFail($id);
        Group::where('id', $id)->update([
            'sent' => true,
        ]);

        session()->flash('success', __('Report Confirmed successfully'));

        return redirect()->back();

    }

    public function called_patient($id)
    {
        $group = Group::findOrFail($id);
        Group::where('id', $id)->update([
            'called' => true,
        ]);

        session()->flash('success', __('Call Confirmed successfully'));

        return redirect()->back();

    }

    /**
     * Sign2 report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sign2($id)
    {
        $group = Group::where('id', $id)->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        if (! empty(auth()->guard('admin')->user()->signature2)) {
            //add signature
            $group->update([
                'signed_by2' => auth()->guard('admin')->user()->id,
            ]);

            //generate pdf
            $categories = Category::all();

            foreach ($categories as $category) {
                $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                    return $query->where('category_id', $category['id']);
                })->where('group_id', $group['id'])->get();

                $category['tests'] = $tests->sortBy(function ($test) {
                    return $test->test->components->count();
                });

                $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                    return $query->where('category_id', $category['id']);
                })->where('group_id', $group['id'])->get();
            }

            $pdf = generate_pdf([
                'group' => $group,
                'categories' => $categories,
            ]);

            if (isset($pdf)) {
                $group->update(['report_pdf' => $pdf]);
            }

            //send notification to patient
            // send_notification('tests_notification',$group['patient']);

            session()->flash('success', __('Report 2 signed successfully'));

            return redirect()->back();
        }

        session()->flash('failed', __('Please select your signature 2 first'));

        return redirect()->back();

    }

    /**
     * Sign3 report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sign3($id)
    {
        $group = Group::where('id', $id)->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        if (! empty(auth()->guard('admin')->user()->signature3)) {
            //add signature
            $group->update([
                'signed_by3' => auth()->guard('admin')->user()->id,
            ]);

            //generate pdf
            // $categories=Category::all();

            // foreach($categories as $category)
            // {
            //     $tests=GroupTest::whereHas('test',function($query)use($category){
            //                             return $query->where('category_id',$category['id']);
            //                         })->where('group_id',$group['id'])->get();

            //     $category['tests']=$tests->sortBy(function($test){
            //                             return $test->test->components->count();
            //                         });

            //     $category['cultures']=GroupCulture::whereHas('culture',function($query)use($category){
            //                             return $query->where('category_id',$category['id']);
            //                         })->where('group_id',$group['id'])->get();
            // }

            // $pdf=generate_pdf([
            //     'group'=>$group,
            //     'categories'=>$categories
            // ]);

            // if(isset($pdf))
            // {
            //     $group->update(['report_pdf'=>$pdf]);
            // }

            //send notification to patient
            // send_notification('tests_notification',$group['patient']);

            session()->flash('success', __('Report signed successfully'));

            return redirect()->back();
        }

        session()->flash('failed', __('Please select your signature 3 first'));

        return redirect()->back();

    }

    /**
     * Sign3 report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sign4($id)
    {
        $group = Group::where('id', $id)->firstOrFail();

        $group->update([
            'uploaded_report' => false,
        ]);

        if (! empty(auth()->guard('admin')->user()->signature4)) {
            //add signature
            $group->update([
                'signed_by4' => auth()->guard('admin')->user()->id,
            ]);

            //generate pdf
            // $categories=Category::all();

            // foreach($categories as $category)
            // {
            //     $tests=GroupTest::whereHas('test',function($query)use($category){
            //                             return $query->where('category_id',$category['id']);
            //                         })->where('group_id',$group['id'])->get();

            //     $category['tests']=$tests->sortBy(function($test){
            //                             return $test->test->components->count();
            //                         });

            //     $category['cultures']=GroupCulture::whereHas('culture',function($query)use($category){
            //                             return $query->where('category_id',$category['id']);
            //                         })->where('group_id',$group['id'])->get();
            // }

            // $pdf=generate_pdf([
            //     'group'=>$group,
            //     'categories'=>$categories
            // ]);

            // if(isset($pdf))
            // {
            //     $group->update(['report_pdf'=>$pdf]);
            // }

            //send notification to patient
            // send_notification('tests_notification',$group['patient']);

            session()->flash('success', __('Report signed successfully'));

            return redirect()->back();
        }

        session()->flash('failed', __('Please select your signature 4 first'));

        return redirect()->back();

    }

    /**
     * Send report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send_report_mail(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $patient = $group['patient'];

        //send_notification('report',$patient,$group);

        session()->flash('success', __('Mail sent successfully'));

        return redirect()->route('admin.medical_reports.index');
    }

    /**
     * upload report
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upload_report(UploadReportRequest $request, $id)
    {
        $group = Group::findOrFail($id);

        if ($request->has('report')) {
            $report = $request->file('report');

            $report->move('uploaded_report/pdf', 'report_'.$group['id'].'.pdf');

            $group->update([
                'uploaded_report1' => true,
                'report_uploaded' => url('uploaded_report/pdf/report_'.$group['id'].'.pdf'),
            ]);
        }

        session()->flash('success', __('Report uploaded successfully'));

        return redirect()->back();
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
            //delete group
            $group = Group::findOrFail($id);
            $group->payments()->delete();

            //delete group tests
            $group_tests = GroupTest::where('group_id', $id)->get();

            //delete test results
            foreach ($group_tests as $group_test) {
                GroupTestResult::where('group_test_id', $group_test['id'])->delete();
            }
            GroupTest::where('group_id', $id)->delete();

            //delete group cultures
            $group_cultures = GroupCulture::where('group_id', $id)->get();
            foreach ($group_cultures as $group_culture) {
                GroupCultureResult::where('group_culture_id', $group_culture['id'])->delete();
            }
            GroupCulture::where('group_id', $id)->delete();

            //delete packages
            $group->packages()->delete();

            //delete consumption
            $group->consumptions()->delete();

            //delete group
            $group->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.medical_reports.index');
    }

    /**
     * Bulk print report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_print_report(BulkActionRequest $request)
    {
        $pdf = PDFMerger::init();

        foreach ($request['ids'] as $id) {
            $group = Group::find($id);

            //generate pdf
            $categories = Category::all();

            foreach ($categories as $category) {
                $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                    return $query->where('category_id', $category['id']);
                })->where('group_id', $group['id'])->get();

                $category['tests'] = $tests->sortBy(function ($test) {
                    return $test->test->components->count();
                });

                $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                    return $query->where('category_id', $category['id']);
                })->where('group_id', $group['id'])->get();
            }

            $pdf_url = generate_pdf([
                'categories' => $categories,
                'group' => $group,
            ]);

            $pdf->addString(file_get_contents($pdf_url));
        }

        $pdf->merge();
        $pdf->save('uploads/pdf/bulk.pdf');

        return redirect('uploads/pdf/bulk.pdf');
    }

    /**
     * Bulk print barcode
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_print_barcode(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])->get();

        $pdf = print_bulk_barcode($groups);

        return redirect($pdf);
    }

    /**
     * Bulk sign report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_sign_report(BulkActionRequest $request)
    {
        if (! empty(auth()->guard('admin')->user()->signature)) {
            $groups = Group::whereIn('id', $request['ids'])->get();

            $categories = Category::all();

            foreach ($groups as $group) {
                $group->update([
                    'uploaded_report' => false,
                ]);

                //add signature
                $group->update([
                    'signed_by' => auth()->guard('admin')->user()->id,
                ]);

                //generate pdf
                foreach ($categories as $category) {
                    $tests = GroupTest::whereHas('test', function ($query) use ($category) {
                        return $query->where('category_id', $category['id']);
                    })->where('group_id', $group['id'])->get();

                    $category['tests'] = $tests->sortBy(function ($test) {
                        return $test->test->components->count();
                    });

                    $category['cultures'] = GroupCulture::whereHas('culture', function ($query) use ($category) {
                        return $query->where('category_id', $category['id']);
                    })->where('group_id', $group['id'])->get();
                }

                $pdf = generate_pdf([
                    'group' => $group,
                    'categories' => $categories,
                ]);

                if (isset($pdf)) {
                    $group->update(['report_pdf' => $pdf]);
                }

                //send notification to patient
                // send_notification('tests_notification',$group['patient']);
            }

            session()->flash('success', __('Reports signed successfully'));

            return redirect()->back();
        }

        session()->flash('failed', __('Please select your signature first'));

        return redirect()->back();
    }

    /**
     * Bulk send report mail
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_send_report_mail(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])
            ->where('signed_by', '!=', null)
            ->get();

        if (! count($groups)) {
            session()->flash('failed', __('You should sign the reports to be sent'));

            return redirect()->back();
        }

        foreach ($groups as $group) {
            $patient = $group['patient'];
            // send_notification('report',$patient,$group);
        }

        session()->flash('success', __('Report mails sent successfully'));

        return redirect()->route('admin.medical_reports.index');
    }

    public function trombofiliPDF($id, $type = 1)
    {

        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');
        $group = Group::with(['testResults', 'all_tests2'])->where('id', $id)->first();
        $pdf = PDF::loadView('admin.medical_reports.trombofiliPDF', compact(
            'group',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        //   dd($group->all_tests2);
        $filename = 'medical_report_'.$group['barcode'].'.pdf';
        $pdf->save('uploads/pdf_new/'.$filename);
        $path = url('uploads/pdf_new/'.$filename);

        $pdf_path = 'uploads/pdf_new/'.$filename;
        $group->pdf_new = url($pdf_path);
        $group->update(); // Stream the PDF to the user's browser

        return $pdf->stream($filename);
    }

    public function testPDF($id, $type = 1)
    {
        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');

        // $group = Group::with(['all_tests.results' => function($query) {
        // $query->with(['component']);
        // }])->where('id', $id)->first();

        $group = Group::with(['all_tests' => function ($query) {
            $query->where(function ($query) {
                $query->where('show', 0)
                    ->orWhereNull('show');
            })->with(['results' => function ($query) {
                $query->with(['component']);
            }]);
        }])->where('id', $id)->first();

        //Barcode to md5
        $timestamp = date('Y');
        $barcode = $group['barcode'] - $group['id'] + $timestamp;
        $hash = md5($barcode);
        //End barcode to md5

        $pdf = PDF::loadView('admin.medical_reports.testPDF', compact(
            'group',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        $filename = 'medical_report_'.$hash.'.pdf';
        $pdf->save('uploads/pdf_new/'.$filename);
        $path = url('uploads/pdf_new/'.$filename);

        $pdf_path = 'uploads/pdf_new/'.$filename;
        $group->pdf_new = url($pdf_path);
        $group->update(); // Stream the PDF to the user's browser

        return $pdf->stream($filename);
    }

    public function testPDF2($id, $type = 1)
    {
        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');

        $group = Group::with(['all_tests.results' => function ($query) {
            $query->with(['component']);
        }])->where('id', $id)->first();

        //Barcode to md5
        $timestamp = date('Y');
        $barcode = $group['barcode'] - $group['id'] + $timestamp;
        $hash = md5($barcode);
        //End barcode to md5

        $pdf = PDF::loadView('admin.medical_reports.testPDF2', compact(
            'group',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        $filename = 'medical_report_'.$hash.'.pdf';
        $pdf->save('uploads/pdf_new/'.$filename);
        $path = url('uploads/pdf_new/'.$filename);

        $pdf_path = 'uploads/pdf_new/'.$filename;
        $group->pdf_new = url($pdf_path);
        $group->update(); // Stream the PDF to the user's browser

        return $pdf->stream($filename);
    }

    public function culturePDF2($id, $type = 1)
    {
        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');
        $group = Group::findOrFail($id);
        if ($group['uploaded_report']) {
            return redirect($group['report_pdf']);
        }
        //Barcode to md5
        $barcode = $group['barcode'];
        $hash = md5($barcode);
        //End barcode to md5

        $categories = Category::get();
        $groupCultures = GroupCulture::where('group_id', $group['id'])->get();

        foreach ($categories as $category) {
            $category['cultures'] = $groupCultures->where('culture.category_id', $category['id']);
        }

        $pdf = PDF::loadView('admin.medical_reports.cultures_pdf2', compact(
            'group',
            'categories',
            'groupCultures',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        $filename = 'medical_report_'.$hash.'.pdf';
        $pdf->save('uploads/pdf_culture_new/'.$filename);
        $path = url('uploads/pdf_culture_new/'.$filename);

        $pdf_path = 'uploads/pdf_culture_new/'.$filename;
        $group->pdf_new = url($pdf_path);
        $group->update(); // Stream the PDF to the user's browser

        return $pdf->stream($filename);
    }

    public function culturePDF($id, $type = 1)
    {
        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');
        $group = Group::findOrFail($id);
        if ($group['uploaded_report']) {
            return redirect($group['report_pdf']);
        }
        //Barcode to md5
        $barcode = $group['barcode'];
        $hash = md5($barcode);
        //End barcode to md5

        $categories = Category::get();
        $groupCultures = GroupCulture::where('group_id', $group['id'])->get();

        foreach ($categories as $category) {
            $category['cultures'] = $groupCultures->where('culture.category_id', $category['id']);
        }

        $pdf = PDF::loadView('admin.medical_reports.cultures_pdf', compact(
            'group',
            'categories',
            'groupCultures',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        $filename = 'medical_report_'.$hash.'.pdf';
        $pdf->save('uploads/pdf_culture_new/'.$filename);
        $path = url('uploads/pdf_culture_new/'.$filename);

        $pdf_path = 'uploads/pdf_culture_new/'.$filename;
        $group->pdf_new = url($pdf_path);
        $group->update(); // Stream the PDF to the user's browser

        return $pdf->stream($filename);
    }

    public function bloodPDF($id, $type = 1)
    {
        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');

        $group = Group::with(['all_tests.results' => function ($query) {
            $query->with(['component']);
        }])->where('id', $id)->first();

        //   dd($group);
        //Barcode to md5
        $timestamp = date('Y');
        $barcode = $group['barcode'] - $group['id'] + $timestamp;
        $hash = md5($barcode);
        //End barcode to md5

        $pdf = PDF::loadView('admin.medical_reports.bloodPDF', compact(
            'group',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        $filename = 'medical_report_'.$hash.'.pdf';
        $pdf->save('uploads/blood_new/'.$filename);
        $path = url('uploads/blood_new/'.$filename);

        //  $pdf_path = 'uploads/blood_new/' . $filename;
        //  $group->blood_new = url($pdf_path);
        $group->update(); // Stream the PDF to the user's browser

        return $pdf->stream($filename);
    }

    public function pcrPDF($id, $type = 1)
    {
        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');

        $group = Group::with(['all_tests.results' => function ($query) {
            $query->with(['component']);
        }])->where('id', $id)->first();

        //   dd($group);
        //Barcode to md5
        $timestamp = date('Y');
        $barcode = $group['barcode'] - $group['id'] + $timestamp;
        $hash = md5($barcode);
        //End barcode to md5

        $pdf = PDF::loadView('admin.medical_reports.pcrPDF', compact(
            'group',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        $filename = 'medical_report_'.$hash.'.pdf';
        $pdf->save('uploads/pcr_new/'.$filename);
        $path = url('uploads/pcr_new/'.$filename);

        //  $pdf_path = 'uploads/blood_new/' . $filename;
        //  $group->blood_new = url($pdf_path);
        $group->update(); // Stream the PDF to the user's browser

        return $pdf->stream($filename);
    }
}
