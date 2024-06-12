@extends('layouts.app')
@section('content')
<div class="w-full p-3">
        <div class="w-full md:w-2/3 md:float-left md:h-screen md:overflow-scroll">
            <div class="rounded-lg w-full p-3 bg-white ring-offset-0 ring-0 shadow-lg">
                <h1 class="text-xl font-bold w-full text-center p-3">{{$single->title}}</h1>
                <div>
                    <div class="float-left"><img src="{{url('storage/logo/logo.png')}}" class="w-[80px] h-[80px] bg-black rounded-full border-solid border-2"/></div>
                    <div class="pb-3">
                        <span class="block font-semibold w-full opacity-90"><i class="fa fa-user p-2"></i>{{$single->username}}</span>
                        <span class="block text-sm opacity-90"><i class="fa fa-clock p-2"></i>{{(date('d-m-y', strtotime($single->created_at)))}}</span>
                    </div>
                    @if ($single->thumbnail != 'no thumb')
                        <img src="{{$url}}/{{$single->thumbnail}}" alt="{{$single->title}}" class="w-full clear-both">
                    @endif
                    <div class="p-3 opacity-85 text-md font-sans w-full">
                        <p>{{$single->body}}</p>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="w-full opacity-85 my-2 font-semibold text-lg">More Posts</h2>
                <div class="ring-0 ring-offset-0 shadow-lg rounded-lg overflow-hidden mx-5 my-3 bg-white">
                    @if ($blogs->count() > 1)
                        @for ($i=0; $i < count($blogs); $i++)
                            @if ($single->id != $blogs[$i]->id)
                                <a href="blogpost/{{$blogs[$i]->title}}" class="my-2 hover:opacity-80">
                                    @if ($blogs[$i]->thumbnail != 'no thumb')
                                        <img src="{{$url}}/{{$blogs[$i]->thumbnail}}" alt="{{$blogs[$i]->title}}" class="w-full">
                                    @endif
                                    <div>
                                        <div class="font-semibold p-3">{{$blogs[$i]->title}}</div>
                                        <p class="px-3 opacity-75 text-xs font-bold"><span class="inline"><i class="fa fa-user m-1"></i>Author</span><a href="{{'blog/'}}{{$blogs[$i]->id}}/{{$blogs[$i]->title}}" class="inline hover:underline"><i class="fa fa-book-reader m-1"></i>Read Now</a></p>
                                    </div>
                                </a>
                            @endif
                        @endfor
                    @else
                    @endif
                </div>
            </div>
        </div>
        @if ($recent->count() > 1)
        <div class="w-full md:w-2/6 p-2 md:h-screen md:overflow-scroll md:float-right md:ml-auto">
            <h3 class="opacity-85 mb-1 font-semibold text-lg">Most Recent</h3>
            @for ($k=0; $k < count($recent); $k++)
                @if ($single->id != $recent[$k]->id)
                    <div class="bg-white rounded-lg mb-3 ring-offset-0 ring-0 shadow-lg ">   
                        <a href="{{}}" class="block w-full hover:opacity-70">
                            @if ($recent[$k]->thumbnail != 'no thumb')
                                <img src="{{$url}}/{{$recent[$k]->thumbnail}}" alt="{{$recent[$k]->title}}" class="w-28 float-left mr-3">
                            @endif
                            <div>
                                <div class="font-semibold text-sm">{{$recent[$k]->title}}</div>
                                <p class="py-2 opacity-75 text-xs font-semibold">
                                @if ($recent[$k]->author == Auth::id())
                                    <span class="capitalize"><i class="fa fa-user m-1"></i>You</span>
                                @else
                                <span class="capitalize"><i class="fa fa-user m-1"></i>{{$recent[$k]->username}}</span>
                                @endif
                                @if (date('d', strtotime($recent[$k]->created_at)) === date('d', time()))
                                        <span><i class="fa fa-clock m-1"></i>Today</span>
                                    @elseif (date('d', time()) - date('d', strtotime($recent[$k]->created_at)) == 1)
                                        <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                                    @else
                                        <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($recent[$k]->created_at))}}</span>
                                    @endif
                                <a href="#" class="inline hover:underline"><i class="fa fa-book-reader m-1"></i>Read Now</a></p>
                            </div>
                            <hr class="clear-both invisible">
                        </a>
                    </div>
                @endif
            @endfor
        </div>
    @else
    @endif
    </div>
    <hr class="clear-both invisible pb-20">
@endsection