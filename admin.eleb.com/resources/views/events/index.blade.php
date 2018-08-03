@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        
         {{--<div class="row">--}}
             {{--<form action="{{ route('events.index') }}" method="get" class="navbar-form navbar-left">--}}
                 {{--<div class="form-group">--}}
                     {{--<input type="hidden" name="k1" value="1">--}}
                     {{--{{ csrf_field() }}--}}
                     {{--<button type="submit" class="btn btn-primary">进行中</button>--}}
                 {{--</div>--}}
             {{--</form>--}}
             {{--<form action="{{ route('activities.index') }}" method="get" class="navbar-form navbar-left">--}}
                 {{--<div class="form-group">--}}
                     {{--<input type="hidden" name="k2" value="2">--}}
                     {{--{{ csrf_field() }}--}}
                     {{--<button type="submit" class="btn btn-info">未开始</button>--}}
                 {{--</div>--}}
             {{--</form>--}}
             {{--<form action="{{ route('activities.index') }}" method="get" class="navbar-form navbar-left">--}}
                 {{--<div class="form-group">--}}
                     {{--<input type="hidden" name="k3" value="3">--}}
                     {{--{{ csrf_field() }}--}}
                     {{--<button type="submit" class="btn btn-default">已结束</button>--}}
                 {{--</div>--}}
             {{--</form>--}}
         {{--</div>--}}
        <botton class="btn btn-primary"><a href="{{ route('sign_up') }}"><span style="color: #f8f8f8">查看报名信息</span></a></botton>
        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td><span>抽奖活动标题</span></td>
                {{--<td><span>活动内容</span></td>--}}
                <td><span>报名开始时间</span></td>
                <td><span>报名结束时间</span></td>
                <td><span>开奖日期</span></td>
                <td><span>报名人数限制</span></td>
                <td><span>是否开奖</span></td>
                <td><span>操作</span></td>
                <td><span>操作</span></td>
                <td><span>操作</span></td>
            </tr>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                {{--<td>{!! $event->content !!}</td>--}}
                <td>{{ date('Y-m-d H:i:s',$event->signup_start) }}</td>
                <td>{{ date('Y-m-d H:i:s',$event->signup_end) }}</td>
                <td>{{ $event->prize_date }}</td>
                <td>{{ $event->signup_num }}人</td>
                <td>@if($event->is_prize==0)未开奖 @else已开奖 @endif</td>
                <td>
                    <div>
                        <a href="{{ route('events.show',[$event]) }}" class="glyphicon glyphicon-gift"></a>&emsp;
                        <a href="{{ route('events.create') }}" class="glyphicon glyphicon-plus"></a>
                        &emsp;<a href="{{ route('events.edit',[$event]) }}"  @if($event->is_prize!=1)  class="glyphicon glyphicon-list-alt" @else class="disabled" @endif></a>
                        {{--&emsp;<a href="{{ route('lotteries.index') }}" class="glyphicon glyphicon-gift"></a>--}}
                    </div>
                </td>
                <td>
                    <form action="{{ route('events.destroy',[$event]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </table>
        {{ $events->links() }}
    </div>
@stop