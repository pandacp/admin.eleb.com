<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Shop_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['index']
        ]);
    }
    //审核
    public function show(Shop $shop)
    {
//        var_dump($shop);die;
        $shop_categories = Shop_category::all();
        return view('shops/check',compact('shop_categories','shop'));
    }

    public function check(Shop $shop)
    {
//        dd($shop);
        $shop->update(['status'=>1]);
        return redirect()->route('shops.index')->with('success','审核通过');
    }
    public function checked(Shop $shop)
    {
        $shop->update(['status'=>-1]);
        return redirect()->route('shops.index')->with('success','禁用');
    }
    public function index()
    {
        if(Auth::check()){
            $shops = Shop::paginate(3);
            return view('shops/index',compact('shops'));
        }
        return redirect()->route('login')->with('danger','请登录');
    }

    public function create()
    {
        $shops = Shop::all();
        $shop_categories = Shop_category::all();
        return view('shops/create',compact('shop_categories','shops'));
    }

    public function store(Request $request)
    {
        $file=$request->shop_img;
        $this->validate($request,[
            'shop_name'=>'required|max:10',
            'shop_img'=>'required',
            'start_send'=>'required',
            'send_cost'=>'required',
        ],[
            'shop_name.required'=>'商店名称不能为空',
            'shop_name.max.required'=>'商店名称不能大于10位',
            'shop_img.required'=>'商店名称不能大于10位',
            'start_send.required'=>'起送金额不能为空',
            'send_cost.required'=>'配送费不能为空',
        ]);
        $rating = 0;
        $filename = $file->store('public/dp_img');
        Shop::create([
            'shop_name'=>$request->shop_name,
            'shop_img'=>$filename,
            'rating'=>$rating,
            'brand'=>$request->brand,
            'on_time'=>$request->on_time,
            'fengniao'=>$request->fengniao,
            'bao'=>$request->bao,
            'piao'=>$request->piao,
            'zhun'=>$request->zhun,
            'start_send'=>$request->start_send,
            'send_cost'=>$request->send_cost,
            'notice'=>$request->notice,
            'discount'=>$request->discount,
            'shop_category_id'=>$request->shop_category_id,
            'status'=>$request->status,
        ]);
//        'shop_category_id','shop_name','shop_img','rating','brand','on_time','fengniao','bao','piao','zhun','start_send','send_cost','notice','discount','status'
        return redirect()->route('shops.index')->with('success','添加成功');

    }

    public function edit(Shop $shop)
    {
        $shop_categories = Shop_category::all();
        return view('shops/edit',compact('shop_categories','shop'));
    }

    public function update(Shop $shop,Request $request)
    {
        $this->validate($request,[
            'shop_name'=>'required|max:10',
            'start_send'=>'required',
            'send_cost'=>'required',
        ],[
            'shop_name.required'=>'商店名称不能为空',
            'shop_name.max'=>'商店名称不能大于10位',
            'start_send'=>'起送金额不能为空',
            'send_cost'=>'配送费不能为空',
        ]);

        $file=$request->shop_img;
        $rating = $request->shop_rating??0;
        $data = [
            'shop_name'=>$request->shop_name,
            'rating'=>$rating,
            'brand'=>$request->brand,
            'on_time'=>$request->on_time,
            'fengniao'=>$request->fengniao,
            'bao'=>$request->bao,
            'piao'=>$request->piao,
            'zhun'=>$request->zhun,
            'start_send'=>$request->start_send,
            'send_cost'=>$request->send_cost,
            'notice'=>$request->notice,
            'discount'=>$request->discount,
            'shop_category_id'=>$request->shop_category_id,
            'status'=>$request->status,
        ];
        if($file){
            $filename = $file->store('public/dp_img');
            $data['shop_img'] = $filename;
        }

        $shop->update($data);
        return redirect()->route('shops.index')->with('success','修改成功');
    }
    public function destroy(Shop $shop){
        $shop->delete();
        return redirect()->route('shops.index')->with('success','删除成功');
    }
}
