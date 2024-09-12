<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BranchProductExport;
use App\Exports\GroupsExport;
use App\Exports\IkshpTestsExport;
use App\Http\Controllers\Controller;
use App\Models\AdjustmentProduct;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\Culture;
use App\Models\Doctor;
use App\Models\Expense;
use App\Models\Group;
use App\Models\GroupPayment;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductConsumption;
use App\Models\Purchase;
use App\Models\PurchasePayment;
use App\Models\PurchaseProduct;
use App\Models\Supplier;
use App\Models\Test;
use App\Models\TransferProduct;
use Carbon\Carbon;
use Excel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_accounting_report', ['only' => ['accounting', 'ikshp']]);
        $this->middleware('can:view_doctor_report', ['only' => ['doctor']]);
        $this->middleware('can:view_inventory_report', ['only' => ['inventory']]);
        $this->middleware('can:view_supplier_report', ['only' => ['supplier']]);
    }

    /**
     * accounting report
     *
     * @return \Illuminate\Http\Response
     */
    //   public function accounting(Request $request)
    //     {
    //         if( $request->has('date'))
    //         {
    //             //format date
    //             $date=explode('-',$request['date']);
    //             $from=date('Y-m-d',strtotime($date[0]));
    //             $to=date('Y-m-d 23:59:59',strtotime($date[1]));

    //             //select groups of date between
    //             $groups=($from==$to)?Group::with('patient','doctor')->whereDate('created_at',$from):Group::with('patient','doctor')->whereBetween('created_at',[$from,$to]);

    //             //filter tests
    //             $tests = [];
    //             if (!empty( $request->has('tests')))
    //             {
    //                 $groups->whereHas('tests',function($q)use($request){
    //                     return $q->whereIn('test_id',$request['tests']);
    //                 });

    //                 $tests=Test::whereIn('id',$request['tests'])->get();
    //             }

    //             $results = [];
    //             if( !empty( $request->has('results')))
    //             {
    //                 $groups->whereHas('results',function($q)use($request){
    //                     return $q->whereIn('test_id',$request['results']);
    //                 });

    //                 $tests=Test::whereIn('status',$request['results'])->get();
    //             }

    //             //filter branches
    //             $branches = [];
    //             if( !empty(request('branches')))
    //             {
    //                 $groups->whereIn('branch_id',$request['branches']);

    //                 $branches=Branch::whereIn('id',$request['branches'])->get();
    //             }

    //             //filter contracts
    //             $contracts = [];
    //             if(!empty(request('contracts')))
    //             {
    //                 $groups->whereIn('contract_id',$request['contracts']);

    //                 $contracts=Contract::whereIn('id',$request['contracts'])->get();
    //             }

    //             $groups=$groups->get();

    //           //  $input_date=$request['date'];

    //             return view('admin.reports.accounting',compact(
    //                 'from',
    //                 'to',
    //                 'tests',
    //                 //'cultures',
    //                 //'packages',
    //                 'branches',
    //                 //'doctors',
    //               // 'input_date',
    //                 'groups',
    //                 'results'

    //             ));
    //         }

    //         return view('admin.reports.accounting');
    //     }

    // In your Controller

    // ... other use statements ...

    // public function accounting(Request $request)
    // {
    //     if ($request->ajax()) {
    //         [$from, $to] = explode(' - ', $request->input('date'));
    //         $from = Carbon::parse($from)->startOfDay();
    //         $to = Carbon::parse($to)->endOfDay();

    //         $query = Group::with(['patient', 'doctor', 'tests', 'cultures', 'services', 'packages', 'contract'])
    //             ->when($from && $to, function ($query) use ($from, $to) {
    //                 return $query->whereBetween('created_at', [$from, $to]);
    //             })
    //             ->when($request->filled('tests'), function ($query) use ($request) {
    //                 return $query->whereHas('tests', function ($q) use ($request) {
    //                     return $q->whereIn('test_id', $request->input('tests'));
    //                 });
    //             });

    //         return DataTables::of($query)
    //             ->addIndexColumn()
    //             ->addColumn('merged_items', function ($group) {
    //                 return $group->mergedItems->implode(', ');
    //             })
    //             ->editColumn('patient.name', function ($group) {
    //                 return $group->patient ? $group->patient->name : '';
    //             })
    //             ->editColumn('created_at', function ($group) {
    //                 return $group->created_at->format('Y-m-d');
    //             })
    //             // Add more columns as needed
    //             ->rawColumns(['merged_items']) // Use this if you need to render HTML in the column
    //             ->make(true);
    //     }

    //     // Load view for initial page request
    //     return view('admin.reports.accounting');
    // }

    public function accounting(Request $request)
    {
        // Initialize the base query
        $baseQuery = Group::with(['patient', 'doctor', 'contract']);

        // Apply filters based on request parameters
        if ($request->filled('date')) {
            [$from, $to] = explode(' - ', $request->input('date'));
            $from = Carbon::parse($from)->startOfDay();
            $to = Carbon::parse($to)->endOfDay();
            $baseQuery->whereBetween('groups.created_at', [$from, $to]);

        }
        if ($request->filled('tests')) {
            $baseQuery->whereHas('tests', function ($q) use ($request) {
                $q->whereIn('test_id', $request->input('tests'));
            });
        }
        // ... other conditions ...

        // Clone the query for export after applying all filters
        $exportQuery = clone $baseQuery;

        // Handle Excel export
        // Inside your controller method
        if ($request->has('export')) {
            [$from, $to] = explode(' - ', $request->input('date'));
            $from = Carbon::parse($from)->startOfDay();
            $to = Carbon::parse($to)->endOfDay();

            $exportQuery = clone $baseQuery;

            return (new GroupsExport($exportQuery, $from, $to))->download('groups.xlsx');
        }

        // Handle AJAX request for DataTables
        if ($request->ajax()) {
            return DataTables::of($baseQuery)
                ->addColumn('merged_items', function ($group) {
                    return $group->mergedItems->implode(', ');
                })
                // ... other columns ...
                ->rawColumns(['merged_items'])
                ->make(true);
        }

        // Load view for initial page request
        return view('admin.reports.accounting');
    }

    //IKSHP report

    public function ikshp(Request $request)
    {
        if ($request->has('date')) {
            //format date
            $date = explode('-', $request['date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //balance
            $payment_methods = PaymentMethod::all();

            foreach ($payment_methods as $payment_method) {
                $payment_method['income'] = ($from == $to) ? GroupPayment::whereDate('created_at', $from)->where('payment_method_id', $payment_method['id'])->sum('amount') : GroupPayment::whereBetween('created_at', [$from, $to])->where('payment_method_id', $payment_method['id'])->sum('amount');
                $payment_method['expense'] = ($from == $to) ? Expense::whereDate('created_at', $from)->where('payment_method_id', $payment_method['id'])->sum('amount') : Expense::whereBetween('created_at', [$from, $to])->where('payment_method_id', $payment_method['id'])->sum('amount');
                $payment_method['balance'] = $payment_method['income'] - $payment_method['expense'];
            }

            //select groups of date between
            $groups = ($from == $to) ? Group::with('patient', 'doctor')->whereDate('created_at', $from) : Group::with('patient', 'doctor')->whereBetween('created_at', [$from, $to]);

            //payments
            $payments = ($from == $to) ? GroupPayment::whereDate('date', $from) : GroupPayment::whereBetween('date', [$from, $to]);

            //expenses
            $expenses = ($from == $to) ? Expense::whereDate('date', $from) : Expense::whereBetween('date', [$from, $to]);

            //purchase payment
            $purchase_payments = ($from == $to) ? PurchasePayment::whereDate('date', $from) : PurchasePayment::whereBetween('date', [$from, $to]);

            //filter doctors
            $doctors = [];
            if ($request->has('doctors')) {
                $groups->whereIn('doctor_id', $request['doctors']);

                $doctors = Doctor::whereIn('id', $request['doctors'])->get();
            }

            //filter tests
            $tests = [];
            if ($request->has('tests')) {
                $groups->whereHas('tests', function ($q) use ($request) {
                    return $q->whereIn('test_id', $request['tests']);
                });

                $tests = Test::whereIn('id', $request['tests'])->get();
            }

            //filter cultures
            $cultures = [];
            if ($request->has('cultures')) {
                $groups->whereHas('cultures', function ($q) use ($request) {
                    return $q->whereIn('culture_id', $request['cultures']);
                });

                $cultures = Culture::whereIn('id', $request['cultures'])->get();
            }

            //filter packages
            $packages = [];
            if ($request->has('packages')) {
                $groups->whereHas('packages', function ($q) use ($request) {
                    return $q->whereIn('package_id', $request['packages']);
                });

                $packages = Package::whereIn('id', $request['packages'])->get();
            }

            //filter branches
            $branches = [];
            if ($request->has('branches')) {
                $groups->whereIn('branch_id', $request['branches']);

                $payments->whereHas('group', function ($query) use ($request) {
                    return $query->whereIn('branch_id', $request['branches']);
                });

                $expenses->whereIn('branch_id', $request['branches']);

                $purchase_payments->whereHas('purchase', function ($query) use ($request) {
                    return $query->whereIn('branch_id', $request['branches']);
                });

                $branches = Branch::whereIn('id', $request['branches'])->get();
            }

            //filter contracts
            $contracts = [];
            if ($request->has('contracts')) {
                $groups->whereIn('contract_id', $request['contracts']);

                $contracts = Contract::whereIn('id', $request['contracts'])->get();
            }

            $groups = $groups->get();
            $payments = $payments->get();
            $expenses = $expenses->get();
            $purchase_payments = $purchase_payments->get();

            //make accounting
            $total = 0;
            $paid = $payments->sum('amount');
            $due = 0;
            $total_expenses = $expenses->sum('amount');
            $total_purchases = $purchase_payments->sum('amount');

            foreach ($groups as $group) {
                $total += $group['total'];
                $due += $group['due'];
            }

            //profit
            $profit = $paid - $total_expenses - $total_purchases;

            //old date
            $input_date = $request['date'];

            if ($request->has('pdf')) {
                $pdf = generate_pdf(compact(
                    'from',
                    'to',
                    'tests',
                    'cultures',
                    'packages',
                    'branches',
                    'doctors',
                    'input_date',
                    'groups',
                    'payments',
                    'expenses',
                    'purchase_payments',
                    'total',
                    'paid',
                    'due',
                    'total_expenses',
                    'total_purchases',
                    'profit',
                    'payment_methods'
                ), 3);

                return redirect($pdf);
            }

            return view('admin.reports.ikshp', compact(
                'from',
                'to',
                'tests',
                'cultures',
                'packages',
                'branches',
                'doctors',
                'input_date',
                'groups',
                'payments',
                'expenses',
                'purchase_payments',
                'total',
                'paid',
                'due',
                'total_expenses',
                'total_purchases',
                'profit',
                'payment_methods'
            ));
        }

        return view('admin.reports.ikshp');
    }

    /**
     * doctors report
     *
     * @return \Illuminate\Http\Response
     */
    public function doctor(Request $request)
    {
        if ($request->has('date')) {
            //format date
            $date = explode('-', $request['date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select groups of date between
            $groups = ($from == $to) ? Group::with('patient', 'doctor')->whereDate('created_at', $from) : Group::with('patient', 'doctor')->whereBetween('created_at', [$from, $to]);
            //payments
            $payments = ($from == $to) ? Expense::with('category')->whereDate('date', $from)->where('doctor_id', $request['doctor_id'])->get() : Expense::with('category')->whereBetween('date', [$from, $to])->where('doctor_id', $request['doctor_id'])->get();

            //filter doctors
            if ($request->has('doctor_id')) {
                $groups->where('doctor_id', $request['doctor_id']);

                $doctor = Doctor::find($request['doctor_id']);
            }

            $groups = $groups->get();

            //make accounting
            $total = 0;
            $paid = 0;
            $due = 0;

            $total += $groups->sum('doctor_commission');
            $paid += $payments->sum('amount');
            $due = $total - $paid;

            //old date
            $input_date = $request['date'];

            if ($request->has('pdf')) {
                $pdf = generate_pdf(compact(
                    'from',
                    'to',
                    'doctor',
                    'input_date',
                    'groups',
                    'payments',
                    'total',
                    'paid',
                    'due'
                ), 4);

                return redirect($pdf);
            }

            return view('admin.reports.doctor', compact(
                'from',
                'to',
                'doctor',
                'input_date',
                'groups',
                'payments',
                'total',
                'paid',
                'due'
            ));
        }

        return view('admin.reports.doctor');
    }

    public function supplier(Request $request)
    {
        if ($request->has('date')) {
            //format date
            $date = explode('-', $request['date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select purchases of date between
            $purchases = ($from == $to) ? Purchase::whereDate('date', $from) : Purchase::whereBetween('date', [$from, $to]);
            $payments = ($from == $to) ? PurchasePayment::whereDate('date', $from) : PurchasePayment::whereBetween('date', [$from, $to]);

            //filter doctors
            if ($request->has('supplier_id')) {
                $purchases->where('supplier_id', $request['supplier_id']);
                $payments->whereHas('purchase', function ($query) use ($request) {
                    return $query->where('supplier_id', $request['supplier_id']);
                });

                $supplier = Supplier::find($request['supplier_id']);
            }

            $purchases = $purchases->get();
            $payments = $payments->get();

            //summary
            $total = $purchases->sum('total');
            $paid = $payments->sum('amount');
            $due = $total - $paid;

            //old date
            $input_date = $request['date'];

            if ($request->has('pdf')) {
                $pdf = generate_pdf(compact(
                    'from',
                    'to',
                    'supplier',
                    'input_date',
                    'purchases',
                    'payments',
                    'total',
                    'paid',
                    'due'
                ), 5);

                return redirect($pdf);
            }

            return view('admin.reports.supplier', compact(
                'from',
                'to',
                'supplier',
                'input_date',
                'purchases',
                'payments',
                'total',
                'paid',
                'due'
            ));
        }

        return view('admin.reports.supplier');
    }

    public function purchase(Request $request)
    {
        if ($request->has('date')) {
            //format date
            $date = explode('-', $request['date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select purchases of date between
            $purchases = ($from == $to) ? Purchase::whereDate('date', $from) : Purchase::whereBetween('date', [$from, $to]);
            $payments = ($from == $to) ? PurchasePayment::whereDate('date', $from) : PurchasePayment::whereBetween('date', [$from, $to]);

            //filter branch
            $branches = [];
            if ($request->has('branch_id')) {
                $purchases->whereIn('branch_id', $request['branch_id']);
                $payments->whereHas('purchase', function ($query) use ($request) {
                    return $query->whereIn('branch_id', $request['branch_id']);
                });
                $branches = Branch::whereIn('id', $request['branch_id'])->get();
            }

            //filter supplier
            $suppliers = [];
            if ($request->has('supplier_id')) {
                $purchases->whereIn('supplier_id', $request['supplier_id']);
                $payments->whereHas('purchase', function ($query) use ($request) {
                    return $query->whereIn('supplier_id', $request['supplier_id']);
                });
                $suppliers = Supplier::whereIn('id', $request['supplier_id'])->get();
            }

            $purchases = $purchases->get();
            $payments = $payments->get();

            //summary
            $total = $purchases->sum('total');
            $paid = $payments->sum('amount');
            $due = $total - $paid;

            //old date
            $input_date = $request['date'];

            if ($request->has('pdf')) {

                $pdf = generate_pdf(compact(
                    'from',
                    'to',
                    'input_date',
                    'purchases',
                    'payments',
                    'total',
                    'paid',
                    'due'
                ), 6);

                return redirect($pdf);
            }

            return view('admin.reports.purchase', compact(
                'from',
                'to',
                'input_date',
                'purchases',
                'payments',
                'branches',
                'suppliers',
                'total',
                'paid',
                'due'
            ));
        }

        return view('admin.reports.purchase');
    }

    public function inventory(Request $request)
    {
        if ($request->has('date')) {
            //format date
            $date = explode('-', $request['date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));

            //select purchases of date between
            if ($from == $to) {
                $purchase_products = PurchaseProduct::whereHas('purchase', function ($query) use ($from) {
                    return $query->whereDate('date', $from);
                });
            } else {
                $purchase_products = PurchaseProduct::whereHas('purchase', function ($query) use ($from, $to) {
                    return $query->whereBetween('date', [$from, $to]);
                });
            }

            //select adjustments of date between
            if ($from == $to) {
                $adjustment_products = AdjustmentProduct::whereHas('adjustment', function ($query) use ($from) {
                    return $query->whereDate('date', $from);
                });
            } else {
                $adjustment_products = AdjustmentProduct::whereHas('adjustment', function ($query) use ($from, $to) {
                    return $query->whereBetween('date', [$from, $to]);
                });
            }

            //select transfers of date between
            if ($from == $to) {
                $transfer_products = TransferProduct::whereHas('transfer', function ($query) use ($from) {
                    return $query->whereDate('date', $from);
                });
            } else {
                $transfer_products = TransferProduct::whereHas('transfer', function ($query) use ($from, $to) {
                    return $query->whereBetween('date', [$from, $to]);
                });
            }

            //select consumption of date between
            if ($from == $to) {
                $consumption_products = ProductConsumption::whereDate('created_at', $from);
            } else {
                $consumption_products = ProductConsumption::whereBetween('created_at', [$from, $to]);
            }

            //filter branch
            $branches = [];
            if ($request->has('branch_id')) {
                $purchase_products->whereIn('branch_id', $request['branch_id']); //filter purchases by branch
                $adjustment_products->whereIn('branch_id', $request['branch_id']); //filter adjustment by branch
                $transfer_products->where(function ($query) use ($request) {
                    return $query->whereIn('from_branch_id', $request['branch_id'])
                        ->orWhereIn('to_branch_id', $request['branch_id']);
                }); //filter transfer by branch
                $consumption_products->whereIn('branch_id', $request['branch_id']); //filter consumption by branch
                $branches = Branch::whereIn('id', $request['branch_id'])->get(); //get branches
            }

            $purchase_products = $purchase_products->get();
            $adjustment_products = $adjustment_products->get();
            $transfer_products = $transfer_products->get();
            $consumption_products = $consumption_products->get();

            //old date
            $input_date = $request['date'];

            return view('admin.reports.inventory', compact(
                'from',
                'to',
                'input_date',
                'purchase_products',
                'adjustment_products',
                'transfer_products',
                'consumption_products',
                'branches'
            ));
        }

        return view('admin.reports.inventory');
    }

    public function product(Request $request)
    {
        if ($request->has('generate')) {
            $branches = ($request->has('branch_id')) ? Branch::whereIn('id', $request['branch_id'])->get() : Branch::all();

            foreach ($branches as $branch) {
                $products = ($request->has('product_id')) ? Product::whereIn('id', $request['product_id'])->get() : $products = Product::all();

                $branch_products = [];
                foreach ($products as $product) {
                    $initial = $product->branches()->where('branch_id', $branch['id'])->sum('initial_quantity');
                    $purchases = $product->purchases()->where('branch_id', $branch['id'])->sum('quantity');
                    $in = $product->adjustments()->where('type', 1)->where('branch_id', $branch['id'])->sum('quantity');
                    $out = $product->adjustments()->where('type', 2)->where('branch_id', $branch['id'])->sum('quantity');
                    $transfers_from = $product->transfers()->where('from_branch_id', $branch['id'])->sum('quantity');
                    $transfers_to = $product->transfers()->where('to_branch_id', $branch['id'])->sum('quantity');
                    $consumptions = $product->consumptions()->where('branch_id', $branch['id'])->sum('quantity');

                    $stock_quantity = $initial + $purchases + $in + $transfers_to - $out - $transfers_from - $consumptions;

                    $branch_products[] = ['product' => $product, 'quantity' => $stock_quantity];
                    $branch['products'] = $branch_products;
                }
            }

            $report_branches = $branches;

            return view('admin.reports.product', compact('report_branches', 'products'));
        }

        return view('admin.reports.product');
    }

    //Lindori
    public function hlresult(Request $request)
    {

        return view('admin.reports.hlresult');
    }

    //Lindori

    public function branch_products(Request $request)
    {
        return Excel::download(new BranchProductExport, 'branch_products.xlsx');
    }

    public function ikshp_status(Request $request)
    {
        return Excel::download(new IkshpTestsExport, 'ikshp_status.xlsx');
    }
}
