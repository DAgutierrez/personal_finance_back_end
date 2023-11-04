<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;

class StoreController extends Controller
{
    public function create(Request $request)
    {
        return Store::create($request->all());
    }

    public function groupByType(Request $request)
    {
        return Store::groupByType($request->all());
    }

    public function createFromBancoEstado(Request $request)
    {
        return Store::createFromBancoEstado($request->all());
    }
}

