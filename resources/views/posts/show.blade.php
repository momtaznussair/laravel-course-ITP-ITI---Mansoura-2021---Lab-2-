@extends('layouts.app')
    @section('title')
        {{ $post->name }}
    @endsection

    @section('content')
    <h1>{{ $post->name }}</h1>
    <hr>
        <img src="{{ asset("uploads/$post->img") }}" height="300">
        <a class="text-decoration-none text-primary" href="{{ url("users/{$post->user->id}") }}">
            <h4 class="my-2">By: {{ $post->user->name }}</h4>
        </a>
        <p>{{ $post->description }}</p>
        <span>Created at: {{ $post->created_at->format('d/m/Y') }}</span>
        <hr>
        <a class="btn btn-dark" href="{{ url('/posts')}} ">Back</a>
        <button type="button"  data-bs-toggle="modal" data-bs-target="#modal{{$post->id}}" class="btn btn-danger">Delete Post</button>

        @include('layouts.delete')
    @endsection