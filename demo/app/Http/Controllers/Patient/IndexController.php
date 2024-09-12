<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Group;

class IndexController extends Controller
{
    /**
     * patinet dashboard view
     */
    public function index()
    {
        $group_tests_count = Group::where('patient_id', auth()->guard('patient')->user()['id'])->count();
        $pending_tests_count = Group::where('patient_id', auth()->guard('patient')->user()['id'])->where('done', false)->count();
        $done_tests_count = Group::where('patient_id', auth()->guard('patient')->user()['id'])->where('done', true)->count();

        return view('patient.index', compact('group_tests_count', 'pending_tests_count', 'done_tests_count'));
    }
}
