<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event_member extends Model
{
    //
    protected $fillable=['events_id','member_id'];

    public function user()
    {
        return $this->hasOne(User::class,'id','member_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class,'events_id','id');
    }
}
