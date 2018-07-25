@extends('default')

@section('contents')
    <div class="container">
        <table class="table table-responsive">
            <tr>
                <td>商家分类ID</td>
                <td>商家分类名称</td>
                <td>商家分类图片</td>
                <td>商家分类状态</td>
                <td>操作</td>
            </tr>
            @foreach($shop_categories as $shop_category)
                <tr>
                    <td>{{ $shop_category->id }}</td>
                    <td>{{ $shop_category->name }}</td>
                    <td><img src="{{ $shop_category->img}}" alt="" style="width:100px"></td>
                    <td>@if($shop_category->status==1)显示@else隐藏@endif</td>
                    <td>
                        <a href="{{ route('shop_categories.edit',[$shop_category]) }}" >修改</a>
                        <form action="{{ route('shop_categories.destroy',[$shop_category]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a href="{{ route('shop_categories.destroy',[$shop_category]) }}"><button class="btn btn-danger">删除</button></a>
                        </form>

                    </td>
                </tr>
            @endforeach
        </table>
        {{ $shop_categories->links() }}
    </div>

@stop