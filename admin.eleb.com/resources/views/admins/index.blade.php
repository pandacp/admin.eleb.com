@extends('default')

@section('contents')
    @include('_error')
    @role('超级管理员')
    <div class="container">
        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td>账号ID</td>
                <td>用户名称</td>
                <td>用户邮箱</td>
                <td>操作</td>
                <td>操作</td>
            </tr>
            @foreach($admins as $admin)
            <tr>
                <td>{{ $admin->id }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>
                    <div>
                        <a href="{{ route('admins.create') }}" class="glyphicon glyphicon-plus"></a>
                        &emsp;<a href="{{ route('admins.edit',[$admin]) }}" class="glyphicon glyphicon-list-alt"></a>
                        &emsp;&emsp;<a href="{{ route('admins.form',[$admin]) }}">修改密码</a>
                    </div>
                </td>
                <td>
                    <form action="{{ route('admins.destroy',[$admin]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    {{ $admins->links() }}
    </div>
    @else
    <div class="container">
        <p style="text-align: center">
            你不是超级管理员,无权访问
        </p>
    </div>
    @endrole
@stop
