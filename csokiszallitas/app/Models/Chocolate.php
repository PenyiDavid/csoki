<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chocolate extends Model
{
    protected $fillable = [
        'brand',
        'chocolate_name',
        'price',
        'expiry_date',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
