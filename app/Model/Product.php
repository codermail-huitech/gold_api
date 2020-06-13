<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['model_number','product_name','product_category_id','price_code_id'];
    /**
     * @var mixed
     */
    private $model_number;

    public function category()
    {
        return $this->belongsTo('App\Model\ProductCategory','product_category_id');
    }
    public function priceCode()
    {
        return $this->belongsTo('App\Model\PriceCode','price_code_id');
    }
}
