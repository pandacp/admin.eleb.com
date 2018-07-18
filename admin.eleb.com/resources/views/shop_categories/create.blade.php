@extends('default')

@section('contents')
    <div class="container">
        <form class="form-group" action="{{ route('shop_categories.store') }}" method="post" enctype="multipart/form-data">

            <label for="">商家分类名称</label>
            <input type="text" name="name" ><br>
            <label for="">商家分类图片</label>
            <input type="file" name="img" ><br>
            <label for="">商家分类状态</label>
            隐藏:<input type="radio" name="status" value="0" checked="checked">
            显示:<input type="radio" name="status" value="1" ><br>
            {{ csrf_field() }}
            <button class="btn btn-primary">提交</button>
        </form>
    </div>
@stop