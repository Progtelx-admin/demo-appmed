<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TestExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkActionRequest;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Http\Requests\Admin\TestRequest;
use App\Imports\TestImport;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Contract;
use App\Models\ContractPrice;
use App\Models\Test;
use App\Models\TestOption;
use App\Models\TestPrice;
use DataTables;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestsController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_test', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_test', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_test', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_test', ['only' => ['destroy', 'bulk_delete']]);
        $this->middleware('can:view_test_orders', ['only' => ['testOrder']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tests.index');
    }

    /**
     * get tests datatable
     *
     * @var @Request
     */
    public function ajax(Request $request)
    {
        $model = Test::with('category')->where(function ($q) {
            return $q->where('parent_id', 0)->orWhere('separated', true);
        });

        return DataTables::eloquent($model)
            ->editColumn('price', function ($test) {
                return formated_price($test['price']);
            })
            ->addColumn('action', function ($test) {
                return view('admin.tests._action', compact('test'));
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
        return view('admin.tests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestRequest $request)
    {
        $test = Test::create([
            'category_id' => $request['category_id'],
            'name' => $request['name'],
            'name2' => $request['name2'],
            'shortcut' => $request['shortcut'],
            'sample_type' => $request['sample_type'],
            'price' => $request['price'],
            'precautions' => $request['precautions'],
            'pantheon_id' => $request['pantheon_id'],
            'parent_id' => 0,
        ]);

        //create test price
        $branches = Branch::all();
        foreach ($branches as $branch) {
            TestPrice::create([
                'branch_id' => $branch['id'],
                'test_id' => $test['id'],
                'price' => $request['price'],
            ]);
        }

        //contracts prices
        $contracts = Contract::all();
        foreach ($contracts as $contract) {
            $contract->tests()->create([
                'priceable_type' => \App\Models\Test::class,
                'priceable_id' => $test['id'],
                'price' => ($contract['discount_type'] == 1) ? ($test['price'] * $contract['discount_percentage'] / 100) : $test['price'],
            ]);
        }

        //create components
        if ($request->has('component')) {
            foreach ($request->component as $component) {
                if (isset($component['title'])) {
                    Test::create([
                        'category_id' => $request['category_id'],
                        'parent_id' => $test['id'],
                        'name' => $component['name'],
                        'name2' => $component['name2'],
                        'title' => true,
                    ]);
                } else {
                    $test_component = Test::create([
                        'category_id' => $request['category_id'],
                        'parent_id' => $test['id'],
                        'type' => $component['type'],
                        'name' => $component['name'],
                        'name2' => $component['name'],
                        'unit' => (isset($component['unit'])) ? $component['unit'] : '',
                        'work_method' => (isset($component['work_method'])) ? $component['work_method'] : '',
                        'reference_range' => (isset($component['reference_range'])) ? $component['reference_range'] : '',
                        'title' => (isset($component['title'])) ? true : false,
                        'separated' => (isset($component['separated'])),
                        'price' => (isset($component['price'])) ? $component['price'] : 0,
                        'status' => (isset($component['status'])),
                        'sample_type' => $test['sample_type'],
                    ]);

                    if (isset($component['separated'])) {
                        //create test price
                        foreach ($branches as $branch) {
                            TestPrice::create([
                                'branch_id' => $branch['id'],
                                'test_id' => $test_component['id'],
                                'price' => $component['price'],
                            ]);
                        }

                        //contracts prices
                        foreach ($contracts as $contract) {
                            $contract->tests()->create([
                                'priceable_type' => \App\Models\Test::class,
                                'priceable_id' => $test_component['id'],
                                'price' => ($contract['discount_type'] == 1) ? ($component['price'] * $contract['discount_percentage'] / 100) : $component['price'],
                            ]);
                        }
                    }

                    //assign options to component
                    if (isset($component['options'])) {
                        foreach ($component['options'] as $option) {
                            TestOption::create([
                                'name' => $option,
                                'test_id' => $test_component['id'],
                            ]);
                        }
                    }

                    //reference ranges
                    if (isset($component['reference_ranges'])) {
                        foreach ($component['reference_ranges'] as $reference_range) {
                            $multiplication = 1;

                            if ($reference_range['age_unit'] == 'month') {
                                $multiplication = 30;
                            } elseif ($reference_range['age_unit'] == 'year') {
                                $multiplication = 365;
                            }

                            $test_component->reference_ranges()->create([
                                'gender' => $reference_range['gender'],
                                'age_unit' => $reference_range['age_unit'],
                                'age_from' => $reference_range['age_from'],
                                'age_to' => $reference_range['age_to'],
                                'low_risk' => $reference_range['low_risk'],
                                'moderate_risk' => $reference_range['moderate_risk'],
                                'high_risk' => $reference_range['high_risk'],
                                'age_from_days' => $reference_range['age_from'] * $multiplication,
                                'age_to_days' => $reference_range['age_to'] * $multiplication,
                                'critical_low_from' => $reference_range['critical_low_from'],
                                'normal_from' => $reference_range['normal_from'],
                                'normal_to' => $reference_range['normal_to'],
                                'critical_high_from' => $reference_range['critical_high_from'],
                                'critical_extra_from' => $reference_range['critical_extra_from'],
                            ]);
                        }
                    }
                }
            }
        }

        //comments
        if ($request->has('comments')) {
            foreach ($request['comments'] as $comment) {
                $test->comments()->create([
                    'comment' => $comment,
                ]);
            }
        }

        session()->flash('success', __('Test created successfully'));

        return redirect()->route('admin.tests.index');
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
        $test = Test::with('components')->where('id', $id)->firstOrFail();

        return view('admin.tests.edit', compact('test'));
    }

    public function consumptions($id)
    {
        $tests = Test::where('id', $id)->orWhere([
            ['parent_id', $id],
            ['separated', true],
        ])->get();

        return view('admin.tests.consumptions', compact('tests'));
    }

    public function consumptions_submit(Request $request)
    {
        if ($request->has('consumption')) {
            foreach ($request['consumption'] as $test_id => $consumptions) {
                $test = Test::find($test_id);

                if (isset($test)) {
                    $test->consumptions()->delete();

                    foreach ($consumptions as $consumption) {
                        $test->consumptions()->create([
                            'product_id' => $consumption['product_id'],
                            'quantity' => $consumption['quantity'],
                        ]);
                    }
                }

            }
        }

        session()->flash('success', __('Consumptions assigned successfully'));

        return redirect()->route('admin.tests.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestRequest $request, $id)
    {
        $test = Test::findOrFail($id);
        $branches = Branch::all();
        $contracts = Contract::all();

        //update test basic info
        $test->update([
            'category_id' => $request['category_id'],
            'name' => $request['name'],
            'name2' => $request['name2'],
            'shortcut' => $request['shortcut'],
            'sample_type' => $request['sample_type'],
            'price' => $request['price'],
            'precautions' => $request['precautions'],
            'pantheon_id' => $request['pantheon_id'],
            'parent_id' => 0,
        ]);

        //update contracts
        foreach ($contracts as $contract) {
            $test_contract = ContractPrice::firstOrCreate([
                'contract_id' => $contract['id'],
                'priceable_type' => \App\Models\Test::class,
                'priceable_id' => $id,
            ]);

            if ($contract['discount_type'] == 1) {
                $test_contract->update([
                    'price' => ($request['price'] * $contract['discount_percentage'] / 100),
                ]);
            }
        }

        //components
        if ($request->has('component')) {
            foreach ($request->component as $component) {
                if (isset($component['title'])) {
                    if (isset($component['id'])) {
                        Test::where('id', $component['id'])->update([
                            'category_id' => $request['category_id'],
                            'name' => $component['name'],
                            'name2' => $component['name2'],
                        ]);
                    } else {
                        Test::create([
                            'category_id' => $request['category_id'],
                            'parent_id' => $id,
                            'name' => $component['name'],
                            // 'name2'=>$component['name2'],
                            'title' => true,
                        ]);
                    }
                } else {
                    if (isset($component['id'])) {
                        $test_component = Test::where('id', $component['id'])->first();
                        // dd($request->all());
                        $test_component->update([
                            'category_id' => $request['category_id'],
                            'parent_id' => $id,
                            'type' => $component['type'],
                            'name' => $component['name'],
                            'name2' => $component['name2'],
                            'unit' => (isset($component['unit'])) ? $component['unit'] : '',
                            'work_method' => (isset($component['work_method'])) ? $component['work_method'] : '',
                            'reference_range' => (isset($component['reference_range'])) ? $component['reference_range'] : '',
                            'reference_range2' => (isset($component['reference_range2'])) ? $component['reference_range2'] : '',
                            'title' => (isset($component['title'])) ? true : false,
                            'separated' => (isset($component['separated'])) ? true : false,
                            'price' => (isset($component['price'])) ? $component['price'] : 0,
                            'status' => (isset($component['status'])),
                            'sample_type' => $test['sample_type'],
                        ]);

                        //separated
                        if ($test_component['separated']) {
                            //create test price
                            foreach ($branches as $branch) {
                                $test_price = TestPrice::firstOrCreate([
                                    'branch_id' => $branch['id'],
                                    'test_id' => $test_component['id'],
                                ]);

                                $test_price->update([
                                    'price' => $test_component['price'],
                                ]);
                            }

                            //create contract prices
                            foreach ($contracts as $contract) {
                                $test_contract = ContractPrice::firstOrCreate([
                                    'contract_id' => $contract['id'],
                                    'priceable_type' => \App\Models\Test::class,
                                    'priceable_id' => $test_component['id'],
                                ]);

                                if ($contract['discount_type'] == 1) {
                                    $test_contract->update([
                                        'price' => ($test_component['price'] * $contract['discount_percentage'] / 100),
                                    ]);
                                }
                            }
                        } else {
                            $test_component->prices()->delete();
                            $test_component->contract_prices()->delete();
                        }

                        //delete options if not select type
                        if ($component['type'] != 'select') {
                            $test_component->options()->delete();
                        }

                        //update old options
                        if (isset($component['old_options'])) {
                            foreach ($component['old_options'] as $option_id => $option) {
                                TestOption::where('id', $option_id)->update([
                                    'name' => $option,
                                ]);
                            }
                        }

                        //assign options to component
                        if (isset($component['options'])) {
                            foreach ($component['options'] as $option) {
                                TestOption::create([
                                    'name' => $option,
                                    'test_id' => $test_component['id'],
                                ]);
                            }
                        }

                        //reference ranges
                        $test_component->reference_ranges()->delete();
                        if (isset($component['reference_ranges'])) {
                            foreach ($component['reference_ranges'] as $reference_range) {
                                $multiplication = 1;

                                if ($reference_range['age_unit'] == 'month') {
                                    $multiplication = 30;
                                } elseif ($reference_range['age_unit'] == 'year') {
                                    $multiplication = 365;
                                }

                                $test_component->reference_ranges()->create([
                                    'gender' => $reference_range['gender'],
                                    'age_unit' => $reference_range['age_unit'],
                                    'age_from' => $reference_range['age_from'],
                                    'age_to' => $reference_range['age_to'],
                                    'low_risk' => $reference_range['low_risk'],
                                    'moderate_risk' => $reference_range['moderate_risk'],
                                    'high_risk' => $reference_range['high_risk'],
                                    'age_from_days' => $reference_range['age_from'] * $multiplication,
                                    'age_to_days' => $reference_range['age_to'] * $multiplication,
                                    'critical_low_from' => $reference_range['critical_low_from'],
                                    'normal_from' => $reference_range['normal_from'],
                                    'normal_to' => $reference_range['normal_to'],
                                    'critical_high_from' => $reference_range['critical_high_from'],
                                    'critical_extra_from' => $reference_range['critical_extra_from'],
                                ]);
                            }
                        }
                    } else {
                        $test_component = Test::create([
                            'category_id' => $request['category_id'],
                            'parent_id' => $id,
                            'type' => $component['type'],
                            'name' => $component['name'],
                            'unit' => (isset($component['unit'])) ? $component['unit'] : '',
                            'work_method' => (isset($component['work_method'])) ? $component['work_method'] : '',
                            'reference_range' => (isset($component['reference_range'])) ? $component['reference_range'] : '',
                            'title' => (isset($component['title'])) ? true : false,
                            'separated' => (isset($component['separated'])) ? true : false,
                            'price' => (isset($component['price'])) ? $component['price'] : 0,
                            'status' => (isset($component['status'])),
                            'sample_type' => $test['sample_type'],
                        ]);

                        //separated
                        if ($test_component['separated']) {
                            //create test price
                            foreach ($branches as $branch) {
                                $test_price = TestPrice::firstOrCreate([
                                    'branch_id' => $branch['id'],
                                    'test_id' => $test_component['id'],
                                ]);

                                $test_price->update([
                                    'price' => $test_component['price'],
                                ]);
                            }

                            //create contract prices
                            foreach ($contracts as $contract) {
                                $test_contract = ContractPrice::firstOrCreate([
                                    'contract_id' => $contract['id'],
                                    'priceable_type' => \App\Models\Test::class,
                                    'priceable_id' => $test_component['id'],
                                ]);

                                if ($contract['discount_type'] == 1) {
                                    $test_contract->update([
                                        'price' => ($test_component['price'] * $contract['discount_percentage'] / 100),
                                    ]);
                                }
                            }
                        } else {
                            $test_component->prices()->delete();
                            $test_component->contract_prices()->delete();
                        }

                        //assign options to component
                        if (isset($component['options'])) {
                            foreach ($component['options'] as $option) {
                                TestOption::create([
                                    'name' => $option,
                                    'test_id' => $test_component['id'],
                                ]);
                            }
                        }

                        //reference ranges
                        if (isset($component['reference_ranges'])) {
                            foreach ($component['reference_ranges'] as $reference_range) {
                                $multiplication = 1;

                                if ($reference_range['age_unit'] == 'month') {
                                    $multiplication = 30;
                                } elseif ($reference_range['age_unit'] == 'year') {
                                    $multiplication = 365;
                                }

                                $test_component->reference_ranges()->create([
                                    'gender' => $reference_range['gender'],
                                    'age_unit' => $reference_range['age_unit'],
                                    'age_from' => $reference_range['age_from'],
                                    'age_to' => $reference_range['age_to'],
                                    'age_from_days' => $reference_range['age_from'] * $multiplication,
                                    'age_to_days' => $reference_range['age_to'] * $multiplication,
                                    'critical_low_from' => $reference_range['critical_low_from'],
                                    'normal_from' => $reference_range['normal_from'],
                                    'normal_to' => $reference_range['normal_to'],
                                    'critical_high_from' => $reference_range['critical_high_from'],
                                    'critical_extra_from' => $reference_range['critical_extra_from'],
                                ]);
                            }
                        }
                    }

                }
            }
        }

        //comments
        $test->comments()->delete();
        if ($request->has('comments')) {
            foreach ($request['comments'] as $comment) {
                $test->comments()->create([
                    'comment' => $comment,
                ]);
            }
        }

        session()->flash('success', __('Test updated successfully'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $test = Test::findOrFail($id);

        //delete old components
        $components = Test::where('parent_id', $id)->get();

        foreach ($components as $component) {
            $component->options()->delete();
            $component->prices()->delete();
            $component->reference_ranges()->delete();
            $component->contract_prices()->delete();
            $component->delete();
        }

        $test->options()->delete();
        $test->prices()->delete();
        $test->contract_prices()->delete();
        $test->comments()->delete();
        $test->delete();

        session()->flash('success', __('Test deleted successfully'));

        return redirect()->route('admin.tests.index');
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
            $test = Test::find($id);

            //delete old components
            $components = Test::where('parent_id', $id)->get();

            foreach ($components as $component) {
                $component->options()->delete();
                $component->prices()->delete();
                $component->reference_ranges()->delete();
                $component->contract_prices()->delete();
                $component->delete();
            }

            $test->options()->delete();
            $test->prices()->delete();
            $test->contract_prices()->delete();
            $test->comments()->delete();
            $test->delete();
        }

        session()->flash('success', __('Bulk deleted successfully'));

        return redirect()->route('admin.tests.index');
    }

    /**
     * Export tests
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function export()
    {

        return Excel::download(new TestExport, 'tests.xlsx');
    }

    /**
     * Import tests
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {

            Excel::import(new TestImport, $request->file('import'));
        }

        session()->flash('success', __('Tests imported successfully'));

        return redirect()->back();
    }

    /**
     * Download tests template
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download_template()
    {

        return response()->download(storage_path('app/public/tests_template.xlsx'), 'tests_template.xlsx');
    }

    public function testOrder()
    {

        $categories = Category::with('testso')
            ->orderBy('position', 'asc')
            ->get();

        return view('admin.tests.test_orders', compact('categories'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        foreach ($request->ids as $index => $id) {
            DB::table('tests')
                ->where('id', $id)
                ->update([
                    'position' => $index + 1,
                    'category_id' => $request->category_id,
                ]);
        }

        foreach ($request->ids as $index => $id) {
            DB::table('group_tests')
                ->where('test_id', $id)
                ->update([
                    'position' => $index + 1,

                ]);
        }

        $positions = Category::find($request->category_id)
            ->tests()
            ->pluck('position', 'id');

        return response(compact('positions'), Response::HTTP_OK);
    }

    public function reorderCategory(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer',
        ]);

        foreach ($request->ids as $index => $id) {
            DB::table('categories')
                ->where('id', $id)
                ->update([
                    'position' => $index + 1,
                ]);
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
