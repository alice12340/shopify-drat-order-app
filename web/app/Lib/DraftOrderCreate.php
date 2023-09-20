<?php

declare(strict_types=1);

namespace App\Lib;

use App\Models\Session as ModelsSession;
use Illuminate\Http\Request;
use Shopify\Auth\Session;
use Shopify\Clients\Graphql;

class DraftOrderCreate
{


    private const CREATE_DRAFT_ORDER = <<<'QUERY'
        mutation draftOrderCreate($input: DraftOrderInput!) {
            draftOrderCreate(input: $input) {
                draftOrder{
                    id
                    totalPrice
                    invoiceUrl
                }
            }
        }
    QUERY;
  

    public static function call(Request $request)
    {
        $session = ModelsSession::first();
        $client = new Graphql($session->shop, $session->access_token);
        $data = $request->post();
        
        $cart_items = $data['items'];
        $line_items = [];
        foreach ($cart_items as $cart_item){
            $line_item = [
                'variantId' => "gid://shopify/ProductVariant/".$cart_item['variant_id'],
                'quantity'  => $cart_item['quantity'],
            ];
            array_push($line_items, $line_item);
            if (isset($cart_item['properties']['Total Custom Price'])){
                $totol_custom_price = $cart_item['properties']['Total Custom Price'];
                unset($cart_item['properties']['Total Custom Price']);
                if ($totol_custom_price > 0){
                    $customAttributes = [];
                    foreach($cart_item['properties'] as $k => $val){
                        $customAttribute = [
                            'key' => $k,
                            'value' => $val,
                        ];
                        array_push($customAttributes, $customAttribute);
                    }
                    $custom_line_item = [
                        "title" => "Customization Cost",
                        "originalUnitPrice" => $totol_custom_price,
                        "quantity"  => $cart_item['quantity'],
                        "taxable"   => true,
                        "customAttributes"  => $customAttributes,

                    ];
                    array_push($line_items, $custom_line_item);
                }
            }
        }

        $response = $client->query(
            [
                "query" => self::CREATE_DRAFT_ORDER,
                "variables" => [
                    "input" => [
                        "lineItems" => $line_items,
                    ]
                ]
            ],
        )->getDecodedBody();
        return $response['data']['draftOrderCreate']['draftOrder']['invoiceUrl'];

    }

}