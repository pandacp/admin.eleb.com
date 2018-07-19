<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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
//        var_dump($admin);die;
        $password = bcrypt($request->password);
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
            'password'=>$password,
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
        return view('admins/create');
    }

    public function store(Request $request)
    {
        if($request->password!=$request->repassword){
            return back()->with('danger','密码不一致');
        };
        $this->validate($request,[
            'name'=>'required',
            'password'=>'required|min:6',
            'email'=>'required',
        ],[
            'name.required'=>'用户名不能为空',
            'password.required'=>'密码不能为空',
            'password.min'=>'密码不能小于6位',
            'email.required'=>'邮箱不能为空',
        ]);

        $rememberToken = 0;
        Admin::create([
            'name'=>$request->name,
            'password'=>bcrypt($request->password),
            'email'=>$request->email,
            'rememberToken'=>$rememberToken,
        ]);
        return redirect()->route('admins.index')->with('success','添加成功');

    }
    //修改
    public function edit(Admin $admin)
    {
        return view('admins/edit',compact('admin'));
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

        return redirect()->route('admins.index')->with('success','修改成功');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with('success','删除成功');
    }

}
