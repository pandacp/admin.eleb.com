@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <form action="{{ route('admins.update',[$admin]) }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="用户名" value="{{ $admin->name }}">
            </div>
            {{--<div class="form-group">--}}
                {{--<label for="exampleInputPassword1">旧密码</label>--}}
                {{--<input type="password" name="oldpassword" class="form-control" id="exampleInputPassword1" placeholder="Password">--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label for="exampleInputPassword1">新密码</label>--}}
                {{--<input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label for="exampleInputPassword1">确认密码</label>--}}
                {{--<input type="password" name="repassword" class="form-control" id="exampleInputPassword1" placeholder="Password">--}}
            {{--</div>--}}
            <div class="form-group">
                <label for="exampleInputEmail1">邮箱</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="邮箱" value="{{ $admin->email }}">
            </div>
            {{--<div class="checkbox">--}}
                {{--<label>--}}
                    {{--<input type="checkbox" name="rememberToken"> 记住我--}}
                {{--</label>--}}
            {{--</div>--}}
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <button type="submit" class="btn btn-primary">修改</button>
        </form>
    </div>
@stop