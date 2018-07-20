<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Shop_category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['index']
        ]);
    }
    public function index()
    {
        if(Auth::check()){
            $users = User::paginate(5);
            return view('users/index',compact('users'));
        }
        return redirect()->route('login')->with('danger','请登录');
    }
    public function create(){
        $shops = Shop::all();
        return view('users/create',compact('shops'));
    }
    public function store(Request $request){
        DB::beginTransaction();
        $this->validate($request,[
            'name'=>'required|max:10',
            'password'=>'required',
            'email'=>'required',
        ],[
            'name.required'=>'用户名不能为空',
            'name.max'=>'用户名不能超过10位',
            'password.required'=>'密码不能为空',
            'email.required'=>'邮箱不能为空',
        ]);

        $rememberToken = 0;
        User::create([
            'name'=>$request->name,
            'password'=>bcrypt($request->password),
            'email'=>$request->email,
            'status'=>$request->status,
            'shop_id'=>$request->shop_id,
            'rememberToken'=>$rememberToken,
        ]);
        return redirect()->route('users.index')->with('success','添加成功');
    }

    public function edit(User $user)
    {
        $shops = Shop::all();
        return view('users/edit',compact('user','shops'));
    }

    public function update(User $user,Request $request){
//        var_dump($request->shop_id);die;

        $this->validate($request,[
            'name'=>'required|max:10',
            'email'=>'required',
        ],[
            'name.required'=>'用户名不能为空',
            'name.max'=>'用户名不能超过10位',
            'email.required'=>'邮箱不能为空',
        ]);
        $data = [
            'name'=>$request->name,
            'email'=>$request->email,
            'shop_id'=>$request->shop_id,
            'status'=>$request->status,
        ];
        $user->update($data);
		return redirect()->route('users.index')->with('success','修改成功');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','删除成功');
    }
    //重置密码
    public function form(User $user)
    {
        return view('users/reset',compact('user'));
    }
    public function reset(User $user,Request $request)
    {
        if($request->password!=$request->repassword){
            return back()->with('danger','密码不一致');
        }
        $this->validate($request,[
            'password'=>'required',
            'repassword'=>'required',
            'captcha'=>'required|captcha',
        ],[
            'password.required'=>'密码不能为空',
            'repassword.required'=>'确认密码不能为空',
            'captcha.required'=>'验证码不能为空',
            'captcha.captcha'=>'验证码错误',
        ]);
        $user->update([
            'password'=>bcrypt($request->password)
        ]);
        return redirect()->route('users.index')->with('重置密码','删除成功');
    }
}
