<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop_category extends Model
{
    //
    protected $fillable=['name','img','status'];


//    public function shops()
//    {
//        return $this->hasOne(Shop::class,'shop_category_id','id');
//    }
}
