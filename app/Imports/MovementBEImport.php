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

class MovementBEImport implements ToCollection, WithHeadingRow
{

    public function __construct($processDate, $cuenta)
    {
        $this->processDate = $processDate;
        $this->cuenta = $cuenta;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {   
        \Log::info($rows);

        $paymentMethodId = 3;
        if($this->cuenta == 'cuenta-rut') {
            $paymentMethodId = 2;
        }

        Movement::where('process_date', $this->processDate)->where('payment_method_id', $paymentMethodId)->delete();
        foreach($rows as $row) {
       
         
            if(isset($row['descripcion'])) {

                $description = $row['descripcion'];

                $store = Store::where('name',$description )->first();

                if(!isset($store)) {
                    $newStore = [
                        'name' => $description,
                        'movement_category_id' => 13
                    ];
                    $store = Store::updateOrCreate($newStore);
                }

                

                $unixDT = ($row['fecha'] - 25569) * 86400;
                $gmtDate = gmdate("d-m-Y H:i:s", $unixDT);
                $date = new Carbon($gmtDate);
                $dateString = $date->format('Y-m-d');

            

                $category_id = $store->movement_category_id;

                // $isNegative = str_contains($row['valor_cuota'], '-');
               

                if(isset($row['cargos'])) {
                    $newMovement = [
                        'date' => $date,
                        'description' => $row['descripcion'],
                        'amount' => $row['cargos'],
                        'movement_category_id' => $category_id,
                        'payment_method_id' => $paymentMethodId,
                        'process_date' => $this->processDate
                    ];
                    $movementCreated = Movement::updateOrCreate($newMovement);
                }

            }
            
        }
    }

  
}
