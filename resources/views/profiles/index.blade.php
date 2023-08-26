@extends('layouts.app')

@section('content')
<div class="container">
    {{-- ==========================================top===================================== --}}
        <div class="row">
            <div class="col-3 p-5"><img src="{{$user->profile->profileImage()}}" alt="profile image" class="rounded-circle w-100"/></div>
            <div class="col-9">
                <div class="d-flex justify-content-between align-items-baseline">
                    <div class="d-flex align-items-center pb-3">
                        <h1 class="mt-2">{{$user->username}}</h1>
                        @cannot('update', $user->profile)
                        <div id="follow-button-container" user-id="{{$user->id}}" follows="{{ $follows }}" followers="{{$followers}}"></div>
                        @endcannot
                    </div>
                    @can('update', $user->profile)
                        <a href="/post/create" style="text-decoration: none">POST <i class="fa-solid fa-plus fa-lg"></i></a>
                    @endcan
                </div>
                @can('update', $user->profile)
                    <div class=""><a href="/profile/{{$user->id}}/edit" style="text-decoration: none">Edit profile</a></div>
                @endcan
                <div class="d-flex">
                    <div class="pe-4"><strong>{{ $postsCount }}</strong> posts</div>
                    <div class="pe-4" id="followers-count"><strong>{{ $followers }}</strong> followers</div>
                    <div class="pe-4"><strong>{{ $followings }}</strong> following</div>
                </div>
                <div class="pt-4"><p class="mb-0 fw-bold">{{$user->profile->title}}</p></div>
                <div>{{$user->profile->description}}</div>
                <div><a href="#">{{$user->profile->url}}</a></div>
            </div>
        </div>

        {{-- ================================================== posts========================================= --}}
        <div class="row pt-5">
            @foreach ($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/post/{{$post->id}}">
                    <img src="/storage/{{$post->image}}" alt="post" class="w-100">
                </a>
            </div>
            @endforeach
        </div>
</div>
@endsection
