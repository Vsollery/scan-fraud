<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    //
    protected $guarded = [];

    public function customer(){
        return $this->belongsToMany(Customer::class, 'customer_scan')->withPivot('is_fraudulent');
    }
}
