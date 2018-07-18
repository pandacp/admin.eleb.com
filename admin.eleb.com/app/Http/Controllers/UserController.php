<?php

namespace App\Http\Controllers;

use App\Models\Shop_category;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
//    public function show()
//    {
//        return 1;
//    }
    public function index()
    {
        $users = User::paginate(5);
        return view('users/index',compact('users'));
    }
    public function create(){
        $shop_categories = Shop_category::all();
        return view('users/create',compact('shop_categories'));
    }
    public function store(Request $request){
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
        $shop_categories = Shop_category::all();
        return view('users/edit',compact('user','shop_categories'));
    }

    public function update(User $user,Request $request){

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

        $data = [
            'name'=>$request->name,
            'password'=>$request->name,
        ];

        $user->update($data);



    }

    public function destroy(User $user)
    {
        return 1;
        $user->delete();
        return redirect()->route('users.index')->with('success','删除成功');
    }


}
