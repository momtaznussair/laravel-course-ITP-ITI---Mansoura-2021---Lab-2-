@extends('layouts.app')
    @section('title')
        {{$keyword}}
    @endsection

    @section('content')
    <h1>Search result for "{{$keyword}}"</h1>
    <hr>
    @foreach ($posts as $post)
        <a href="{{url("posts/{$post->id}")}}">
            <h3>{{ $post->title }}</h3>
        </a>
        <p>{{ $post->description }}</p>
        <span>Created at: {{ $post->created_at->format('d/m/Y') }}</span>
        <hr>
    @endforeach

    <a href="{{ url('/posts')}} ">Back</a>
    @endsection
