@extends('layouts.app')
@section('content')
    <div class="h-screen w-full">
        <div class="md:w-full mt-5">
            <div class="w-full md:w-1/2 md:float-left p-3">
                <div class="w-full pl-3">
                    <h2 class="w-full text-center my-2"></h2>
                    <ul class="flex w-full flex-nowrap justify-center">
                        <li class="text-center mx-2">
                            <i class="fa fa-warehouse text-5xl opacity-30 p-1"></i>
                            <h3 class="opacity-30 p-1">Affiliate</h3>
                            <span class="text-blue-800 p-2"><span class="line-through"><strike>N</strike></span>{{$balance->affiliate_balance}}</span>
                        </li>
                        <li class="text-center mx-2">
                            <i class="fa fa-wallet text-5xl opacity-30 p-1"></i>
                            <h3 class="opacity-30 p-1">Task</h3>
                            <span class="text-blue-800 p-2"><span class="line-through"><strike>N</strike></span>{{$balance->task_balance}}</span>
                        </li>
                    </ul>
                </div>
                <h2 class="px-3 opacity-70 w-full text-lg font-semibold">Process Withdrawal</h2>
                <!-- <div class="m-3 p-3 bg-white rounded-md">
                    <p id="selected" class="opacity-70">Selected: </p>
                    <p class="opacity-70">Avaible Balance: <span id="balance"> </span></p>
                </div> -->
                <form method="post" action="{{route('request.withdraw')}}" class="bg-white mb-16 md:mb-3 rounded-lg m-3 p-3">
                    @csrf
                    <label for="wallet" class="">Select An Account Type:</label>
                    <select name="wallet" id="wallet" class="w-full capitalize p-2 my-1 bg-white outline-blue-800 border-solid border-2 rounded-lg">
                        <option value="affiliate">Affiliate</option>
                        <option value="task">Task</option>
                    </select>
                    <input type="hidden" name="affiliate" id="affiliate" value="{{$balance->affiliate_balance}}">
                    <input type="hidden" name="task" id="task" value="{{$balance->task_balance}}">
                    <label for="amount" class="block w-full opacity-80 my-3 font-semibold">Amount to Withdraw:</label>
                    <input type="text" name="amount" required autofocus class="w-full p-2 border-solid border-2 rounded-lg outline-blue-800 shadow-black ring-offset-0 ring-0 focus:shadow-lg"/>
                    <p class="text-sm font-semibold text-blue-700 py-3"><i class="fa fa-exclamation-circle px-1"></i>Minimun withdrawal is NGN 5000</p>
                    @if(session('status') === 'insufficient-balance')
                        <p class="text-sm font-semibold text-red-700 py-3"><i class="fa fa-exclamation-circle px-1"></i>Wallet Ballance is not up to the Requested Amount</p>
                    @endif
                    @if(session('status') === 'minimun')
                        <p class="text-sm font-semibold text-red-700 py-3"><i class="fa fa-exclamation-circle px-1"></i>Minimun Withdrawal Amount is NGN 5000</p>
                    @endif
                    <button type="submit" class="bg-blue-800 px-4 text-white my-2 py-2 rounded-lg float-right ring-offset-0 ring-0 transition-all hover:shadow-lg active:bg-opacity-50">Process</button>
                    <hr class="border-solid border-blue-800 clear-both"/>
                    <h2 class="opacity-80 my-2 font-semibold">Bank Details</h2>
                    <div>
                        <i class="fa fa-warehouse p-1 mx-2 text-lg opacity-70 float-left font-semibold"></i>
                        @if ($details->bank_name != null && $details->account_name != null && $details->account_number != null)
                           <div class="flex flex-wrap items-center opacity-80 text-md"><span class="w-full capitalize font-semibold">{{$details->account_name}}</span><span class="w-full capitalize">{{$details->account_number}} - {{$details->bank_name}}</span></div>
                        @else
                            <div class="flex flex-wrap opacity-80 text-xs">no bank details <a href="{{route('profile.edit')}}">Update Bank Details</a></div>
                        @endif
                    </div>
                    
                    
                </form>
            </div>

            <div class="w-full md:w-1/2  md:float-right md:h-[80vh]  border-solid md:border-l-4 md:overflow-y-scroll ml-auto">
                <h2 class="px-3 opacity-70 w-full text-lg font-semibold">Withdrawal History({{$history->count()}})</h2>
                <ul class="m-1 bg-white md:ml-3 rounded-lg mt-2 border-solid border-2">
                @if ($history->count() >0)
                    @for ($i = 0; $i < count($history); $i++)
                        <li class="flex flex-nowrap items-center p-3 border-solid border-b-2">
                            <span class=""><i class="fa fa-check bg-green-700 rounded-full m-2 text-white p-1"></i></span>
                            <div><span class="block w-full font-bold">NGN{{$history[$i]->amount}} Withdrawal from {{$history[$i]->wallet}} balance</span></div>
                            @if (date('d', strtotime($history[$i]->created_at)) === date('d', time()))
                                <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>Today</span>
                            @elseif (date('d', time()) - date('d', strtotime($history[$i]->created_at)) == 1)
                                <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>Yesterday</span>
                            @else
                                <span class="text-xs float-right ml-auto px-3 font-semibold"><i class="fa fa-clock px-1"></i>{{date('d-m-y', strtotime($history[$i]->created_at))}}</span>
                            @endif
                        </li>
                    @endfor
                @else
                    <p class="w-full text-lg opacity-70 text-center">No Transaction have been done!</p>
                @endif
            </ul>
            </div>
        </div>
    </div>
    <hr class="clear-both invisible pb-20">
@endsection