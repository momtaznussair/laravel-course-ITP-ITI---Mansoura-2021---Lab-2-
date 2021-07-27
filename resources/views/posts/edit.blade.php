@extends('layouts.app')

@section('title')
    Edit Post
@endsection

@section('content')
   @include('errors')
    <form action='{{ url("posts/update") }}' method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $post->id }}">
        <div class="mb-3">
            <label for="name" class="form-label">Title</label>
            <input type="text" name="title"  class="form-control" value="{{ $post->title }}">
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Description</label>
            <textarea name="desc" cols="30" rows="5" class="form-control">{{$post->description}}</textarea>
        </div>
        <div class="mb-3">
            <select name="user_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected disabled>Choose Creator ...</option>
                @foreach ($users as $user)

                    <option @if ($post->user_id == $user->id)   {{"selected"}}  @endif value="{{ $user->id }}">
                    {{ $user->name }}
                    </option>

                @endforeach
              </select>
              
        </div>
        <img class="mb-2" src="{{ asset("uploads/$post->img") }}" alt="{{ $post->name }}" height = "200">

        <div class="mb-3">
            <label for="img" class="form-label">Image</label>
            <input type="file" name="img" class="form-control">
        </div>
        <div class="text-center">
            <input type="submit" class="btn btn-primary">
            <button type="button"  data-bs-toggle="modal" data-bs-target="#modal{{$post->id}}" class="btn btn-danger">Delete</button>
        </div>
    </form>

    <a class="btn btn-light" href="{{ url('/posts')}} ">Back</a>
    
    @include('layouts.delete')
@endsection