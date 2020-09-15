<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    //
    /**
     * @var mixed
     */
    private $order_master_id;
    protected $guarded = ['id'];
    /**
     * @var mixed
     */
    private $price;
    /**
     * @var mixed
     */
    private $p_loss;
    /**
     * @var mixed
     */
    private $approx_gold;
    /**
     * @var mixed
     */
    private $quantity;
    /**
     * @var mixed
     */
    private $material_id;
    /**
     * @var mixed
     */
    private $size;
    /**
     * @var mixed
     */
    private $product_id;
    /**
     * @var int|mixed
     */
    private $status_id;
}
