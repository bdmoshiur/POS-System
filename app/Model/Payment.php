<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
