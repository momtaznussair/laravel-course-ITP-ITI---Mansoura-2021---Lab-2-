@extends('layouts.app')

@section('title')
    Create a Post
@endsection

@section('content')
   @include('errors')
    <form action="{{ url('posts/store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Title</label>
            <input type="text" name="title"  class="form-control">
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label">Description</label>
            <textarea name="desc" cols="30" rows="5" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <select name="user_id" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example">
                <option selected disabled>Choose Creator Name ...</option>
                @foreach ($users as $user)

                    <option value="{{ $user->id }}">{{ $user->name }}</option>

                @endforeach
              </select>
              
        </div>
        
        <div class="mb-3">
            <label for="img" class="form-label">Image</label>
            <input type="file" name="img" class="form-control">
        </div>
        <div class="text-end">
            <input type="submit" class="btn btn-primary btn-block btn-lg">
        </div>
    </form>

    <a class="btn btn-light" href="{{ url('/posts')}} ">Back</a>

@endsection