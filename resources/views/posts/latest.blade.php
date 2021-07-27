@extends('layouts.app')
    @section('title')
        Latest Posts
    @endsection

    @section('content')
    <h1>Latest Posts</h1>
    <hr>
    @foreach ($latest as $post)
        <a href='{{url("/posts/{$post->id}")}}'>
            <h3>{{ $post->name }}</h3>
        </a>
        <p>{{ $post->description }}</p>
        <span>Created at: {{ $post->created_at->format('d/m/Y') }}</span>
        <hr>
    @endforeach

     <a href="{{ url('/posts')}} ">Back</a>
     @endsection
</body>
</html>