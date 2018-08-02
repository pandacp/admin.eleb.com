@extends('default')

@section('contents')
    <div class="container" style="text-align: center">
        <h1>{{ $event->title }}</h1>
        <p>{!! $event->content !!}</p>
    </div>
@stop