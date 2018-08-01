@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td>角色ID</td>
                <td>角色名称</td>
                <td>操作</td>
                <td>操作</td>
            </tr>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>
                    <div>
                        <a href="{{ route('roles.create') }}" class="glyphicon glyphicon-plus"></a>
                        &emsp;<a href="{{ route('roles.edit',[$role]) }}" class="glyphicon glyphicon-list-alt"></a>
                    </div>
                </td>
                <td>
                    <form action="{{ route('roles.destroy',[$role]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    {{ $roles->links() }}
    </div>
@stop