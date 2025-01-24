<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Log;

use App\Models\Store;
use App\Models\Movement;
use \Carbon\Carbon;

class MovementFalabellaImport implements ToCollection, WithHeadingRow
{

    public function __construct($processDate)
    {
        $this->processDate = $processDate;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {   
        \Log::info($rows);
        Movement::where('process_date', $this->processDate)->where('payment_method_id', 1)->delete();
        foreach($rows as $row) {
       
         
            if(isset($row['descripcion'])) {

                $store = Store::where('name',$row['descripcion'] )->first();

                if(!isset($store)) {
                    $newStore = [
                        'name' => $row['descripcion'],
                        'movement_category_id' => 13
                    ];
                    $store = Store::updateOrCreate($newStore);
                }

                

                $unixDT = ($row['fecha'] - 25569) * 86400;
                $gmtDate = gmdate("d-m-Y H:i:s", $unixDT);
                $date = new Carbon($gmtDate);
                $dateString = $date->format('Y-m-d');

            

                $category_id = $store->movement_category_id;

                $isNegative = str_contains($row['valor_cuota'], '-');

                if($isNegative == false) {
                    $newMovement = [
                        'date' => $date,
                        'description' => $row['descripcion'],
                        'amount' => $row['valor_cuota'],
                        'movement_category_id' => $category_id,
                        'payment_method_id' => 1,
                        'process_date' => $this->processDate
                    ];
                    $movementCreated = Movement::updateOrCreate($newMovement);
                }

            }
            
        }
    }

  
}
