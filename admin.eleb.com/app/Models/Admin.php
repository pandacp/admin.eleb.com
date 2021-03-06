<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    //
    use Notifiable;
    use HasRoles;
    protected $fillable=['name','email','password','rememberToken'];
//    protected $guard_name = 'web';

    protected $hidden = [
        'password',
    ];
}
