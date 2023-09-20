<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionDetail extends Model
{
    use HasFactory;
    protected $table = 'product_option_detail';

    protected $guarded = [];


    /**
     * @desc add or edit product option
     */
    static public function operateProductOptionDetail($data, $product_option_id  = 0){
        self::where('product_option_id', $product_option_id)->delete();
        self::insert($data);
    }
}
