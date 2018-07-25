@extends('default')
@section('css_files')
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
@stop

@section('js_files')
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
@stop
@section('contents')
    @include('_error')
    <div class="container">
        <form class="form-group" action="{{ route('shop_categories.store') }}" method="post" >

            <label for="">商家分类名称</label>
            <input type="text" name="name" ><br>
            <label for="">分类图片地址</label>
            <input type="hidden" name="img" id="img_url" style="width:500px">
            <div id="uploader-demo">
                <!--用来存放item-->
                <div id="fileList" class="uploader-list"></div>
                <div id="filePicker">选择图片</div>
            </div>
            <img id="img" style="width:200px"/>
            <br>
            <label for="">商家分类状态</label>
            隐藏:<input type="radio" name="status" value="0" checked="checked">
            显示:<input type="radio" name="status" value="1" ><br>
            {{ csrf_field() }}
            <button class="btn btn-primary">提交</button>
        </form>
    </div>
@stop
@section('js')
    <script>
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // swf文件路径
//            swf: BASE_URL + '/js/Uploader.swf',

            // 文件接收服务端。
            server: "{{ route('upload') }}",

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/jpeg,image/jpg,image/gif,image/png,image/bmp'
            },
            formData:{
                _token:'{{ csrf_token() }}'
            },
        });
        uploader.on('uploadSuccess',function(file,response){

            $('#img').attr('src',response.filename);
            $('#img_url').val(response.filename)
        })
    </script>
@stop