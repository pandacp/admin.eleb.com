<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //使用中间件指定可以访问的页面
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['index']
        ]);
    }
    //重置密码
    public function form(Admin $admin)
    {
        return view('admins/reset',compact('admin'));
    }
    public function reset(Admin $admin,Request $request)
    {
        $this->validate($request,[
           'oldpassword'=>'required',
           'password'=>'required',
           'repassword'=>'required',
           'captcha'=>'required|captcha',
        ],[
            'oldpassword.required'=>'旧密码不能为空',
            'password.required'=>'新密码不能为空',
            'repassword.required'=>'确认密码不能为空',
            'captcha.required'=>'验证码未填写',
            'captcha.captcha'=>'验证码错误',
        ]);
        $admin->update([
            'password'=>bcrypt($request->password),
        ]);
        return redirect()->route('admins.index')->with('success','修改成功');
    }
    public function index()
    {
        if(!Auth::check()){
            return redirect()->route('login')->with('danger','请登录');
        }
        $admins = Admin::paginate(5);

        return view('admins/index',compact('admins'));
    }

    public function create()
    {
        //查询所有的角色
        $roles = Role::all();
        return view('admins/create',compact('roles'));
    }

    public function store(Request $request)
    {
        if($request->password!=$request->repassword){
            return back()->with('danger','密码不一致');
        };
        $this->validate($request,[
            'name'=>'required|unique:admins',
            'password'=>'required|min:6',
            'email'=>'required',
            'role'=>'required',
        ],[
            'name.required'=>'用户名不能为空',
            'name.unique'=>'用户名已存在',
            'password.required'=>'密码不能为空',
            'password.min'=>'密码不能小于6位',
            'email.required'=>'邮箱不能为空',
            'role.required'=>'角色不能为空',
        ]);
        $rememberToken = 0;
        Admin::create([
            'name'=>$request->name,
            'password'=>bcrypt($request->password),
            'email'=>$request->email,
            'rememberToken'=>$rememberToken,
        ]);
        $admin = Admin::where('name',$request->name)->first();//1.找到新添加的用户
        $admin->assignRole($request->role);//2.给用户添加角色
        return redirect()->route('admins.index')->with('success','添加成功');

    }
    //修改
    public function edit(Admin $admin)
    {
        //查询所有的角色
        $roles = Role::all();
        return view('admins/edit',compact('admin','roles'));
    }

    public function update(Admin $admin,Request $request)
    {

        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
        ],[
            'name.required'=>'用户名不能为空',
            'email.required'=>'邮箱不能为空',
        ]);
        $admin->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        //移除所有角色,再添加
        $admin = Admin::where('name',$request->name)->first();
        $admin->syncRoles($request->role);
        return redirect()->route('admins.index')->with('success','修改成功');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with('success','删除成功');
    }

}
