<?php

declare(strict_types=1);

namespace App\Lib;

use App\Models\ProductOptionDetail;
use App\Models\ProductOptions;
use Shopify\Auth\Session;
use Shopify\Clients\Graphql;

class OptionDetail
{
    
    public static function call(Session $session, $option_id)
    {
        $option = ProductOptions::find($option_id)->toArray();
        $optionDetails = ProductOptionDetail::where('product_option_id', $option_id)
                                            ->where('deleted', 0)
                                            ->get()
                                            ->toArray();
        $option['details'] = $optionDetails;
        return $option;
    }
}
