@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td>权限ID</td>
                <td>权限名称</td>
                <td>操作</td>
                <td>操作</td>
            </tr>
            @foreach($permissions as $permission)
            <tr>
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>
                    <div>
                        <a href="{{ route('permissions.create') }}" class="glyphicon glyphicon-plus"></a>
                        &emsp;<a href="{{ route('permissions.edit',[$permission]) }}" class="glyphicon glyphicon-list-alt"></a>
                    </div>
                </td>
                <td>
                    <form action="{{ route('permissions.destroy',[$permission]) }}" method="post">
                        {{--<input type="text" name="name">--}}
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    {{ $permissions->links() }}
    </div>
@stop