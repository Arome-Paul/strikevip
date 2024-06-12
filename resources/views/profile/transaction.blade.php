@extends('layouts.app')
@section('content')
<h2 class="p-3 w-full font-semibold">Earning History</h2>
<div class="w-full md:w-1/2">
    <ul class="m-1 bg-white md:ml-3 rounded-lg mt-2 border-solid border-2">
        @if ($transactions->count() >0)
            @for ($i = 0; $i < count($transactions); $i++)
                <li class="flex flex-nowrap p-3 border-solid border-b-2">
                    <span class=""><i class="fa fa-check bg-green-700 rounded-full m-2 text-white p-1"></i></span>
                    <div><span class="block w-full font-bold">{{$transactions[$i]->transaction_name}}</span><span class="w-full">{{$transactions[$i]->created_at}}</span></div>
                    <span class="float-right ml-auto"><strike>N</strike>{{$transactions[$i]->amount_earned}}</span>
                </li>
            @endfor
        @else
            <p class="w-full text-lg opacity-70 text-center">No Transaction have been done!</p>
        @endif
    </ul>
    <p class="py-3 px-2">{{$transactions->links()}}</p>
</div>
<hr class="clear-both invisible pb-20">
@endsection