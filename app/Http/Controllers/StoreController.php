<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\StoresImport;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function create(Request $request)
    {
        return Store::create($request->all());
    }

    public function import(Request $request)
    {

        \Log::info('import');
        $import = new StoresImport();
        Excel::import($import, $request->file('file'));
    
        return response()->json([
            'status' => 'success'
        ]);
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

