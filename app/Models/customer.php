<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\order;


class customer extends Model
{


    public $fillable = [
        "name",
        "date",
        "phone",
    ];
    public function item()
    {
        return $this->hasMany(order::class, 'c_id', 'id');
    }
}
