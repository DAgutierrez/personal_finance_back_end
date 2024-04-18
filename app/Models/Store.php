<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'movement_category_id'
    ];

    public function movementCategory()
    {
        return $this->belongsTo('App\Models\MovementCategory', 'movement_category_id');
    }

    public static function create($data)
    {

        foreach($data as $store) {

            $store = collect($store);
            $keys =  $store->keys();

            $descriptionKey =  $keys[2];

            $storeName = $store[$descriptionKey];

            $storeFinded = Store::where('name', $storeName )->first();

            if(!isset($storeFinded)) {
    
                $newStore = new Store();
                $newStore->name =  $storeName;
                $newStore->created_at =  Carbon::now();
                $newStore->movement_category_id =  1;
                $newStore->save();
            } 

        }
     
       


        return response()->json([
            'status' => 'success'
        ]);
    }

    public static function groupByType()
    {

       $category=[];

       $obj1 = 
        [
        'category_id'=> 7,
        'movement_category'=> [
            'id' => 7,
            'name' => 'shopping',
            'created_at'=> '2023-08-26T23:51:51.000000Z',
            'update_at'=> null,
            'deleted_at'=> null,
            'movement_type_id'=> 2
        ],
        'movement_name'=> 'shopping',
        'total'=> 362960

    ];



    $obj2=
    [    
        'category_id' => 8,
        'movement_category'=> [
            'id' => 8,
            'name' => 'advance_money',
            'created_at'=> '2023-08-27T00:06:48.000000Z',
            'update_at'=> null,
            'deleted_at'=> null,
            'movement_type_id'=> 2
        ],
        'movement_name'=> 'shopping',
        'total'=> 35727  
    ];

       array_push($category, $obj1,$obj2 );
    
    

   
        return response()->json([
            'status' => 'success',
            'response' => $category
        ]);
    }



    
    public static function test()
    {

       $variableNull = null;

       $variableInt = 1;
       
       $variableString = 'string';

    
       $variableObject = [
        'id' => 1,
        'name' => 'Negocio',
        'user' => [
            'id' => 1,
            'name' => 'Diego',
        ],
        'array' => [1,2,3,4,5]
       ];

       $name = $variableObject['name'];



       $variableArray = [1,2,3,4,5,6,7,8];

       
       foreach($variableArray as $array) 
       {
          
       }


        return response()->json([
            'status' => 'success'
        ]);
    }

    public static function createFromBancoEstado($data)
    {
       $keys = null;
        foreach($data as $store) {


            $store = collect($store);
            $keys =  $store->keys();

            $descriptionKey =  $keys[3];

            $storeName = $store[$descriptionKey];

            $storeFinded = Store::where('name', $storeName )->first();

            if(!isset($storeFinded)) {
    
                $newStore = new Store();
                $newStore->name =  $storeName;
                $newStore->created_at =  Carbon::now();
                $newStore->movement_category_id =  1;
                $newStore->save();
            } 

        }
     
       


        return response()->json([
            'status' => 'success',
            'storeFinded' => $keys
        ]);
    }

    
}
