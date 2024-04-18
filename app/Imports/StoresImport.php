<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Log;

use App\Models\Store;

class StoresImport implements ToCollection, WithHeadingRow,ShouldQueue, WithChunkReading
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {   
        \Log::info($rows);
        foreach($rows as $row) {
       
         
            if(isset($row['descripcion'])) {
                $newStore = [
                    'name' => $row['descripcion'],
                    'movement_category_id' => 1
                ];
                $storeCreated = Store::updateOrCreate($newStore);
            }
            
        }
    }

    public function chunkSize(): int
    {
        return 500;
    }
}
