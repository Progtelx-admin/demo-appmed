<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExpenseRequest;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use DataTables;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_expense', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_expense', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_expense', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_expense', ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.accounting.expenses.index');
    }

    /**
     * get analyses datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = Expense::with('category', 'payment_method')
            ->where('branch_id', session('branch_id'));

        return DataTables::eloquent($model)
            ->editColumn('amount', function ($expense) {
                return formated_price($expense['amount']);
            })
            ->addColumn('action', function ($expense) {
                return view('admin.accounting.expenses._action', compact('expense'));
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
        $expense_categories = ExpenseCategory::all();

        return view('admin.accounting.expenses.create', compact('expense_categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseRequest $request)
    {
        $request['date'] = \Carbon\Carbon::parse($request['date']);

        $expense = Expense::create($request->except('_token', '_method', 'files'));
        $expense->update([
            'branch_id' => session('branch_id'),
        ]);

        session()->flash('success', __('Expense created successfully'));

        return redirect()->route('admin.expenses.index');
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
        $expense_categories = ExpenseCategory::all();
        $expense = Expense::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        return view('admin.accounting.expenses.edit', compact('expense_categories', 'expense'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseRequest $request, $id)
    {
        $request['date'] = \Carbon\Carbon::parse($request['date']);

        $expense = Expense::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $expense->update($request->except('_token', '_method', 'files'));

        session()->flash('success', __('Expense updated successfully'));

        return redirect()->route('admin.expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $expense->delete();

        session()->flash('success', __('Expense deleted successfully'));

        return redirect()->route('admin.expenses.index');
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
            $expense = Expense::where('branch_id', session('branch_id'))
                ->find($id);

            $expense->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.expenses.index');
    }
}
