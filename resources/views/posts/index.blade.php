@extends('layouts.app')

@section('content')
    <div class="container justify-content-center align-items-center vh-100">
        @foreach ($posts as $post)
        <div class="card mx-auto mt-5" style="max-width: 800px; max-height: 800px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-8 pb-3">
                        <img src="/storage/{{$post->image}}" alt="post" class="w-100"/>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        {{-- ====================== Top ========================== --}}
                        <div class="post-top-right">
                            {{-- <div class="card-body"> --}}
                                <a href="/profile/{{$post->user->id}}">
                                    <img src="{{$post->user->profile->profileImage()}}" alt="post" class="rounded-circle w-100" style="max-width: 50px"/>
                                </a>
                                <div class="ps-2" style="font-weight: bold;">
                                    <a href="/profile/{{$post->user->id}}" style="text-decoration: none">
                                        <span class="text-dark">
                                            {{$post->user->username}}
                                        </span>
                                    </a>
                                </div>
                                <div class="ps-2"><a href="#">Follow</a></div>
                            {{-- </div> --}}
                            </div>
                        {{-- ===================================== --}}
                        <hr/>
                        {{-- =================================== --}}
                        <div class="caption" style="overflow-y: scroll; max-height: 200px;">
                            <p>
                                {{$post->caption}}
                            </p>
                        </div>
                        {{-- ================== --}}
                        <hr/>
                        {{-- ===================== --}}
                        <div class="d-flex justify-content-between align-items-baseline">
                            <div class="d-flex">
                                <i class="fa-regular fa-heart"></i>
                                <i class="fa-regular fa-comment ps-2"></i>
                                <i class="fa-regular fa-paper-plane ps-2"></i>
                            </div>
                            <div class="">
                                <i class="fa-regular fa-bookmark"></i>
                            </div>
                        </div>
                        <div class=" "><strong>21</strong> Likes</div>
                        <div class=" ">8 days ago</div>

                        <hr/>

                        @cannot('update', $post->user->profile)
                        <div class=" "><strong>Login</strong> to like or comment</div>
                        @endcannot
                    </div>
                </div>
            </div>
        </div>
        @endforeach


        {{-- <div class="card">
        <div class="card-body"> --}}
        <div class="row pt-3">
            <div class="col-12 d-flex justify-content-center">
                {{$posts->links()}}
            </div>
        </div>
        {{-- </div>
        </div> --}}
    </div>
@endsection
