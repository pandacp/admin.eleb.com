@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <form action="{{ route('admins.store') }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="用户名" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">密码</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">确认密码</label>
                <input type="password" name="repassword" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">邮箱</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="邮箱" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">角色</label><br>
                @foreach($roles as $role)
                {{ $role->name }}<input type="checkbox" name="role[]">
                @endforeach
            </div>

            {{--<div class="checkbox">--}}
                {{--<label>--}}
                    {{--<input type="checkbox" name="rememberToken"> 记住我--}}
                {{--</label>--}}
            {{--</div>--}}
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">注册</button>
        </form>
    </div>

    {{--<div class="form-group">--}}
        {{--<label for="exampleInputFile">File input</label>--}}
        {{--<input type="file" id="exampleInputFile">--}}
        {{--<p class="help-block">Example block-level help text here.</p>--}}
    {{--</div>--}}
@stop