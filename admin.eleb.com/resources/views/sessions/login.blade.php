@extends('default')

@section('contents')
    @include('_error')

    <div style="width:300px" class="container">
        <form action="{{ route('login') }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="用户名" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">密码</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="rememberToken" value="1"> 记住我
                </label>
            </div>
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">登录</button>
        </form>
    </div>

@stop