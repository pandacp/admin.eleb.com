<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_member;
use App\Models\Event_prize;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //抽奖活动管理[报名人数限制、报名时间设置、开奖时间设置]
    public function index()
    {
        $events = Event::paginate(3);
        return view('events/index',compact('events'));
    }

    public function create()
    {
        return view('events/create');
    }

    public function store(Request $request)
    {
        //活动开始日期不能小于当前日期,结束日期不能小于开始日期,开奖日期不能小于结束日期
        if(strtotime($request->signup_start)<time()){
            return back()->with('danger','开始日期不能小于当前日期');
        }
        if(strtotime($request->signup_end)<strtotime($request->signup_start)){
            return back()->with('danger','结束日期不能小于开始日期');
        }
        if(strtotime($request->prize_date)<strtotime($request->signup_end)){
            return back()->with('danger','开奖日期不能小于结束日期');
        }

        $this->validate($request,[
            'title'=>'required',
            'signup_start'=>'required',
            'signup_end'=>'required',
            'prize_date'=>'required',
            'signup_num'=>'required',
            'is_prize'=>'required',
            'contents'=>'required',
        ],[
            'title.required'=>'标题不能为空',
            'signup_start.required'=>'开始时间不能为空',
            'signup_end.required'=>'结束时间不能为空',
            'prize_date.required'=>'开奖时间不能为空',
            'signup_num.required'=>'报名人数限制不能小于0',
            'contents.required'=>'内容不能为空',
        ]);
        Event::create([
            'title'=>$request->title,
            'signup_start'=>strtotime($request->signup_start),
            'signup_end'=>strtotime($request->signup_end),
            'prize_date'=>$request->prize_date,
            'signup_num'=>$request->signup_num,
            'is_prize'=>$request->is_prize,
            'content'=>$request->contents,
        ]);

        return redirect()->route('events.index')->with('success','添加成功');
    }

    public function edit(Event $event)
    {
        //活动开启之后不能修改活动
//        if($event->signup_start<time()){
//            return back()->with('danger','活动已开启不能修改内容');
//        }

        return view('events/edit',compact('event'));
    }

    public function update(Event $event,Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'signup_start'=>'required|date|after:today',
            'signup_end'=>'required|date|after:signup_start',
            'prize_date'=>'required|date|after:signup_end',
            'signup_num'=>'required',
            'is_prize'=>'required',
            'contents'=>'required',
        ],[
            'title.required'=>'标题不能为空',
            'signup_start.required'=>'开始时间不能为空',
            'signup_start.after'=>'开始时间必须在今天之后',
            'signup_end.required'=>'结束时间不能为空',
            'signup_end.after'=>'结束时间必须在开始时间之后',
            'prize_date.required'=>'开奖时间不能为空',
            'prize_date.after'=>'开奖时间必须在结束时间之后',
            'signup_num.required'=>'报名人数限制不能小于0',
            'contents.required'=>'内容不能为空',
        ]);
        $event->update([
            'title'=>$request->title,
            'signup_start'=>strtotime($request->signup_start),
            'signup_end'=>strtotime($request->signup_end),
            'prize_date'=>$request->prize_date,
            'signup_num'=>$request->signup_num,
            'is_prize'=>$request->is_prize,
            'content'=>$request->contents,
        ]);
        return redirect()->route('events.index')->with('success','修改成功');
    }

    public function destroy(Event $event)
    {
        //活动未结束不能删除
        if($event->signup_end>time()){
              return back()->with('danger','活动未结束不能删除');
        }
        $event->delete();
        return redirect()->route('events.index')->with('success','删除成功');
    }

    public function show(Event $event)
    {

        if($event->is_prize==1){
            return back()->with('danger','不能重复开奖');
        }
        //根据报名人数随机抽取活动奖品,将活动奖品和报名的账号随机匹配
        $prizes = Event_prize::where('events_id',$event->id)->get();//该活动所有的奖品
        $count = Event_prize::where('events_id',$event->id)->count();
        $members = Event_member::where('events_id',$event->id)->get();//参与该活动的所有用户
//        $rd_p = $prizes->shuffle();
        $rd_m = $members->shuffle();
//        $p = $rd_p->pop();
//        $m = $rd_m->pop();

        $arr = [];
        foreach($prizes as $p){
            $m = $rd_m->pop();//随机参与的用户
            $arr[$p->id]=$m->member_id;
            if(in_array($m->member_id,$arr)){
                continue;
            }
        }

        foreach($arr as $k=>$v){
            $prize = Event_prize::where('id',$k)->first();
            $prize->update([
                'member_id'=>$v,
            ]);
//            echo "奖品为{$k}:中奖人{$v},<br>";
        }
        //修改活动状态
        $event->update([
            'is_prize'=>1,
        ]);

     return redirect()->route('events.index')->with('success','抽奖完成');
    }
    //查询所有的报名信息
    public function sign_up()
    {
        $event_members = Event_member::all();
//        var_dump($members);die;
        return view('events/event_member',compact('event_members'));
    }
    //抽奖
    // 根据报名人数随机抽取活动奖品,将活动奖品和报名的账号随机匹配]

}
