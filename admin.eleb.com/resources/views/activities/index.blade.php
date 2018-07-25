@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
         <div class="row">
             <form action="{{ route('activities.index') }}" method="get" class="navbar-form navbar-left">
                 <div class="form-group">
                     <input type="hidden" name="k1" value="1">
                     {{ csrf_field() }}
                     <button type="submit" class="btn btn-primary">进行中</button>
                 </div>
             </form>
             <form action="{{ route('activities.index') }}" method="get" class="navbar-form navbar-left">
                 <div class="form-group">
                     <input type="hidden" name="k2" value="2">
                     {{ csrf_field() }}
                     <button type="submit" class="btn btn-info">未开始</button>
                 </div>
             </form>
             <form action="{{ route('activities.index') }}" method="get" class="navbar-form navbar-left">
                 <div class="form-group">
                     <input type="hidden" name="k3" value="3">
                     {{ csrf_field() }}
                     <button type="submit" class="btn btn-default">已结束</button>
                 </div>
             </form>
         </div>
        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td><span>活动标题</span></td>
                <td><span>活动内容</span></td>
                <td><span>开始时间</span></td>
                <td><span>结束时间</span></td>
                <td><span>操作</span></td>
            </tr>
            @foreach($activities as $activity)
            <tr>
                <td>{{ $activity->title }}</td>
                <td>{!! $activity->content !!}</td>
                <td>{{ $activity->start_time }}</td>
                <td>{{ $activity->end_time }}</td>
                <td>
                    <div>
                        <a href="{{ route('activities.create') }}" class="glyphicon glyphicon-plus"></a>
                        &emsp;<a href="{{ route('activities.edit',[$activity]) }}" class="glyphicon glyphicon-list-alt"></a>
                    </div>
                </td>
                <td>
                    <form action="{{ route('activities.destroy',[$activity]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    {{ $activities->appends(['activities'=>$activities,'k1'=>$k1,'k2'=>$k2,'k3'=>$k3])->links() }}
    </div>
@stop