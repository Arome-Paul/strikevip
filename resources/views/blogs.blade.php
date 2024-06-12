@extends('layouts.guest')
@section('content')
<div class="w-full p-3">
    <div class="w-full md:w-2/3 md:h-screen md:overflow-scroll md:float-left">
        <h3 class="opacity-85 mb-1 font-semibold text-lg">Blogs</h3>
        <div class="rounded-lg w-full p-3 bg-white ring-offset-0 ring-0 shadow-lg">
            @if ($blogs->count() > 0)
                @for ($i = 0; $i<count($blogs); $i++)
                    <a href="{{'blogread/'}}{{$blogs[$i]->id}}/{{$blogs[$i]->title}}" class="w-full my-2 hover:opacity-75">
                        @if ($blogs[$i]->thumbnail != 'no thumb')
                            <img src="{{$url}}/{{$blogs[$i]->thumbnail}}" alt="{{$blogs[$i]->title}}" class="w-28 float-left mr-3">
                        @endif
                        <div>
                            <div class="font-semibold">{{$blogs[$i]->title}}</div>
                            <p class="py-2 opacity-75 text-sm font-semibold">
                            @if ($blogs[$i]->author == Auth::id())
                                   <span class="capitalize"><i class="fa fa-user m-1"></i>You</span>
                            @else
                            <span class="capitalize"><i class="fa fa-user m-1"></i>Admin</span>
                            @endif

                            @if (date('d', strtotime($blogs[$i]->created_at)) === date('d', time()))
                                <span><i class="fa fa-clock m-1"></i>Today</span>
                            @elseif (date('d', time()) - date('d', strtotime($blogs[$i]->created_at)) == 1)
                                <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                            @else
                                <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($blogs[$i]->created_at))}}</span>
                            @endif
                            <a href="{{'blogread/'}}{{$blogs[$i]->id}}/{{$blogs[$i]->title}}" class="hover:underline"><i class="fa fa-book-reader m-1"></i>Read Now</a></p>
                        </div>
                        <hr class="clear-both my-2">
                    </a>
                @endfor
                <p class="py-3">{{$blogs->links()}}</p>
            @else
                <p class="w-full opacity-70 text-center text-xl p-3 font-semibold">There is no blog post</p>
            @endif
        </div>
    </div>
    @if ($recent->count())
        <div class="w-full md:w-2/6 p-2 md:h-screen md:float-right md:ml-auto">
            <h3 class="opacity-85 mb-1 font-semibold text-lg">Most Recent</h3>
            @for ($k=0; $k < count($recent); $k++)
                <div class="bg-white rounded-lg mb-3 ring-offset-0 ring-0 shadow-lg ">   
                    <a href="{{'blogread/'}}{{$recent[$k]->id}}/{{$recent[$k]->title}}" class="block w-full hover:opacity-70">
                        @if ($recent[$k]->thumbnail != 'no thumb')
                            <img src="{{$url}}/{{$recent[$k]->thumbnail}}" alt="{{$recent[$k]->title}}" class="w-28 float-left mr-3">
                        @endif
                        <div>
                            <div class="font-semibold text-sm">{{$recent[$k]->title}}</div>
                            <p class="py-2 opacity-75 text-xs font-semibold">
                            @if ($recent[$k]->author == Auth::id())
                                   <span class="capitalize"><i class="fa fa-user m-1"></i>You</span>
                            @else
                            <span class="capitalize"><i class="fa fa-user m-1"></i>Admin</span>
                            @endif
                            @if (date('d', strtotime($recent[$k]->created_at)) === date('d', time()))
                                <span><i class="fa fa-clock m-1"></i>Today</span>
                            @elseif (date('d', time()) - date('d', strtotime($recent[$k]->created_at)) == 1)
                                <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                            @else
                                <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($recent[$k]->created_at))}}</span>
                            @endif
                            <a href="{{'blogpread/'}}{{$recent[$k]->id}}/{{$recent[$k]->title}}" class="inline hover:underline"><i class="fa fa-book-reader m-1"></i>Read Now</a></p>
                        </div>
                        <hr class="clear-both invisible">
                    </a>
                </div>
            @endfor
        </div>
    @endif
</div>
    <hr class="clear-both invisible pb-20">
@endsection