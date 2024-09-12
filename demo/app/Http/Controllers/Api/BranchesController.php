<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;

class BranchesController extends Controller
{
    public function index()
    {
        $branches = Branch::all();

        return Response::response(200, 'success', [
            'branches' => $branches,
        ]);
    }
}
