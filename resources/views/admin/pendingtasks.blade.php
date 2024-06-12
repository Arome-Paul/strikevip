@extends('layouts.admin')
@section('content')
    <h2 class="font-bold text-lg p-3">Pending Tasks ({{count($pending)}})</h2>
    <div class="w-full overflow-x-scroll md:overflow-auto">
        @if($tasks->count() > 0)
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
                    @for($i = 0; $i < count($tasks); $i++)
                        <tr class="flex w-full my-5 pb-3 border-solid border-b-2">
                            <td class="flex w-[10%] justify-center items-center font-semibold">{{$tasks[$i]->userid}}</td>
                            <td class="flex justify-center items-center w-[20%]"><div class="flex flex-wrap pl-2 items-center"><span class="font-semibold capitalize w-full">{{$tasks[$i]->fullname}}</span><div><span class="w-full text-sm font-semibold capitalize px-1">fb: {{$tasks[$i]->facebook}} </span><span class="w-full text-sm font-semibold px-1">whatsapp: {{$tasks[$i]->whatsapp}}</span><span class="w-full text-sm font-semibold capitalize px-1">X: {{$tasks[$i]->x}}</span><span class="w-full text-sm font-semibold px-1">Telegram: {{$tasks[$i]->telegram}}</span></div></div></td>
                            <td class="w-[20%] flex justify-center items-center"><span class="text-sm p-2 rounded-lg font-semibold">{{$tasks[$i]->description}}</span></td>
                            <td class="flex flex-wrap w-[20%]"><span class="font-semibold capitalize w-full text-center">{{$tasks[$i]->type}} on {{$tasks[$i]->sm}}</span><span class="w-full text-sm text-center font-semibold"><a href="{{$tasks[$i]->link}}" class="bg-blue-600 text-xs py-2 px-4 rounded-full text-white transition-all mx-2 duration-300 hover:bg-none font-semibold hover:bg-blue-800 hover:shadow-xl">Check Task</a></span>
                            </td>
                            <td class="w-[15%] flex justify-center items-center font-semibold"><strike>N</strike>{{$tasks[$i]->amount}}
                            </td>
                            <td class="w-[10%] flex justify-center items-center"><a href="{{route('approve.task', ['id' => $tasks[$i]->id])}}" class="bg-green-600 text-xs py-2 px-4 rounded-full text-white transition-all mx-2 duration-300 hover:bg-none font-semibold hover:bg-green-800 hover:shadow-xl">Approve</a><a href="{{route('decline.task', ['id' => $tasks[$i]->id])}}" class="bg-red-600 text-xs py-2 px-4 rounded-full text-white transition-all mx-2 duration-300 hover:bg-none font-semibold hover:bg-red-800 hover:shadow-xl">Remove</a></td>
                        </tr>
                    @endfor
                </tbody> 
            </table>
        @else
            <p class="capitalize flex items-center justify-center w-full text-2xl pt-16">No Pending Tasks</p>
        @endif
        <p class="flex py-3 w-full">{{$tasks->links()}}</p>
    </div>

    <hr class="clear-both invisible pb-20">
@endsection