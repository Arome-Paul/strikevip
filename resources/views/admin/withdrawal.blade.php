@extends('layouts.admin')
@section('content')
    <h2 class="font-bold text-lg p-3">Pending Withdrawals({{$withdrawals->count()}})</h2>
    <div class="overflow-x-scroll px-2">
        @if($withdrawals->count() > 0)
            <table class="w-[1000px] md:w-full table bg-white ring-0 ring-offset-0 shadow-lg rounded-lg p-3 border-solid border-b-2 border-b-gray-300">
                <thead>
                    <tr class="flex w-full text-left py-3 border-solid border-b-2 border-opacity-50">
                        <th class="w-[5%] text-center">ID</th>
                        <th class="w-[25%] text-center">NAME</th>
                        <th class="w-[10%] text-center">WALLET</th>
                        <th class="w-[10%] text-center">AMOUNT(<strike>N</strike>)</th>
                        <th class="w-[20%] text-center">BANK DETAILS</th>
                        <th class="w-[10%] text-center">TIME</th>
                        <th class="w-[20%] text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($withdrawals); $i++)
                        <tr class="flex w-full my-5 pb-3">
                            <td class="flex w-[5%] justify-center items-center font-semibold">{{$withdrawals[$i]->userid}}</td>
                            <td class="flex w-[25%]"><div><img src="{{url('storage/' . $withdrawals[$i]->profile_photo)}}" alt="user profile photo" class="w-[50px] h-[50px] float-left mr-2 rounded-full border-solid border-2 border-black"></div><div class="flex flex-wrap items-center"><span class="font-semibold capitalize w-full">{{$withdrawals[$i]->fullname}}</span></div></td>
                            <td class="w-[10%] flex justify-center items-center"><span class="text-md p-2 rounded-lg font-bold">{{$withdrawals[$i]->wallet}}</span></td>
                            <td class="w-[10%] flex justify-center items-center font-semibold">{{$withdrawals[$i]->amount}}
                            </td>
                            <td class="flex flex-wrap w-[20%]">
                                @if($withdrawals[$i]->account_name == null || $withdrawals[$i]->account_number == null || $withdrawals[$i]->bank_name == null)
                                    <span class="font-semibold text-sm w-full text-center">{{'None'}}</span>
                                @else
                                    <span class="font-semibold capitalize w-full text-center">{{$withdrawals[$i]->account_name}}</span>
                                    <span class="w-full text-xs text-center font-semibold">{{$withdrawals[$i]->account_number}}</span><span class="w-full text-center text-xs font-semibold capitalize">{{$withdrawals[$i]->bank_name}}</span>
                                @endif
                            </td>
                            <td class="w-[10%] flex justify-center items-center">{{date('d-m-y', strtotime($withdrawals[$i]->created_at))}}</td>
                            <td class="w-[20%] flex justify-center items-center"><a href="{{route('withdrawal.approve', ['id' => $withdrawals[$i]->id])}}" class="bg-green-600 text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all mx-2 duration-200 hover:bg-none font-semibold hover:bg-green-800 hover:shadow-xl">Approve</a><a href="{{route('withdrawal.decline', ['id' => $withdrawals[$i]->id])}}" class="bg-red-600 text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all mx-2 duration-200 hover:bg-none font-semibold hover:bg-red-800 hover:shadow-xl">Decline</a></td>
                        </tr>
                    @endfor
                </tbody> 
            <p class="flex py-3 w-full">{{$withdrawals->links()}}</p>
            </table>
            <p class="flex py-3 w-full">{{$withdrawals->links()}}</p>
        @else
            <tr><td><p class="capitalize flex items-center justify-center w-full text-2xl pt-16">No Pending Withdrawals!</p></td></tr>
        @endif
        <hr class="clear-both invisible mb-5">
    </div>
    <hr class="clear-both invisible pb-20">
@endsection