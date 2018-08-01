@extends('default')

@section('contents')
    @include('_error')
    <div class="container">

        <form class="navbar-form navbar-left" action="{{ route('orders.index') }}" method="post">
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
            </div>
            {{ csrf_field() }}
            {{ method_field('GET') }}
            <button type="submit" class="btn btn-default">统计</button>
        </form>
        <div class="container">
               <table class="table table-bordered">
                   <tr>
                       <td>商家名称</td>
                       <td>商家总销量排行榜</td>
                   </tr>
                   {{--@foreach($seles as $sele)--}}
                   {{--<tr>--}}
                       {{--<td></td>--}}
                       {{--<td>1</td>--}}
                   {{--</tr>--}}
                   {{--@endforeach--}}
               </table>             

        </div>
        
        
        
        <table class="table table-bordered">
            <tr>
                <td>订单id</td>
                <td>商店id</td>
                <td>订单编号</td>
                <td>订单生成日期</td>
            </tr>
            <?php foreach($orders as $order):?>
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->shop->shop_name }}</td>
                <td>{{ $order->sn }}</td>
                <td>{{ $order->created_at }}</td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>


@stop