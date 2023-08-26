<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{

    // to enjoy authorisation before visibility
    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);
        // $followers = $user->profile->followers()->count();
        // dd($users);
        // dd($posts);
        return view('posts.index' , compact('posts'));
    }

    public function create()
    {
        // $user = User::findOrFail($user);
        // dump user on browser
        // dd(User::find($user));
        return view('posts.create');
    }

    public function store()
    {
        // validate the data passed into form that would be stored
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        // to upload file to local directory and get file path
        $imgPath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imgPath}"))->fit(1200, 1200);
        $image->save();

        // get the authenticated user and then post with that user id
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imgPath,
        ]);

        return redirect('/profile/'.auth()->user()->id);
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
