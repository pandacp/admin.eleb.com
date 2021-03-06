@extends('default')
@section('css_files')
    <link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
@stop

@section('js_files')
    <script type="text/javascript" src="/webuploader/webuploader.js"></script>
    @include('vendor.ueditor.assets')

@stop
@section('contents')
    @include('_error')
    <div class="container">
        <form action="{{ route('event_prizes.store') }}" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">奖品名称</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="奖品名称" value="{{ old('name') }}">
            </div>

            <div class="form-group">

                <label for="exampleInputEmail1">所属活动</label><span style="color:red">(必选)</span><br>
                <select name="events_id" id="" >
                    @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1" >奖品详情</label>
            <!-- 编辑器容器 -->
            <script id="container" name="description" type="text/plain"></script>
            </div>
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">添加奖品</button>
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
        });
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@stop

