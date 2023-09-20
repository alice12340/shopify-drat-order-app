<?php

declare(strict_types=1);

namespace App\Lib;

use App\Exceptions\ShopifyProductCreatorException;
use App\Models\ProductOptionDetail;
use App\Models\ProductOptions;
use Illuminate\Http\Request;
use Shopify\Auth\Session;
use Shopify\Clients\Graphql;
use Shopify\Rest\Admin2022_04\Product;

class OptionCreator
{
    
    public static function call(Request $request)
    {
        $data = $request->post();
        $product_option = [
            'title'         => $data['title'],
            'instruction'   => $data['instruction'],
            'option_type'   => $data['option_type']
        ];

        // add or edit product option
        $product_option_id = ProductOptions::operateProductOption($product_option);
        $product_option_detail_arr = array();
        foreach ($data['option_items'] as $option) {    
           
            $product_option_detail = [
                'product_option_id' => $product_option_id,
                'product_option_value' =>$option['product_option_value'],
                'product_option_description' => $option['product_option_description'],
                'product_option_price' => $option['product_option_price'],
            ];
            array_push($product_option_detail_arr, $product_option_detail);
        }
        //add product option detail 
        ProductOptionDetail::operateProductOptionDetail($product_option_detail_arr, $product_option_id);
        
    }
}
