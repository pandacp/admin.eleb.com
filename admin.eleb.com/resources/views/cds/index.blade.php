@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td>菜单ID</td>
                <td>菜单名称</td>
                <td>菜单地址</td>
                <td>关联权限ID</td>
                <td>顶级菜单ID</td>
                <td>操作</td>
                <td>操作</td>
            </tr>
            @foreach($cds as $cd)
            <tr>
                <td>{{ $cd->id }}</td>
                <td>{{ $cd->name }}</td>
                <td>{{ $cd->url }}</td>
                <td>{{ $cd->permission->name  }}</td>
                <td>{{ $cd->pid }}</td>
                <td>
                    <div>
                        &emsp;<a href="{{ route('cds.edit',[$cd]) }}" class="glyphicon glyphicon-list-alt"></a>
                    </div>
                </td>
                <td>
                    <form action="{{ route('cds.destroy',[$cd]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    {{ $cds->links() }}
    </div>

@stop
