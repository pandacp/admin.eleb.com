<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap 101 Template</title>
    @yield('css_files')
    <link href="/css/bootstrap.css" rel="stylesheet">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/js/jquery-3.2.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
    @yield('js_files')
</head>
<body>
@include('_nav')
<div class="container">
    @include('_message')
</div>

@yield('contents')


{{--<link href="/css/bootstrap.css" rel="stylesheet">--}}
{{--<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->--}}
{{--<script src="/js/jquery-3.2.1.js"></script>--}}
{{--<!-- Include all compiled plugins (below), or include individual files as needed -->--}}
{{--<script src="/js/bootstrap.min.js"></script>--}}
@yield('js')
@include('_footer')







