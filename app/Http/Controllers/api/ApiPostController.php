<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;


class ApiPostController extends Controller
{
    public function index()
    {
        $posts = Post::get();

        // return response()->json($posts);

        return PostResource::collection($posts);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        return new PostResource($post);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255|min:3|unique:posts,title',
            'desc' => 'required|string|min:10',
            'img' => 'required|image|max:512|mimes:png,jpg',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails())
        {
            return Response::json($validator->errors());
        }

        $path = Storage::putFile('posts', $request->file('img'));
        Post::create([
            'title' => $request->title,
            'description' => $request->desc,
            'img' =>  $path,
            'user_id' => $request->user_id,
        ]);

        $data = [
            'msg' => "data Created successfully",
        ];

        return Response::json($data);

    }

    

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => "required|string|max:255|min:3|unique:posts,title, $request->id",
            'desc' => 'required|string|min:10',
            'img' => 'nullable|image|max:512|mimes:png,jpg',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails())
        {
            return Response::json($validator->errors());
        }

        $post = Post::findOrFail($request->id);
        $path = $post->img;

        if ($request->hasFile('img'))
        {
            Storage::delete("$path");
            $path = Storage::putFile('posts', $request->file('img'));
        }

        $post->update([
            'titlt' => $request->title,
            'description' => $request->desc,
            'img' => $path,
            'user_id'=> $request->user_id,
        ]);

        $data = [
            'msg' => "Post updated successfully"
        ];

        return Response::json($data);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Storage::delete($post->img);
        $post->delete();

        $data = [
            'msg' => "post deleted successfully"
        ];

        return Response::json($data);
    }

}
