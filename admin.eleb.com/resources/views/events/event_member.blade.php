@extends('default')

@section('contents')
    <div class="container" style="text-align: center">
        <table class="table table-bordered">
            <tr style="background-color: #00cae9">
                <td>活动标题</td>
                <td>报名用户</td>
            </tr>
            @foreach($event_members as $event_member)
                <tr>
                    <td>{{ $event_member->event->title }}</td>
                    <td>{{ $event_member->user->name }}</td>
                </tr>
            @endforeach
        </table>

    </div>
@stop