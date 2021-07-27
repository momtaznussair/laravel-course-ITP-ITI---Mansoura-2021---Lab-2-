@extends('layouts.app')
    @section('title')
        {{ $user->name }}
    @endsection

    @section('content')
    <h1>{{ $user->name }}</h1>
    <hr>
        <h5>Email: {{$user->email}}</h5>
        <span>Created at: {{ $user->created_at->format('d/m/Y') }}</span>
        <hr>
        <h3>Posts:</h3>
        <ul>
            @foreach ($user->posts as $post)
            <a href="{{ url("books/{$post->id}") }}">
                <li>{{$post->title}}</li>
            </a>
            @endforeach
        </ul>   

        <a class="btn btn-info ms-3" href="{{ url('/posts')}} ">All Posts</a>
    @endsection