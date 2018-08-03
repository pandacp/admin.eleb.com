<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Event_prize;
use Illuminate\Http\Request;

class Event_prizeController extends Controller
{
    //活动奖品列表
    public function index()
    {
        $event_prizes = Event_prize::paginate(5);
        return view('event_prizes/index',compact('event_prizes'));
    }

    public function create()
    {
        //查询所有的未开奖的活动
        $events = Event::where('prize_date','>',date('Y-m-d',time()))->get();
        return view('event_prizes/create',compact('events'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'events_id'=>'required',
            'description'=>'required',
        ],[
            'name.required'=>'奖品名称不能为空',
            'events_id.required'=>'所属活动不能为空',
            'description.required'=>'奖品详情不能为空',
        ]);
        Event_prize::create([
            'name'=>$request->name,
            'events_id'=>$request->events_id,
            'description'=>$request->description,
        ]);

        return redirect()->route('event_prizes.index')->with('success','添加成功');
    }

    public function edit(Event_prize $event_prize)
    {
        //根据该奖品中的events_id,查找对应的活动,是否已开奖
        $event = Event::where('id',$event_prize->events_id)->first();
        //活动已开奖,不能修改奖品
        if($event->is_prize!=0){
            return back()->with('danger','活动已开奖,不能修改奖品');
        }
        //查询所有的未开奖的活动
        $events = Event::where('prize_date','>',date('Y-m-d',time()))->get();
        return view('event_prizes/edit',compact('events','event_prize'));
    }

    public function update(Event_prize $event_prize,Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'events_id'=>'required',
            'description'=>'required',
        ],[
            'name.required'=>'奖品名称不能为空',
            'events_id.required'=>'所属活动不能为空',
            'description.required'=>'奖品详情不能为空',
        ]);
        $event_prize->update([
            'name'=>$request->name,
            'events_id'=>$request->events_id,
            'description'=>$request->description,
        ]);
        return redirect()->route('event_prizes.index')->with('success','修改成功');
    }

    public function destroy(Event_prize $event_prize)
    {
        //根据该奖品中的events_id,查找对应的活动,是否已开奖
        $event = Event::where('id',$event_prize->events_id)->first();
        //活动已开奖,不能修改奖品
        if($event->is_prize==0){
        return back()->with('danger','活动未开奖,不能删除奖品');
    }
        $event_prize->delete();
        return redirect()->route('event_prizes.index')->with('success','删除成功');
    }


}
