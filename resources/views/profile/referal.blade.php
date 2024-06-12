@extends('layouts.app')
@section('content')
<div class="flex flex-wrap w-full p-3 rounded-lg my-5">
    <h2 class="w-full font-bold text-xl text-black p-2">Referees({{$referees->count()}})</h2>
    <div class="w-full md:w-1/2 text-center p-3">
        <ul class="m-1">
            @if ($referees->count() > 0)
                @for ($i = 0; $i < count($referees); $i++)
                        <li class="flex flex-nowrap items-center text-sm p-2 border-solid border-b-[1px] border-b-black">
                            <span><img src="{{$link}}/{{$referees[$i]->profile_photo}}" alt="{{$referees[$i]->username}} Profile photo" class="w-[50px] h-[50px] rounded-full"></span>
                            <div class="opacity-70"><span class="block w-full mx-1 text-xl capitalize font-bold">{{$referees[$i]->username}}</span><span class="w-full"></span></div>
                            <span class="float-right opacity-70 ml-auto">Join on {{date('d-m-y', strtotime($referees[$i]->created_at))}}</span>
                        </li>
                @endfor
            @else
                <h3 class="block text-center font-semibold opacity-40 p-5 text-3xl ">No Referee</h3>
                <p class="block p-5 text-center font-semibold opacity-40">You haven't done any referal</p>
            @endif
        </ul>
        <p class="py-3">{{$referees->links()}}</p>
    </div>
    <div class="block my-3 p-3 rounded-lg w-full md:w-1/2 bg-white ring-offset-0 ring-0 shadow-lg">
        <h3 class="font-semibold">Top 10 Users</h3>
        <p class="text-sm">Your Referral Count: {{$referees->count()}}</p>
        <table class="w-full mb-10 md:mb-0 my-4">
            <tr class="bg-white opacity-80">
                <th class="font-semibold">RANK</th>
                <th class="font-semibold">USERNAME</th>
                <th class="font-semibold">REFERRALS</th>
            </tr>
            @if ($refs->count() > 0)
                @for ($k = 0; $k < count($refs); $k++)
                <tr class="opacity-80">
                    <td class="py-1 text-center">{{$k + 1}}</td>
                    <td class="py-1 text-center capitalize">{{$refs[$k]->username}}</td>
                    <td class="py-1 text-center font-semibold">{{$refs[$k]->referees}}</td>
                </tr>
                @endfor
            @endif
        </table>
    </div>
</div>
<hr class="clear-both invisible pb-20">
@endsection