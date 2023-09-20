<?php

declare(strict_types=1);

namespace App\Lib;

use App\Models\ProductOptions;
use Shopify\Auth\Session;
use Shopify\Clients\Graphql;

class OptionList
{
    
    public static function call(Session $session)
    {
        $type = [
            1   => ProductOptions::OPTION_TYPE_1,
            2   => ProductOptions::OPTION_TYPE_2,
            2   => ProductOptions::OPTION_TYPE_3,
        ];
        $re = ProductOptions::where('deleted', 0)->get()->toArray();
        foreach($re as &$v){
            $v['option_type_desc'] = $type[$v['option_type']];
        }
        return $re;
       
    }
}
