<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_id',
        'firstName',
        'lastName',
        'phoneNumber',
        'dob',
        'ipAddress',
        'iban',
    ];
     protected $primaryKey = 'customer_id';

     public function scans()
     {
        return $this->belongsToMany(Scan::class, 'customer_scan')->withPivot('is_fraudulent');
     }
}
