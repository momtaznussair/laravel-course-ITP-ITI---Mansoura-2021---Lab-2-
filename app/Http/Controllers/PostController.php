<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->paginate(3);
        // dd($posts);
        return view('posts.index', ['posts' => $posts]);
    }
    public function latest()
    {
        // SELECT * FROM posts ORDER BY created_at DESC LIMIT 3;
        $latest = Post::select()->orderBy('id', 'DESC')->take(3)->get();
        // dd($latest);
        return view('posts.latest', ['latest' => $latest]);
    }

    public function show($id)
    {
        // $book = Book::select()->where('id', '=', $id)->first();
        $post = Post::select()->findOrFail($id);
        return view('posts.show', ['post' => $post]);
    }
    
    public function validateSearch(Request $request)
    {
        $keyword = $request->keyword;
        return redirect(url("posts/search/$keyword"));
    }

    public function search($keyword)
    {
        // SELECT * FROM posts WHERE name LIKE '%$kw';
        $posts = Post::select()->where('title', 'LIKE', "%$keyword%")->get();
        // dd($posts);
        return view('posts.search', ['posts' => $posts, 'keyword' => $keyword]);
    }

    public function create()
    {
        $users = User::select('id', 'name')->get();

        return view('posts.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|min:3|unique:posts,title',
            'desc' => 'required|string|min:10',
            'img' => 'required|image|max:512|mimes:png,jpg',
            'user_id' => 'required|exists:users,id',
        ]);

        $path = Storage::putFile('posts', $request->file('img'));
        Post::create([
            'title' => $request->title,
            'description' => $request->desc,
            'img' =>  $path,
            'user_id' => $request->user_id,
        ]);

        return redirect(url('posts'));
    }

    public function edit($id)
    {
        $users = User::select('id', 'name')->get();
        $post = Post::findOrFail($id);
        return view('posts.edit', ['post' => $post, 'users' => $users]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => "required|string|max:255|min:3|unique:posts,title, $request->id",
            'desc' => 'required|string|min:10',
            'img' => 'nullable|image|max:512|mimes:png,jpg',
            'user_id' => 'required|exists:users,id',
        ]);
       
        $post = Post::findOrFail($request->id);
        $path = $post->img;

        if ($request->hasFile('img'))
        {
            Storage::delete("$path");
            $path = Storage::putFile('posts', $request->file('img'));
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->desc,
            'img' => $path,
            'user_id'=> $request->user_id,
        ]);

        return back();
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        Storage::delete($post->img);
        $post->delete();

        return redirect('posts');
    }
}
