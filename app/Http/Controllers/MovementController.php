<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movement;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MovementFalabellaImport;

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

    public function importFalabella(Request $request)
    {

        $data = $request->all();
        $import = new MovementFalabellaImport($data['process_date']);
        Excel::import($import, $request->file('file'));
    
        return response()->json([
            'status' => 'success'
        ]);
    }

}

