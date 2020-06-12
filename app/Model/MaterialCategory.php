<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    public function materials()
    {
        return $this->hasMany('App\Model\Material');
    }
}
