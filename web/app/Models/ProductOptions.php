<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptions extends Model
{
    use HasFactory;
    protected $table = 'product_options';

    protected $guarded = [];

    const OPTION_TYPE_1 = 'Switch Text';
    const OPTION_TYPE_2 = 'Switch Color';
    const OPTION_TYPE_3 = 'Switch Image';

    /**
     * @desc add or edit product option
     */
    static public function operateProductOption($data, $id  = 0){
        if ($id){
            $info = self::find($id);
            unset($data['id']);
            $info->update($data);
        }else{
            $info = new self();
            $info->fill($data);
            $info->save();
        }
        return $info->id;
    }
}
