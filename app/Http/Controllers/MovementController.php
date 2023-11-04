<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movement;

class MovementController extends Controller
{
    public function create(Request $request)
    {
        return Movement::create($request->all());
    }

    public function groupByCategory(Request $request)
    {
        return Movement::groupByCategory($request->all());
    }

}

