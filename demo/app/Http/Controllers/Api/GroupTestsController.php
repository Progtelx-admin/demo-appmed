<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupTestsController extends Controller
{
    public function group_tests(Request $request)
    {
        $groups = Group::where('patient_id', $request->user()->id)->select('id', 'total', 'discount', 'paid', 'due', 'created_at', 'done', 'report_pdf', 'receipt_pdf')->get();

        return Response::response(200, 'success', ['groups' => $groups]);
    }
}
