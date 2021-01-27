<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BillMaster extends Model
{
    //
    /**
     * @var mixed
     */

    public function getCustomer(){
        return $this->belongsTo('App\User','customer_id');

    }

    public function getBills(){
        return $this->hasMany('App\Model\BillDetail','bill_master_id');
    }

}
