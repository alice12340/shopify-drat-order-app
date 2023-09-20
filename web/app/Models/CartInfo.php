<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartInfo extends Model
{
    use HasFactory;
    protected $table = 'cart_infos';

    protected $guarded = [];

    public static function add($data){
        $info = self::where('cart_id', $data['token'])->first();
        $saveData = [
            'cart_id' => $data['token'],
            'cart_info' => json_encode($data),
        ];
        if ($info){
            $info->update($saveData);
        }else{
            $info = new self();
            $info->fill($saveData);
            $info->save();
        }
        return $info ? $info->id : false;
    }

   
}
