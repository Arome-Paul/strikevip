
@extends('layouts.app')
@section('content')
    <div class="flex flex-wrap w-full border-solid border-2 md:flex-nowrap">
        <div class="bg-blue-800 text-white shadow-black ring-offset-0 ring-0 shadow-sm rounded-lg w-full m-2 md:w-3/12">
            <div class="w-full text-center">Rank</div>
            <div class="font-bold mt-24 w-full text-center">Novice</div>
        </div>
        <div class="w-full md:w-3/12 m-2 bg-black text-white shadow-black ring-offset-0 ring-0 shadow-sm rounded-lg p-4">
            <div class="w-1/2 mb-2"><img src="{{url('storage/logo/logo.png')}}" class="w-[80px] " alt="Strikevip logo"></div>
            <div>Structure</div>
            @if($details->structure == null)
                <div class=" my-2 font-bold">No Investment Strucure!</div>
                <a href="{{route('profile.edit')}}" class="text-sm p-2 rounded-lg bg-white bg-opacity-20 transition-all duration-300 hover:underline hover:bg-opacity-40">Updated Structure</a>
            @else
                <div class="mt-2 font-bold">VIP {{$details->structure}}</div>
            @endif
        </div>
        <div class="flex flex-wrap w-full shadow-black ring-offset-0 ring-0 shadow-sm md:w-1/2 p-5 m-2 rounded-lg bg-blue-300">
            <div class="w-1/2 p-2">
                <i class="fa fa-users bg-white text-blue-800 text-xl p-3 rounded-full float-left"></i>
                <div class="pl-3 float-left"><span class="block">Affiliate Balance</span><span class="block font-bold"><strike>N</strike>{{ $balance->affiliate_balance }}</span></div>
            </div>
            <div class="w-1/2 p-2">
                <i class="fa fa-toolbox bg-white text-blue-800 text-xl p-3 px-4 rounded-full float-left"></i>
                <div class="pl-3 float-left"><span class="block">Task Balance</span><span class="block font-bold"><strike>N</strike>{{ $balance->task_balance }}</span></div>
            </div>
            <div class="w-1/2 p-2">
                <i class="fa fa-user-plus bg-white text-blue-800 text-xl p-3 rounded-full float-left"></i>
                <div class="pl-3 float-left"><span class="block">Referees</span><span class="block font-bold">{{ $details->referees }}</span></div>
            </div>
            <div class="w-1/2 p-2">
                <i class="fa fa-tools bg-white text-blue-800 text-xl p-3 px-4 rounded-full float-left"></i>
                <div class="pl-3 float-left"><span class="block">Total Tasks</span><span class="block font-bold">{{ $tasks->count() }}</span></div>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap md:flex-nowrap w-full mt-5">
        <div class="w-full md:w-1/2 pl-3">
            @if (session('status') === 'registered')
                <div class="w-full p-3 rounded-lg my-5 bg-white">
                    <p>Welcome! kindly setup your profile <a href="{{route('profile.edit')}}" class="text-blue-800 hover:underline ">Profile setup</a></p>
                </div>
            @endif
            <div>
                <p class="my-1">Invite Others</p>
                <form action="#" class="flex flex-nowrap overflow-hidden rounded-lg w-full border-solid border-2 border-blue-700">
                    <input type="url" id="copyRef" disabled name="invite" value="{{route('register')}}/{{ $details->referer_code }}" class="w-[80%] outline-none p-3">
                    <button id="copy" class="w-1/5 bg-blue-700 text-white hover:bg-blue-500 font-semibold"> Copy</button>
                </form>
                <!-- <p class="text-[rgba(0,0,0,0.4)] text-sm my-1">Stand a chance to win NGN00000 when you invite a friend</p> -->
            </div>
            <div class="w-full p-3 rounded-lg my-5">
                <h2 class="w-full font-bold text-xl text-black border-solid border-b-2 border-b-blue-950 p-2">Referees</h2>
                <div class="w-full text-center">
                    <ul class="m-1">
                        @if ($referees->count() > 0)
                            @for ($i = 0; $i < count($referees); $i++)
                                    <li class="flex flex-nowrap text-sm p-2 border-solid border-b-[1px] border-b-black">
                                        <span><img src="{{$link}}/{{$referees[$i]->profile_photo}}" alt="{{$referees[$i]->username}} Profile photo" class="w-[50px] h-[50px] rounded-full"></span>
                                        <div class="opacity-70"><span class="block w-full mx-1 text-xl capitalize font-bold">{{$referees[$i]->username}}</span><span class="w-full"></span></div>
                                        <span class="float-right opacity-70 ml-auto font-bold">Join on {{$referees[$i]->created_at}}</span>
                                    </li>
                            @endfor
                            <a href="{{route('referal')}}" class="text-blue-800 hover:underline p-2 text-sm font-semibold">view more</a>
                        @else
                            <h3 class="block text-center font-semibold opacity-40 p-5 text-3xl ">No Referee</h3>
                            <p class="block p-5 text-center font-semibold opacity-40">You haven't done any referal</p>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="w-full mb-10 md:mb-0 md:w-1/2 p-4">
            <h2 class="w-full font-bold text-xl text-black border-solid border-b-2 border-b-blue-950 p-2">Transations</h2>
            <ul class="m-1">
                @if ($transactions->count() > 0)
                    @foreach ($transactions as $transactions)
                        <li class="flex flex-nowrap align-middle text-sm p-2 border-solid border-b-[1px] border-b-black">
                            <span class=""><i class="fa fa-check bg-green-700 rounded-full m-2 text-white p-1"></i></span>
                            <div class="opacity-70 border-solid border-2 block w-full font-bold">{{ $transactions->transaction_name }}<span class="block w-full">
                                @if (date('d', strtotime($transactions->created_at)) === date('d', time()))
                                <span><i class="fa fa-clock m-1"></i>Today</span>
                                @elseif (date('d', time()) - date('d', strtotime($transactions->created_at)) == 1)
                                <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                                @else
                                <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($transactions->created_at))}}</span>
                                @endif</span>
                            </div>
                                <span class="float-right opacity-70 ml-auto"><strike>N</strike>{{$transactions->amount_earned}}</span>
                        </li>
                    @endforeach
                        <a href="{{route('transaction')}}" class="text-blue-800 hover:underline p-2 text-sm font-semibold">view more</a>
                    @else
                        <h3 class="block text-center font-semibold opacity-40 p-5 text-3xl ">No Transaction</h3>
                        <p class="block p-5 text-center font-semibold opacity-40">You have done no transaction so far</p>
                @endif
            </ul>
        </div>
    </div>
    <hr class="clear-both invisible pb-20">
    <script>
        window.onload = function(){
            
        };
    </script>
@endsection