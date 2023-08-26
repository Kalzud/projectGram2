<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $followers = Cache::remember('count.followers.' . $user->id,
        now()->addSeconds(30), function () use ($user){
           return $user->profile->followers()->count();
        });

        $followings = Cache::remember('count.following.' . $user->id,
        now()->addSeconds(30), function () use ($user){
            return $user->following->count();
        });

        $postsCount = Cache::remember('count.posts.' . $user->id,
        now()->addSeconds(30), function () use ($user){
            return $user->posts->count();
        });

        // dd($followers);
        return view('profiles.index' , compact('user', 'follows', 'followers', 'followings', 'postsCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles.edit' , compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        if(request('image')){
            $imgPath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imgPath}"))->fit(1000, 1000);
            $image->save();
            $imgArray = ['image' => $imgPath];
        }



        auth()->user()->profile->update(array_merge($data, $imgArray ?? []));
        return redirect("/profile/{$user->id}");
    }
}
