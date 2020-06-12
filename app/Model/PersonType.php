<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PersonType extends Model
{
    public function people()
    {
        return $this->hasMany('App\User','person_type_id');
    }
}
