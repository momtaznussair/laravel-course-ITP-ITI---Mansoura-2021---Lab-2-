
    @extends('layouts.app')
    @section('title')
        All Post
    @endsection

    @section('custom-css')
        <style>
            h3{
                color: blue;
            }
            a{
                text-decoration: none;
            }
        </style>
    @endsection
        @section('content')
        <h1 class="d-inline-block">All Posts</h1>
        <a class="btn btn-primary ms-5 mb-3" href="{{url('posts/create')}}">Create a post</a>

        @guest
            <div class="alert alert-info">
                Please Log in to manage Posts.
            </div>
        @endguest
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Post title</th>
                    <th>Post slug</th>
                    <th>Posted By</th>
                    <th>Created At</th>
                    <th colspan="3">
                        Manage Post
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                <tr>
                    <td>{{$post->id}}</td>
                    <td>{{$post->title}}</td>
                    <td>{{$post->slug}}</td>
                    <td>
                        <a class="text-light" href="{{url("cats/{$post->user->id}")}}">{{$post->user->name}}</a>
                    </td>
                    <td>{{$post->created_at->format('d/m/Y')}}</td>
                    <td width = "30"><a href="{{url("posts/{$post->id}")}}"><button class="btn btn-info">View</button></a></td>
                    <td width = "30">
                        <a href="{{url("posts/edit/{$post->id}")}}"><button type="button"  class="btn btn-warning">Edit</button></a>
                    </td>
                    <td width = "30">
                        <button type="button"  data-bs-toggle="modal" data-bs-target="#modal{{$post->id}}" class="btn btn-danger">Delete</button>
                    </td>
                </tr>

                @include('layouts.delete')

                @endforeach
            </tbody>
          </table>
        
    {{$posts->links()}}
    @endsection