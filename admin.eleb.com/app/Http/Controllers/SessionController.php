<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    //登录页面
    public function login()
    {
        return view('sessions/login');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
           'name'=>'required',
           'password'=>'required',
        ],[
            'name.required'=>'用户名不能为空',
            'password.required'=>'密码不能为空',
        ]);
        if(Auth::attempt([
            'name'=>$request->name,
            'password'=>$request->password,
        ],$request->rememberToken)){
            return redirect()->route('admins.index')->with('success','登录成功');
        }else{
            return back()->with('danger','用户名或密码错误');
        }
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('login')->with('success','注销成功');
    }
}
