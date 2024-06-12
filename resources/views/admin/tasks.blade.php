@extends('layouts.admin')
@section('content')
    <h2 class="font-bold text-lg p-3">Tasks ({{$tasks->count()}})</h2>
    <ul class="flex nowrap px-2">
        <li><a href="{{route('admin.pending')}}" class="bg-blue-600 mx-2 font-semibold text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all duration-300 hover:bg-none hover:bg-blue-800 hover:shadow-xl">Pending Tasks ({{$pending->count()}})</a></li>
        <li><a href="{{route('admin.create_tasks')}}" class="bg-blue-600 font-semibold text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all duration-300 hover:bg-none hover:bg-blue-800 hover:shadow-xl"><i class="fa fa-plus pr-2"></i>Create Task</a></li>
    </ul>
    @if($tasks->count() > 0)
        @for($i = 0; $i < count($tasks); $i++)
            <div class="w-full p-3">
                <div class="w-full md:w-1/2 my-2">
                    <div class="rounded-lg w-full p-3 bg-white ring-offset-0 ring-0 shadow-lg">
                        <div class="w-full my-2">
                            <div class="flex items-center pb-2"><div><img src="{{url('storage/logo/logo.png')}}" alt="User Profile pics" class="w-[50px] h-[50px] mr-2 bg-black float-left rounded-full"/></div><div><span class="capitalize block font-semibold">Strike Media</span><span class="text-xs font-semibold">Admin</span>
                            @if($tasks[$i]->userid == Auth::user()->id)
                                <span class="text-xs font-semibold">(You)</span>
                            @endif
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
                            <ul class="flex flex-wrap md:nowrap items-center">
                                <li class="text-xs capitalize font-semibold">{{'Task Action: '}} <span class="text-md text-blue-700 font-bold bg-gray-200 p-2 rounded-md">{{$tasks[$i]->type}} On {{$tasks[$i]->sm}}</span></li>
                                <li class="text-sm mx-3 capitalize font-bold bg-gray-200 p-2 rounded-md">NGN {{$tasks[$i]->amount}}</span></li>
                                @if($tasks[$i]->userid == Auth::user()->id)
                                    <li class="text-xs capitalize font-semibold"><a href="edittask/{{$tasks[$i]->id}}" class="text-blue-600 px-2 font-semibold hover:underline hover:text-blue-800">Edit Task</a></li>
                                    <li class="text-xs capitalize font-semibold"><a href="deletetask/{{$tasks[$i]->id}}" class="text-blue-600 px-2 font-semibold hover:underline hover:text-blue-800">Remove Task</a></li>
                                @endif
                                <li class="text-xs capitalize font-semibold md:float-right md:ml-auto p-2 m-2"><a href="{{$tasks[$i]->link}}" class="bg-blue-600 text-xs py-2 px-4 rounded-full text-white transition-all duration-300 hover:bg-none hover:bg-blue-800 hover:shadow-xl">Run task</a><br class="clear-both"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endfor

        <p class="flex py-3 w-full">{{$tasks->links()}}</p>
    @else
        <p class="capitalize flex items-center justify-center w-full text-2xl pt-16">There is no available task</p>
    @endif
    <hr class="clear-both invisible pb-20">
@endsection