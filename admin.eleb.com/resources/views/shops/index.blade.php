@extends('default')

@section('contents')
    @include('_error')
    <div class="container">
        <form class="navbar-form navbar-left" action="{{ route('shops.index') }}" method="post">
            <div class="form-group">
                年:<select name="year" >
                    <option value=""></option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                </select>
                月:<select name="month" >
                    <?php for($i=0;$i<=12;$i++):?>
                    <option value="{{ $i }}">{{ $i }}</option>
                    <?php endfor;?>
                </select>
                天:<input type="date" name="day" class="form-control" placeholder="2018-12-31" value="{{ old('to_year') }}">
                商家:<input type="text" name="shop">
                菜品:<input type="text" name="menu">
            </div>
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <button type="submit" class="btn btn-default">统计</button>
        </form>

        <table class="table table-condensed">
            <tr style="background: #9dcbff">
                <td>店铺名称</td>
                <td>店铺图片</td>
                <td>店铺分类ID</td>
                <td>评分</td>
                <td>审核状态</td>
                <td>操作</td>
            </tr>
            @foreach($shops as $shop)
            <tr>
                <td>{{ $shop->shop_name }}</td>
                <td><img src="{{ $shop->shop_img }}" alt="" style="width:100px"></td>
                <td>{{ $shop->Shop_category->name }}</td>
                <td>{{ $shop->rating }}</td>
                <td>@if($shop->status==1)正常@elseif($shop->status==0)待审核@else禁用@endif</td>
                <td>
                    <a href="{{ route('shops.show',[$shop]) }}"><button class="btn btn-primary">审核</button></a>
                    <a href="{{ route('shops.edit',[$shop]) }}"><button class="btn btn-primary">修改</button></a>
                    <form action="{{ route('shops.destroy',[$shop]) }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="btn btn-danger">删除</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    {{ $shops->links() }}
    </div>
@stop