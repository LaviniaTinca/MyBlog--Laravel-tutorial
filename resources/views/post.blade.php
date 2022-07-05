@extends('layout')

@section('content')
<article>
        <h1>{{$post->title}}</h1>
        <div>
             {!!$post->body!!} <!-- we want this as html-->
        </div>
    </article>
    <a href="/">Go Back</a>
@endsection
