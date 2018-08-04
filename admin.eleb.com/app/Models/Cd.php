<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cd extends Model
{
    //
    protected $fillable=['name','url','permission_id','pid'];
    //自身与自身是一对多的关系
    public function children(){
        return $this->hasMany(self::class,'pid','id');
    }
    //菜单和权限是一对多(反向)的关系
    public function permission()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Permission::class);
    }
    public static function getChildHtml()
    {
        $html='';
        foreach(self::where('pid',1)->where('id','<>',1)->get() as $nav){
            $childHtml = '';
            foreach($nav->children as $v){
                if(auth()->user()->can($v->permission->name)){
                    $childHtml.='<li><a href="'.route($v->url).'">'.$v->name.'</a></li>';
                }
            }
            if(empty($childHtml)) continue;
            $html.= '<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><button class="btn btn-primary">'.$nav->name.'</button><span class="caret"></span></a>
                        <ul class="dropdown-menu">';

            $html.=$childHtml;
            $html.='</ul>
                    </li>';
        }

        return $html;
    }

}
