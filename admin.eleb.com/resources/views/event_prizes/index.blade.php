@extends('default')

@section('contents')
    @include('_error')
    <div class="container">

        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td><span>奖品名称</span></td>
                <td><span>所属活动</span></td>
                <td><span>奖品详情</span></td>
                <td><span>中奖商家</span></td>
                <td><span>操作</span></td>
                <td><span>操作</span></td>
            </tr>
            @foreach($event_prizes as $event_prize)
            <tr>
                <td>{{ $event_prize->name }}</td>
                <td>{{ $event_prize->event->title }}</td>
                <td>{!! $event_prize->description !!}</td>
                <td>{{ $event_prize->member_id }}</td>
                {{--<td>@if($event_prize->member_id==0){{$event_prize->member_id}}@else{{ $event_prize->user->name }}@endif</td>--}}
                <td>
                    <div>
                        {{--<a href="{{ route('event_prizes.show',[$event_prize]) }}" class="glyphicon glyphicon-eye-open"></a>&emsp;--}}
                        <a href="{{ route('event_prizes.create') }}" class="glyphicon glyphicon-plus"></a>
                        &emsp;<a href="{{ route('event_prizes.edit',[$event_prize]) }}" class="glyphicon glyphicon-list-alt"></a>
                    </div>
                </td>
                <td>
                    <form action="{{ route('event_prizes.destroy',[$event_prize]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>

                </td>
            </tr>
            @endforeach
        </table>
        {{ $event_prizes->links() }}
    </div>
@stop