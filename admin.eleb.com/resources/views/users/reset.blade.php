@extends('default')

@section('contents')
    @include('_error')
    <div class="container" style="">
        <form action="{{ route('users.reset',[$user]) }}" method="post" class="form-group">
            <div style="width:500px">
                请输入新密码:<input type="password" name="password" class="form-control">
                确认密码:<input type="password" name="repassword" class="form-control"><hr>
                <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                {{ csrf_field() }}
                {{ method_field("PATCH") }}
                输入验证码:<input id="captcha" class="form-control" name="captcha" >
                <button class="btn btn-block btn-primary">提交</button>
            </div>
        </form>
    </div>
@stop