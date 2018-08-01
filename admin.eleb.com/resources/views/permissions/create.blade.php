@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <form action="{{ route('permissions.store') }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">权限名</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="权限名" value="{{ old('name') }}">
            </div>

            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">添加权限</button>
        </form>
    </div>

@stop