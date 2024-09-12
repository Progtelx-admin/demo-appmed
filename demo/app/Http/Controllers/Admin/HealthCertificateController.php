<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\HealthCertificateRequest;
use App\Models\Antibiotic;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Contract;
use App\Models\Culture;
use App\Models\Doctor;
use App\Models\Group;
use App\Models\GroupCulture;
use App\Models\GroupTest;
use App\Models\HealthCertificate;
use App\Models\Package;
use App\Models\Patient;
use App\Models\Test;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;
use PDF;
use Str;

class HealthCertificateController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_healthcertificates', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_healthcertificates', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_healthcertificates', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_healthcertificates', ['only' => ['destroy', 'bulk_delete']]);
        $this->middleware('can:create_healthcertificates', ['only' => ['create_tests']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.healthcertificates.index');
    }

    /**
     * get visits datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = HealthCertificate::with('patient', 'doctor', 'branch', 'contract')
            ->where('branch_id', session('branch_id'))
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
            ->editColumn('read', function ($healthcertificate) {
                return view('admin.healthcertificates._read', compact('healthcertificate'));
            })
            ->editColumn('status', function ($healthcertificate) {
                return view('admin.healthcertificates._status', compact('healthcertificate'));
            })
            ->addColumn('action', function ($healthcertificate) {
                return view('admin.healthcertificates._action', compact('healthcertificate'));
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

    /* public function create(Request $request)
    {
    $healthcb=Branch::where('id',session('branch_id'))
                    ->first();
    $healthproto=HealthCertificate::where('branch_id',$healthcb)->orderby('id','DESC')->first('protocol_no');
    if($healthproto == NULL)
    {
    $health=$healthcb->protocol_cert;
    }
    else
    {
    $health=HealthCertificate::all()->last();
                $number = (int)substr($health['protocol_no'] ,-6) +1 ;
                $generate = $number;
    }
     return view('admin.healthcertificates.create',compact('health'));

    } */

    public function create(Request $request)
    {

        $doctors = Doctor::all();
        $branches = Branch::all();
        $healthcb = Branch::where('id', session('branch_id'))
            ->first();

        $datenow = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $theDate = $now->year.$now->month;
        $healthc = HealthCertificate::count();
        $number = 8; // Initialize with a default value

        if ($healthc == 0) {
            if ($healthcb != null && isset($healthcb->protocol_cert)) {
                $number = $healthcb->protocol_cert;
            } else {
                // Handle the case when $healthcb or $healthcb->protocol_cert is null
                // Set a default value or throw an exception, depending on your requirements
            }
            $generate = $number;
            //  dd($generate);
        } else {
            $health = HealthCertificate::where('branch_id', $healthcb['id'])->latest()->first();

            if ($health != null && isset($health['protocol_no'])) {
                $number = (int) substr($health['protocol_no'], -6) + 1;
            } else {
                // Handle the case when $health or $health['protocol_no'] is null
                // Set a default value or throw an exception, depending on your requirements
            }
            $generate = $number;
            //  echo'bpbp';
        }

        $healthc_no = HealthCertificate::count();
        if ($healthc == 0) {
            $number = '008000';
            $generate_no = $number;
            //  dd($generate);
        } else {
            $health = HealthCertificate::all()->last();
            $number = (int) substr($health['reg_no'], -6) + 1;
            $generate_no = $number;
            //  echo'bpbp';
        }

        return view('admin.healthcertificates.create', compact('theDate', 'generate', 'generate_no', 'healthc_no', 'doctors', 'branches'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HealthCertificateRequest $request)
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
        // $lastProtocolNo2 = HealthCertificate::max('protocol_no2'); // Get the last value of protocol_no2
        $branch_id = $request->has('branch_id');

        $healthcertificate = HealthCertificate::create([
            'patient_id' => $patient['id'],
            'lat' => $request['lat'],
            'lng' => $request['lng'],
            'zoom_level' => $request['zoom_level'],
            'visit_date' => $request['visit_date'],
            'visit_address' => $request['visit_address'],
            'doctor_id' => $request['doctor_id'],
            // 'branch_id'=>session('branch_id'),
            //  'branch_id' => $branch_id ? session('branch_id') : null, // Conditionally set branch_id
            //  'branch_id' => $branch_id,
            'branch_id' => $request['branch_id'],
            'visit_type' => $request['visit_type'],
            'diagnosis' => $request['diagnosis'],
            'anamnesis' => $request['anamnesis'],
            'recommendation' => $request['recommendation'],
            'ta' => $request['ta'],
            'spo2' => $request['spo2'],
            'fc' => $request['fc'],
            'comment' => $request['comment'],
            'protocol_no' => $request['protocol_no'],
            // 'protocol_no2' => $lastProtocolNo2 + 1, // Increment the last value by 1
            'protocol_no2' => $request['protocol_no2'],
            'reg_no' => $request['reg_no'],
            'alergy' => $request['alergy'],
        ]);

        //tests
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $test,
                    'testable_type' => \App\Models\Test::class,
                ]);
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $culture,
                    'testable_type' => \App\Models\Culture::class,
                ]);
            }
        }

        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $package,
                    'testable_type' => \App\Models\Package::class,
                ]);
            }
        }
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $antibiotic) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $antibiotic,
                    'testable_type' => \App\Models\Antibiotic::class,
                ]);
            }
        }
        if ($request->has('doctors')) {
            foreach ($request['doctors'] as $doctor) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $doctor,
                    'testable_type' => \App\Models\Doctor::class,
                ]);
            }
        }

        if ($request->has('attach')) {
            $attach = $request->file('attach');
            $name = time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/healthcertificate', $name);
            $healthcertificate->update(['attach' => $name]);
        }

        session()->flash('success', __('Health Certificate saved successfully'));

        return redirect()->route('admin.healthcertificates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $healthcertificate = HealthCertificate::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $healthcertificate->update(['read' => true]);

        return view('admin.healthcertificates.show', compact('healthcertificate'));
    }

    //Generate PDF

    // public function print_reportgr($id)
    // {
    //     $healthcertificate=HealthCertificate::findOrFail($id);

    //   if($healthcertificate['uploaded_report'])
    //     {
    //         return redirect($healthcertificate['report_pdfCertificate']);
    //     }

    //   //generate pdf
    //     $categories=Category::all();

    //   foreach($categories as $category)
    //     {
    //         $tests=GroupTest::whereHas('test',function($query)use($category){
    //             return $query->where('category_id',$category['id']);
    //         })->where('group_id',$healthcertificate['id'])->get();

    //       $category['tests']=$tests->sortBy(function($test){
    //                                 return $test->test->components->count();
    //                             });

    //       $category['cultures']=GroupCulture::whereHas('culture',function($query)use($category){
    //             return $query->where('category_id',$category['id']);
    //         })->where('group_id',$healthcertificate['id'])->get();
    //     }

    //   $pdfCertificate=generate_pdfCertificate([
    //         'categories'=>$categories,
    //         'group'=>$healthcertificate,
    //     ]);

    // //   if(isset($pdf3))
    // //     {
    // //         $healthcertificate->update(['report_pdf3'=>$pdf3]);
    // //     }

    //   return redirect($pdfCertificate);//return pdf url
    // }

    public function report_healthcertificate($id)
    {
        $healthcertificate = HealthCertificate::findOrFail($id);

        $pdfC = generate_pdfC($healthcertificate, 7);

        return redirect($pdfC);
    }

    public function bulk_print_report_healthcertificate(BulkActionRequest $request)
    {
        $healthcertificates = HealthCertificate::whereIn('id', $request['ids'])->get();

        $pdf = print_bulk_report_healthcertificate($healthcertificates);

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
        $healthcertificate = HealthCertificate::where('branch_id', session('branch_id'))
            ->findOrFail($id);
        $doctors = Doctor::all();
        $branches = Branch::all();
        $health = HealthCertificate::all()->last();
        $number = (int) substr($health['protocol_no'], -6);
        $generate = $number;

        $health = HealthCertificate::all()->last();
        $number = (int) substr($health['reg_no'], -6);
        $generate_no = $number;

        $healthcertificate->update(['read' => true]);

        return view('admin.healthcertificates.edit', compact('healthcertificate', 'generate', 'generate_no', 'doctors', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HealthCertificateRequest $request, $id)
    {
        $healthcertificate = HealthCertificate::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $healthcertificate->update($request->except('_token', '_method', 'patient_type', 'tests', 'cultures', 'packages', 'antibiotics', 'doctors'));

        //tests
        $healthcertificate->healthcertificate_tests()->delete();
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $test,
                    'testable_type' => \App\Models\Test::class,
                ]);
            }
        }

        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $culture,
                    'testable_type' => \App\Models\Culture::class,
                ]);
            }
        }

        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $package,
                    'testable_type' => \App\Models\Package::class,
                ]);
            }
        }
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $antibiotic) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $antibiotic,
                    'testable_type' => \App\Models\Antibiotic::class,
                ]);
            }
        }

        if ($request->has('doctors')) {
            foreach ($request['doctors'] as $doctor) {
                $healthcertificate->healthcertificate_tests()->create([
                    'testable_id' => $doctor,
                    'testable_type' => \App\Models\Doctor::class,
                ]);
            }
        }

        if ($request->has('attach')) {
            $attach = $request->file('attach');
            $name = time().'.'.$attach->getClientOriginalExtension();
            $attach->move('uploads/healthcertificates', $name);
            $healthcertificate = HealthCertificate::find($id);
            $healthcertificate->update(['attach' => $name]);
        }

        session()->flash('success', __('Health Certificate updated successfully'));

        return redirect()->route('admin.healthcertificates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $healthcertificate = HealthCertificate::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $healthcertificate->healthcertificate_tests()->delete();
        $healthcertificate->delete();

        session()->flash('success', __('Health Certificate deleted successfully'));

        return redirect()->route('admin.healthcertificates.index');

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
            $healthcertificate = HealthCertificate::where('branch_id', session('branch_id'))->find($id);
            $healthcertificate->healthcertificate_tests()->delete();
            $healthcertificate->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.healthcertificates.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_tests($visit_id)
    {
        $healthcertificate = HealthCertificate::where('branch_id', session('branch_id'))
            ->findOrFail($visit_id);

        $healthcertificate->update([
            'read' => true,
            'status' => true,
        ]);

        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $packages = Package::all();
        $antibiotics = Antibiotic::all();
        $doctors = Doctor::all();
        $contracts = Contract::all();

        return view('admin.groups.create', compact('healthcertificate', 'tests', 'cultures', 'packages', 'antibiotics', 'contracts', 'doctors'));
    }

    public function healthcertificate_pdfs($id, $type = 1)
    {

        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');

        $healthcertificate = HealthCertificate::findOrFail($id);

        $pdf = PDF::loadView('admin.healthcertificates.healthcertificate_pdfs', compact(
            'healthcertificate',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        return $pdf->stream('healthcertificates_'.'report'.'.pdf');

    }
}
