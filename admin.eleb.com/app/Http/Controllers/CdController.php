<?php

namespace App\Http\Controllers;

use App\Models\Cd;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class CdController extends Controller
{
    //菜单管理
    public function index()
    {
        //查询所有的菜单
        $cds =  Cd::paginate(10);
        return view('cds/index',compact('cds'));
    }

    public function create()
    {
        //所有的权限
        $permissions = Permission::all();
        //所有顶级菜单
        $pids = Cd::where('pid',1)->get();
        return view('cds/create',compact('permissions','pids'));
    }

    public function store(Request $request)
    {
        //判断

        Cd::create([
            'name'=>$request->name,
            'url'=>$request->url,
            'permission_id'=>$request->permission_id,
            'pid'=>$request->pid,
        ]);
        return redirect()->route('cds.index')->with('success','添加成功');
    }

    public function edit(Cd $cd)
    {
        //所有的权限
        $permissions = Permission::all();
        //所有顶级菜单
        $pids = Cd::where('pid',1)->get();
        return view('cds/edit',compact('permissions','pids','cd'));
    }

    public function update(Request $request,Cd $cd)
    {
        //判断

        $cd->update([
            'name'=>$request->name,
            'url'=>$request->url,
            'permission_id'=>$request->permission_id,
            'pid'=>$request->pid,
        ]);
        return redirect()->route('cds.index')->with('success','修改成功');
    }

    public function destroy(Cd $cd)
    {
        //判断,当前菜单下有子菜单,不能删除
        $rs = Cd::where('pid',$cd->id)->get();
        if(!empty($rs)){
            return back()->with('danger','当前菜单下有子菜单,不能删除');
        }
        $cd->delete();
        return redirect()->route('cds.index')->with('success','删除成功');
    }
}
