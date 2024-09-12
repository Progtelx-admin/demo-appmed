<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CulturePriceExport;
use App\Exports\PackagePriceExport;
use App\Exports\TestPriceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExcelImportRequest;
use App\Imports\CulturePriceImport;
use App\Imports\PackagePriceImport;
use App\Imports\TestPriceImport;
use App\Models\Culture;
use App\Models\CulturePrice;
use App\Models\Package;
use App\Models\PackagePrice;
use App\Models\Service;
use App\Models\ServicePrice;
use App\Models\Test;
use App\Models\TestPrice;
use App\Models\MicrobiologyTestPrice;
use DataTables;
use Excel;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    /**
     * assign roles
     */
    public function __construct()
    {
        $this->middleware('can:view_test_prices', ['only' => ['tests']]);
        $this->middleware('can:update_test_prices', ['only' => ['tests_submit']]);
        $this->middleware('can:view_package_prices', ['only' => ['packages']]);
        $this->middleware('can:update_pacakage_prices', ['only' => ['pacakages_submit']]);
        $this->middleware('can:view_culture_prices', ['only' => ['cultures']]);
        $this->middleware('can:update_culture_prices', ['only' => ['cultures_submit']]);
        $this->middleware('can:view_service_prices', ['only' => ['services']]);
        $this->middleware('can:update_service_prices', ['only' => ['service_submit']]);
    }

    /**
     * tests price list
     *
     * @return \Illuminate\Http\Response
     */
    public function tests(Request $request)
    {
        if ($request->ajax()) {
            $model = TestPrice::with('test.category')
                ->where('branch_id', session('branch_id'));

            return DataTables::eloquent($model)
                ->editColumn('price', function ($test) {
                    return view('admin.prices._test_price', compact('test'));
                })
                ->toJson();
        }

        return view('admin.prices.tests');
    }

    /**
     * update tests prices
     *
     * @return \Illuminate\Http\Response
     */
    public function tests_submit(Request $request)
    {
        if ($request->has('tests')) {
            foreach ($request['tests'] as $key => $value) {
                TestPrice::where('id', $key)
                    ->where('branch_id', session('branch_id'))
                    ->update([
                        'price' => $value,
                    ]);
            }
        }

        session()->flash('success', __('Tests prices updated successfully'));

        return redirect()->back();
    }

        /**
     * microbiology_tests price list
     *
     * @return \Illuminate\Http\Response
     */
    public function microbiology_tests(Request $request)
    {
        if ($request->ajax()) {
            $model = MicrobiologyTestPrice::with('test.category')
                ->where('branch_id', session('branch_id'));

            return DataTables::eloquent($model)
                ->editColumn('price', function ($test) {
                    return view('admin.prices._microbiology_test_price', compact('test'));

                })
                ->toJson();
        }

        return view('admin.prices.microbiology_tests');
    }

    /**
     * microbiology_tests price list
     *
     * @return \Illuminate\Http\Response
     */
    public function microbiology_tests_submit(Request $request)
    {
        if ($request->has('tests')) {
            foreach ($request['tests'] as $key => $value) {
                MicrobiologyTestPrice::where('id', $key)
                    ->where('branch_id', session('branch_id'))
                    ->update([
                        'price' => $value,
                    ]);
            }
        }

        session()->flash('success', __('Microbiology tests prices updated successfully'));

        return redirect()->back();
    }

    /**
     * cultures price list
     *
     * @return \Illuminate\Http\Response
     */
    public function cultures(Request $request)
    {
        if ($request->ajax()) {
            $model = CulturePrice::with('culture.category')
                ->where('branch_id', session('branch_id'));

            return DataTables::eloquent($model)
                ->editColumn('price', function ($culture) {
                    return view('admin.prices._culture_price', compact('culture'));
                })
                ->toJson();
        }

        return view('admin.prices.cultures');
    }

    /**
     * update cultures prices
     *
     * @return \Illuminate\Http\Response
     */
    public function cultures_submit(Request $request)
    {
        if ($request->has('cultures')) {
            foreach ($request['cultures'] as $key => $value) {
                CulturePrice::where('id', $key)
                    ->where('branch_id', session('branch_id'))
                    ->update([
                        'price' => $value,
                    ]);
            }
        }

        session()->flash('success', __('Cultures prices updated successfully'));

        return redirect()->back();
    }

    /**
     * packges price list
     *
     * @return \Illuminate\Http\Response
     */
    public function packages(Request $request)
    {
        if ($request->ajax()) {
            $model = PackagePrice::with('package.category')
                ->where('branch_id', session('branch_id'));

            return DataTables::eloquent($model)
                ->editColumn('price', function ($package) {
                    return view('admin.prices._package_price', compact('package'));
                })
                ->toJson();
        }

        return view('admin.prices.packages');
    }

    /**
     * update packages prices
     *
     * @return \Illuminate\Http\Response
     */
    public function packages_submit(Request $request)
    {
        if ($request->has('packages')) {
            foreach ($request['packages'] as $key => $value) {
                PackagePrice::where('id', $key)->update([
                    'price' => $value,
                ]);
            }
        }

        session()->flash('success', __('Packages prices updated successfully'));

        return redirect()->back();
    }

    /**
     * services price list
     *
     * @return \Illuminate\Http\Response
     */
    public function services(Request $request)
    {
        if ($request->ajax()) {
            $model = ServicePrice::with('service.category')
                ->where('branch_id', session('branch_id'));

            return DataTables::eloquent($model)
                ->editColumn('price', function ($service) {
                    return view('admin.prices._services_price', compact('service'));
                })
                ->toJson();
        }

        return view('admin.prices.services');
    }

    /**
     * update services prices
     *
     * @return \Illuminate\Http\Response
     */
    public function services_submit(Request $request)
    {
        if ($request->has('services')) {
            foreach ($request['services'] as $key => $value) {
                ServicePrice::where('id', $key)->update([
                    'price' => $value,
                ]);
            }
        }

        session()->flash('success', __('Services prices updated successfully'));

        return redirect()->back();
    }

    public function tests_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download(new TestPriceExport, 'tests_prices.xlsx');
    }

    public function cultures_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download(new CulturePriceExport, 'cultures_prices.xlsx');
    }

    public function packages_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download(new PackagePriceExport, 'packages_prices.xlsx');
    }

    public function services_prices_export()
    {
        ob_end_clean(); // this
        ob_start(); // and this

        return Excel::download(new ServicePriceExport, 'services_prices.xlsx');
    }

    /**
     * Import tests prices
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tests_prices_import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this

            //import tests
            Excel::import(new TestPriceImport, $request->file('import'));
        }

        session()->flash('success', __('Tests prices imported successfully'));

        return redirect()->back();
    }

    /**
     * Import cultures prices
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cultures_prices_import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this

            //import tests
            Excel::import(new CulturePriceImport, $request->file('import'));
        }

        session()->flash('success', __('Cultures prices imported successfully'));

        return redirect()->back();
    }

    /**
     * Import packages prices
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function packages_prices_import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this

            //import packages
            Excel::import(new PackagePriceImport, $request->file('import'));
        }

        session()->flash('success', __('Packages prices imported successfully'));

        return redirect()->back();
    }

    /**
     * Import services prices
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function services_prices_import(ExcelImportRequest $request)
    {
        if ($request->hasFile('import')) {
            ob_end_clean(); // this
            ob_start(); // and this

            //import packages
            Excel::import(new ServicesPriceImport, $request->file('import'));
        }

        session()->flash('success', __('Services prices imported successfully'));

        return redirect()->back();
    }

    public function updateTestPrices(Request $request)
    {

        // Update Test prices
        $tests = Test::where('parent_id', '0')->get();
        foreach ($tests as $test) {
            TestPrice::where('test_id', $test->id)->update([
                'price' => $test->price,
            ]);
        }

        // Update Culture prices
        $cultures = Culture::all(); // Assuming there's no parent_id filter for cultures
        foreach ($cultures as $culture) {
            CulturePrice::where('culture_id', $culture->id)->update([
                'price' => $culture->price,
            ]);
        }

        // Update Service prices
        $services = Service::all(); // Assuming there's no parent_id filter for services
        foreach ($services as $service) {
            ServicePrice::where('service_id', $service->id)->update([
                'price' => $service->price,
            ]);
        }

        // Update Package prices
        $packages = Package::all(); // Assuming there's no parent_id filter for packages
        foreach ($packages as $package) {
            PackagePrice::where('package_id', $package->id)->update([
                'price' => $package->price,
            ]);
        }

        // Flash a success message to the session
        session()->flash('success', __('Prices updated successfully across all entities.'));

        // Redirect back
        return redirect()->back();
    }
}
