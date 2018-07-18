<?php

namespace App\Http\Controllers;

use App\Models\Shop_category;
use Illuminate\Http\Request;

class Shop_categoryController extends Controller
{
    //
    public function index()
    {
        $shop_categories = Shop_category::paginate(5);
        return view('shop_categories/list',compact('shop_categories'));
    }

    public function create()
    {
        return view('shop_categories/create');
    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required|max:10',
            'img'=>'required',
        ],[
            'name.required'=>'分类名不能为空',
            'name.max'=>'分类名不能超过10个字',
            'img.required'=>'图片不能为空',
        ]);

        $file=$request->img;
        $filename = $file->store('public/img');
        Shop_category::create([
            'name'=>$request->name,
            'status'=>$request->status,
            'img'=>$filename,
        ]);
        session()->flash('success','添加成功');
        return redirect()->route('shop_categories.index');
    }
    //修改
    public function edit(Shop_category $shop_category)
    {
        return view('shop_categories/edit',compact('shop_category'));
    }

    public function update(Shop_category $shop_category,Request $request)
    {
        $this->validate($request,[
            'name'=>'required|max:10',
        ],[
            'name.required'=>'分类名不能为空',
            'name.max'=>'分类名不能超过10个字',
        ]);
        $file = $request->img;
        $data = [
            'name'=>$request->name,
            'status'=>$request->status,
            ];
        if($file){
            $filename = $file->store('public/img');
            $data['img']=$filename;
        }
        $shop_category->update($data);
        session()->flash('success','修改成功');
        return redirect()->route('shop_categories.index');
    }

    public function destroy(Shop_category $shop_category)
    {
        $shop_category->delete();
        session()->flash('success','删除成功');
        return redirect()->route('shop_categories.index');
    }
}
