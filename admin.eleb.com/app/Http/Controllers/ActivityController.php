<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    //使用中间件指定可以访问的页面
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['index']
        ]);
    }
    public function index(Request $request)
    {
        if(Auth::check()){//验证是否登录

            $k1 = $request->k1;
            $k2 = $request->k2;
            $k3 = $request->k3;
//            var_dump(date('Y-m-d H:i:s'));
            $time =date('Y-m-d H:i:s');//当前时间
            if($k1){
                //开始时间<当前时间<结束时间,进行中['start_time','<',$time],['end_time','>',$time]
                $activities = Activity::where([['end_time','>',$time],])->paginate(2);
            }elseif($k2){
                //开始时间>当前时间,未开始
                $activities = Activity::where('start_time','>',$time)->paginate(2);
            }elseif($k3){
                //结束时间<当前时间,过期
                $activities = Activity::where('end_time','<',$time)->paginate(2);
            }else{
                $activities = Activity::paginate(2);
            }
            return view('activities/index',compact('activities','k1','k2','k3'));
        }
        return redirect()->route('login')->with('danger','请登录');
    }

    public function create()
    {
        return view('activities/create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'content'=>'required',
        ],[
            'title.required'=>'标题不能为空',
            'start_time.required'=>'开始时间不能为空',
            'end_time.required'=>'结束时间不能为空',
            'content.required'=>'内容不能为空',
        ]);
        //开始时间必须大于当前时间
        //结束时间必须大于开始时间
        //  d<s<e
        $time = time();//当前时间
        $start = strtotime($request->start_time);//开始时间
        $end = strtotime($request->end_time);//结束时间
        if($start<$time){
            return back()->with('danger','开始时间必须大于当前时间');
        }elseif ($end<$start){
            return back()->with('danger','结束时间必须大于开始时间');
        }
        Activity::create([
            'title'=>$request->title,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'content'=>$request->content,
        ]);

        return redirect()->route('activities.index')->with('success','添加成功');
    }

    public function edit(Activity $activity)
    {

        return view('activities/edit',compact('activity'));
    }

    public function update(Activity $activity,Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'content'=>'required',
        ],[
            'title.required'=>'标题不能为空',
            'start_time.required'=>'开始时间不能为空',
            'end_time.required'=>'结束时间不能为空',
            'content.required'=>'内容不能为空',
        ]);
        $time = time();//当前时间
        $start = strtotime($request->start_time);//开始时间
        $end = strtotime($request->end_time);//结束时间
        if($start<$time){
            return back()->with('danger','开始时间必须大于当前时间');
        }elseif ($end<$start){
            return back()->with('danger','结束时间必须大于开始时间');
        }
        $activity->update([
            'title'=>$request->title,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'content'=>$request->content,
        ]);

        return redirect()->route('activities.index')->with('success','修改成功');
    }
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return redirect()->route('activities.index')->with('success','删除成功');
    }
}
