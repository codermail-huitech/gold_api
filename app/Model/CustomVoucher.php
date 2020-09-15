<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CustomVoucher extends Model
{
    //
    /**
     * @var mixed|string
     */
    private $voucher_name;
    /**
     * @var mixed|string
     */
    private $accounting_year;
    /**
     * @var int|mixed
     */
    private $last_counter;
    /**
     * @var mixed|string
     */
    private $delimiter;
    /**
     * @var mixed|string
     */
    private $prefix;
}
