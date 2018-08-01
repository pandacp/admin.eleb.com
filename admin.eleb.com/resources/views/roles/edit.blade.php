@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <form action="{{ route('roles.update',[$role]) }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">角色名</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="角色名" value="{{ $role->name }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">添加权限</label><br>
                @foreach($permissions as $permission)
                {{ $permission->name }}<input type="checkbox" name="permission[]" value="{{ $permission->name }}" @if($role->hasPermissionTo($permission)) checked @endif>
                @endforeach
            </div>
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <button type="submit" class="btn btn-primary">修改角色</button>
        </form>
    </div>

@stop