<?php

namespace App\Http\Controllers;

//use App\Models\Permission;
//use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    public function index()
    {
//        $roles = Role::paginate();

        $roles = Role::paginate();
        return view('roles/index',compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();//所有的权限
        return view('roles/create',compact('permissions'));
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required|unique:roles',
        ],[
            'name.required'=>'角色名不能为空',
            'name.unique'=>'角色名不能重复',
        ]);
        $role = \Spatie\Permission\Models\Role::create(['name'=>$request->name]);
        $role->givePermissionTo($request->permission);
        return redirect()->route('roles.index')->with('success',"给{$request->name}添加权限成功");

    }
    public function edit(Role $role)
    {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('roles/edit',compact('permissions','role'));
    }

    public function update(Request $request)
    {
        $request->name;
        $request->permission;
        $this->validate($request,[
            'name'=>'required',
        ],[
            'name.required'=>'角色名不能为空',
        ]);
        $role = \Spatie\Permission\Models\Role::findByName($request->name);

//select name FROM role_has_permissions as r join permissions as p on r.permission_id=p.id where role_id=3;
        $pers = DB::table('role_has_permissions')->join('permissions','role_has_permissions.permission_id','=','permissions.id')->select('name')->where('role_id',$role->id)->get();

//        var_dump($pers);die;
        foreach($pers as $per){
            $role->revokePermissionTo($per->name);//移除已存在的
        }

        $role->givePermissionTo($request->permission);//给角色添加新的权限

        return redirect()->route('roles.index')->with('success',"给{$request->name}修改权限成功");
    }
    //删除
    public function destroy(Role $role)
    {
        //根据对象名字,找到角色,删除
        $role = \Spatie\Permission\Models\Role::findByName($role->name);
        $role->delete();
    }
}
