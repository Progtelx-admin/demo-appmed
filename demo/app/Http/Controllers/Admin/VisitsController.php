<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\VisitRequest;
use App\Models\Antibiotic;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\Culture;
use App\Models\Doctor;
use App\Models\Package;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Test;
use App\Models\Visit;
use DataTables;
use Illuminate\Http\Request;
use PDF;
use Str;

class VisitsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_visit', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_visit', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_visit', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_visit', ['only' => ['destroy', 'bulk_delete']]);
        $this->middleware('can:create_group', ['only' => ['create_tests']]);
        $this->middleware('can:view_visitDr', ['only' => ['view_visitDr']]);

        $this->middleware('can:view_visitDr', ['only' => ['indexDr', 'ajax']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.visits.index');
    }

    public function indexDr()
    {
        return view('admin.visits.indexDr');
    }

    /**
     * get visits datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = Visit::with('patient', 'branch')
            ->orderBy('id', 'desc');

        if ($request['filter_read'] != null) {
            $model->where('read', $request['filter_read']);
        }

        if ($request['filter_status'] != null) {
            $model->where('status', $request['filter_status']);
        }

        if ($request['filter_date'] != '') {
            //format date
            $date = explode('-', $request['filter_date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select groups of date between
            ($date[0] == $date[1]) ? $model->whereDate('created_at', $from) : $model->whereBetween('created_at', [$from, $to]);
        } else {
            // set default filter to today's date
            $from = date('Y-m-d');
            $to = date('Y-m-d 23:59:59');

            $model->whereDate('created_at', $from);
        }

        return DataTables::eloquent($model)
            ->editColumn('read', function ($visit) {
                return view('admin.visits._read', compact('visit'));
            })
            ->editColumn('status', function ($visit) {
                return view('admin.visits._status', compact('visit'));
            })
            ->addColumn('action', function ($visit) {
                return view('admin.visits._action', compact('visit'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->toJson();
    }

    public function ajaxDr(Request $request)
    {
        $model = Visit::with('patient', 'branch')
            ->where('branch_id', session('branch_id'))
            ->orderBy('id', 'desc');

        if ($request['filter_read'] != null) {
            $model->where('read', $request['filter_read']);
        }

        if ($request['filter_status'] != null) {
            $model->where('status', $request['filter_status']);
        }

        return DataTables::eloquent($model)
            ->editColumn('read', function ($visit) {
                return view('admin.visits._read', compact('visit'));
            })
            ->editColumn('status', function ($visit) {
                return view('admin.visits._statusDr', compact('visit'));
            })
            ->addColumn('action', function ($visit) {
                return view('admin.visits._actionDr', compact('visit'));
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

        return view('admin.visits.create', compact('branches'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitRequest $request)
    {

        if ($request->has('patient_id')) {
            $patient = Patient::find($request['patient_id']);
        } else {
            $patient = Patient::create([
                'code' => time(),
                'name' => $request['name'],
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'address' => $request['address'],
                'gender' => $request['gender'],
                'email' => $request['email'],
                'api_token' => Str::random(32),
            ]);
        }

        $visit = Visit::create([
            'patient_id' => $patient['id'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'zoom_level' => $request['zoom_level'],
            'visit_date' => $request['visit_date'],
            'visit_address' => $request['visit_address'],
            'doctor_id' => $request['doctor_id'],
            'branch_id' => $request['branch_id'],
            // 'branch_id'=>session('branch_id'),
            'visit_type' => $request['visit_type'],
            'diagnosis' => $request['diagnosis'],
            'examination' => $request['examination'],
            'anamnesis' => $request['anamnesis'],
            'recommendation' => $request['recommendation'],
            'therapy' => $request['therapy'],
        ]);

        //tests
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $visit->visit_tests()->create([
                    'testable_id' => $test,
                    'testable_type' => \App\Models\Test::class,
                ]);
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $visit->visit_tests()->create([
                    'testable_id' => $culture,
                    'testable_type' => \App\Models\Culture::class,
                ]);
            }
        }
        if ($request->has('services')) {
            foreach ($request['services'] as $service) {
                $visit->visit_tests()->create([
                    'testable_id' => $service,
                    'testable_type' => \App\Models\Service::class,
                ]);
            }
        }

        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $visit->visit_tests()->create([
                    'testable_id' => $package,
                    'testable_type' => \App\Models\Package::class,
                ]);
            }
        }
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $antibiotic) {
                $visit->visit_tests()->create([
                    'testable_id' => $antibiotic,
                    'testable_type' => \App\Models\Antibiotic::class,
                ]);
            }
        }
        if ($request->has('doctors')) {
            foreach ($request['doctors'] as $doctor) {
                $visit->visit_tests()->create([
                    'testable_id' => $doctor,
                    'testable_type' => \App\Models\Doctor::class,
                ]);
            }
        }

        if ($request->has('attach')) {
            $attach = $request->file('attach');
            $name = time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/visits', $name);
            $visit->update(['attach' => $name]);
        }

        session()->flash('success', __('Visit saved successfully'));

        return redirect()->route('admin.visits.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visit = Visit::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $visit->update(['read' => true]);

        return view('admin.visits.show', compact('visit'));
    }

    public function report_visit($id)
    {
        $visit = Visit::findOrFail($id);

        $pdf = generate_pdf($visit, 7);

        return redirect($pdf);
    }

    public function report_visit2($id)
    {
        $visit = Visit::findOrFail($id);

        $pdf2 = generate_pdf2($visit, 7);

        return redirect($pdf2);
    }

    public function report_visit3($id)
    {
        $visit = Visit::findOrFail($id);

        $pdfv3 = generate_pdfv3($visit, 7);

        return redirect($pdfv3);
    }

    public function report_visit4($id)
    {
        $visit = Visit::findOrFail($id);

        $pdfv31 = generate_pdfv31($visit, 7);

        return redirect($pdfv31);
    }

    public function bulk_print_report_visit(BulkActionRequest $request)
    {
        $visits = Visit::whereIn('id', $request['ids'])->get();

        $pdf = print_bulk_report_visit($visits);

        return redirect($pdf);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visit = Visit::where('branch_id', session('branch_id'))
            ->findOrFail($id);
        $branches = Branch::all();

        $visit->update(['read' => true]);

        return view('admin.visits.edit', compact('visit', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VisitRequest $request, $id)
    {
        $visit = Visit::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $visit->update($request->except('_token', '_method', 'patient_type', 'tests', 'cultures', 'services', 'packages', 'antibiotics', 'doctors'));

        //tests
        $visit->visit_tests()->delete();
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $visit->visit_tests()->create([
                    'testable_id' => $test,
                    'testable_type' => \App\Models\Test::class,
                ]);
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $visit->visit_tests()->create([
                    'testable_id' => $culture,
                    'testable_type' => \App\Models\Culture::class,
                ]);
            }
        }
        if ($request->has('services')) {
            foreach ($request['services'] as $service) {
                $visit->visit_tests()->create([
                    'testable_id' => $service,
                    'testable_type' => \App\Models\Service::class,
                ]);
            }
        }

        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $visit->visit_tests()->create([
                    'testable_id' => $package,
                    'testable_type' => \App\Models\Package::class,
                ]);
            }
        }
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $antibiotic) {
                $visit->visit_tests()->create([
                    'testable_id' => $antibiotic,
                    'testable_type' => \App\Models\Antibiotic::class,
                ]);
            }
        }

        if ($request->has('doctors')) {
            foreach ($request['doctors'] as $doctor) {
                $visit->visit_tests()->create([
                    'testable_id' => $doctor,
                    'testable_type' => \App\Models\Doctor::class,
                ]);
            }
        }

        if ($request->has('attach')) {
            $attach = $request->file('attach');
            $name = time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/visits', $name);
            $visit = Visit::find($id);
            $visit->update(['attach' => $name]);
        }

        session()->flash('success', __('Visit updated successfully'));

        return redirect()->route('admin.visits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visit = Visit::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $visit->visit_tests()->delete();
        $visit->delete();

        session()->flash('success', __('Visit deleted successfully'));

        return redirect()->route('admin.visits.index');

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
            $visit = Visit::where('branch_id', session('branch_id'))->find($id);
            $visit->visit_tests()->delete();
            $visit->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.visits.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_tests($visit_id)
    {
        $visit = Visit::where('branch_id', session('branch_id'))
            ->findOrFail($visit_id);

        $visit->update([
            'read' => true,
            'status' => true,
        ]);

        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $services = Service::all();
        $packages = Package::all();
        $antibiotics = Antibiotic::all();
        $doctors = Doctor::all();
        $contracts = Contract::all();

        return view('admin.groups.create', compact('visit', 'tests', 'cultures', 'services', 'packages', 'antibiotics', 'contracts', 'doctors'));
    }

    public function sign($id)
    {
        $visit = Visit::where('id', $id)->firstOrFail();

        if (! empty(auth()->guard('admin')->user()->signature)) {
            //add signature
            $visit->update([
                'signed_by' => auth()->guard('admin')->user()->id,
            ]);

            session()->flash('success', __('Report signed successfully'));

            return redirect()->back();
        }

        session()->flash('failed', __('Please select your signature first'));

        return redirect()->back();

    }

    public function visits_pdfs($id, $type = 1)
    {

        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');

        $visit = Visit::findOrFail($id);

        $pdf = PDF::loadView('admin.visits.visits_pdfs', compact(
            'visit',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        return $pdf->stream('visit_'.'report'.'.pdf');

    }

    ///PER RECEPSION
    public function visits_pdfs_recepsion($id, $type = 1)
    {

        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');

        $visit = Visit::findOrFail($id);

        $pdf = PDF::loadView('admin.visits.visits_pdfs_recepsion', compact(
            'visit',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        return $pdf->stream('visit_'.'report'.'.pdf');

    }
}
