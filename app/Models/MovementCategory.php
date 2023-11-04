<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementCategory extends Model
{
    use HasFactory;

    public function movementType()
    {
        return $this->belongsTo('App\Models\MovementType', 'movement_type_id');
    }
}
