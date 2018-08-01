<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    //角色列表
    public function index()
    {
        $permissions = Permission::paginate();
        return view('permissions/index',compact('permissions'));
    }

    public function create()
    {
        return view('permissions/create');
    }
    //添加
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:permissions',
        ],[
            'name.required'=>'权限名不能为空',
            'name.unique'=>'权限名不能重复',
        ]);
        \Spatie\Permission\Models\Permission::create(['name'=>$request->name]);
        return redirect()->route('permissions.index')->with('success','添加权限成功');
    }

    public function edit(Permission $permission)
    {
//        var_dump($permission);die;
        return view('permissions/edit',compact('permission'));
    }
    //修改
    public function update(Permission $permission,Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
        ],[
            'name.required'=>'权限名不能为空',
        ]);
        $per = \Spatie\Permission\Models\Permission::findByName($permission->name);
        $per->update([
            'name'=>$request->name,
        ]);
        return redirect()->route('permissions.index')->with('success','修改权限名权限成功');
    }
    //删除
    public function destroy(Permission $permission)
    {
        $permission = \Spatie\Permission\Models\Permission::findByName($permission->name);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success','删除权限成功');
    }

}
