<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['index']
        ]);
    }
    public function index(Request $request)
    {
        if(Auth::check()){
            if (!empty($request->year)&&!empty($request->shop)) {

                $year = $request->year . '-1-1 00:00:00';//开始年份
                $end_year = $request->year . '-12-31 23:59:59';//结束年份
                $shop = DB::table('shops')->where('shop_name',$request->shop)->first();
                $count = DB::table('orders')->where('shop_id',$shop->id)->whereBetween('created_at', [$year, $end_year])->count();
                $name="{$request->shop}{$request->year}年订单量";
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
            elseif (!empty($request->day)&&!empty($request->shop)) {
                $day = $request->day.' 00:00:00';
                $end_day = $request->day.' 23:59:59';
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
            }
            else {
                $orders = Order::paginate(10);
                return view('orders/index',compact('orders'));
            }
        }
        return redirect()->route('login')->with('danger','请登录');
    }



}
