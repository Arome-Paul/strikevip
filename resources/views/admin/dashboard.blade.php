@extends('layouts.admin')
@section('content')
    <h2 class="font-bold text-lg p-3">Admin Dashboard</h2>
    <div>
        <ul class="flex flex-wrap md:flex-nowrap p-3 w-full">
            <li class="w-full md:w-[22%] m-3 md:m-[1%] bg-white flex ring-0 ring-offset-0 shadow-lg items-center rounded-lg py-10 px-4"><i class="fa fa-users text-5xl"></i><div class="flex-wrap px-2 w-full font-semibold"><Span class="text-lg">Total Users</Span><span class="block w-full"><span class="font-bold text-2xl">{{$users->count()}}</span><a href="{{route('admin.users')}}" class="float-right ml-auto text-blue-600 transition-all ring-0 ring-offset-0 text-md hover:text-blue-800 hover:shadow-lg">see all <i class="fa fa-arrow-right"></i></a></span></div></li>
            <li class="w-full md:w-[22%] m-[1%] bg-white flex ring-0 ring-offset-0 shadow-lg items-center rounded-lg py-10 px-4"><i class="fa fa-hammer text-5xl"></i><div class="flex-wrap px-2 w-full font-semibold"><Span class="text-lg">Tasks Completed</Span><span class="block w-full"><span class="font-bold text-2xl">{{$tasks->count()}}</span><a href="{{route('admin.tasks')}}" class="float-right ml-auto text-blue-600 transition-all ring-0 ring-offset-0 text-md hover:text-blue-800 hover:shadow-lg">see tasks <i class="fa fa-arrow-right"></i></a></span></div></li>
            <li class="w-full md:w-[22%] m-[1%] bg-white flex ring-0 ring-offset-0 shadow-lg items-center rounded-lg py-10 px-4"><i class="fa fa-money-check text-5xl"></i><div class="flex-wrap px-2 w-full font-semibold"><Span class="text-lg">Pending Payouts</Span><span class="block w-full"><span class="font-bold text-2xl">{{$withdrawals->count()}}</span><a href="{{route('pending.withdrawal')}}" class="float-right ml-auto text-blue-600 transition-all ring-0 ring-offset-0 text-md hover:text-blue-800 hover:shadow-lg">see all <i class="fa fa-arrow-right"></i></a></span></div></li>
            <li class="w-full md:w-[22%] m-[1%] bg-white flex ring-0 ring-offset-0 shadow-lg items-center rounded-lg py-10 px-4"><i class="fa fa-comment text-5xl"></i><div class="flex-wrap px-2 w-full font-semibold"><Span class="text-lg">Blogs Public</Span><span class="block w-full"><span class="font-bold text-2xl">{{$blogs->count()}}</span><a href="{{route('blogs')}}" class="float-right ml-auto text-blue-600 transition-all ring-0 ring-offset-0 text-md hover:text-blue-800 hover:shadow-lg">see all <i class="fa fa-arrow-right"></i></a></span></div></li>
        </ul>
    </div>
    <div class="flex flex-wrap w-full mt-5">
        <div class="w-full md:w-1/2 pl-3">
            <div class="w-full p-3 rounded-lg my-5">
                <h2 class="w-full font-bold text-xl text-black border-solid border-b-2 p-2">Joined Today ({{$today->count()}})</h2>
                <div class="w-full">
                    <ul class="m-1">
                        @if($today->count() > 0)
                            @for($i = 0; $i < count($today); $i++)
                                <li class="flex flex-nowrap items-center text-sm p-2 border-solid border-b-[1px] border-b-black">
                                    <span><img src="{{url('storage/' . $today[$i]->profile_photo)}}" alt="username Profile photo" class="w-[50px] h-[50px] rounded-full"></span>
                                    <div class="opacity-70"><span class="block w-full mx-1 text-xl capitalize font-bold">{{$today[$i]->username}}</span><span class="w-full"></span></div>
                                    <span class="float-right opacity-70 ml-auto font-bold">{{date('h:m', strtotime($today[$i]->created_at))}}</span>
                                </li>
                            @endfor
                            <a href="{{route('admin.users')}}" class="text-blue-800 text-left hover:underline p-2 text-sm font-semibold">view more</a>
                        @else
                            <p class="block p-5 text-center font-semibold opacity-40">No New User For The Day</p>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="w-full p-4">
            <h2 class="w-full font-bold text-xl text-black border-solid border-b-2 p-2">Pending Tasks ({{$pending_tasks->count()}})</h2>
            @if($pending_tasks->count() > 0)
                <table class="w-[1000px] md:w-full table bg-white ring-0 ring-offset-0 shadow-lg rounded-lg p-3 border-solid border-b-2 border-b-gray-300">
                    <thead>
                        <tr class="flex w-full py-3 TEXT-LG border-solid border-b-2 border-opacity-50">
                            <th class="w-[10%] text-center px-2">USERID</th>
                            <th class="w-[20%] text-center">USER (SOCIAL MEDIA)</th>
                            <th class="w-[20%] text-center">DESCRIPTION</th>
                            <th class="w-[20%] text-center">TASK</th>
                            <th class="w-[15%] text-center">AMOUNT(<strike>N</strike>)</th>
                            <th class="w-[10%] text-center">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for($j = 0; $j < count($pending_tasks); $j++)
                            <tr class="flex w-full my-5 pb-3 border-solid border-b-2">
                                <td class="flex w-[10%] justify-center items-center font-semibold">{{$pending_tasks[$j]->userid}}</td>
                                <td class="flex justify-center items-center w-[20%]"><div class="flex flex-wrap pl-2 items-center"><span class="font-semibold capitalize w-full">{{$pending_tasks[$j]->fullname}}</span><div><span class="w-full text-sm font-semibold capitalize px-1">fb: {{$pending_tasks[$j]->facebook}} </span><span class="w-full text-sm font-semibold px-1">whatsapp: {{$pending_tasks[$j]->whatsapp}}</span><span class="w-full text-sm font-semibold capitalize px-1">X: {{$pending_tasks[$j]->x}}</span><span class="w-full text-sm font-semibold px-1">Telegram: {{$pending_tasks[$j]->telegram}}</span></div></div></td>
                                <td class="w-[20%] flex justify-center items-center"><span class="text-sm p-2 rounded-lg font-semibold">{{$pending_tasks[$j]->description}}</span></td>
                                <td class="flex flex-wrap w-[20%]"><span class="font-semibold capitalize w-full text-center">{{$pending_tasks[$j]->type}} on {{$pending_tasks[$j]->sm}}</span><span class="w-full text-sm text-center font-semibold"><a href="{{$pending_tasks[$j]->link}}" class="bg-blue-600 text-xs py-2 px-4 rounded-full text-white transition-all mx-2 duration-300 hover:bg-none font-semibold hover:bg-blue-800 hover:shadow-xl">Check Task</a></span>
                                </td>
                                <td class="w-[15%] flex justify-center items-center font-semibold"><strike>N</strike>{{$pending_tasks[$j]->amount}}
                                </td>
                                <td class="w-[10%] flex justify-center items-center"><a href="{{route('approve.task', ['id' => $pending_tasks[$j]->id])}}" class="bg-green-600 text-xs py-2 px-4 rounded-full text-white transition-all mx-2 duration-300 hover:bg-none font-semibold hover:bg-green-800 hover:shadow-xl">Approve</a><a href="{{route('decline.task', ['id' => $pending_tasks[$j]->id])}}" class="bg-red-600 text-xs py-2 px-4 rounded-full text-white transition-all mx-2 duration-300 hover:bg-none font-semibold hover:bg-red-800 hover:shadow-xl">Remove</a></td>
                            </tr>
                        @endfor
                    </tbody> 
                    <a href="{{route('admin.pending')}}" class="text-blue-800 hover:underline p-2 text-sm font-semibold">see all</a>
                </table>
            @else
                <p class="capitalize flex items-center justify-center w-full text-2xl pt-16">No Pending Tasks</p>
            @endif
        </div>
    </div>
    <hr class="clear-both invisible pb-20">
@endsection