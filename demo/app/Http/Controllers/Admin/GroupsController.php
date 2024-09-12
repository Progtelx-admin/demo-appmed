<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ResultsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\GroupRequest;
use App\Models\Antibiotic;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\Culture;
use App\Models\CultureOption;
use App\Models\Group;
use App\Models\GroupAntibiotic;
use App\Models\GroupCulture;
use App\Models\GroupCultureOption;
use App\Models\GroupCultureResult;
use App\Models\GroupPackage;
use App\Models\GroupService;
use App\Models\GroupTest;
use App\Models\GroupTestResult;
use App\Models\GroupMicrobiologyTest;
use App\Models\GroupMicrobiologyTestResult;
use App\Models\Package;
use App\Models\Patient;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Test;
use App\Models\MicrobiologyTest;
use App\Models\PointOfSale;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DataTables;
use Excel;
use Illuminate\Http\Request;
use PDF;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class GroupsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_group', ['only' => ['index', 'show', 'ajax', 'send_receipt_mail']]);
        $this->middleware('can:create_group', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_group', ['only' => ['edit', 'updae']]);
        $this->middleware('can:delete_group', ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(Auth::guard('admin')->user()->id);

        if (!$user->pointOfSale) {
            return view('admin.pos_transactions.error');
        }

        return view('admin.groups.index');
    }

    /**
     * get groups datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        // //bp
        // $today = Carbon::today();

        // $model = Group::with('patient', 'contract', 'created_by_user')
        //     ->where('branch_id', session('branch_id'))
        //     ->whereDate('created_at', $today);

        $model = Group::with('patient', 'contract', 'created_by_user')
            ->where('branch_id', session('branch_id'));

        if ($request['filter_status'] != '') {
            $model->where('done', $request['filter_status']);
        }

        if ($request['filter_barcode'] != '') {
            $model->where('barcode', $request['filter_barcode']);
        }

        if ($request['filter_created_by'] != '') {
            $model->whereIn('created_by', $request['filter_created_by']);
        }

        if ($request['filter_contract'] != '') {
            $model->whereIn('contract_id', $request['filter_contract']);
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

        $summaryQuery = clone $model;

        // Calculate summary values based on the filtered query
        $summary = [
            'total' => $summaryQuery->sum('total'),
            'subtotal' => $summaryQuery->sum('subtotal'),
            'discount' => $summaryQuery->sum('discount_fix'),
            'paid' => $summaryQuery->sum('paid'),
            'due' => $summaryQuery->sum('due'),
        ];

        return DataTables::eloquent($model)
        // ->editColumn('subtotal',function($group){
        //     return formated_price($group['subtotal']);
        // })
        // ->editColumn('discount',function($group){
        //     return formated_price($group['discount']);
        // })
        // ->editColumn('total',function($group){
        //     return formated_price($group['total']);
        // })
        // ->editColumn('paid',function($group){
        //     return formated_price($group['paid']);
        // })
        // ->editColumn('due',function($group){
        //     return view('admin.groups._due',compact('group'));
        // })
            ->editColumn('done', function ($group) {
                return view('admin.groups._status', compact('group'));
            })
            ->editColumn('api', function ($group) {
                return view('admin.groups._fiscal', compact('group'));
            })
            ->addColumn('action', function ($group) {
                return view('admin.groups._action', compact('group'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->editColumn('created_at', function ($group) {
                return date('Y-m-d H:i', strtotime($group['created_at']));
            })
            ->with('summary', $summary)
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     return view('admin.groups.create');
    // }

    public function create()
    {
        $defaultContract = Contract::find(49);

        return view('admin.groups.create', ['defaultContract' => $defaultContract]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        $group = Group::create($request->except('_token', 'tests', 'cultures', 'packages', 'services','microbiology_tests', 'antibiotics', 'payments', 'DataTables_Table_0_length', 'DataTables_Table_1_length', 'DataTables_Table_2_length'));

        $group->update([
            'branch_id' => session('branch_id'),
            'created_by' => auth()->guard('admin')->user()->id,

            // Vetem per testim
            'pos' => auth()->guard('admin')->user()->pointOfSale->id,
            'fiscalized' => 1
        ]);

        // Get current date
        $current_date = date('Y-m-d');

        // Get max daily count for GroupTest GroupCulture
        $max_group_test_count = GroupTest::whereDate('created_at', $current_date)
            ->max('daily_count');
        $max_group_culture_count = GroupCulture::whereDate('created_at', $current_date)
            ->max('daily_count');
        //bp
        $max_group_service_count = GroupService::whereDate('created_at', $current_date)
            ->max('daily_count');
        // Increment count by 1
        $group_test_daily_count = $max_group_test_count + 1;
        $group_culture_daily_count = $max_group_culture_count + 1;
        //bp
        $group_service_daily_count = $max_group_service_count + 1;

        //store assigned tests
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                GroupTest::create([
                    'group_id' => $group->id,
                    'test_id' => $test['id'],
                    'price' => $test['price'],
                    'daily_count' => $group_test_daily_count,
                ]);
            }
        }

        //store assigned services
        if ($request->has('services')) {
            foreach ($request['services'] as $service) {
                GroupService::create([
                    'group_id' => $group->id,
                    'service_id' => $service['id'],
                    'price' => $service['price'],
                    //bp
                    'daily_count' => $group_service_daily_count,
                ]);
            }
        }

        // Store assigned microbiology tests
        if ($request->has('microbiology_tests')) {
            foreach ($request['microbiology_tests'] as $microbiologyTest) {
                GroupMicrobiologyTest::create([
                    'group_id' => $group->id,
                    'test_id' => $microbiologyTest['id'],
                    'price' => $microbiologyTest['price'],
                ]);
            }
        }

        //  dd($group['services'],$service);

        //store assigned cultures
        $culture_options = CultureOption::where('parent_id', 0)->get();
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $group_culture = GroupCulture::create([
                    'group_id' => $group->id,
                    'culture_id' => $culture['id'],
                    'price' => $culture['price'],
                    'daily_count' => $group_culture_daily_count,
                ]);

                //assign default report
                foreach ($culture_options as $culture_option) {
                    GroupCultureOption::create([
                        'group_culture_id' => $group_culture['id'],
                        'culture_option_id' => $culture_option['id'],
                    ]);
                }
            }
        }

        //store assigned packages
        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                // packages tests and cultures
                $original_package = Package::find($package['id']);

                $group_package = GroupPackage::create([
                    'group_id' => $group['id'],
                    'package_id' => $package['id'],
                    'price' => $package['price'],
                ]);

                //store assigned antibiotics
                if ($request->has('antibiotics')) {
                    foreach ($request['antibiotics'] as $antibiotic) {
                        GroupAntibiotic::create([
                            'group_id' => $group->id,
                            'antibiotic_id' => $antibiotic['id'],
                            'price' => $antibiotic['price'],
                        ]);
                    }
                }

                //tests
                foreach ($original_package['tests'] as $test) {
                    GroupTest::create([
                        'group_id' => $group['id'],
                        'test_id' => $test['test']['id'],
                        'package_id' => $group_package['id'],
                    ]);
                }

                //tests
                foreach ($original_package['microbiology_tests'] as $test) {
                    GroupMicrobiologyTest::create([
                        'group_id' => $group['id'],
                        'test_id' => $test['microbiologyTest']['id'],
                        'package_id' => $group_package['id'],
                    ]);
                }

                //cultures
                foreach ($original_package['cultures'] as $culture) {
                    $group_culture = GroupCulture::create([
                        'group_id' => $group['id'],
                        'culture_id' => $culture['culture']['id'],
                        'package_id' => $group_package['id'],
                    ]);

                    //assign default report
                    foreach ($culture_options as $culture_option) {
                        GroupCultureOption::create([
                            'group_culture_id' => $group_culture['id'],
                            'culture_option_id' => $culture_option['id'],
                        ]);
                    }
                }
            }
        }

        //payments
        // if ($request->has('payments')) {
        //     foreach ($request['payments'] as $payment) {
        //         $group->payments()->create([
        //             'date' => $payment['date'],
        //             'payment_method_id' => $payment['payment_method_id'],
        //             'amount' => $payment['amount'],
        //         ]);
        //     }
        // }


        if ($request->has('payments')) {
            foreach ($request['payments'] as $payment) {
                $pointOfSaleId = Auth::guard('admin')->user()->pointOfSale->id;
                $pointOfSale = PointOfSale::findOrFail($pointOfSaleId);

                $paymentAmount = $payment['amount'];
                $paymentMethodId = $payment['payment_method_id'];

                // If payment method ID is 1, update cash_in_hand
                if ($paymentMethodId == 1) {
                    $updatedCashInHand = $pointOfSale->cash_in_hand + $paymentAmount;

                    // Update cash_in_hand
                    $pointOfSale->cash_in_hand = $updatedCashInHand;
                    $pointOfSale->save();
                }

                // Create payment record
                $group->payments()->create([
                    'date' => $payment['date'],
                    'payment_method_id' => $paymentMethodId,
                    'amount' => $paymentAmount,
                ]);
            }
        }

        //   dd($request);
        //barcode
        generate_barcode($group['id']);

        //assign default report
        $this->assign_tests_report($group['id']);

        //assign consumption
        $this->assign_consumption($group['id']);

        //calculations
        group_test_calculations($group['id']);

        //save receipt pdf
        $group = Group::find($group['id']);
        $pdf = generate_pdf($group, 2);

        if (isset($pdf)) {
            $group->update(['receipt_pdf' => $pdf]);
        }

        session()->flash('success', __('Group saved successfully'));

        //   return redirect()->route('admin.groups.show',$group['id']);
        return redirect()->route('admin.groups.index');
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
        $barcode_settings = setting('barcode');

        return view('admin.groups.show', compact('group', 'barcode_settings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::with(['tests.test.test_price', 'cultures.culture.culture_price', 'packages.package.package_price', 'antibiotics.antibiotic.antibiotic_price', 'services.service.service_price'])
            ->where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $packages = Package::all();
        $antibiotics = Antibiotic::all();
        $services = Service::all();

        $defaultContract = Contract::find(49);
        $currentContract = isset($group->contract) ? $group->contract : $defaultContract;

        return view('admin.groups.edit', compact('group', 'tests', 'cultures', 'packages', 'antibiotics', 'services', 'currentContract', 'defaultContract'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orderTests($id)
    {
        $group = Group::findOrFail($id);
        $tests = $group->tests()->orderBy('order')->get();

        return view('admin.groups.order-tests', compact('group', 'tests'));
    }

    public function updateTestOrder(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $tests = $group->tests;
        $order = 1;
        foreach ($request->tests as $test) {
            $test_id = $test['id'];
            $group_test = $tests->firstWhere('id', $test_id);
            $group_test->pivot->order = $order;
            $group_test->pivot->save();
            $order++;
        }

        return redirect()->route('admin.groups.show', $group->id);
    }

    public function update(GroupRequest $request, $id)
    {
        $group = Group::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $group->update($request->except('_method',
            '_token',
            'tests',
            'cultures',
            'services',
            'microbiology_tests',
            'packages',
            'antibiotics',
            'payments',
            'DataTables_Table_0_length',
            'DataTables_Table_1_length',
            'DataTables_Table_2_length'
        ));

        $group->update([
            'contract_id' => (isset($request['contract_id'])) ? $request['contract_id'] : '',
        ]);

        $current_date = date('Y-m-d');

        if (isset($group->cultures) && count($group->cultures) > 0) {
            $daily_count_c = $group->cultures[0]->daily_count;
        } else {
            $max_group_culture_count = GroupCulture::whereDate('created_at', $current_date)->max('daily_count');
            $daily_count_c = $max_group_culture_count + 1;
        }

        if (isset($group->tests) && count($group->tests) > 0) {
            $daily_count_t = $group->tests[0]->daily_count;
        } else {
            $max_group_test_count = GroupTest::whereDate('created_at', $current_date)->max('daily_count');
            $daily_count_t = $max_group_test_count + 1;
        }

        if (isset($group->services) && count($group->services) > 0) {
            $daily_count_s = $group->services[0]->daily_count;
        } else {
            $max_group_service_count = GroupService::whereDate('created_at', $current_date)->max('daily_count');
            $daily_count_s = $max_group_service_count + 1;
        }

        //store assigned tests
        $selected_tests = [];
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $selected_tests[] = $test['id'];

                $group_test = GroupTest::where([
                    ['group_id', $id],
                    ['test_id', $test['id']],
                ])->first();

                if (isset($group_test)) {
                    $group_test->update([
                        'price' => $test['price'],
                    ]);
                } else {
                    GroupTest::create([
                        'group_id' => $group->id,
                        'test_id' => $test['id'],
                        'price' => $test['price'],
                        'daily_count' => $daily_count_t,
                    ]);
                }
            }
        }

        //delete unselected tests
        $group->tests()->whereNotIn('test_id', $selected_tests)->delete();

        // Store assigned microbiology tests
        $selected_microbiology_tests = [];
        if ($request->has('microbiology_tests')) {
            foreach ($request['microbiology_tests'] as $microbiologyTest) {
                $selected_microbiology_tests[] = $microbiologyTest['id'];

                $group_microbiology_test = GroupMicrobiologyTest::where([
                    ['group_id', $id],
                    ['test_id', $microbiologyTest['id']],
                ])->first();

                if (isset($group_microbiology_test)) {
                    $group_microbiology_test->update([
                        'price' => $microbiologyTest['price'],
                    ]);
                } else {
                    GroupMicrobiologyTest::create([
                        'group_id' => $group->id,
                        'test_id' => $microbiologyTest['id'],
                        'price' => $microbiologyTest['price'],
                    ]);
                }
            }
        }

        // Delete unselected microbiology tests
        $group->microbiology_tests()->whereNotIn('test_id', $selected_microbiology_tests)->delete();

        //store assigned services
        $selected_services = [];
        if ($request->has('services')) {
            foreach ($request['services'] as $service) {
                $selected_services[] = $service['id'];

                $group_service = GroupService::where([
                    ['group_id', $id],
                    ['service_id', $service['id']],
                ])->first();

                if (isset($group_service)) {
                    $group_service->update([
                        'price' => $service['price'],
                    ]);
                } else {
                    Groupservice::create([
                        'group_id' => $group->id,
                        'service_id' => $service['id'],
                        'price' => $service['price'],
                        'daily_count' => $daily_count_s,
                    ]);
                }
            }
        }

        //delete unselected services
        $group->services()->whereNotIn('service_id', $selected_services)->delete();

        //store assigned cultures
        $selected_cultures = [];
        $culture_options = CultureOption::where('parent_id', 0)->get();
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $selected_cultures[] = $culture['id'];

                $group_culture = GroupCulture::where([
                    ['group_id', $id],
                    ['culture_id', $culture['id']],
                ])->first();

                if (isset($group_culture)) {
                    $group_culture->update([
                        'price' => $culture['price'],
                    ]);
                } else {
                    $group_culture = GroupCulture::create([
                        'group_id' => $group->id,
                        'culture_id' => $culture['id'],
                        'price' => $culture['price'],
                        'daily_count' => $daily_count_c,
                    ]);

                    //assign default report
                    foreach ($culture_options as $culture_option) {
                        GroupCultureOption::create([
                            'group_culture_id' => $group_culture['id'],
                            'culture_option_id' => $culture_option['id'],
                        ]);
                    }
                }
            }
        }

        //delete unselected cultures
        // $group->cultures()->whereNotIn('culture_id',$selected_cultures)->get();
        //delete unselected cultures bp ek
        $group->cultures()->whereNotIn('culture_id', $selected_cultures)->delete();

        //store assigned packages
        $packages_selected = [];
        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $packages_selected[] = $package['id'];

                $group_package = GroupPackage::where([
                    ['group_id', $id],
                    ['package_id', $package['id']],
                ])->first();

                // original package
                $original_package = Package::find($package['id']);

                if (isset($group_package)) {
                    $group_package->update([
                        'price' => $package['price'],
                    ]);
                } else {
                    $group_package = GroupPackage::create([
                        'group_id' => $group['id'],
                        'package_id' => $package['id'],
                        'price' => $package['price'],
                    ]);

                    //tests
                    foreach ($original_package['tests'] as $test) {
                        GroupTest::create([
                            'group_id' => $group['id'],
                            'test_id' => $test['test']['id'],
                            'package_id' => $group_package['id'],
                        ]);
                    }

                    //cultures
                    foreach ($original_package['cultures'] as $culture) {
                        $group_culture = GroupCulture::create([
                            'group_id' => $group['id'],
                            'culture_id' => $culture['culture']['id'],
                            'package_id' => $group_package['id'],
                        ]);

                        //assign default report
                        foreach ($culture_options as $culture_option) {
                            GroupCultureOption::create([
                                'group_culture_id' => $group_culture['id'],
                                'culture_option_id' => $culture_option['id'],
                            ]);
                        }
                    }
                }
            }
        }

        //delete unselected packages
        $unselected_packages = GroupPackage::where([
            ['group_id', $id],
        ])->whereNotIn('package_id', $packages_selected)
            ->get();

        if (count($unselected_packages)) {
            foreach ($unselected_packages as $unselected_package) {
                $unselected_package->tests()->delete();
                $unselected_package->cultures()->delete();
                $unselected_package->delete();
            }
        }
        //store assigned antibiotics
        $selected_antibiotics = [];
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $antibiotic) {
                $selected_antibiotics[] = $antibiotic['id'];

                $group_antibiotic = GroupAntibiotic::where([
                    ['group_id', $id],
                    ['antibiotic_id', $antibiotic['id']],
                ])->first();

                if (isset($group_antibiotic)) {
                    $group_antibiotic->update([
                        'price' => $antibiotic['price'],
                    ]);
                } else {
                    GroupAntibiotic::create([
                        'group_id' => $group->id,
                        'antibiotic_id' => $antibiotic['id'],
                        'price' => $antibiotic['price'],
                    ]);
                }
            }
        }

        //delete unselected antibiotic
        $group->antibiotics()->whereNotIn('antibiotic_id', $selected_antibiotics)->delete();

        //payments
        // $group->payments()->delete();
        // if ($request->has('payments')) {
        //     foreach ($request['payments'] as $payment) {
        //         $group->payments()->create([
        //             'date' => $payment['date'],
        //             'payment_method_id' => $payment['payment_method_id'],
        //             'amount' => $payment['amount'],
        //         ]);
        //     }
        // }

        //LM NEW
        $oldPayments = $group->payments()->get();

        foreach ($oldPayments as $oldPayment) {
            $oldAmount = $oldPayment->amount;
            $oldPaymentMethodId = $oldPayment->payment_method_id;

            // If the old payment method was cash (ID 1), subtract the old amount from cash_in_hand
            if ($oldPaymentMethodId == 1) {
                $pointOfSaleId = Auth::guard('admin')->user()->pointOfSale->id;
                $pointOfSale = PointOfSale::findOrFail($pointOfSaleId);

                $pointOfSale->cash_in_hand -= $oldAmount;
                $pointOfSale->save();
            }
        }

        // Delete old payments
        $group->payments()->delete();

        // Add new payments and update cash_in_hand if payment method is cash
        if ($request->has('payments')) {
            foreach ($request['payments'] as $payment) {
                $paymentAmount = $payment['amount'];
                $paymentMethodId = $payment['payment_method_id'];

                // If payment method ID is 1, update cash_in_hand
                if ($paymentMethodId == 1) {
                    $pointOfSaleId = Auth::guard('admin')->user()->pointOfSale->id;
                    $pointOfSale = PointOfSale::findOrFail($pointOfSaleId);

                    $pointOfSale->cash_in_hand += $paymentAmount;
                    $pointOfSale->save();
                }

                // Create payment record
                $group->payments()->create([
                    'date' => $payment['date'],
                    'payment_method_id' => $paymentMethodId,
                    'amount' => $paymentAmount,
                ]);
            }
        }


        //assign default report
        $this->assign_tests_report($id);

        //assign consumption
        $this->assign_consumption($group['id']);

        //calculations
        group_test_calculations($id);

        //save receipt pdf
        $group = Group::with(['tests', 'cultures', 'antibiotics', 'services'])->where('id', $id)->first();

        $pdf = generate_pdf($group, 2);

        if (isset($pdf)) {
            $group->update(['receipt_pdf' => $pdf]);
        }

        //send notification with the patient code
        $patient = Patient::find($group['patient_id']);
        send_notification('patient_code', $patient);

        session()->flash('success', __('Group updated successfully'));

        return redirect()->route('admin.groups.show', $id);
    }

    //Edit API Pantheon
    public function apipantheon($id)
    {
        $group = Group::with(['tests.test.test_price', 'cultures.culture.culture_price', 'packages.package.package_price', 'antibiotics.antibiotic.antibiotic_price', 'services.service.service_price'])
            ->where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $tests = Test::where('parent_id', 0)->orWhere('separated', true)->get();
        $cultures = Culture::all();
        $packages = Package::all();
        $antibiotics = Antibiotic::all();
        $services = Service::all();

        return view('admin.groups.editApi', compact('group', 'tests', 'cultures', 'packages', 'antibiotics', 'services'));
    }

    // ORDER SEND

    public function updateapi(GroupRequest $request, $id)
    {
        $group = Group::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $group->update($request->except('_method',
            '_token',
            'tests',
            'cultures',
            'packages',
            'antibiotics',
            'payments',
            'DataTables_Table_0_length',
            'DataTables_Table_1_length',
            'DataTables_Table_2_length'
        ));

        $group->update([
            'contract_id' => (isset($request['contract_id'])) ? $request['contract_id'] : '',
        ]);

        //store assigned tests
        $selected_tests = [];
        if ($request->has('tests')) {
            foreach ($request['tests'] as $test) {
                $selected_tests[] = $test['id'];

                $group_test = GroupTest::where([
                    ['group_id', $id],
                    ['test_id', $test['id']],
                ])->first();

                if (isset($group_test)) {
                    $group_test->update([
                        'price' => $test['price'],
                    ]);
                } else {
                    GroupTest::create([
                        'group_id' => $group->id,
                        'test_id' => $test['id'],
                        'price' => $test['price'],
                    ]);
                }
            }
        }

        //dd($selected_tests);

        //delete unselected tests
        $group->tests()->whereNotIn('test_id', $selected_tests)->delete();

        //store assigned cultures
        $selected_cultures = [];
        $culture_options = CultureOption::where('parent_id', 0)->get();
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $culture) {
                $selected_cultures[] = $culture['id'];

                $group_culture = GroupCulture::where([
                    ['group_id', $id],
                    ['culture_id', $culture['id']],
                ])->first();

                if (isset($group_culture)) {
                    $group_culture->update([
                        'price' => $culture['price'],
                    ]);
                } else {
                    $group_culture = GroupCulture::create([
                        'group_id' => $group->id,
                        'culture_id' => $culture['id'],
                        'price' => $culture['price'],
                    ]);

                    //assign default report
                    foreach ($culture_options as $culture_option) {
                        GroupCultureOption::create([
                            'group_culture_id' => $group_culture['id'],
                            'culture_option_id' => $culture_option['id'],
                        ]);
                    }
                }
            }
        }

        //delete unselected cultures
        $group->cultures()->whereNotIn('culture_id', $selected_cultures)->get();

        //store assigned packages
        $packages_selected = [];
        if ($request->has('packages')) {
            foreach ($request['packages'] as $package) {
                $packages_selected[] = $package['id'];

                $group_package = GroupPackage::where([
                    ['group_id', $id],
                    ['package_id', $package['id']],
                ])->first();

                // original package
                $original_package = Package::find($package['id']);

                if (isset($group_package)) {
                    $group_package->update([
                        'price' => $package['price'],
                    ]);
                } else {
                    $group_package = GroupPackage::create([
                        'group_id' => $group['id'],
                        'package_id' => $package['id'],
                        'price' => $package['price'],
                    ]);

                    //tests
                    foreach ($original_package['tests'] as $test) {
                        GroupTest::create([
                            'group_id' => $group['id'],
                            'test_id' => $test['test']['id'],
                            'package_id' => $group_package['id'],
                        ]);
                    }

                    //cultures
                    foreach ($original_package['cultures'] as $culture) {
                        $group_culture = GroupCulture::create([
                            'group_id' => $group['id'],
                            'culture_id' => $culture['culture']['id'],
                            'package_id' => $group_package['id'],
                        ]);

                        //assign default report
                        foreach ($culture_options as $culture_option) {
                            GroupCultureOption::create([
                                'group_culture_id' => $group_culture['id'],
                                'culture_option_id' => $culture_option['id'],
                            ]);
                        }
                    }
                }
            }
        }

        //delete unselected packages
        $unselected_packages = GroupPackage::where([
            ['group_id', $id],
        ])->whereNotIn('package_id', $packages_selected)
            ->get();

        if (count($unselected_packages)) {
            foreach ($unselected_packages as $unselected_package) {
                $unselected_package->tests()->delete();
                $unselected_package->cultures()->delete();
                $unselected_package->delete();
            }
        }
        //store assigned antibiotics
        $selected_antibiotics = [];
        if ($request->has('antibiotics')) {
            foreach ($request['antibiotics'] as $antibiotic) {
                $selected_antibiotics[] = $antibiotic['id'];

                $group_antibiotic = GroupAntibiotic::where([
                    ['group_id', $id],
                    ['antibiotic_id', $antibiotic['id']],
                ])->first();

                if (isset($group_antibiotic)) {
                    $group_antibiotic->update([
                        'price' => $antibiotic['price'],
                    ]);
                } else {
                    GroupAntibiotic::create([
                        'group_id' => $group->id,
                        'antibiotic_id' => $antibiotic['id'],
                        'price' => $antibiotic['price'],
                    ]);
                }
            }
        }

        //delete unselected antibiotic
        $group->antibiotics()->whereNotIn('antibiotic_id', $selected_antibiotics)->delete();
        //payments
        $group->payments()->delete();
        if ($request->has('payments')) {
            foreach ($request['payments'] as $payment) {
                $group->payments()->create([
                    'date' => $payment['date'],
                    'payment_method_id' => $payment['payment_method_id'],
                    'amount' => $payment['amount'],
                ]);
            }
        }

        //assign default report
        $this->assign_tests_report($id);

        //assign consumption
        $this->assign_consumption($group['id']);

        //calculations
        group_test_calculations($id);

        //save receipt pdf
        $group = Group::with(['tests', 'cultures', 'antibiotics', 'services'])->where('id', $id)->first();

        $pdf = generate_pdf($group, 2);

        if (isset($pdf)) {
            $group->update(['receipt_pdf' => $pdf]);
        }

        //send notification with the patient code
        $patient = Patient::find($group['patient_id']);
        send_notification('patient_code', $patient);

        //API Pantheon
        $requestapi = (new APIController)->order($patient, $group, $request);

        return redirect()->route('admin.groups.index');
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


        // Adjust cash_in_hand for cash payments associated with the group being deleted
        $cashPayments = $group->payments()->where('payment_method_id', 1)->get();
        foreach ($cashPayments as $payment) {
            $pointOfSaleId = Auth::guard('admin')->user()->pointOfSale->id;
            $pointOfSale = PointOfSale::findOrFail($pointOfSaleId);

            $pointOfSale->cash_in_hand -= $payment->amount;
            $pointOfSale->save();
        }
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


        // Delete group microbiology tests
        $group_microbiology_tests = GroupMicrobiologyTest::where('group_id', $id)->get();

        //delete group microbiology tests results
        foreach ($group_microbiology_tests as $group_microbiology_test) {
            GroupMicrobiologyTestResult::where('group_microbiology_test_id', $group_microbiology_test['id'])->delete();
        }
        GroupMicrobiologyTest::where('group_id', $id)->delete();

        //delete group antibiotics
        // $group_antibiotics=GroupAntibiotic::where('group_id',$id)->get();
        //bp
        $group_antibiotics = GroupAntibiotic::where('group_id', $id)->delete();

        //delete packages
        $group->packages()->delete();

        //delete consumption
        $group->consumptions()->delete();

        //delete group
        $group->delete();

        //return success
        session()->flash('success', __('Group deleted successfully'));

        return redirect()->route('admin.groups.index');
    }

    /**
     * generate pdf
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pdf($id)
    {
        $group = Group::with('patient', 'analyses', 'cultures')->where('id', $id)->first();

        $response = generate_pdf($group, 2);

        if (! empty($response)) {
            return redirect($response['url']);
        } else {
            session()->flash('failed', __('Something Went Wrong'));

            return redirect()->back();
        }

    }

    /**
     * assign default tests report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign_tests_report($id)
    {
        $group = Group::with('tests', 'packages.microbiology_tests')->where('id', $id)->first();

        //tests reports
        foreach ($group['tests'] as $test) {
            if (! $test->has_results) {
                $test->update(['has_results' => true]);

                $separated = Test::where('id', $test['test_id'])->first();

                if ($separated['separated']) {
                    GroupTestResult::create([
                        'group_test_id' => $test['id'],
                        'test_id' => $test['test_id'],
                    ]);
                }

                foreach ($test['test']['components'] as $component) {
                    GroupTestResult::create([
                        'group_test_id' => $test['id'],
                        'test_id' => $component['id'],
                    ]);
                }
            }
        }

        // microbiology tests
        foreach ($group['microbiology_tests'] as $microbiologyTest) {
            if (!$microbiologyTest->has_results) {
                $microbiologyTest->update(['has_results' => true]);

                $separated = MicrobiologyTest::where('id', $microbiologyTest['test_id'])->first();

                if ($separated['separated']) {
                    GroupMicrobiologyTestResult::create([
                        'group_microbiology_test_id' => $microbiologyTest['id'],
                        'test_id' => $microbiologyTest['test_id'],
                    ]);
                }

                foreach ($microbiologyTest['microbiologyTest']['components'] as $component) {
                    GroupMicrobiologyTestResult::create([
                        'group_microbiology_test_id' => $microbiologyTest['id'],
                        'test_id' => $component['id'],
                    ]);
                }
            }
        }

        //packages reports
        if (count($group['packages'])) {
            foreach ($group['packages'] as $package) {
                if (count($package['tests'])) {
                    foreach ($package['tests'] as $test) {
                        if (! $test->has_results) {
                            $test->update(['has_results' => true]);

                            $separated = Test::where('id', $test['test_id'])->first();

                            if ($separated['separated']) {
                                GroupTestResult::create([
                                    'group_test_id' => $test['id'],
                                    'test_id' => $test['test_id'],
                                ]);
                            }

                            foreach ($test['test']['components'] as $component) {
                                GroupTestResult::create([
                                    'group_test_id' => $test['id'],
                                    'test_id' => $component['id'],
                                ]);
                            }
                        }
                    }
                }

                if (count($package['microbiology_tests'])) {
                    foreach ($package['microbiology_tests'] as $microbiologyTest) {
                        if (!$microbiologyTest->has_results) {
                            $microbiologyTest->update(['has_results' => true]);

                            $separated = MicrobiologyTest::where('id', $microbiologyTest['test_id'])->first();

                            if ($separated['separated']) {
                                GroupMicrobiologyTestResult::create([
                                    'group_microbiology_test_id' => $microbiologyTest['id'],
                                    'test_id' => $microbiologyTest['test_id'],
                                ]);
                            }

                            foreach ($microbiologyTest['microbiologyTest']['components'] as $component) {
                                GroupMicrobiologyTestResult::create([
                                    'group_microbiology_test_id' => $microbiologyTest['id'],
                                    'test_id' => $component['id'],
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * print barcode
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_barcode(Request $request, $id)
    {
        $request->validate([
            'number' => 'required|numeric|min:1',
        ]);

        $group = Group::findOrFail($id);

        $number = $request['number'];

        $pdf = print_barcode($group, $number);

        return redirect($pdf);
    }

    /**
     * send receipt mail
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send_receipt_mail(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $patient = $group['patient'];

        send_notification('receipt', $patient, $group);

        session()->flash('success', __('Mail sent successfully'));

        return redirect()->route('admin.groups.index');
    }

    /**
     * Assign consumptions to invoice
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assign_consumption($id)
    {
        $group = Group::find($id);
        $group->consumptions()->delete();

        if (isset($group)) {
            foreach ($group['all_tests'] as $test) {
                if (isset($test['test'])) {
                    foreach ($test['test']['consumptions'] as $consumption) {
                        $group->consumptions()->create([
                            'branch_id' => $group['branch_id'],
                            'testable_type' => \App\Models\Test::class,
                            'testable_id' => $test['test_id'],
                            'product_id' => $consumption['product_id'],
                            'quantity' => $consumption['quantity'],
                        ]);
                    }
                }
            }

            foreach ($group['all_cultures'] as $culture) {
                if (isset($culture['culture'])) {
                    foreach ($culture['culture']['consumptions'] as $consumption) {
                        $group->consumptions()->create([
                            'branch_id' => $group['branch_id'],
                            'testable_type' => \App\Models\Culture::class,
                            'testable_id' => $culture['culture_id'],
                            'product_id' => $consumption['product_id'],
                            'quantity' => $consumption['quantity'],
                        ]);
                    }
                }
            }
        }

    }

    /**
     * Print working paper
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function working_paper($id)
    {
        $group = Group::findOrFail($id);

        $pdf = generate_pdf($group, 7);

        return redirect($pdf);
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

            //delete group antibiotics
            $group_antibiotics = GroupAntibiotic::where('group_id', $id)->get();

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

        return redirect()->route('admin.groups.index');
    }

    /**
     * Bulk print barcodes
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
     * Bulk print receipts
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_print_receipt(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])->get();

        $pdf = PDFMerger::init();

        foreach ($groups as $group) {
            //generate pdf
            $url = generate_pdf($group, 2);

            $pdf->addString(file_get_contents($url));
        }

        $pdf->merge();
        $pdf->save('uploads/pdf/bulk.pdf');

        return redirect('uploads/pdf/bulk.pdf');
    }

    /**
     * Bulk print working paper
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_print_working_paper(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])->get();

        $pdf = print_bulk_working_paper($groups);

        return redirect($pdf);
    }

    /**
     * Bulk send receipt mail
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bulk_send_receipt_mail(BulkActionRequest $request)
    {
        $groups = Group::whereIn('id', $request['ids'])->get();

        foreach ($groups as $group) {
            $patient = $group['patient'];
            send_notification('receipt', $patient, $group);
        }

        session()->flash('success', __('Receipts have been sent successfully'));

        return redirect()->route('admin.groups.index');
    }

    //Lindori
    public function export()
    {

        return Excel::download(new ResultsExport, 'High Low Results.xlsx');
    }
    //Lindori

    public function working_paper_pdf($id, $type = 1)
    {
        $info_settings = setting('info');
        $reports_settings = setting('reports');
        $barcode_settings = setting('barcode');
        $group = Group::findOrFail($id);

        $pdf = PDF::loadView('admin.groups.working_paper', compact(
            'group',
            'reports_settings',
            'info_settings',
            'type',
            'barcode_settings'
        ));

        $filename = 'working_paper_'.$group->id.'.pdf';
        // // $pdf->save("uploads/pdf_working_paper/" . $filename);
        // $path = url("uploads/pdf_working_paper/" . $filename);

        // $pdf_path = 'uploads/pdf_working_paper/' . $filename;
        // $group->pdf_new = url($pdf);
        // $group->update(); // Stream the PDF to the user's browser
        return $pdf->stream($filename);

        // return view('admin.groups.working_paper', compact('group','info_settings','reports_settings','barcode_settings','type'));
    }

    // public function working_paper_pdf($id, $type = 1)
    // {
    //     $info_settings = setting("info");
    //     $reports_settings = setting("reports");
    //     $barcode_settings = setting("barcode");
    //     $group = Group::findOrFail($id);

    //     // Estimate the height based on the content
    //     $linesOfText = 50; // Example: number of lines of text
    //     $lineHeight = 5; // Example: height of each line in mm
    //     $additionalHeight = 20; // Additional height for headers, footers, etc.
    //     $estimatedHeight = ($linesOfText * $lineHeight) + $additionalHeight;

    //     // Define a custom page size for 80mm wide paper
    //     $customPageSize = [80, $estimatedHeight]; // Width: 80mm, Height: Estimated

    //     $pdf = PDF::loadView('admin.groups.working_paper', compact(
    //         "group",
    //         "reports_settings",
    //         "info_settings",
    //         "type",
    //         "barcode_settings"
    //     ), [], [
    //         'format' => $customPageSize
    //     ]);

    //     $filename = 'working_paper_' . $group->id . '.pdf';

    //     return $pdf->stream($filename);
    // }

    public function print_80mm($id, $type = 1)
    {
        $info_settings = setting("info");
        $reports_settings = setting("reports");
        $barcode_settings = setting("barcode");
        $group = Group::findOrFail($id);

        // Calculate total count
        $totalCount = $group['daily_count'];

        // Assuming 'admin.groups.working_paper' is a view file that renders the content to be printed
        return view('admin.groups.print_80mm', compact(
            "group",
            "reports_settings",
            "info_settings",
            "type",
            "barcode_settings",
            "totalCount",
        ));
    }

}
