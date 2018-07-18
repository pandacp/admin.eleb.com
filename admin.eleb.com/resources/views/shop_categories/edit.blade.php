@extends('default')

@section('contents')
    <div class="container">
        <form class="form-group" action="{{ route('shop_categories.update',[$shop_category]) }}" method="post" enctype="multipart/form-data">
            <table class="table table-responsive">
                <tr>
                    <td>
                        <label for="">商家分类名称</label>
                        <input type="text" name="name" value="{{ $shop_category->name }}">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">商家分类图片</label>
                        <input type="file" name="img" ><img src="{{ \Illuminate\Support\Facades\Storage::url($shop_category->img) }}" alt="" style="width:200px">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">商家分类状态</label>
         隐藏:<input type="radio" name="status" value="0" @if($shop_category->status==0)checked="checked"@endif>
                        显示:<input type="radio" name="status" value="1" @if($shop_category->status!=0)checked="checked"@endif><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <button class="btn btn-primary">提交</button>
                    </td>
                </tr>
            </table>

        </form>
    </div>
@stop