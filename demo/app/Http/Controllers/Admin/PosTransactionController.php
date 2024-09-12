<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group;
use App\Models\GroupPayment;
use App\Models\PointOfSale;
use App\Models\User;
use App\Models\PaymentMethod;
use App\Models\CashInOutflow;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PosTransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view_pos_transactions',     ['only' => ['index', 'show','ajax']]);
        $this->middleware('can:create_pos_transactions',   ['only' => ['create', 'store']]);
        $this->middleware('can:edit_pos_transactions',     ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_pos_transactions',   ['only' => ['destroy','bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::guard('admin')->user()->id;
        $user = User::find($userId);

        if (!$user->pointOfSale) {
            return view('admin.pos_transactions.error');
        }

        $cashInHand = $user->pointOfSale->cash_in_hand;
        $posname = $user->pointOfSale->pos_name;
        $posid = $user->pointOfSale->id;

        $transactions = Group::whereHas('payments', function ($query) use ($posid) {
            $query->where('closed', '!=', 1)->where('pos', $posid);
        })

        ->with(['payments', 'payments.payment_method', 'created_by_user.pointOfSale'])
        ->get();

        $cashFlowEntries = CashInOutflow::where('point_of_sale_id', $user->pointOfSale->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pos_transactions.index', compact('transactions', 'cashInHand', 'posname', 'userId', 'cashFlowEntries'));
    }



    //Per gjenerim X dhe Z sipas nevojes
    // public function salesReport()
    // {
    //     $transactions = Group::whereHas('payments')
    //                          ->with(['payments', 'payments.payment_method', 'created_by_user.pointOfSale'])
    //                          ->get();

    //     return view('admin.pos_transactions.sales_report', compact('transactions'));
    // }

    // public function salesReport(Request $request)
    // {
    //     $query = Group::whereHas('payments')
    //                   ->with(['payments', 'payments.payment_method', 'created_by_user.pointOfSale']);

    //     if ($request->has('user_id')) {
    //         $query->where('created_by', $request->user_id);
    //     }

    //     if ($request->has('start_date') && $request->has('end_date')) {
    //         $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    //     }

    //     if ($request->has('pos')) {
    //         $query->whereHas('pointOfSale', function ($q) use ($request) {
    //             $q->where('id', $request->pos_id);
    //         });
    //     }

    //     // Filter payments
    //     $payments = [];
    //     if ($request->has('payments')) {
    //         $query->whereHas('payments', function ($q) use ($request) {
    //             $q->whereIn('payment_method_id', $request->input('payments'));
    //         });

    //         $payments = PaymentMethod::whereIn('id', $request->input('payments'))->get();
    //     }

    //     $transactions = $query->get();
    //     $users = User::all();
    //     $paymentMethods = PaymentMethod::all();
    //     $pointsOfSale = PointOfSale::all();

    //     return view('admin.pos_transactions.sales_report', compact('transactions', 'users', 'paymentMethods', 'pointsOfSale', 'payments'));
    // }




    public function salesReport(Request $request)
    {
        if ($request->has('date')) {
            //format date
            $date = explode('-', $request['date']);
            $from = date('Y-m-d', strtotime($date[0]));
            $to = date('Y-m-d 23:59:59', strtotime($date[1]));
            //select groups of date between
            $groups = ($from == $to) ? Group::with('pointOfSale')->whereDate('created_at', $from) : Group::with('pointOfSale')->whereBetween('created_at', [$from, $to]);
            //filter payments
            $payments = [];
            if ($request->has('payments')) {
                $groups->whereHas('payments', function ($query) use ($request) {
                    $query->whereIn('payment_method_id', $request->input('payments'));
                });
                $payments = PaymentMethod::whereIn('id', $request->input('payments'))->get();
            }
            // filter point of sale
            $pos = [];
            if ($request->has('pos')) {
                $groups->where('pos', $request->input('pos'));
                $pos = PointOfSale::where('id', $request->input('pos'))->get();
            }

            // Filter created by user
            if ($request->has('created_by_user')) {
                $groups->where('created_by', $request->input('created_by_user'));
            }

            $groups = $groups->get();

            // Calculate total amount for each payment method within each POS
            $posTotals = [];
            foreach ($groups as $group) {
                foreach ($group->payments as $payment) {
                    $posName = $group->pointOfSale->pos_name;
                    $paymentMethodName = $payment->payment_method->name;
                    if (!isset($posTotals[$posName][$paymentMethodName])) {
                        $posTotals[$posName][$paymentMethodName] = 0;
                    }
                    $posTotals[$posName][$paymentMethodName] += $payment->amount;
                }
            }

            // Calculate total amount for each payment method across all POS
            $totalByPaymentMethod = [];
            foreach ($posTotals as $posName => $paymentMethods) {
                foreach ($paymentMethods as $paymentMethodName => $totalAmount) {
                    if (!isset($totalByPaymentMethod[$paymentMethodName])) {
                        $totalByPaymentMethod[$paymentMethodName] = 0;
                    }
                    $totalByPaymentMethod[$paymentMethodName] += $totalAmount;
                }
            }


            // Fetch CashInOutflow data
            // $cashInOutflows = CashInOutflow::with('createdBy', 'pointOfSale')
            // ->whereBetween('created_at', [$from, $to])
            // ->get();



            $cashInOutflows = CashInOutflow::with('createdBy', 'pointOfSale')
            ->whereBetween('created_at', [$from, $to])
            ->when($request->has('pos'), function ($query) use ($request) {
                $query->where('point_of_sale_id', $request->input('pos'));
            })
            ->get();
            $cashFlowEntries = CashInOutflow::with('createdBy', 'pointOfSale')
            ->whereBetween('created_at', [$from, $to])
            ->when($request->has('pos'), function ($query) use ($request) {
                $query->where('point_of_sale_id', $request->input('pos'));
            })
            ->get();




            return view('admin.pos_transactions.sales_report', compact(
                'from',
                'to',
                'pos',
                'groups',
                'posTotals',
                'totalByPaymentMethod',
                'cashInOutflows',
                'cashFlowEntries'
            ));
        }

        return view('admin.pos_transactions.sales_report');
    }





    public function generatePDF()
    {
        $userId = Auth::guard('admin')->user()->id;

        $transactions = Group::whereHas('payments', function ($query) use ($userId) {
                $query->where('created_by', $userId)->where('closed', '!=', 1);
            })
            ->with(['payments', 'payments.payment_method', 'created_by_user.pointOfSale'])
            ->get();

        $data = [
            'transactions' => $transactions,
        ];

        // $pdf = PDF::loadView('admin.pos_transactions.pdf_transactions', $data);
        $pdf = PDF::loadView('admin.pos_transactions.pdf_transactions', $data)
         ->setPaper([0, 0, 226.77, 1000], 'portrait'); // Width: 80mm in points, Height: dynamic


        return $pdf->stream('pos-transactions.pdf');
    }


    // public function generateReport(Request $request)
    // {
    //     $query = Group::whereHas('payments', function ($query) use ($request) {
    //         $query->where('closed', '!=', 9);

    //         // Filter payments by creation date range
    //         if ($request->filled('start_date') && $request->filled('end_date')) {
    //             $startDate = $request->input('start_date');
    //             $endDate = $request->input('end_date');

    //             $query->whereDate('created_at', '>=', $startDate)
    //                   ->whereDate('created_at', '<=', $endDate);
    //         }
    //     })
    //     ->with(['payments', 'payments.payment_method', 'created_by_user.pointOfSale']);

    //     // Filter payments based on payment methods
    //     if ($request->has('payments')) {
    //         $paymentMethodIds = $request->input('payments');
    //         $query->whereHas('payments', function ($query) use ($paymentMethodIds) {
    //             $query->whereIn('payment_method_id', $paymentMethodIds);
    //         });
    //     }

    //     $transactions = $query->get();
    //     $allPaymentMethods = PaymentMethod::all();
    //     $selectedPaymentMethods = $request->input('payments', []);
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');

    //     return view('admin.pos_transactions.generate_report', compact('transactions', 'allPaymentMethods', 'selectedPaymentMethods', 'startDate', 'endDate'));
    // }



        // PUNON 100


    // public function generateReport(Request $request)
    // {
    //     $query = Group::whereHas('payments', function ($query) use ($request) {
    //         $query->where('closed', '!=', 10);

    //         // Filter payments by creation date range
    //         if ($request->filled('start_date') && $request->filled('end_date')) {
    //             $startDate = $request->input('start_date');
    //             $endDate = $request->input('end_date');

    //             $query->whereDate('created_at', '>=', $startDate)
    //                   ->whereDate('created_at', '<=', $endDate);
    //         }
    //     })
    //     ->with(['payments', 'payments.payment_method', 'created_by_user.pointOfSale']);

    //     // Filter payments based on payment methods
    //     if ($request->has('payments')) {
    //         $paymentMethodIds = $request->input('payments');
    //         $query->whereHas('payments', function ($query) use ($paymentMethodIds) {
    //             $query->whereIn('payment_method_id', $paymentMethodIds);
    //         });
    //     }

    //     // Filter by Point of Sale (POS)
    //     if ($request->filled('pos')) {
    //         $posId = $request->input('pos');
    //         $query->whereHas('pointOfSale', function ($query) use ($posId) {
    //             $query->where('id', $posId);
    //         });
    //     }

    //     $transactions = $query->get();
    //     $allPaymentMethods = PaymentMethod::all();
    //     $allPOS = PointOfSale::all();
    //     $selectedPaymentMethods = $request->input('payments', []);
    //     $startDate = $request->input('start_date');
    //     $endDate = $request->input('end_date');
    //     $selectedPOS = $request->input('pos');

    //     if ($request->has('generate_pdf')) {
    //         $pdf = PDF::loadView('admin.pos_transactions.pdf_template', compact('transactions'));

    //         // You can customize the PDF filename here
    //         return $pdf->download('report.pdf');
    //     }


    //     return view('admin.pos_transactions.generate_report', compact('transactions', 'allPaymentMethods', 'allPOS', 'selectedPaymentMethods', 'startDate', 'endDate', 'selectedPOS'));
    // }

        //UPDATED WITH PDF AND PAYMENT  FILTER
    public function generateReport(Request $request)
    {
        $query = Group::whereHas('payments', function ($query) {
            $query->where('closed', '!=', 10);
        })
        ->with(['payments', 'payments.payment_method', 'created_by_user', 'pointOfSale']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $query->whereHas('payments', function ($paymentQuery) use ($startDate, $endDate) {
                $paymentQuery->whereDate('created_at', '>=', $startDate)
                             ->whereDate('created_at', '<=', $endDate);
            });
        }

        if ($request->has('payments')) {
            $paymentMethodIds = $request->input('payments');
            $query->whereHas('payments', function ($paymentQuery) use ($paymentMethodIds) {
                $paymentQuery->whereIn('payment_method_id', $paymentMethodIds);
            });
        }

        if ($request->filled('pos')) {
            $posId = $request->input('pos');
            $query->whereHas('pointOfSale', function ($posQuery) use ($posId) {
                $posQuery->where('id', $posId);
            });
        }

        $transactions = $query->get();
        $allPaymentMethods = PaymentMethod::all();
        $allPOS = PointOfSale::all();
        //PDF
        $selectedPaymentMethods = $request->input('payments', []);
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedPOS = $request->input('pos', []);

                if ($request->has('generate_pdf')) {
                $pdf = PDF::loadView('admin.pos_transactions.pdf_template', compact('transactions','request','selectedPaymentMethods','selectedPOS','startDate','endDate','allPaymentMethods','allPOS'));

                // You can customize the PDF filename here
                // return $pdf->download('report.pdf');
                return $pdf->stream('report.pdf');
            }


        return view('admin.pos_transactions.generate_report', compact(
            'transactions',
            'allPaymentMethods',
            'allPOS',
            'selectedPaymentMethods',
            'startDate',
            'endDate',
            'selectedPOS',
            'request'
        ));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function storecashflow(Request $request)
    {

        $validatedData = $request->validate([
            'cash_in' => 'nullable|numeric',
            'cash_out' => 'required|numeric',
            'description' => 'nullable|string',
            'comment' => 'nullable|string',
        ]);

        $userId = Auth::guard('admin')->user()->id;
        $user = User::find($userId);
        $pointOfSaleId = $user->pointOfSale->id;

        $cashOut = $validatedData['cash_out'];

        // Update cash in hand in the PointOfSale model
        $pointOfSale = PointOfSale::find($pointOfSaleId);
        $updatedCashInHand = $pointOfSale->cash_in_hand - $cashOut;
        $pointOfSale->cash_in_hand = $updatedCashInHand;
        $pointOfSale->save();

        $cashInOutflow = new CashInOutflow([
            'cash_in' => $validatedData['cash_in'],
            'cash_out' => $cashOut,
            'description' => $validatedData['description'],
            'point_of_sale_id' => $pointOfSaleId,
            'comment' => $validatedData['comment'],
            'created_by' => $request['created_by'],
        ]);


        $cashInOutflow->save();

        return redirect()->back()->with('success', 'Cash inflow outflow created successfully.');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    // public function bulkUpdate(Request $request)
    // {
    //     $transactionIds = $request->input('transaction_ids', []);

    //     GroupPayment::whereIn('id', $transactionIds)->update(['closed' => 1]);

    //     return response()->json(['message' => 'Bulk update successful']);
    // }
    // public function bulkUpdate(Request $request)
    // {
    //     $transactionIds = $request->input('transaction_ids', []);

    //     // Calculate total amount of closed transactions
    //     $totalAmount = GroupPayment::whereIn('id', $transactionIds)->sum('amount');

    //     // Update cash_in_hand of the associated PointOfSale
    //     $userId = Auth::guard('admin')->user()->id;
    //     $pointOfSale = PointOfSale::whereHas('users', function ($query) use ($userId) {
    //         $query->where('users.id', $userId);
    //     })->first();

    //     if ($pointOfSale) {
    //         $pointOfSale->cash_in_hand += $totalAmount;
    //         $pointOfSale->save();
    //     }

    //     // Update the closed status of transactions
    //     GroupPayment::whereIn('id', $transactionIds)->update(['closed' => 1]);

    //     return response()->json(['message' => 'Bulk update successful']);
    // }


    //Punon
    // public function bulkUpdate(Request $request)
    // {
    //     $transactionIds = $request->input('transaction_ids', []);

    //     // Calculate total amount of closed transactions with payment_method_id = 1
    //     $totalAmount = GroupPayment::whereIn('id', $transactionIds)
    //         ->where('payment_method_id', 1)
    //         ->sum('amount');

    //     if ($totalAmount > 0) {
    //         // Update cash_in_hand of the associated PointOfSale
    //         $userId = Auth::guard('admin')->user()->id;
    //         $pointOfSale = PointOfSale::whereHas('users', function ($query) use ($userId) {
    //             $query->where('users.id', $userId);
    //         })->first();

    //         if ($pointOfSale) {
    //             $pointOfSale->cash_in_hand += $totalAmount;
    //             $pointOfSale->save();
    //         }
    //     }

    //     // Update the closed status of transactions
    //     GroupPayment::whereIn('id', $transactionIds)->update(['closed' => 1]);

    //     return response()->json(['message' => 'Bulk update successful']);
    // }

    public function bulkUpdate(Request $request)
    {
        $transactionIds = $request->input('transaction_ids', []);

        // Calculate total amount of closed transactions with payment_method_id = 1
        // $totalAmount = GroupPayment::whereIn('id', $transactionIds)
        //     ->where('payment_method_id', 1)
        //     ->sum('amount');

        // if ($totalAmount > 0) {
        //     // Update cash_in_hand of the associated PointOfSale
        //     $userId = Auth::guard('admin')->user()->id;
        //     $user = User::find($userId);

        //     if ($user && $user->pointOfSale) {
        //         $pointOfSale = $user->pointOfSale;
        //         $pointOfSale->cash_in_hand += $totalAmount;
        //         $pointOfSale->save();
        //     }
        // }

        // Update the closed status of transactions

        // GroupPayment::whereIn('id', $transactionIds)->update(['closed' => 1]);
        GroupPayment::whereIn('id', $transactionIds)->update([
            'closed' => 1,
            'closed_at' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Bulk update successful']);
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
}
