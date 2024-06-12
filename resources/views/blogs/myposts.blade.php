@extends('layouts.app')
@section('content')
    <div class="block w-full p-3 pb-10 md:pb-3">
        <div class="block w-full md:w-2/3 md:h-screen md:float-left">
            @if(Auth::role() == "admin")
                <div class="text-sm opacity-85 my-5 font-semibold">
                    <a href="{{route('createblog')}}" class="rounded-full mr-5 bg-blue-800 p-2 text-white border-solid border-2 border-blue-800 ring-0 ring-offset-0 hover:shadow-lg hover:opacity-80 hover:bg-opacity-0 hover:text-blue-800"><i class="fa fa-pen m-1"></i>Create Post</a>
                    <a href="{{route('blogs')}}" class="rounded-full bg-none p-2 text-blue-800 border-solid border-2 border-blue-800 ring-0 ring-offset-0 hover:shadow-lg hover:opacity-80 hover:bg-blue-800 hover:text-white"><i class="fa fa-book m-1"></i>Blog Feeds</a>
                </div>
            @endif
            <h3 class="opacity-85 mb-1 font-semibold text-lg">My Blogs({{ $myblogs->count() }})</h3>
            @if ($myblogs->count() > 0)
                @for ($i=0; $i < count($myblogs); $i++)
                    <div class="rounded-lg w-full p-3 my-2 bg-white ring-offset-0 ring-0 shadow-lg">
                        <a href="{{'/blog/'}}{{$myblogs[$i]->id}}/{{$myblogs[$i]->title}}" class="w-full my-2 hover:opacity-75">
                            @if ($myblogs[$i]->thumbnail != 'no thumb')
                                <img src="{{$url}}/{{$myblogs[$i]->thumbnail}}" alt="{{$myblogs[$i]->title}}" class="w-28 float-left mr-3">
                            @endif
                            <div>
                                <div class="font-semibold">{{$myblogs[$i]->title}}</div>
                                <p class="py-2 opacity-75 text-sm font-semibold">
                                    @if (date('d', strtotime($myblogs[$i]->created_at)) === date('d', time()))
                                        <span><i class="fa fa-clock m-1"></i>Today</span>
                                    @elseif (date('d', time()) - date('d', strtotime($myblogs[$i]->created_at)) == 1)
                                        <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                                    @else
                                        <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($myblogs[$i]->created_at))}}</span>
                                    @endif
                                <a href="{{'/blog/'}}{{$myblogs[$i]->id}}/{{$myblogs[$i]->title}}" class="hover:underline mx-1"><i class="fa fa-book-reader m-1"></i>Open</a>
                                </p>
                            </div>
                            <hr class="clear-both my-2">
                        </a>
                    </div>
                @endfor
            @else
                <p class="w-full opacity-60 pt-10 text-center font-semibold text-xl">you don't have any post yet</p>
                <p class="opacity-60 w-full text-center"><a href="{{route('createblog')}}" class="hover:underline">create post</a></p>
            @endif

            @if (session('status') === 'blog-created')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="fixed transform bg-white rounded-lg p-10 font-bold bottom-1/2 left-1/2 text-xl text-gray-600 dark:text-gray-400"
                >{{ __('Blog created successfully') }}</p>
            @elseif (session('status') === 'blog-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="fixed transform bg-white rounded-lg p-10 font-bold bottom-1/2 left-1/2 text-xl text-gray-600 dark:text-gray-400"
                >{{ __('Blog updated successfully') }}</p>

            @elseif (session('status') === 'blog-exist')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="fixed transform bg-white rounded-lg p-10 font-bold bottom-1/2 left-1/2 text-xl text-gray-600 dark:text-gray-400"
                >{{ __('Blog exist') }}</p>
                        
            @elseif (session('status') === 'blog-delete')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="fixed transform bg-white rounded-lg p-10 font-bold bottom-1/2 left-1/2 text-xl text-gray-600 dark:text-gray-400"
                >{{ __('Blog Removed') }}</p>
            @endif
            
        </div>
    </div>
    <hr class="clear-both invisible mb-5">
@endsection