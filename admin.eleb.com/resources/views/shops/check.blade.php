@extends('default')

@section('contents')
    @include('_error')
    <div class="container" style="width:600px">
                <table class="table table-bordered">
                    <tr>
                        <td>商户名</td>
                        <td>{{$shop->shop_name}}</td>
                    </tr>
                    <tr>
                        <td>商户图片</td>
                        <td><img src="{{ \Illuminate\Support\Facades\Storage::url($shop->shop_img) }}" alt="" style="width:200px"></td>
                    </tr>
                    <tr>
                        <td>评分</td>
                        <td>{{$shop->shop_rating}}</td>
                    </tr>
                    <tr>
                        <td>是否品牌</td>
                        <td>@if($shop->brand==1)是@else否@endif</td>
                    </tr>
                    <tr>
                        <td>是否准时送达</td>
                        <td>@if($shop->on_time==1)是@else否@endif</td>
                    </tr>
                    <tr>
                        <td>是否蜂鸟</td>
                        <td>@if($shop->fengniao==1)是@else否@endif</td>
                    </tr>
                    <tr>
                        <td>是否保标记</td>
                        <td>@if($shop->bao==1)是@else否@endif</td>
                    </tr>
                    <tr>
                        <td>是否票标记</td>
                        <td>@if($shop->piao==1)是@else否@endif</td>
                    </tr>
                    <tr>
                        <td>是否准标记</td>
                        <td>@if($shop->zhun==1)是@else否@endif</td>
                    </tr>
                    <tr>
                        <td>起送金额</td>
                        <td>{{ $shop->start_send }}</td>
                    </tr>
                    <tr>
                        <td>配送费</td>
                        <td>{{ $shop->send_cost }}</td>
                    </tr>
                    <tr>
                        <td>店公告</td>
                        <td>
                            <textarea name="notice" id="" cols="30" rows="3"  class="form-control">{{ $shop->notice }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>优惠信息</td>
                        <td>
                            <textarea name="notice" id="" cols="30" rows="3"  class="form-control">{{ $shop->discount }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>店铺分类</td>
                        <td>
                            <select name="shop_category_id" id="">
                                @foreach($shop_categories as $shop_category)
       <option value="{{ $shop_category->id }}" @if($shop_category->id == $shop->shop_category_id)selected @endif>{{ $shop_category->name }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>审核状态</td>
                        <td>
                            <select name="status" id="">
                                <option value="1" @if($shop->status==1)selected @endif>正常</option>
                                <option value="0" @if($shop->status==0)selected @endif>待审核</option>
                                <option value="-1" @if($shop->status==-1)selected @endif>禁用</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center">
                            <a href="{{ route('shops.check',[$shop]) }}"><button class="btn btn-primary">通过</button></a>
                            <a href="{{ route('shops.check',[$shop]) }}"><button class="btn btn-primary">待审核</button></a>
                            <a href="{{ route('shops.checked',[$shop]) }}"><button class="btn btn-danger">禁用</button></a>
                        </td>
                    </tr>

                </table>

    </div>

    {{--<div class="form-group">--}}
        {{--<label for="exampleInputFile">File input</label>--}}
        {{--<input type="file" id="exampleInputFile">--}}
        {{--<p class="help-block">Example block-level help text here.</p>--}}
    {{--</div>--}}
@stop