@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td>账号ID</td>
                <td>用户名称</td>
                <td>用户邮箱</td>
                <td>用户状态</td>
                <td>所属商家</td>
                <td>操作</td>
            </tr>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>@if($user->status==1)通过@else未通过@endif</td>
                <td>{{ $user->shop->shop_name }}</td>
                <td>
                    <a href="{{ route('users.edit',[$user]) }}"><button class="btn btn-primary">修改</button></a>
                    <form action="{{ route('users.destroy',[$user]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    {{ $users->links() }}
    </div>
@stop