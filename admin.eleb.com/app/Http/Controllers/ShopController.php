<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Shop_category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        $user = User::where('shop_id',$shop->id)->first();
        $email = $user->email;
        $_SERVER['email']=$email;

        $shop->update(['status'=>1]);
        //审核通过发送邮件
        $rs = Mail::raw('您的信息通过审核,欢迎加入我们的团队',function($message){
            $email = $_SERVER['email'];
            $message->subject('商城审核');
            $message->to(["{$email}"]);
            $message->from('13658010910@163.com','13658010910');

        });
        if(!empty($rs)){
            return back()->with('danger','邮箱发送失败');
        }

        return redirect()->route('shops.index')->with('success','审核通过');
    }
    public function checked(Shop $shop)
    {
        $shop->update(['status'=>-1]);
        return redirect()->route('shops.index')->with('success','禁用');
    }
    //商家首页
    public function index(Request $request)
    {
        if(Auth::check()){
            if (!empty($request->year)&&!empty($request->shop)&&!empty($request->menu)) {
    //select * from (select shop_id,amount,goods_id from order_goods  join menus as m on order_goods.goods_id=m.id) as g left JOIN  shops as s on g.shop_id=s.id where shop_id=1;
                $year = $request->year . '-1-1 00:00:00';//开始年份
                $end_year = $request->year . '-12-31 23:59:59';//结束年份
                //根据传入的菜名找出对应的菜品id
                $menu = DB::table('menus')->where('goods_name',$request->menu)->first();

                $data = DB::table('order_goods')
                    ->join('menus','order_goods.goods_id','=','menus.id')
                    ->select('shop_id','amount','goods_id')->where('goods_id',$menu->id)
                    ->get();
                var_dump($data);die;

                $shop = DB::table('shops')->where('shop_name',$request->shop)->first();
                $count = DB::table('order_goods')->where('shop_id',$shop->id)->whereBetween('created_at', [$year, $end_year])->count();
                $name="{$request->shop}{$request->year}年订单量";
                //
                $menus = DB::table('order_goods')->where('goods_name', 'like', "%{$request->menu}%")->whereBetween('created_at',[$year,$end_year])->get();
                $amount = 0;
                foreach ($menus as $menu) {
                    $amount += $menu->amount;//总销量
                }
                $menu = DB::table('order_goods')->where('goods_name', 'like', "%{$request->menu}%")->first();
                $name = $menu->goods_name;


                return view('orders/date', compact('count','name'));

            }
            //月订单量
            elseif (!empty($request->month)&&!empty($request->shop)) {
                $year = date('Y', time());//获取当前时间的年份
                $month = $year . '-' . $request->month . '-1 00:00:00';//开始月份
                $end_month = $year . '-' . $request->month . '-31 23:59:59';//结束月份
                //根据月份查询订单数量
                //根据输入的名称获取商店id,然后查询订单量
                $shop = DB::table('shops')->where('shop_name',$request->shop)->first();
                $count = DB::table('orders')->where('shop_id',$shop->id)->whereBetween('created_at', [$month, $end_month])->count();
                $name="{$request->shop}{$request->month}月总订单量";
                return view('orders/date', compact('count','name'));
            }
            //日订单量
            elseif (!empty($request->day)&&!empty($request->shop)&&!empty($request->menu)) {
                $day = $request->day.' 00:00:00';
                $end_day = $request->day.' 23:59:59';
                //根据传入的菜名找出对应的菜品id
                $shop = DB::table('shops')->where('shop_name',$request->shop)->first();//商店id
                $menu = DB::table('menus')->where('goods_name',$request->menu)->first();//菜品id
    //select * from order_goods  join menus as m on order_goods.goods_id=m.id where goods_id=12

//                $menus = DB::table('order_goods')
//                    ->join('menus','order_goods.goods_id','=','menus.id')
//                    ->select('shop_id','amount','goods_id')->where('goods_id',$menu->id)
//                    ->get();
//$arr = DB::select("select id,sum(parents+1) as total_people from orders where game_id=6 and pay_status=1 and hotel_id=5");
                $menus = DB::select("select shop_name,goods_name,amount from (select shop_id,amount,goods_id,o.goods_name from order_goods as o join menus as m on o.goods_id=m.id) as g left JOIN  shops as s on g.shop_id=s.id where shop_id='{$shop->id}' and goods_name='{$request->menu}'
");
                $amount = 0;
                foreach ($menus as $menu) {
                    $amount += $menu->amount;//日总销量
                }
                var_dump($amount);

                var_dump($menus);die;

                //->whereBetween('created_at',[$day,$end_day])
                $amount = 0;
                foreach ($menus as $menu) {
                    $amount += $menu->amount;//日总销量
                }
                var_dump($amount);
                die;


                //根据输入的名称获取商店id,然后查询订单量
                $shop = DB::table('shops')->where('shop_name',$request->shop)->first();
                $count = DB::table('orders')->where('shop_id',$shop->id)->whereBetween('created_at', [$day, $end_day])->count();

                $name="{$request->shop}{$request->day}号总订单";
                return view('orders/date', compact('count','name'));

            }
            elseif(!empty($request->shop)){
                //根据输入的名称获取商店id,然后查询订单量
                $shop = DB::table('shops')->where('shop_name',$request->shop)->first();
                $count = DB::table('orders')->where('shop_id',$shop->id)->count();
                $name="{$request->shop}总订单";
                return view('orders/date', compact('count','name'));

            }else{
                $shops = Shop::paginate(5);
                return view('shops/index',compact('shops'));
            }
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
        //   http://admin.eleb.com/
//        Storage::disk('oss');

//        $filename = $file->store('public/dp_img');
        Shop::create([
            'shop_name'=>$request->shop_name,
            'shop_img'=>$file,
            'shop_rating'=>$rating,
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
            'shop_rating'=>$rating,
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
//            $filename = $file->store('public/dp_img');
            $data['shop_img'] = $file;
        }

        $shop->update($data);
        return redirect()->route('shops.index')->with('success','修改成功');
    }
    public function destroy(Shop $shop){
        $shop->delete();
        return redirect()->route('shops.index')->with('success','删除成功');
    }
}
