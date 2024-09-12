<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AppointmentRequest;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Models\Antibiotic;
use App\Models\Appointment;
use App\Models\Contract;
use App\Models\Culture;
use App\Models\Doctor;
use App\Models\Package;
use App\Models\Patient;
use App\Models\Test;
use App\Models\Visit;
use Carbon\Carbon;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Str;

class AppointmentsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_appointments_all', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:view_appointments_branch', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_appointments', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_appointments', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_appointments', ['only' => ['destroy', 'bulk_delete']]);
        $this->middleware('can:create_group', ['only' => ['create_tests']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Appointment::with('patient')
            ->where('branch_id', session('branch_id'))
            ->get();

        return view('admin.appointments.index', compact('tasks'));
    }

    /**
     * get visits datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = Appointment::with('patient')
            ->where('branch_id', session('branch_id'))->where('status', 0)->whereDate('visit_date', Carbon::today())
            ->orderBy('id', 'desc');

        if ($request['filter_read'] != null) {
            $model->where('read', $request['filter_read']);
        }

        if ($request['filter_status'] != null) {
            $model->where('status', $request['filter_status']);
        }

        if ($request['filter_branch'] != null) {
            $model->where('branch_id', $request['filter_branch']);
        }

        return DataTables::eloquent($model)
            ->editColumn('read', function ($appointment) {
                return view('admin.appointments._read', compact('appointment'));
            })
            ->editColumn('status', function ($appointment) {
                return view('admin.appointments._status', compact('appointment'));
            })
            ->addColumn('action', function ($appointment) {
                return view('admin.appointments._action', compact('appointment'));
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
        return view('admin.appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentRequest $request)
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

        $appointment = Appointment::create([
            'patient_id' => $patient['id'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'zoom_level' => $request['zoom_level'],
            'visit_date' => $request['visit_date'],
            'visit_address' => $request['visit_address'],
            'doctor_id' => 'doctor_id' && $request['doctor_id'],
            'branch_id' => session('branch_id'),
            'visit_type' => $request['visit_type'],
            'diagnosis' => $request['diagnosis'],
            'anamnesis' => $request['anamnesis'],
            'recommendation' => $request['recommendation'],
            'therapy' => $request['therapy'],
            'doctor_name' => $request['doctor_name'],
            'from_date' => $request['from_date'],
            'to_date' => $request['to_date'],

        ]);

        //tests
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $appointment->visit_tests()->create([
                    'testable_id' => $test,
                    'testable_type' => \App\Models\Test::class,
                ]);
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $appointment->visit_tests()->create([
                    'testable_id' => $culture,
                    'testable_type' => \App\Models\Culture::class,
                ]);
            }
        }

        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $appointment->visit_tests()->create([
                    'testable_id' => $package,
                    'testable_type' => \App\Models\Package::class,
                ]);
            }
        }
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $antibiotic) {
                $appointment->visit_tests()->create([
                    'testable_id' => $antibiotic,
                    'testable_type' => \App\Models\Antibiotic::class,
                ]);
            }
        }
        if ($request->has('doctors')) {
            foreach ($request['doctors'] as $doctor) {
                $appointment->visit_tests()->create([
                    'testable_id' => $doctor,
                    'testable_type' => \App\Models\Doctor::class,
                ]);
            }
        }

        if ($request->has('attach')) {
            $attach = $request->file('attach');
            $name = time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/appointments', $name);
            $appointment->update(['attach' => $name]);
        }

        // $dt = Carbon::now();
        // $appointment= DB::table('appointments')
        //     ->whereRaw('"'.$dt.'" between `from_date` and `to_date`')
        //     ->get();

        session()->flash('success', __('Appointment saved successfully'.$request->visit_date));

        return redirect()->route('admin.appointments.index');
        // return redirect()->back()->with('message', 'An appointment created for ' . $request->visit_date);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $appointment->update(['read' => true]);

        return view('admin.appointments.show', compact('appointment'));
    }

    public function report_appointment($id)
    {
        $appointment = Appointment::findOrFail($id);

        $pdf = generate_pdf($appointment, 7);

        return redirect($pdf);
    }

    public function report_appointment2($id)
    {
        $appointment = Appointment::findOrFail($id);

        $pdf2 = generate_pdf2($appointment, 7);

        return redirect($pdf2);
    }

    public function bulk_print_report_appointment(BulkActionRequest $request)
    {
        $appointments = Appointment::whereIn('id', $request['ids'])->get();

        $pdf = print_bulk_report_visit($appointments);

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
        $appointment = Appointment::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $appointment->update(['read' => true]);

        return view('admin.appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentRequest $request, $id)
    {
        $appointment = Appointment::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $appointment->update($request->except('_token', '_method', 'patient_type', 'tests', 'cultures', 'packages', 'antibiotics', 'doctors'));

        //tests
        $appointment->visit_tests()->delete();
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $appointment->visit_tests()->create([
                    'testable_id' => $test,
                    'testable_type' => \App\Models\Test::class,
                ]);
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $appointment->visit_tests()->create([
                    'testable_id' => $culture,
                    'testable_type' => \App\Models\Culture::class,
                ]);
            }
        }

        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $appointment->visit_tests()->create([
                    'testable_id' => $package,
                    'testable_type' => \App\Models\Package::class,
                ]);
            }
        }
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $antibiotic) {
                $appointment->visit_tests()->create([
                    'testable_id' => $antibiotic,
                    'testable_type' => \App\Models\Antibiotic::class,
                ]);
            }
        }

        if ($request->has('doctors')) {
            foreach ($request['doctors'] as $doctor) {
                $appointment->visit_tests()->create([
                    'testable_id' => $doctor,
                    'testable_type' => \App\Models\Doctor::class,
                ]);
            }
        }

        if ($request->has('attach')) {
            $attach = $request->file('attach');
            $name = time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/visits', $name);
            $appointment = Appointment::find($id);
            $appointment->update(['attach' => $name]);
        }

        session()->flash('success', __('Appointment updated successfully'));

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $appointment->visit_tests()->delete();
        $appointment->delete();

        session()->flash('success', __('Appointment deleted successfully'));

        return redirect()->route('admin.appointments.index');

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
            $appointment = Appointment::where('branch_id', session('branch_id'))->find($id);
            $appointment->visit_tests()->delete();
            $appointment->delete();
        }

        session()->flash('success', __('Bulk appointments deleted successfully'));

        return redirect()->route('admin.appointments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_tests($visit_id)
    {
        $appointment = Appointment::where('branch_id', session('branch_id'))
            ->findOrFail($visit_id);

        $appointment->update([
            'read' => true,
            'status' => true,
        ]);

        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $packages = Package::all();
        $antibiotics = Antibiotic::all();
        $doctors = Doctor::all();
        $contracts = Contract::all();

        return view('admin.groups.create', compact('appointment', 'tests', 'cultures', 'packages', 'antibiotics', 'contracts', 'doctors'));
    }
}
