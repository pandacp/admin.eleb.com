@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <form action="{{ route('permissions.update',[$permission]) }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">权限名</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="权限名" value="{{ $permission->name }}">
            </div>
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <button type="submit" class="btn btn-primary">修改权限</button>
        </form>
    </div>

@stop