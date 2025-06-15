<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;

    public function customers(){
        return $this->belongsToMany(Customer::class, 'customer_scan', 'scan_id', 'customer_id')->withPivot('is_fraudulent');
    }

    public function getRouteKeyName()
    {
//        if (request()->is('api/*')) {
//            return 'id'; // Use 'id' for API routes
//        }
        return 'scan_date';
    }

    public function fraudulentCustomers()
    {
        return $this->customers()->wherePivot('is_fraudulent', 1);
    }


}
