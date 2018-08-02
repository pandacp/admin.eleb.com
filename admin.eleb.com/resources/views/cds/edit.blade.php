@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <form action="{{ route('cds.update',[$cd]) }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">菜单名</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="菜单名" value="{{ $cd->name }}">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">地址</label>
                <input type="text" name="url" class="form-control" id="exampleInputPassword1" placeholder="地址" value="{{ $cd->url }}">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">关联权限ID</label><br>
                <select name="permission_id" id="">
                    @foreach($permissions as $permission)
                        <option value="{{ $permission->id }}" @if($permission->id==$cd->permission_id) selected @endif>{{ $permission->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">顶级菜单</label><br>
                <select name="pid" id="">
                    @foreach($pids as $pid)
                        <option value="{{ $pid->id }}" @if($cd->pid==$pid->id) selected @endif>{{ $pid->name }}</option>
                    @endforeach
                </select>
            </div>
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <button type="submit" class="btn btn-primary">添加菜单</button>
        </form>
    </div>

@stop