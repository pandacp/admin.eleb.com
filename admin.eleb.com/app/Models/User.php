<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    //
    protected $fillable=['name','email','password','status','shop_id','rememberToken'];
    public function shop(){
        return $this->hasOne(Shop::class,'id','shop_id');
    }
}
