<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\APIController;
use App\Http\Requests\Admin\DoctorRequest;
use App\Http\Requests\Admin\PatientRequest;
use App\Models\Antibiotic;
use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Contract;
use App\Models\ContractPrice;
use App\Models\Country;
use App\Models\Culture;
use App\Models\Doctor;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\GroupCulture;
use App\Models\GroupPackage;
use App\Models\GroupPayment;
use App\Models\GroupTest;
use App\Models\HealthCertificate;
use App\Models\Instrument;
use App\Models\Laboratory;
use App\Models\Language;
use App\Models\Option;
use App\Models\Package;
use App\Models\Patient;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\PurchasePayment;
use App\Models\Service;
use App\Models\Supplier;
use App\Models\Test;
use App\Models\MicrobiologyTest;
use App\Models\TestOption;
use App\Models\Timezone;
use App\Models\User;
use App\Models\Visit;
use App\Models\Pathology;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    /**
     * get patient by code select2
     *
     * @var @Request
     */
    public function get_patient_by_code(Request $request)
    {
        if (isset($request->term)) {
            $patients = Patient::with('contract')
                ->where('code', 'like', '%'.$request->term.'%')
                ->take(20)
                ->get();
        } else {
            $patients = Patient::with('contract')
                ->take(20)
                ->get();
        }

        return response()->json($patients);

    }

    /**
     * get patient by name select2
     *
     * @var @Request
     */
    public function get_patient_by_name(Request $request)
    {
        if (isset($request->term)) {
            $patients = Patient::with('contract')
                ->where('name', 'like', '%'.$request->term.'%')
                ->take(20)
                ->get();
        } else {
            $patients = Patient::with('contract')
                ->take(20)
                ->get();
        }

        return response()->json($patients);

    }

    /**
     * create patient
     *
     * @var @Request
     */
    public function create_patient(PatientRequest $request)
    {
        $patient = Patient::create($request->except('_token', 'avatar', 'age', 'age_unit'));

        patient_code($patient['id']);

        if ($request->has('avatar') && ! empty($request['avatar'])) {
            //save file
            $data = explode(',', $request['avatar']);
            $extension = explode('/', mime_content_type($request['avatar']))[1];
            $decoded = base64_decode($data[1]);

            //generte name
            $name = time().$patient['id'].'.'.$extension;
            file_put_contents('uploads/patient-avatar/'.$name, $decoded);

            //save file name to record
            $patient->update(['avatar' => $name]);
        }

        //send patient code notification
        $patient = Patient::find($patient['id']);
        send_notification('patient_code', $patient);

        //API Pantheon
        $requestapi = (new APIController)->patient($patient);

        return response()->json($patient);
    }

    /**
     * edit patient
     *
     * @var @Request
     */
    public function edit_patient(PatientRequest $request, $id)
    {
        $patient = Patient::find($id);

        $patient->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'dob' => $request['dob'],
            'address' => $request['address'],
            'profession' => $request['profession'],
            'contract_id' => $request['contract_id'],
            'country_id' => $request['country_id'],
            'national_id' => $request['national_id'],
            'passport_no' => $request['passport_no'],
            'vaccinated' => $request['vaccinated'],
            'vaccinemodel' => $request['vaccinemodel'],
            'datevaccine1' => $request['datevaccine1'],
            'datevaccine2' => $request['datevaccine2'],
            'datevaccine3' => $request['datevaccine3'],
        ]);

        //API Pantheon
        $requestapi = (new APIController)->patientId($patient);

        if ($request->has('avatar') && ! empty($request['avatar'])) {
            //save file
            $data = explode(',', $request['avatar']);
            $extension = explode('/', mime_content_type($request['avatar']))[1];
            $decoded = base64_decode($data[1]);

            //generte name
            $name = time().$patient['id'].'.'.$extension;
            file_put_contents('uploads/patient-avatar/'.$name, $decoded);

            //save file name to record
            $patient->update(['avatar' => $name]);
        }

        $patient = Patient::find($id);

        return response()->json($patient);
    }

    /**
     * get doctors select2
     *
     * @var @Request
     */
    public function get_doctors(Request $request)
    {
        if (isset($request->term)) {
            $doctors = Doctor::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $doctors = Doctor::take(20)->get();
        }

        return response()->json($doctors);
    }

    /**
     * get tests select2
     *
     * @var @Request
     */
    public function get_tests(Request $request)
    {
        if (isset($request->term)) {
            $tests = Test::where(function ($q) {
                return $q->where('parent_id', 0)->orWhere('separated', true);
            })->where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $tests = Test::where(function ($q) {
                return $q->where('parent_id', 0)->orWhere('separated', true);
            })->take(20)->get();
        }

        return response()->json($tests);
    }

    public function get_microbiology_tests(Request $request)
    {
        if (isset($request->term)) {
            $tests = MicrobiologyTest::where(function ($q) {
                return $q->where('parent_id', 0)->orWhere('separated', true);
            })->where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $tests = MicrobiologyTest::where(function ($q) {
                return $q->where('parent_id', 0)->orWhere('separated', true);
            })->take(20)->get();
        }

        return response()->json($tests);
    }

    /**
     * get cultures select2
     *
     * @var @Request
     */
    public function get_cultures(Request $request)
    {
        if (isset($request->term)) {
            $cultures = Culture::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $cultures = Culture::take(20)->get();
        }

        return response()->json($cultures);
    }

    public function get_services(Request $request)
    {
        if (isset($request->term)) {
            $services = Service::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $services = Service::take(20)->get();
        }

        return response()->json($services);
    }

    /**
     * create doctor
     *
     * @var @Request
     */
    public function create_doctor(DoctorRequest $request)
    {
        $doctor = Doctor::create($request->except('_token'));

        doctor_code($doctor['id']);

        $doctor = Doctor::find($doctor['id']);

        return response()->json($doctor);
    }

    /**
     * get online users
     *
     * @var @Request
     */
    public function online_admins()
    {
        $online_users = User::where('last_activity', '>', now()->subMinutes(5))
            ->where('id', '!=', auth()->guard('admin')->user()->id)
            ->get();

        return response()->json($online_users);
    }

    /**
     * get online users
     *
     * @var @Request
     */
    public function online_patients()
    {
        $online_patients = Patient::where('last_activity', '>', now()->subMinutes(5))
            ->get();

        return response()->json($online_patients);
    }

    /**
     * get chat messages
     *
     * @var @Request
     */
    public function get_chat($id)
    {
        $chats = Chat::with('from_user')->where([
            ['from', $id], ['to', auth()->guard('admin')->user()['id']],
        ])->orWhere([
            ['to', $id], ['from', auth()->guard('admin')->user()['id']],
        ])->orderBy('id', 'desc')->take(20)->get();

        $to_chats = Chat::where([['from', $id], ['to', auth()->guard('admin')->user()['id']]])->get();

        foreach ($to_chats as $chat) {
            $chat->update(['read' => 1]);
        }

        return response()->json($chats);
    }

    /**
     * get chat unread messages
     *
     * @var @Request
     */
    public function chat_unread($id)
    {
        $chats = Chat::with('from_user')->where([
            ['from', $id], ['to', auth()->guard('admin')->user()['id']],
        ])->where('read', 0)
            ->get();

        foreach ($chats as $chat) {
            $chat->update(['read' => 1]);
        }

        return response()->json($chats);
    }

    /**
     * send message
     *
     * @var @Request
     */
    public function send_message(Request $request, $id)
    {
        $chat = Chat::create([
            'from' => auth()->guard('admin')->user()['id'],
            'to' => $id,
            'message' => $request->message,
        ]);

        return $chat;
    }

    /**
     * Change visit status
     *
     * @var @Request
     */
    public function change_visit_status($id)
    {
        $visit = Visit::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $visit->update([
            'read' => true,
            'status' => ($visit['status']) ? false : true,
        ]);

        return response()->json(__('Visit status updated successfully'));
    }
    /**
     * Change visit status
     *
     * @var @Request
     */
    public function change_pathology_status($id)
    {
        $pathology = Pathology::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $pathology->update([
            'read' => true,
            'status' => ($pathology['status']) ? false : true,
        ]);

        return response()->json(__('Visit status updated successfully'));
    }

    public function change_appointment_status($id)
    {
        $appointment = Appointment::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $appointment->update([
            'read' => true,
            'status' => ($appointment['status']) ? false : true,
        ]);

        return response()->json(__('Appointment status updated successfully'));
    }

    public function change_certificate_status($id)
    {
        $healthcertificate = HealthCertificate::where('branch_id', session('branch_id'))
            ->findOrFail($id);

        $healthcertificate->update([
            'read' => true,
            'status' => ($healthcertificate['status']) ? false : true,
        ]);

        return response()->json(__('Health Certificate status updated successfully'));
    }

    /**
     * Change visit status
     *
     * @var @Request
     */

    /**
     * Change lang status
     *
     * @var @Request
     */
    public function change_lang_status($id)
    {
        $lang = Language::find($id);

        $lang->update([
            'active' => ($lang['active']) ? false : true,
        ]);

        return response()->json(__('Language status updated successfully'));
    }

    /**
     * create expenses category
     *
     * @var @Request
     */
    public function add_expense_category(Request $request)
    {
        $category = ExpenseCategory::create([
            'name' => $request['name'],
        ]);

        return response()->json($category);
    }

    /**
     * get unread mesasges
     *
     * @var @Request
     */
    public function get_unread_messages(Request $request)
    {
        $messages = Chat::with('from_user')->where('to', auth()->guard('admin')->user()['id'])->where('read', false)->get();

        return response()->json($messages);
    }

    /**
     * get unread mesasges count
     *
     * @var @Request
     */
    public function get_unread_messages_count($user_id)
    {
        $count = Chat::with('from_user')->where([['to', auth()->guard('admin')->user()['id']], ['from', $user_id]])->where('read', false)->count();

        return $count;
    }

    /**
     * load more messages
     *
     * @var @Request
     */
    public function load_more($user_id, $message_id)
    {
        $chats = Chat::with(['from_user', 'to_user'])->where(function ($q) use ($user_id) {
            return $q->where([
                ['to', $user_id], ['from', auth()->guard('admin')->user()['id']],
            ])->orWhere([
                ['from', $user_id], ['to', auth()->guard('admin')->user()['id']],
            ]);
        })->where('id', '<', $message_id)->orderBy('id', 'desc')->take(10)->get();

        return response()->json($chats);

    }

    /**
     * get my messages to user
     *
     * @var @Request
     */
    public function get_my_messages($id)
    {
        $chats = Chat::where([['from', auth()->guard('admin')->user()['id']], ['to', $id]])->orderBy('id', 'desc')->take(20)->get();

        return response()->json($chats);
    }

    /**
     * get new visits
     *
     * @var @Request
     */
    public function get_new_visits()
    {
        $visits = Visit::where('read', false)
            ->where('branch_id', session('branch_id'))
            ->orderBy('id', 'desc')
            ->with('patient')
            ->get();

        return response()->json($visits);

    }

    /**
     * get new appointments
     *
     * @var @Request
     */
    public function get_new_appointments()
    {
        $appointments = Appointment::where('read', false)
            ->where('branch_id', session('branch_id'))
            ->orderBy('id', 'desc')
            ->with('patient')
            ->get();

        return response()->json($appointments);

    }

    /**
     * get new visits
     *
     * @var @Request
     */
    public function get_new_healthcertificates()
    {
        $healthcertificates = HealthCertificate::where('read', false)
            ->where('branch_id', session('branch_id'))
            ->orderBy('id', 'desc')
            ->with('patient')
            ->get();

        return response()->json($healthcertificates);

    }

    /**
     * get current patient
     *
     * @var @Request
     */
    public function get_current_patient()
    {
        $patient = Patient::where('id', auth()->guard('patient')->user()['id'])->first();

        return response()->json($patient);
    }

    /**
     * get patient
     *
     * @var @Request
     */
    public function get_patient(Request $request)
    {
        $patient = Patient::with('contract.tests', 'contract.cultures', 'contract.packages', 'contract.antibiotics', 'country')->find($request->id);

        $age = explode(' ', $patient['age']);

        $patient['age_splited'] = ['age' => $age[0], 'age_unit' => strtolower($age[1])];

        return response()->json($patient);
    }

    /**
     * delete test
     *
     * @var @Request
     */
    public function delete_test($test_id)
    {
        $test = Test::find($test_id);

        if (isset($test)) {
            $test->options()->delete();
            $test->reference_ranges()->delete();
            $test->comments()->delete();
            $test->prices()->delete();

            $test->delete();
        }

        return response()->json('success');
    }

    /**
     * delete test option
     *
     * @var @Request
     */
    public function delete_option($option_id)
    {
        TestOption::where('id', $option_id)->delete();

        return response()->json('success');
    }

    public function delete_option_mikro($option_id)
    {
        MicrobiologyTestOption::where('id', $option_id)->delete();

        return response()->json('success');
    }

    /**
     * select2 categories
     *
     * @var @Request
     */
    public function get_categories(Request $request)
    {
        if (isset($request->term)) {
            $categories = Category::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $categories = Category::take(20)->get();
        }

        return response()->json($categories);
    }

    /**
     * select2 contracts
     *
     * @var @Request
     */
    public function get_contracts(Request $request)
    {
        if (isset($request->term)) {
            $contracts = Contract::where('title', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $contracts = Contract::take(20)->get();
        }

        return response()->json($contracts);
    }

    /**
     * select2 payment methods
     *
     * @var @Request
     */
    public function get_payment_methods(Request $request)
    {
        if (isset($request->term)) {
            $payment_methods = PaymentMethod::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $payment_methods = PaymentMethod::take(20)->get();
        }

        return response()->json($payment_methods);
    }

    /**
     * create payment method
     *
     * @var @Request
     */
    public function create_payment_method(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
            ],
        ]);

        $payment_method = PaymentMethod::create([
            'name' => $request['name'],
        ]);

        return response()->json($payment_method);
    }

    public function get_statistics(Request $request)
    {
        //format date
        $date = explode('-', $request['date']);
        $from = date('Y-m-d', strtotime($date[0]));
        $to = date('Y-m-d 23:59:59', strtotime($date[1]));

        $data = [];

        //general statistics
        $tests_count = Test::where(function ($query) {
            return $query->where('parent_id', 0)
                ->orWhere('separated', true);
        });
        $tests_count = ($from == $to) ? $tests_count->whereDate('created_at', $from)->count() : $tests_count->whereBetween('created_at', [$from, $to])->count();
        $data['tests_count'] = $tests_count;

        $cultures_count = Culture::query();
        $cultures_count = ($from == $to) ? $cultures_count->whereDate('created_at', $from)->count() : $cultures_count->whereBetween('created_at', [$from, $to])->count();
        $data['cultures_count'] = $cultures_count;

        $antibiotics_count = Antibiotic::query();
        $antibiotics_count = ($from == $to) ? $antibiotics_count->whereDate('created_at', $from)->count() : $antibiotics_count->whereBetween('created_at', [$from, $to])->count();
        $data['antibiotics_count'] = $antibiotics_count;

        $patients_count = Patient::query();
        $patients_count = ($from == $to) ? $patients_count->whereDate('created_at', $from)->count() : $patients_count->whereBetween('created_at', [$from, $to])->count();
        $data['patients_count'] = $patients_count;

        $contracts_count = Contract::query();
        $contracts_count = ($from == $to) ? $contracts_count->whereDate('created_at', $from)->count() : $contracts_count->whereBetween('created_at', [$from, $to])->count();
        $data['contracts_count'] = $contracts_count;

        //tests statistics
        $group_tests_count = GroupTest::whereHas('group', function ($query) {
            return $query->where('branch_id', session('branch_id'));
        });
        $group_tests_count = ($from == $to) ? $group_tests_count->whereDate('created_at', $from)->count() : $group_tests_count->whereBetween('created_at', [$from, $to])->count();

        $data['group_tests_count'] = $group_tests_count;

        $pending_tests_count = GroupTest::where('done', false)
            ->whereHas('group', function ($query) {
                return $query->where('branch_id', session('branch_id'));
            });
        $pending_tests_count = ($from == $to) ? $pending_tests_count->whereDate('created_at', $from)->count() : $pending_tests_count->whereBetween('created_at', [$from, $to])->count();

        $data['pending_tests_count'] = $pending_tests_count;

        $done_tests_count = GroupTest::where('done', true)
            ->whereHas('group', function ($query) {
                return $query->where('branch_id', session('branch_id'));
            });
        $done_tests_count = ($from == $to) ? $done_tests_count->whereDate('created_at', $from)->count() : $done_tests_count->whereBetween('created_at', [$from, $to])->count();

        $data['done_tests_count'] = $done_tests_count;

        //cultures statistics
        $group_cultures_count = GroupCulture::whereHas('group', function ($query) {
            return $query->where('branch_id', session('branch_id'));
        });
        $group_cultures_count = ($from == $to) ? $group_cultures_count->whereDate('created_at', $from)->count() : $group_cultures_count->whereBetween('created_at', [$from, $to])->count();

        $data['group_cultures_count'] = $group_cultures_count;

        $pending_cultures_count = GroupCulture::where('done', false)
            ->whereHas('group', function ($query) {
                return $query->where('branch_id', session('branch_id'));
            });
        $pending_cultures_count = ($from == $to) ? $pending_cultures_count->whereDate('created_at', $from)->count() : $pending_cultures_count->whereBetween('created_at', [$from, $to])->count();

        $data['pending_cultures_count'] = $pending_cultures_count;

        $done_cultures_count = GroupCulture::where('done', true)
            ->whereHas('group', function ($query) {
                return $query->where('branch_id', session('branch_id'));
            });
        $done_cultures_count = ($from == $to) ? $done_cultures_count->whereDate('created_at', $from)->count() : $done_cultures_count->whereBetween('created_at', [$from, $to])->count();

        $data['done_cultures_count'] = $done_cultures_count;

        //visits
        $visits_count = Visit::with('patient')
            ->where('branch_id', session('branch_id'));
        $visits_count = ($from == $to) ? $visits_count->whereDate('visit_date', $from)->count() : $visits_count->whereBetween('visit_date', [$from, $to])->count();

        $data['visits_count'] = $visits_count;

        //appointments
        $appointments_count = Appointment::with('patient')
            ->where('branch_id', session('branch_id'));
        $appointments_count = ($from == $to) ? $appointments_count->whereDate('visit_date', $from)->count() : $appointments_count->whereBetween('visit_date', [$from, $to])->count();

        $data['appointments_count'] = $appointments_count;

        $healthcertificates_count = HealthCertificate::with('patient')
            ->where('branch_id', session('branch_id'));
        $healthcertificates_count = ($from == $to) ? $healthcertificates_count->whereDate('visit_date', $from)->count() : $healthcertificates_count->whereBetween('visit_date', [$from, $to])->count();

        $data['healthcertificates_count'] = $healthcertificates_count;

        return response()->json($data);
    }

    /**
     * select2 tests
     *
     * @var @Request
     */
    public function get_doctors_select2(Request $request)
    {
        if (isset($request->term)) {
            $doctors = Doctor::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $doctors = Doctor::take(20)->get();
        }

        return response()->json($doctors);
    }

    public function get_tests_select2(Request $request)
    {
        if (isset($request->term)) {
            $tests = Test::where('name', 'like', '%'.$request->term.'%')->where(function ($query) {
                return $query->where('parent_id', 0)->orWhere('separated', true);
            })->take(20)->get();
        } else {
            $tests = Test::where(function ($query) {
                return $query->where('parent_id', 0)->orWhere('separated', true);
            })->take(20)->get();
        }

        return response()->json($tests);
    }

    /**
     * select2 cultures
     *
     * @var @Request
     */
    public function get_cultures_select2(Request $request)
    {
        if (isset($request->term)) {
            $cultures = Culture::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $cultures = Culture::take(20)->get();
        }

        return response()->json($cultures);
    }

    public function get_services_select2(Request $request)
    {
        if (isset($request->term)) {
            $services = Service::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $services = Service::take(20)->get();
        }

        return response()->json($services);
    }

    /**
     * select2 packages
     *
     * @var @Request
     */
    public function get_packages_select2(Request $request)
    {
        if (isset($request->term)) {
            $packages = Package::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $packages = Package::take(20)->get();
        }

        return response()->json($packages);
    }

    /**
     * select2 antibiotic
     *
     * @var @Request
     */
    public function get_antibiotics_select2(Request $request)
    {
        if (isset($request->term)) {
            $antibiotics = Antibiotic::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $antibiotics = Antibiotic::take(20)->get();
        }

        return response()->json($antibiotics);
    }

    /**
     * get contract
     *
     * @var @Request
     */
    public function get_contract(Request $request, $id)
    {
        $request['tests_id'] = explode(',', $request['tests_id']);
        $request['cultures_id'] = explode(',', $request['cultures_id']);
        $request['packages_id'] = explode(',', $request['packages_id']);
        $request['antibiotics_id'] = explode(',', $request['antibiotics_id']);

        $contract = Contract::with(['tests' => function ($query) use ($request) {
            return $query->whereIn('priceable_id', $request['tests_id']);
        }]
        )->with(['cultures' => function ($query) use ($request) {
            return $query->whereIn('priceable_id', $request['cultures_id']);
        }]
        )->with(['packages' => function ($query) use ($request) {
            return $query->whereIn('priceable_id', $request['packages_id']);
        }]
        )->with(['antibiotics' => function ($query) use ($request) {
            return $query->whereIn('priceable_id', $request['antibiotics_id']);
        }])
            ->find($id);

        if (isset($contract)) {
            return response()->json($contract);
        }

        return response()->json('');
    }

    /**
     * select2 branches
     *
     * @var @Request
     */
    public function get_branches_select2(Request $request)
    {
        if (isset($request->term)) {
            $branches = Branch::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $branches = Branch::take(20)->get();
        }

        return response()->json($branches);
    }

    /**
     * get all branches
     *
     * @var @Request
     */
    public function get_all_branches()
    {
        $branches = Branch::all();

        return response()->json($branches);
    }

    /**
     * select2 products
     *
     * @var @Request
     */
    public function get_products_select2(Request $request)
    {
        if (isset($request->term)) {
            $products = Product::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $products = Product::take(20)->get();
        }

        return response()->json($products);
    }

    /**
     * select2 suppliers
     *
     * @var @Request
     */
    public function get_suppliers_select2(Request $request)
    {
        if (isset($request->term)) {
            $suppliers = Supplier::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $suppliers = Supplier::take(20)->get();
        }

        return response()->json($suppliers);
    }

    /**
     * get stock alerts
     *
     * @var @Request
     */
    public function get_stock_alerts()
    {
        $alerts = \DB::select(\DB::raw('
        SELECT branches.id, branch_id , branches.name , product_name , Qty  , stock_alert
        FROM
        (
        SELECT branch_products.branch_id , branch_products.product_id ,products.name product_name , sum(A.quantity) AS Qty  ,branch_products.alert_quantity  As stock_alert
        FROM
        (
            SELECT branch_id , product_id , initial_quantity as quantity
            FROM branch_products
            UNION ALL
            SELECT branch_id , product_id , quantity
            FROM purchase_products
            UNION ALL
            SELECT branch_id , product_id , quantity*-1
            FROM product_consumptions
            UNION ALL
            SELECT from_branch_id , product_id , quantity*-1
            FROM transfer_products
            UNION ALL
            SELECT to_branch_id , product_id , quantity
            FROM transfer_products
            UNION ALL
            SELECT branch_id , product_id , CASE WHEN type = 1  THEN quantity ELSE quantity *-1  END AS quantity
            FROM adjustment_products
        ) AS A JOIN products ON products.id = A.product_id
        JOIN branch_products ON A.product_id = branch_products.product_id
        WHERE products.deleted_at IS NULL
        GROUP BY branch_id,product_id
        HAVING Qty <= branch_products.alert_quantity
        ) AS B LEFT JOIN branches ON B.branch_id = branches.id
        WHERE branches.deleted_at IS NULL
        '));

        return response()->json($alerts);
    }

    /**
     * get income chart
     *
     * @var @Request
     */
    public function get_income_chart($month, $year, Request $request)
    {
        $payments_arr = [];
        $expenses_arr = [];
        $purchases_arr = [];
        $profit_arr = [];

        for ($i = 1; $i < 32; $i++) {
            $payment_amount = (empty($request['branch_id'])) ? GroupPayment::whereDate('date', date('Y-m-d', strtotime($year.'-'.$month.'-'.$i)))->sum('amount') : GroupPayment::whereHas('group', function ($q) use ($request) {
                $q->where('branch__idid', $request['branch_id']);
            })->whereDate('date', date('Y-m-d', strtotime($year.'-'.$month.'-'.$i)))->sum('amount');
            $payments_arr[] = $payment_amount;
            $expense_amount = (empty($request['branch_id'])) ? Expense::whereDate('date', date('Y-m-d', strtotime($year.'-'.$month.'-'.$i)))->sum('amount') : Expense::where('branch_id', $request['branch_id'])->whereDate('date', date('Y-m-d', strtotime($year.'-'.$month.'-'.$i)))->sum('amount');
            $expenses_arr[] = $expense_amount;
            $purchase_amount = (empty($request['branch_id'])) ? PurchasePayment::whereDate('date', date('Y-m-d', strtotime($year.'-'.$month.'-'.$i)))->sum('amount') : PurchasePayment::whereHas('purchase', function ($q) use ($request) {
                $q->where('branch_id', $request['branch_id']);
            })->whereDate('date', date('Y-m-d', strtotime($year.'-'.$month.'-'.$i)))->sum('amount');
            $purchases_arr[] = $purchase_amount;
            $profit_arr[] = $payment_amount - $expense_amount - $purchase_amount;
        }

        return response()->json([
            'data' => [
                [
                    'label' => __('Income'),
                    'data' => $payments_arr,
                    'fill' => false,
                    'borderColor' => '#00cfe8',
                    'tension' => 0.1,
                ],
                [
                    'label' => __('Expenses'),
                    'data' => $expenses_arr,
                    'fill' => false,
                    'borderColor' => '#ea5455',
                    'tension' => 0.1,
                ],
                [
                    'label' => __('Purchases'),
                    'data' => $purchases_arr,
                    'fill' => false,
                    'borderColor' => '#7367f0',
                    'tension' => 0.1,
                ],
                [
                    'label' => __('Profit'),
                    'data' => $profit_arr,
                    'fill' => false,
                    'borderColor' => '#28c76f',
                    'tension' => 0.1,
                ],
            ],
            'font_color' => (auth()->guard('admin')->user()->theme == 'dark') ? '#d0d2d6' : 'black',
        ]);
    }

    /**
     * get best income packages chart
     *
     * @var @Request
     */
    public function get_best_income_packages(Request $request)
    {
        //format date
        $date = explode('-', $request['date']);
        $from = date('Y-m-d', strtotime($date[0]));
        $to = date('Y-m-d 23:59:59', strtotime($date[1]));

        $packages = GroupPackage::selectRaw('package_id ,packages.name, sum(group_packages.price) as income')
            ->groupBy('package_id')
            ->leftJoin('packages', 'group_packages.package_id', 'packages.id')
            ->orderByRaw('income DESC')
            ->having('income', '>', 0);

        ($from == $to) ? $packages->whereDate('group_packages.created_at', $from) : $packages->whereBetween('group_packages.created_at', [$from, $to]);

        if (! empty($request['branch_id'])) {
            $packages->whereHas('group', function ($query) use ($request) {
                return $query->where('branch_id', $request['branch_id']);
            });
        }

        $packages = $packages->take(5)->get();

        $labels = [];
        $data = [];
        $background_color = ['#00cfe8', '#ea5455', '#7367f0', '#28c76f', '#ff9f43'];

        foreach ($packages as $package) {
            $labels[] = $package['name'];
            $data[] = $package['income'];
        }

        return response()->json([
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'data' => $data,
                        'backgroundColor' => $background_color,
                        'borderWidth' => 0,
                    ],
                ],
            ],
            'font_color' => (auth()->guard('admin')->user()->theme == 'dark') ? '#d0d2d6' : 'black',
        ]);

    }

    /**
     * get best income tests chart
     *
     * @var @Request
     */
    public function get_best_income_tests(Request $request)
    {
        //format date
        $date = explode('-', $request['date']);
        $from = date('Y-m-d', strtotime($date[0]));
        $to = date('Y-m-d 23:59:59', strtotime($date[1]));

        $tests = GroupTest::selectRaw('test_id ,tests.name, sum(group_tests.price) as income')
            ->groupBy('test_id')
            ->leftJoin('tests', 'group_tests.test_id', 'tests.id')
            ->orderByRaw('income DESC')
            ->having('income', '>', 0);

        ($from == $to) ? $tests->whereDate('group_tests.created_at', $from) : $tests->whereBetween('group_tests.created_at', [$from, $to]);

        if (! empty($request['branch_id'])) {
            $tests->whereHas('group', function ($query) use ($request) {
                return $query->where('branch_id', $request['branch_id']);
            });
        }

        $tests = $tests->take(5)->get();

        $labels = [];
        $data = [];
        $background_color = ['#00cfe8', '#ea5455', '#7367f0', '#28c76f', '#ff9f43'];

        foreach ($tests as $test) {
            $labels[] = $test['name'];
            $data[] = $test['income'];
        }

        return response()->json([
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'data' => $data,
                        'backgroundColor' => $background_color,
                        'borderWidth' => 0,
                    ],
                ],
            ],
            'font_color' => (auth()->guard('admin')->user()->theme == 'dark') ? '#d0d2d6' : 'black',
        ]);

    }

    /**
     * get best income cultures chart
     *
     * @var @Request
     */
    public function get_best_income_cultures(Request $request)
    {
        //format date
        $date = explode('-', $request['date']);
        $from = date('Y-m-d', strtotime($date[0]));
        $to = date('Y-m-d 23:59:59', strtotime($date[1]));

        $cultures = GroupCulture::selectRaw('culture_id ,cultures.name, sum(group_cultures.price) as income')
            ->groupBy('culture_id')
            ->leftJoin('cultures', 'group_cultures.culture_id', 'cultures.id')
            ->orderByRaw('income DESC')
            ->having('income', '>', 0);

        ($from == $to) ? $cultures->whereDate('group_cultures.created_at', $from) : $cultures->whereBetween('group_cultures.created_at', [$from, $to]);

        if (! empty($request['branch_id'])) {
            $cultures->whereHas('group', function ($query) use ($request) {
                return $query->where('branch_id', $request['branch_id']);
            });
        }

        $cultures = $cultures->take(5)->get();

        $labels = [];
        $data = [];
        $background_color = ['#00cfe8', '#ea5455', '#7367f0', '#28c76f', '#ff9f43'];

        foreach ($cultures as $culture) {
            $labels[] = $culture['name'];
            $data[] = $culture['income'];
        }

        return response()->json([
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'data' => $data,
                        'backgroundColor' => $background_color,
                        'borderWidth' => 0,
                    ],
                ],
            ],
            'font_color' => (auth()->guard('admin')->user()->theme == 'dark') ? '#d0d2d6' : 'black',
        ]);
    }

    /**
     * Change admin theme
     */
    public function change_admin_theme()
    {
        $user = User::find(auth()->guard('admin')->user()->id);

        $theme = ($user['theme'] == 'dark') ? 'light' : 'dark';

        $user->update([
            'theme' => $theme,
        ]);

        return response()->json($theme);
    }

    /**
     * Change patient theme
     */
    public function change_patient_theme()
    {
        $patient = Patient::find(auth()->guard('patient')->user()->id);

        $theme = ($patient['theme'] == 'dark') ? 'light' : 'dark';

        $patient->update([
            'theme' => $theme,
        ]);

        return response()->json($theme);
    }

    /**
     * get timezones select2
     *
     * @var @Request
     */
    public function get_timezones_select2(Request $request)
    {
        if (isset($request->term)) {
            $timezones = Timezone::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $timezones = Timezone::take(20)->get();
        }

        return response()->json($timezones);
    }

    /**
     * get age from dob
     *
     * @var @Request
     */
    public function get_age($dob)
    {
        $date = new \DateTime($dob);
        $now = new \DateTime();
        $interval = $now->diff($date);

        // dd($interval);
        if ($interval->y == 0) {
            if ($interval->m == 0) {
                return response()->json(['age' => $interval->d, 'unit' => 'days']);
            } else {
                return response()->json(['age' => $interval->m, 'unit' => 'months']);
            }
        } else {
            return response()->json(['age' => $interval->y, 'unit' => 'years']);
        }
    }

    /**
     * get dob from age
     *
     * @var @Request
     */
    public function get_dob($age)
    {
        $dob = date('Y-m-d', strtotime('- '.$age));

        return response()->json($dob);
    }

    /**
     * get countries
     *
     * @var @Request
     */
    public function get_countries(Request $request)
    {
        if (isset($request->term)) {
            $countries = Country::where('nationality', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $countries = Country::take(20)->get();
        }

        return response()->json($countries);
    }

    /**
     * delete patient avatar by admin
     *
     * @var @Request
     */
    public function delete_patient_avatar($patient_id)
    {
        $patient = Patient::find($patient_id);

        $patient->update([
            'avatar' => null,
        ]);

        return response()->json('success');
    }

    /**
     * delete patient avatar by patient
     *
     * @var @Request
     */
    public function delete_patient_avatar_by_patient()
    {
        $patient = Patient::find(auth()->guard('patient')->user()->id);

        $patient->update([
            'avatar' => null,
        ]);

        return response()->json('success');
    }

    /**
     * delete user avatar by user
     *
     * @var @Request
     */
    public function delete_user_avatar_by_user()
    {
        $user = User::find(auth()->guard('admin')->user()->id);

        $user->update([
            'avatar' => null,
        ]);

        return response()->json('success');
    }

    /**
     * get users
     *
     * @var @Request
     */
    public function get_users(Request $request)
    {
        if (isset($request->term)) {
            $users = User::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $users = User::take(20)->get();
        }

        return response()->json($users);
    }

    public function get_instruments(Request $request)
    {
        if (isset($request->term)) {
            $instruments = Instrument::where('name', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $instruments = Instrument::take(20)->get();
        }

        return response()->json($instruments);
    }

    public function get_laboratories(Request $request)
    {
        if (isset($request->term)) {
            $laboratories = Laboratory::where('SampleNo', 'like', '%'.$request->term.'%')->take(20)->get();
        } else {
            $laboratories = Laboratory::take(20)->get();
        }

        return response()->json($laboratories);
    }

    /**
     * get invoice tests
     *
     * @var @Request
     */
    public function get_invoice_tests(Request $request)
    {
        if (isset($request->term)) {
            $tests = Test::where(function ($query) {
                return $query->where('parent_id', 0)->orWhere('separated', 1);
            })
                ->where('name', 'like', '%'.$request->term.'%')
                ->take(50)
                ->with('category')
                ->get();
        } else {
            $tests = Test::where(function ($query) {
                return $query->where('parent_id', 0)->orWhere('separated', 1);
            })
                ->take(50)
                ->with('category')
                ->get();
        }

        return response()->json($tests);
    }

    public function get_invoice_microbiology_tests(Request $request)
    {
        if (isset($request->term)) {
            $microbiology_tests = MicrobiologyTest::where(function ($query) {
                return $query->where('parent_id', 0)->orWhere('separated', 1);
            })
                        ->where('name', 'like', '%'.$request->term.'%')
                        ->take(50)
                        ->with('category')
                        ->get();
        } else {
            $microbiology_tests = MicrobiologyTest::where(function ($query) {
                return $query->where('parent_id', 0)->orWhere('separated', 1);
            })
                        ->take(50)
                        ->with('category')
                        ->get();
        }

        return response()->json($microbiology_tests);
    }

    /**
     * get invoice test
     *
     * @var @Request
     */
    public function get_invoice_test(Request $request)
    {
        $test = Test::with('test_price', 'category')->find($request['test_id']);
        if (! empty($request['contract_id'])) {
            $contract = ContractPrice::where([
                ['contract_id', $request['contract_id']],
                ['priceable_type', \App\Models\Test::class],
                ['priceable_id', $request['test_id']],
            ])->first();
            $test['current_price'] = $contract['price'];
        } else {
            $test['current_price'] = $test['test_price']['price'];
        }

        return response()->json($test);
    }


    public function get_invoice_microbiology_test(Request $request)
    {
        $microbiology_test = MicrobiologyTest::with('test_price', 'category')->find($request['test_id']);
        if (! empty($request['contract_id'])) {
            $contract = ContractPrice::where([
                ['contract_id', $request['contract_id']],
                ['priceable_type', \App\Models\MicrobiologyTest::class],
                ['priceable_id', $request['test_id']],
            ])->first();
            $microbiology_test['current_price'] = $contract['price'];
        } else {
            $microbiology_test['current_price'] = $microbiology_test['test_price']['price'];
        }

        return response()->json($microbiology_test);
    }

    /**
     * get invoice cultures
     *
     * @var @Request
     */
    public function get_invoice_cultures(Request $request)
    {
        if (isset($request->term)) {
            $cultures = Culture::where('name', 'like', '%'.$request->term.'%')
                ->take(50)
                ->with('category')
                ->get();
        } else {
            $cultures = Culture::take(50)
                ->with('category')
                ->get();
        }

        return response()->json($cultures);
    }

    public function get_invoice_services(Request $request)
    {
        if (isset($request->term)) {
            $services = Service::where('name', 'like', '%'.$request->term.'%')
                ->take(50)
                ->with('category')
                ->get();
        } else {
            $services = Service::take(50)
                ->with('category')
                ->get();
        }

        return response()->json($services);
    }

    /**
     * get invoice test
     *
     * @var @Request
     */
    public function get_invoice_culture(Request $request)
    {
        $culture = Culture::with('culture_price', 'category')->find($request['culture_id']);
        if (! empty($request['contract_id'])) {
            $contract = ContractPrice::where([
                ['contract_id', $request['contract_id']],
                ['priceable_type', \App\Models\Culture::class],
                ['priceable_id', $request['culture_id']],
            ])->first();
            $culture['current_price'] = $contract['price'];
        } else {
            $culture['current_price'] = $culture['culture_price']['price'];
        }

        return response()->json($culture);
    }

    public function get_invoice_service(Request $request)
    {
        $service = Service::with('service_price', 'category')->find($request['service_id']);
        if (! empty($request['contract_id'])) {
            $contract = ContractPrice::where([
                ['contract_id', $request['contract_id']],
                ['priceable_type', \App\Models\Service::class],
                ['priceable_id', $request['service_id']],
            ])->first();
            $service['current_price'] = $contract['price'];
        } else {
            $service['current_price'] = $service['service_price']['price'];
        }

        return response()->json($service);
    }

    // public function get_invoice_service(Request $request)
    // {
    //     $service=Service::with('service_price','category')->find($request['service_id']);
    //     if(!empty($request['contract_id']))
    //     {
    //         $contract=ContractPrice::where([
    //             ['contract_id',$request['contract_id']],
    //             ['priceable_type','App\Models\Service'],
    //             ['priceable_id',$request['service_id']]
    //         ])->first();
    //         if($service['service_price'] !== null) {
    //             $service['current_price']=$contract['price'];
    //         } else {
    //             $service['current_price']=$service['service_price']['price'];
    //         }
    //     }
    //     else{
    //         $service['current_price']=$service['service_price']['price'];
    //     }

    //     return response()->json($service);
    // }

    /**
     * get invoice packages
     *
     * @var @Request
     */
    public function get_invoice_packages(Request $request)
    {
        if (isset($request->term)) {
            $packages = Package::where('name', 'like', '%'.$request->term.'%')
                ->take(50)
                ->get();
        } else {
            $packages = Package::take(50)
                ->get();
        }

        return response()->json($packages);
    }

    /**
     * get invoice packages
     *
     * @var @Request
     */
    public function get_invoice_antibiotics(Request $request)
    {
        if (isset($request->term)) {
            $antibiotics = Antibiotic::where('name', 'like', '%'.$request->term.'%')
                ->take(50)
                ->get();
        } else {
            $antibiotics = Antibiotic::take(50)
                ->get();
        }

        return response()->json($antibiotics);
    }

    /**
     * get invoice test
     *
     * @var @Request
     */
    public function get_invoice_package(Request $request)
    {
        $package = Package::with('package_price', 'category')->find($request['package_id']);
        if (! empty($request['contract_id'])) {
            $contract = ContractPrice::where([
                ['contract_id', $request['contract_id']],
                ['priceable_type', \App\Models\Package::class],
                ['priceable_id', $request['package_id']],
            ])->first();
            $package['current_price'] = $contract['price'];
        } else {
            $package['current_price'] = $package['package_price']['price'];
        }

        return response()->json($package);
    }

    public function get_invoice_antibiotic(Request $request)
    {
        $antibiotic = Antibiotic::with('antibiotic_price', 'category')->find($request['antibiotic_id']);
        if (! empty($request['contract_id'])) {
            $contract = ContractPrice::where([
                ['contract_id', $request['contract_id']],
                ['priceable_type', \App\Models\Antibiotic::class],
                ['priceable_id', $request['antibiotic_id']],
            ])->first();
            $antibiotic['current_price'] = $contract['price'];
        } else {
            $antibiotic['current_price'] = $antibiotic['antibiotic_price']['price'];
        }

        return response()->json($antibiotic);
    }

    /**
     * get languages
     *
     * @var @Request
     */
    public function get_languages(Request $request)
    {
        if (isset($request->term)) {
            $languages = Language::where('iso', 'like', '%'.$request->term.'%')
                ->take(50)
                ->get();
        } else {
            $languages = Language::take(50)
                ->get();
        }

        return response()->json($languages);
    }
}
