<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExpenseCategoryRequest;
use App\Models\ExpenseCategory;
use DataTables;
use Illuminate\Http\Request;

class ExpenseCategoriesController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_expense_category', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_expense_category', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_expense_category', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_expense_category', ['only' => ['destroy', 'bulk_delete']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.accounting.expense_categories.index');
    }

    /**
     * get analyses datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = ExpenseCategory::query();

        return DataTables::eloquent($model)
            ->addColumn('action', function ($expense_category) {
                return view('admin.accounting.expense_categories._action', compact('expense_category'));
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
        return view('admin.accounting.expense_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExpenseCategoryRequest $request)
    {
        ExpenseCategory::create($request->except('_token'));

        session()->flash('success', __('Expense category created successfully'));

        return redirect()->route('admin.expense_categories.index');
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
        $expense_category = ExpenseCategory::findOrFail($id);

        return view('admin.accounting.expense_categories.edit', compact('expense_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ExpenseCategoryRequest $request, $id)
    {
        $expense_category = ExpenseCategory::findOrFail($id);
        $expense_category->update($request->except('_token', '_method'));

        session()->flash('success', __('Expense category updated successfully'));

        return redirect()->route('admin.expense_categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense_category = ExpenseCategory::findOrFail($id);
        $expense_category->delete();

        session()->flash('success', __('Expense category deleted successfully'));

        return redirect()->route('admin.expense_categories.index');
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
            $expense_category = ExpenseCategory::find($id);
            $expense_category->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.expense_categories.index');
    }
}
