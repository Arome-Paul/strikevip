@extends('layouts.admin')
@section('content')
    <h2 class="font-bold text-lg p-3">Users ({{$users->count()}})</h2>

    <div class="w-full overflow-x-scroll px-2">
        <form action="{{route('search')}}" method="post" class="bg-white w-full p-3 py-5 my-3 ring-0 ring-offset-0 shadow-lg rounded-lg">
            @csrf
            <input type="search" name="search" placeholder="Search For User">
            <button class="bg-blue-800 p-2 px-4 text-white font-semibold rounded-lg transition-all hover:bg-opacity-80">Search</button>
        </form>
        @if($users->count() > 0)
            <table class="w-[1000px] md:w-full table bg-white ring-0 ring-offset-0 shadow-lg rounded-lg p-3 border-solid border-b-2 border-b-gray-300">
                <thead>
                    <tr class="flex w-full text-left py-3 border-solid border-b-2 border-opacity-50">
                        <th class="w-[5%] text-center">ID</th>
                        <th class="w-[25%] text-center">NAME</th>
                        <th class="w-[10%] text-center">STATUS</th>
                        <th class="w-[10%] text-center">STRUCTURE</th>
                        <th class="w-[20%] text-center">BANK DETAILS</th>
                        <th class="w-[15%] text-center">REFERRALS</th>
                        <th class="w-[15%] text-center">JOINED AT</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->count() > 0)
                        @for($i = 0; $i < count($users); $i++)
                            <tr class="flex w-full my-5 pb-3">
                                <td class="flex w-[5%] justify-center items-center font-semibold">{{$users[$i]->userid}}</td>
                                <td class="flex justify-center w-[25%]"><div><img src="{{url('storage/' . $users[$i]->profile_photo)}}" alt="user profile photo" class="w-[50px] h-[50px] float-left mr-2 rounded-full border-solid border-2 border-black"></div><div class="flex flex-wrap items-center"><span class="font-semibold capitalize w-full">{{$users[$i]->fullname}}</span><span class="w-full text-xs font-semibold">{{$users[$i]->email}}</span><span class="w-full text-xs font-semibold">{{$users[$i]->tel}}</span></div></td>
                                <td class="w-[10%] flex justify-center items-center"><span class="{{$users[$i]->status}} text-xs p-2 rounded-lg font-bold">{{$users[$i]->status}}</span></td>

                                
                                <td class="w-[10%] flex justify-center items-center font-semibold">
                                    @if($users[$i]->structure != null)
                                        <span class="{{$users[$i]->structure}} text-xs p-2 rounded-lg font-bold">VIP {{$users[$i]->structure}}</span>
                                    @else
                                        <span class="{{$users[$i]->structure}} text-xs p-2 rounded-lg font-bold">None</span>
                                    @endif
                                </td>
                                <td class="flex flex-wrap w-[20%]">
                                    @if($users[$i]->account_name == null || $users[$i]->account_number == null || $users[$i]->bank_name == null)
                                        <span class="font-semibold text-sm w-full text-center">{{'None'}}</span>
                                    @else
                                        <span class="font-semibold capitalize w-full text-center">{{$users[$i]->account_name}}</span>
                                        <span class="w-full text-xs text-center font-semibold">{{$users[$i]->account_number}}</span><span class="w-full text-center text-xs font-semibold capitalize">{{$users[$i]->bank_name}}</span>
                                    @endif
                                </td>
                                <td class="w-[15%] flex justify-center items-center font-semibold">{{$users[$i]->referees}}</td>
                                <td class="w-[15%] flex justify-center items-center">{{date('d-m-y', strtotime($users[$i]->created_at))}}</td>
                            </tr>
                        @endfor
                    @endif
                </tbody> 
            </table>
            <p class="py-3">{{$users->links()}}</p>
        @else
            <p class="capitalize flex items-center justify-center w-full text-2xl pt-16">No User</p>
        @endif
    </div>
    <hr class="clear-both invisible pb-20">
@endsection