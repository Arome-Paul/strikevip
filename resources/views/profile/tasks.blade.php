@extends('layouts.app')
@section('content')
    <h2 class="font-semibold m-3">Tasks {{$tasks->count()}}</h2>
        <div class="w-full p-3">
            @if($tasks->count() > 0)
                <div class="w-full md:w-3/5 md:float-left">
                    @for($i = 0; $i < count($tasks); $i++)
                        <div class="rounded-lg w-full p-3 my-3 bg-white ring-offset-0 ring-0 shadow-lg">
                            <div class="w-full my-2">
                                <div class="flex items-center pb-2"><div><img src="{{url('storage/logo/logo.png')}}" alt="User Profile pics" class="w-[50px] h-[50px] mr-2 bg-black float-left rounded-full"/></div><div><span class="capitalize block font-semibold">Strike Media</span><span class="text-xs font-semibold">Admin</span>
                                </div>
                                @if (date('d', strtotime($tasks[$i]->created_at)) === date('d', time()))
                                    <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>Today</span>
                                @elseif (date('d', time()) - date('d', strtotime($tasks[$i]->created_at)) == 1)
                                    <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>Yesterday</span>
                                @else
                                    <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>{{date('d-m-y', strtotime($tasks[$i]->created_at))}}</span>
                                @endif
                                </div>
                                <div class="font-semibold p-2 text-sm clear-both">{{$tasks[$i]->description}}</div>
                                <hr class="clear-both my-2">
                                <ul class="inline-flex nowrap items-center">
                                <li class="text-xs capitalize font-semibold">{{'Task Action: '}} <span class="text-md text-blue-700 font-bold bg-gray-200 p-2 rounded-md">{{$tasks[$i]->type}} On {{$tasks[$i]->sm}}</span></li>
                                    <li class="text-sm mx-3 capitalize font-bold bg-gray-200 p-2 rounded-md">NGN {{$tasks[$i]->amount}}</span></li>
                                </ul>
                                <a href="runningtask/{{$tasks[$i]->id}}" class="bg-blue-600 font-semibold    text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all duration-300 hover:bg-none hover:bg-blue-800 hover:shadow-xl">Run task</a><br class="clear-both">
                            </div>
                        </div>
                    @endfor
                    <p class="flex py-3 w-full">{{$tasks->links()}}</p>
                </div>
            @else
                <p class="capitalize flex items-center justify-center w-full text-2xl pt-16">There is no available task</p>
            @endif
            <div class="px-3 md:float-right md:h-[80vh] md:overflow-y-scroll md:ml-auto w-full md:w-2/5">
                <h2 class="block font-semibold">My Completed Tasks({{$completed->count()}})</h2>
                @if($completed->count() > 0)
                    <div class="w-full">
                        @for($j = 0; $j < count($completed); $j++)
                            <div class="blog w-full my-3 rounded-lg bg-white ring-offset-0 ring-0 shadow-lg">
                                <div class="p-3">
                                    <div class="flex w-full border-solid border-b-2 items-center"><span class="capitalize font-semibold">{{$completed[$j]->type}} On {{$completed[$j]->sm}}</span><span class="text-md font-semibold">(NGN {{$completed[$j]->amount}})</span>
                                        @if (date('d', strtotime($completed[$j]->created_at)) === date('d', time()))
                                            <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>Today</span>
                                        @elseif (date('d', time()) - date('d', strtotime($completed[$j]->created_at)) == 1)
                                            <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>Yesterday</span>
                                        @else
                                            <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>{{date('d-m-y', strtotime($completed[$j]->created_at))}}</span>
                                        @endif
                                    </div>
                                    <div class="font-semibold w-full py-2 text-sm clear-both">{{$completed[$j]->description}}</div>
                                </div>
                            </div>
                        @endfor
                    </div>
                @else
                    <p class="capitalize flex items-center font-bold mt-10 justify-center w-full text-2xl">No Completed Task</p>
                @endif
            </div>
        </div>
        <hr class="clear-both invisible pb-20">
@endsection