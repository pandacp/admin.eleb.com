@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <form action="{{ route('roles.store') }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">角色名</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="角色名" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">添加权限</label><br>
                @foreach($permissions as $permission)
                {{ $permission->name }}<input type="checkbox" name="permission[]" value="{{ $permission->name }}">
                @endforeach
            </div>
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">添加角色</button>
        </form>
    </div>

@stop