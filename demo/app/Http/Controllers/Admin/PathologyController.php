<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pathology;
use App\Http\Requests\Admin\PathologyRequest;
use DataTables;
use App\Models\Patient;
use App\Models\Group;
use App\Models\PathologyPaptest;
use PDF;

class PathologyController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view_pathologys',     ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_pathologys',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_pathologys',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_pathologys',   ['only' => ['destroy', 'bulk_delete']]);
        // $this->middleware('can:create_group',   ['only' => ['create_tests']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pathologys.index');
    }

    /**
     * get visits datatable
     *
     * @access public
     * @var  @Request $request
     */
    public function ajax(Request $request)
    {
        $model = Pathology::with('patient', 'doctors')
            ->where('branch_id', session('branch_id'))
            ->orderBy('id', 'desc');

        if ($request['filter_read'] != null) {
            $model->where('read', $request['filter_read']);
        }

        if ($request['filter_status'] != null) {
            $model->where('status', $request['filter_status']);
        }

        return DataTables::eloquent($model)

            ->editColumn('read', function ($pathology) {
                return view('admin.pathologys._read', compact('pathology'));
            })
            ->editColumn('status', function ($pathology) {
                return view('admin.pathologys._status', compact('pathology'));
            })
            ->editColumn('reports', function ($pathology) {
                return view('admin.pathologys._reports', compact('pathology'));
            })
            ->addColumn('action', function ($pathology) {
                return view('admin.pathologys._action', compact('pathology'));
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
        return view('admin.pathologys.create');
    }

    public function createCytology()
    {
        return view('admin.pathologys.createCytology');
    }

    public function createPapTest()
    {
        return view('admin.pathologys.createPapTest');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PathologyRequest $request)
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
                'api_token' => Str::random(32)
            ]);
        }

        $pathology = Pathology::create([
            'patient_id' => $patient['id'],
            'visit_type' => $request['visit_type'],
            'clinical_diagnosis' => $request['clinical_diagnosis'],
            'reference' => $request['reference'],
            'doctor_id' => $request['doctor_id'],
            'branch_id' => session('branch_id'),
            'births' => $request['births'],
            'abortions' => $request['abortions'],
            'menstrual_cycle' => $request['menstrual_cycle'],
            'pap_tests' => $request['pap_tests'],
            'hysterectomy' => $request['hysterectomy'],
            'chemotherapy' => $request['chemotherapy'],
            'radiation' => $request['radiation'],
            'hormonal_therapy' => $request['hormonal_therapy'],
            'cytological_examination' => $request['cytological_examination'],
            'microscopic_examination' => $request['microscopic_examination'],
            'macroscopic_examination' => $request['macroscopic_examination'],
            'sample' => $request['sample'],
            'pathologist' => $request['pathologist'],
            'report' => $request['report'],
            'histopathological' => $request['histopathological']
        ]);




        if ($request->has('attach')) {
            $attach = $request->file('attach');
            $name = time() . '.' . $attach->getClientOriginalExtension();
            $attach->move('uploads/pathologys', $name);
            $visit->update(['attach' => $name]);
        }

        session()->flash('success', __('Visit saved successfully'));

        return redirect()->route('admin.pathologys.index');
    }

    public function storePapTest(Request $request)
    {
        // dd($request);

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
                'api_token' => Str::random(32)
            ]);
        }

        $pathology = Pathology::create([
            'patient_id' => $patient['id'],
            'visit_type' => $request['visit_type'],
            'clinical_diagnosis' => $request['clinical_diagnosis'],
            'reference' => $request['reference'],
            'doctor_id' => $request['doctor_id'],
            'branch_id' => session('branch_id'),
            'births' => $request['births'],
            'abortions' => $request['abortions'],
            'menstrual_cycle' => $request['menstrual_cycle'],
            'pap_tests' => $request['pap_tests'],
            'hysterectomy' => $request['hysterectomy'],
            'chemotherapy' => $request['chemotherapy'],
            'radiation' => $request['radiation'],
            'hormonal_therapy' => $request['hormonal_therapy'],
            'cytological_examination' => $request['cytological_examination'],
            'microscopic_examination' => $request['microscopic_examination'],
            'macroscopic_examination' => $request['macroscopic_examination'],
            'sample' => $request['sample'],
            'pathologist' => $request['pathologist'],
            'report' => $request['report'],
            'histopathological' => $request['histopathological']
        ]);

        $paptest = PathologyPaptest::create([
            'pathology_id' => $pathology['id'],
            // 'sample_conventional' => $request['sample_conventional'],
            'sample_conventional' => $request->has('sample_conventional') ? 1 : 0,
            'sample_other' => $request['sample_other'],
            //'sample_satisfactory' => $request->sample_satisfactory,
            'sample_satisfactory' => $request->has('sample_satisfactory') ? 1 : 0,
            'sample_unsatisfactory' => $request['sample_unsatisfactory'],
            'sample_negative' => $request->has('sample_negative') ? 1 : 0,
            'sample_abnormal' =>  $request->has('sample_abnormal') ? 1 : 0,
            'reactive_changes' => $request->has('reactive_changes') ? 1 : 0,
            'inflammation' =>  $request->has('inflammation') ? 1 : 0,
            'iud' =>  $request->has('iud') ? 1 : 0,
            'repair_changes' =>  $request->has('repair_changes') ? 1 : 0,
            'radiation' =>  $request->has('radiation') ? 1 : 0,
            'cylinder_cells' =>  $request->has('cylinder_cells') ? 1 : 0,
            'squamous_metaplasia' =>  $request->has('squamous_metaplasia') ? 1 : 0,
            'atrophy' =>  $request->has('atrophy') ? 1 : 0,
            'pregnancy_related' =>  $request->has('pregnancy_related') ? 1 : 0,
            'hormonal_status' =>  $request->has('hormonal_status') ? 1 : 0,
            'endometrial_cells' =>  $request->has('endometrial_cells') ? 1 : 0,
            'squamous_cells' =>  $request->has('squamous_cells') ? 1 : 0,
            'atypical_squamous' => $request->has('atypical_squamous') ? 1 : 0,
            'ascus' =>  $request->has('ascus') ? 1 : 0,
            'asc_h' =>  $request->has('asc_h') ? 1 : 0,
            'lsil' =>  $request->has('lsil') ? 1 : 0,
            'hsil' =>  $request->has('hsil') ? 1 : 0,
            'suspicious_patterns' => $request->has('suspicious_patterns') ? 1 : 0,
            'squamous_carcinoma' =>  $request->has('squamous_carcinoma') ? 1 : 0,
            'glandular_cells' =>  $request->has('glandular_cells') ? 1 : 0,
            'atypical_glandular' =>  $request->has('atypical_glandular') ? 1 : 0,
            'endocervical' =>  $request->has('endocervical') ? 1 : 0,
            'endometrial' =>  $request->has('endometrial') ? 1 : 0,
            'glandular' =>  $request->has('glandular') ? 1 : 0,
            'neoplastic_cells' =>  $request->has('neoplastic_cells') ? 1 : 0,
            'endocervical_in' =>  $request->has('endocervical_in') ? 1 : 0,
            'adenocarcinoma' =>  $request->has('adenocarcinoma') ? 1 : 0,
            'endocervical_ade' =>  $request->has('endocervical_ade') ? 1 : 0,
            'endometrial_ade' => $request->has('endometrial_ade') ? 1 : 0,
            'other_neoplasm' =>  $request['other_neoplasm'],
            'repeat_treatment' =>  $request->has('repeat_treatment') ? 1 : 0,
            'repeat_date' =>  $request['repeat_date'],
            'hpv_typing1' =>  $request->has('hpv_typing1') ? 1 : 0,
            'hpv_typing2' =>  $request->has('hpv_typing2') ? 1 : 0,
            'hpv_typing3' =>  $request->has('hpv_typing3') ? 1 : 0,
            'biopsy' =>  $request->has('biopsy') ? 1 : 0,
            'comment' => $request['comment'],
        ]);

        session()->flash('success', __('PapTest saved successfully'));

        return redirect()->route('admin.pathologys.index');
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
        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $pathology->update(['read' => true]);

        return view('admin.pathologys.edit', compact('pathology'));
    }

    public function editCytology($id)
    {
        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $pathology->update(['read' => true]);

        return view('admin.pathologys.editCytology', compact('pathology'));
    }

    public function editPapTest($id)
    {
        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);
        // dd($pathology);
        $pathology->update(['read' => true]);

        return view('admin.pathologys.editPaptest', compact('pathology'));
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
        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $pathology->update($request->except('_token', '_method'));

        session()->flash('success', __('Pathology updated successfully'));

        return redirect()->route('admin.pathologys.index');
    }

    public function updateCytology(Request $request, $id)
    {
        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $pathology->update($request->except('_token', '_method'));

        session()->flash('success', __('Pathology updated successfully'));

        return redirect()->route('admin.pathologys.index');
    }

    public function updatePapTest(Request $request, $id)
    {
        // Find the existing pathology record
        $pathology = Pathology::findOrFail($id);

        // Update other pathology fields
        $pathology->visit_type = $request['visit_type'];
        $pathology->clinical_diagnosis = $request['clinical_diagnosis'];
        $pathology->reference = $request['reference'];
        $pathology->doctor_id = $request['doctor_id'];
        $pathology->branch_id = session('branch_id');
        $pathology->births = $request['births'];
        $pathology->abortions = $request['abortions'];
        $pathology->menstrual_cycle = $request['menstrual_cycle'];
        $pathology->pap_tests = $request['pap_tests'];
        $pathology->hysterectomy = $request['hysterectomy'];
        $pathology->chemotherapy = $request['chemotherapy'];
        $pathology->radiation = $request['radiation'];
        $pathology->hormonal_therapy = $request['hormonal_therapy'];
        $pathology->cytological_examination = $request['cytological_examination'];
        $pathology->microscopic_examination = $request['microscopic_examination'];
        $pathology->macroscopic_examination = $request['macroscopic_examination'];
        $pathology->sample = $request['sample'];
        $pathology->pathologist = $request['pathologist'];
        $pathology->report = $request['report'];
        $pathology->histopathological = $request['histopathological'];

        // Update the pathology record
        $pathology->save();

        // Update the PathologyPaptest record
        $paptest = $pathology->paptest;
        $paptest->sample_conventional = $request->has('sample_conventional') ? 1 : 0;
        $paptest->sample_other = $request['sample_other'];
        $paptest->sample_satisfactory = $request->has('sample_satisfactory') ? 1 : 0;
        $paptest->sample_unsatisfactory = $request['sample_unsatisfactory'];
        $paptest->sample_negative = $request->has('sample_negative') ? 1 : 0;
        $paptest->sample_abnormal = $request->has('sample_abnormal') ? 1 : 0;
        $paptest->reactive_changes = $request->has('reactive_changes') ? 1 : 0;
        $paptest->inflammation = $request->has('inflammation') ? 1 : 0;
        $paptest->iud = $request->has('iud') ? 1 : 0;
        $paptest->repair_changes = $request->has('repair_changes') ? 1 : 0;
        $paptest->radiation = $request->has('radiation') ? 1 : 0;
        $paptest->cylinder_cells = $request->has('cylinder_cells') ? 1 : 0;
        $paptest->squamous_metaplasia = $request->has('squamous_metaplasia') ? 1 : 0;
        $paptest->atrophy = $request->has('atrophy') ? 1 : 0;
        $paptest->pregnancy_related = $request->has('pregnancy_related') ? 1 : 0;
        $paptest->hormonal_status = $request->has('hormonal_status') ? 1 : 0;
        $paptest->endometrial_cells = $request->has('endometrial_cells') ? 1 : 0;
        $paptest->squamous_cells = $request->has('squamous_cells') ? 1 : 0;
        $paptest->atypical_squamous = $request->has('atypical_squamous') ? 1 : 0;
        $paptest->ascus = $request->has('ascus') ? 1 : 0;
        $paptest->asc_h = $request->has('asc_h') ? 1 : 0;
        $paptest->lsil = $request->has('lsil') ? 1 : 0;
        $paptest->hsil = $request->has('hsil') ? 1 : 0;
        $paptest->suspicious_patterns = $request->has('suspicious_patterns') ? 1 : 0;
        $paptest->squamous_carcinoma = $request->has('squamous_carcinoma') ? 1 : 0;
        $paptest->glandular_cells = $request->has('glandular_cells') ? 1 : 0;
        $paptest->atypical_glandular = $request->has('atypical_glandular') ? 1 : 0;
        $paptest->endocervical = $request->has('endocervical') ? 1 : 0;
        $paptest->endometrial = $request->has('endometrial') ? 1 : 0;
        $paptest->glandular = $request->has('glandular') ? 1 : 0;
        $paptest->neoplastic_cells = $request->has('neoplastic_cells') ? 1 : 0;
        $paptest->endocervical_in = $request->has('endocervical_in') ? 1 : 0;
        $paptest->adenocarcinoma = $request->has('adenocarcinoma') ? 1 : 0;
        $paptest->endocervical_ade = $request->has('endocervical_ade') ? 1 : 0;
        $paptest->endometrial_ade = $request->has('endometrial_ade') ? 1 : 0;
        $paptest->other_neoplasm = $request['other_neoplasm'];
        $paptest->repeat_treatment = $request->has('repeat_treatment') ? 1 : 0;
        $paptest->repeat_date = $request['repeat_date'];
        $paptest->hpv_typing1 = $request->has('hpv_typing1') ? 1 : 0;
        $paptest->hpv_typing2 = $request->has('hpv_typing2') ? 1 : 0;
        $paptest->hpv_typing3 = $request->has('hpv_typing3') ? 1 : 0;
        $paptest->biopsy = $request->has('biopsy') ? 1 : 0;
        $paptest->comment = $request['comment'];

        // Update the PathologyPaptest record
        $paptest->save();

        session()->flash('success', __('PapTest updated successfully'));

        return redirect()->route('admin.pathologys.index');
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

    public function pathologyPdf($id, $type = 1)
    {
        $info_settings = setting("info");
        $reports_settings = setting("reports");
        $barcode_settings = setting("barcode");


        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);


        $pdf = PDF::loadView('admin.pathologys.pathology_pdf', compact(
            'pathology',
            "reports_settings",
            "info_settings",
            "type",
            "barcode_settings"
        ));

        $filename = 'pathology_' . '.pdf';
        $pdf->save("uploads/pdf_pathology/" . $filename);
        $path = url("uploads/pdf_pathology/" . $filename);


        return $pdf->stream($filename);
    }

    public function pathology2Pdf($id, $type = 1)
    {
        $info_settings = setting("info");
        $reports_settings = setting("reports");
        $barcode_settings = setting("barcode");


        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);


        $pdf = PDF::loadView('admin.pathologys.pathology2_pdf', compact(
            'pathology',
            "reports_settings",
            "info_settings",
            "type",
            "barcode_settings"
        ));

        $filename = 'pathology2_' . '.pdf';
        $pdf->save("uploads/pdf_pathology/" . $filename);
        $path = url("uploads/pdf_pathology/" . $filename);


        return $pdf->stream($filename);
    }

    public function cytologicalPdf($id, $type = 1)
    {
        $info_settings = setting("info");
        $reports_settings = setting("reports");
        $barcode_settings = setting("barcode");


        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);


        $pdf = PDF::loadView('admin.pathologys.cytological_pdf', compact(
            'pathology',
            "reports_settings",
            "info_settings",
            "type",
            "barcode_settings"
        ));

        $filename = 'pathology_cytological_' . '.pdf';
        $pdf->save("uploads/pdf_pathology/" . $filename);
        $path = url("uploads/pdf_pathology/" . $filename);


        return $pdf->stream($filename);
    }

    public function papTestPdf($id, $type = 1)
    {
        $info_settings = setting("info");
        $reports_settings = setting("reports");
        $barcode_settings = setting("barcode");


        $pathology = Pathology::with('paptest')->where('branch_id', session('branch_id'))
            ->findOrFail($id);

            // dd($pathology);
        $pdf = PDF::loadView('admin.pathologys.paptest_pdf', compact(
            'pathology',
            "reports_settings",
            "info_settings",
            "type",
            "barcode_settings"
        ));

        $filename = 'pathology_paptest_' . '.pdf';
        $pdf->save("uploads/pdf_pathology/" . $filename);
        $path = url("uploads/pdf_pathology/" . $filename);


        return $pdf->stream($filename);
    }
}
