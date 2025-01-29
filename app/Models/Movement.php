<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MovementCategory;
use App\Models\Store;

use Carbon\Carbon;



class Movement extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'date',
        'amount',
        'movement_category_id',
        'payment_method_id',
        'process_date'
    ];

    public static function create($data)
    {
        // $movements = Movement::all();
        // $movementCategories= MovementCategory::all();
        $stores = Store::with(['movementCategory' =>  function ($query) {
            $query->with(['movementType']);
        }])->get();



        $date = Carbon::createFromFormat('d-m-Y', $data['date']);

        $movement = [
            'date' => $date,
            'description' => $data['description'],
            'process_date' => $data['process_date'],
            'payment_method_id' => $data['payment_method_id'],
            'amount' => $data['amount'],
            'movem'
        ];


        foreach($data as $movement) {

            $movement = collect($movement);
            $keys =  $movement->keys();

           // $descriptionKey =  $keys[2];
          //  $amountKey =  $keys[5];

          $descriptionKey =  $keys[3];
           $amountKey =  $keys[7];

            $description = $movement[$descriptionKey];
            $amount  = $movement[$amountKey];

            $store = $stores->firstWhere('name', $description);
            if(isset($store)) {
              $amountVal = str_replace("$", "", $amount);
              $amountVal = str_replace(".", "", $amountVal);
              $amountVal = intval($amountVal);


              $newMovement = new Movement();
              $newMovement->description = $description;
              $newMovement->amount = $amountVal;
              $newMovement->date = Carbon::now();
              $newMovement->movement_category_id = $store['movement_category_id'];
              $newMovement->movements_type_id = $store['movementCategory']['movement_type_id'];
              $newMovement->save();
            }
        }

        return response()->json([
            'status' => $description,
            'stores' => $stores
        ]);
    }

    public static function groupByCategory($data)
    {
        $movements = collect();
        if($data['all'] == true) {
            $movements = Movement::where('process_date', $data['process_date'])->get()->groupBy('movement_category_id');
        } else {
            $movements = Movement::where('process_date', $data['process_date'])->where('payment_method_id', $data['payment_method_id'])->get()->groupBy('movement_category_id');
        }
        

        $keys =  $movements->keys();

        $response = collect();

        $total =  0;
        
        foreach($keys as $key) {

            $movementCategory = MovementCategory::find($key);

            $categoryResponse = [
                'category_id' => $key,
                'category_name' => $movementCategory['name']
            ];
            

            $movementsByCategory = $movements[$key];

            $amountTotal = 0;

            foreach($movementsByCategory as $movementByCategory){
                $amountTotal += $movementByCategory['amount'];
            }

            $categoryResponse['total'] = $amountTotal;

            $total += $amountTotal;

 

            $response->push($categoryResponse);



        }

        $transferencias  = $response->first(function ($value) {
            return $value['category_name'] == 'Transferencias';
        });



        return response()->json([
            'response' => $response,
            'total_bruto' => $total,
            'total_neto' => $total - $transferencias['total']
        ]);
    }
    

    

}
