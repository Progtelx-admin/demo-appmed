<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Branch;
use App\Models\Contract;
use App\Models\ContractPrice;
use App\Models\MicrobiologyTest;
use App\Models\MicrobiologyTestOption;
use App\Models\MicrobiologyTestPrice;
use App\Models\Category;
use DataTables;
use Excel;


class MicrobiologyTestController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:view_test', ['only' => ['index', 'show', 'ajax']]);
        $this->middleware('can:create_test', ['only' => ['create', 'store']]);
        $this->middleware('can:edit_test', ['only' => ['edit', 'update']]);
        $this->middleware('can:delete_test', ['only' => ['destroy', 'bulk_delete']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.microbiology_tests.index');
    }

    public function ajax(Request $request)
    {
        $model = MicrobiologyTest::with('category')->where(function ($q) {
            return $q->where('parent_id', 0)->orWhere('separated', true);
        });

        return DataTables::eloquent($model)
            ->editColumn('price', function ($microbiologyTest) {
                return formated_price($microbiologyTest['price']);
            })
            ->addColumn('action', function ($microbiologyTest) {
                return view('admin.microbiology_tests._action', compact('microbiologyTest'));
            })
            ->addColumn('bulk_checkbox', function ($item) {
                return view('partials._bulk_checkbox', compact('item'));
            })
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function create()
     {
        $categories = Category::all();
        //  return view('admin.microbiology_tests.create');
         return view('admin.microbiology_tests.create', compact('categories'));
     }


    public function store(Request $request)
    {

        try {
            DB::beginTransaction();

            $microbiologyTest = MicrobiologyTest::create([
                'name' => $request->name,
                'parent_id' => 0,
                'sample_type' => $request->sample_type,
                'shortcut' => $request->shortcut,
                'price' => $request->price,
                'precautions' => $request->precautions,
                'category_id' => $request->category_id,
                'pantheon_id' => $request->pantheon_id,
            ]);



            $this->createTestPrices($microbiologyTest, $request);
            $this->createContractPrices($microbiologyTest);
            $this->createComponents($microbiologyTest, $request);
            $this->createComments($microbiologyTest, $request);

            DB::commit();

            session()->flash('success', __('Microbiology Test created successfully'));
            return redirect()->route('admin.microbiology_tests.index');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            DB::rollBack();
            session()->flash('error', __('Failed to create Microbiology Test'));
            return back()->withInput();
        }
    }

    private function createTestPrices($microbiologyTest, $request)
    {
        $branches = Branch::all();
        foreach ($branches as $branch) {
            MicrobiologyTestPrice::create([
                'branch_id' => $branch->id,
                'test_id' => $microbiologyTest->id,
                'price' => $request->price,
            ]);
        }
    }

    private function createContractPrices($microbiologyTest)
    {
        $contracts = Contract::all();
        foreach ($contracts as $contract) {
            $contract->tests()->create([
                'priceable_type' => MicrobiologyTest::class,
                'priceable_id' => $microbiologyTest->id,
                'price' => ($contract->discount_type == 1) ? ($microbiologyTest->price * $contract->discount_percentage / 100) : $microbiologyTest->price,
            ]);
        }
    }

    private function createComponents($microbiologyTest, $request)
    {
        if ($request->has('component')) {
            foreach ($request->component as $component) {
                if (isset($component['title'])) {
                    MicrobiologyTest::create([
                        'category_id' => $request['category_id'],
                        'parent_id' => $microbiologyTest->id,
                        'name' => $component['name'],
                        'name2' => $component['name2'],
                        'title' => true,
                    ]);
                } else {
                    $test_component = MicrobiologyTest::create([
                        'category_id' => $request['category_id'],
                        'parent_id' => $microbiologyTest->id,
                        'type' => $component['type'],
                        'name' => $component['name'],
                        'name2' => $component['name2'] ?? '',
                        'unit' => $component['unit'] ?? '',
                        'reference_range' => $component['reference_range'] ?? '',
                        'title' => (isset($component['title'])) ? true : false,
                        'separated' => isset($component['separated']),
                        'price' => $component['price'] ?? 0,
                        'status' => isset($component['status']),
                        'sample_type' => $microbiologyTest->sample_type,
                    ]);

                    if (isset($component['separated'])) {
                        $this->createTestPrices($test_component, $request);
                        $this->createContractPrices($test_component);
                    }

                    // if (isset($component['options'])) {
                    //     foreach ($component['options'] as $option) {
                    //         MicrobiologyTestOption::create([
                    //             'name' => $option,
                    //             'test_id' => $test_component->id,
                    //         ]);
                    //     }
                    // }



                                            //delete options if not select type
                                            if ($component['type'] != 'select') {
                                                $test_component->options()->delete();
                                            }

                                            //update old options
                                            if (isset($component['old_options'])) {
                                                foreach ($component['old_options'] as $option_id => $option) {
                                                    MicrobiologyTestOption::where('id', $option_id)->update([
                                                        'name' => $option,
                                                    ]);
                                                }
                                            }

                                            //assign options to component
                                            if (isset($component['options'])) {
                                                foreach ($component['options'] as $option) {
                                                    MicrobiologyTestOption::create([
                                                        'name' => $option,
                                                        'test_id' => $test_component['id'],
                                                    ]);
                                                }
                                            }

                    if (isset($component['reference_ranges'])) {
                        foreach ($component['reference_ranges'] as $referenceRange) {
                            $multiplication = 1;
                            if ($referenceRange['age_unit'] == 'month') {
                                $multiplication = 30;
                            } elseif ($referenceRange['age_unit'] == 'year') {
                                $multiplication = 365;
                            }

                            $test_component->reference_ranges()->create([
                                'gender' => $referenceRange['gender'],
                                'age_unit' => $referenceRange['age_unit'],
                                'age_from' => $referenceRange['age_from'],
                                'age_to' => $referenceRange['age_to'],
                                'age_from_days' => $referenceRange['age_from'] * $multiplication,
                                'age_to_days' => $referenceRange['age_to'] * $multiplication,
                                'critical_low_from' => $referenceRange['critical_low_from'],
                                'normal_from' => $referenceRange['normal_from'],
                                'normal_to' => $referenceRange['normal_to'],
                                'critical_high_from' => $referenceRange['critical_high_from'],
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function createComments($microbiologyTest, $request)
    {
        if ($request->has('comments')) {
            foreach ($request['comments'] as $comment) {
                $microbiologyTest->comments()->create([
                    'comment' => $comment,
                ]);
            }
        }
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

        $microbiologyTest = MicrobiologyTest::with('components')->where('id', $id)->firstOrFail();

        return view('admin.microbiology_tests.edit', compact('microbiologyTest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function update(Request $request, MicrobiologyTest $microbiologyTest)
    {
        try {
            DB::beginTransaction();

            $microbiologyTest->update([
                'name' => $request->name,
                'sample_type' => $request->sample_type,
                'shortcut' => $request->shortcut,
                'price' => $request->price,
                'precautions' => $request->precautions,
                'category_id' => $request->category_id,
                'pantheon_id' => $request->pantheon_id,
            ]);

            // Update test prices
            $this->updateTestPrices($microbiologyTest, $request);

            // Update contract prices
            $this->updateContractPrices($microbiologyTest);

            // Update components
            $this->updateComponents($microbiologyTest, $request);

            // Update comments
            $this->updateComments($microbiologyTest, $request);

            DB::commit();

            session()->flash('success', __('Microbiology Test updated successfully'));
            return redirect()->route('admin.microbiology_tests.index');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', __('Failed to update Microbiology Test'));
            return back()->withInput();
        }
    }

    private function updateTestPrices($microbiologyTest, $request)
    {
        $branches = Branch::all();
        foreach ($branches as $branch) {
            $testPrice = MicrobiologyTestPrice::where('branch_id', $branch->id)
                ->where('test_id', $microbiologyTest->id)
                ->first();

            if ($testPrice) {
                $testPrice->update([
                    'price' => $request->price,
                ]);
            }
        }
    }

    private function updateContractPrices($microbiologyTest)
    {
        $contracts = Contract::all();
        foreach ($contracts as $contract) {
            $testContract = $contract->tests()
                ->where('priceable_type', MicrobiologyTest::class)
                ->where('priceable_id', $microbiologyTest->id)
                ->first();

            if ($testContract) {
                $testContract->update([
                    'price' => ($contract->discount_type == 1) ? ($microbiologyTest->price * $contract->discount_percentage / 100) : $microbiologyTest->price,
                ]);
            }
        }
    }

    private function updateComponents($microbiologyTest, $request)
    {
        if ($request->has('component')) {
            foreach ($request->component as $component) {
                if (isset($component['id'])) {
                    $existingComponent = MicrobiologyTest::findOrFail($component['id']);

                    $existingComponent->update([
                        'name' => $component['name'],
                        'name2' => $component['name2'] ?? '',
                        'type' => $component['type'],
                        'unit' => $component['unit'] ?? '',
                        'reference_range' => $component['reference_range'] ?? '',
                        'title' => isset($component['title']),
                        'separated' => isset($component['separated']),
                        'price' => $component['price'] ?? 0,
                        'status' => isset($component['status']),
                    ]);

                    // Update test prices and contract prices if the component is separated
                    if (isset($component['separated'])) {
                        $this->updateTestPrices($existingComponent, $request);
                        $this->updateContractPrices($existingComponent);
                    }

                    // Update options if they exist
                    if (isset($component['options'])) {
                        $existingComponent->options()->delete(); // Remove existing options

                        foreach ($component['options'] as $option) {
                            MicrobiologyTestOption::create([
                                'name' => $option,
                                'test_id' => $existingComponent->id,
                            ]);
                        }
                    }

                    // Update reference ranges if they exist
                    if (isset($component['reference_ranges'])) {
                        $existingComponent->reference_ranges()->delete(); // Remove existing reference ranges

                        foreach ($component['reference_ranges'] as $referenceRange) {
                            $multiplication = 1;
                            if ($referenceRange['age_unit'] == 'month') {
                                $multiplication = 30;
                            } elseif ($referenceRange['age_unit'] == 'year') {
                                $multiplication = 365;
                            }

                            $existingComponent->reference_ranges()->create([
                                'gender' => $referenceRange['gender'],
                                'age_unit' => $referenceRange['age_unit'],
                                'age_from' => $referenceRange['age_from'],
                                'age_to' => $referenceRange['age_to'],
                                'age_from_days' => $referenceRange['age_from'] * $multiplication,
                                'age_to_days' => $referenceRange['age_to'] * $multiplication,
                                'critical_low_from' => $referenceRange['critical_low_from'],
                                'normal_from' => $referenceRange['normal_from'],
                                'normal_to' => $referenceRange['normal_to'],
                                'critical_high_from' => $referenceRange['critical_high_from'],
                            ]);
                        }
                    }
                } else {
                    // Handle creation of new components if the ID is not provided
                    // This part is similar to the createComponents logic
                }
            }
        }
    }


    private function updateComments($microbiologyTest, $request)
    {
        // Delete existing comments
        $microbiologyTest->comments()->delete();

        // Create new comments based on the request
        if ($request->has('comments')) {
            foreach ($request->comments as $commentData) {
                if (is_array($commentData) && isset($commentData['comment'])) {
                    $microbiologyTest->comments()->create([
                        'comment' => $commentData['comment'],
                    ]);
                } else if (is_string($commentData)) {
                    $microbiologyTest->comments()->create([
                        'comment' => $commentData,
                    ]);
                }
            }
        }
    }





    public function consumptions($id)
    {
        $tests = MicrobiologyTest::where('id', $id)->orWhere([
            ['parent_id', $id],
            ['separated', true],
        ])->get();

        return view('admin.microbiology_tests.consumptions', compact('tests'));
    }

    public function consumptions_submit(Request $request)
    {
        if ($request->has('consumption')) {
            foreach ($request['consumption'] as $test_id => $consumptions) {
                $test = MicrobiologyTest::find($test_id);

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

        return redirect()->route('admin.microbiology_tests.index');
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
