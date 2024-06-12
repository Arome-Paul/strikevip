@extends('layouts.admin')
@section('content')
<div class="w-full p-3">
        <div class="w-full md:w-3/4 md:float-left md:h-screen">
            <div class="rounded-lg w-full p-3 bg-white ring-offset-0 ring-0 shadow-lg">
                <h1 class="text-xl font-bold w-full text-center p-3">{{$single->title}}</h1>
                <div>
                    <div class="float-left"><img src="{{url('storage/logo/logo.png')}}" class="w-[80px] h-[80px] bg-black rounded-full border-solid border-2"/></div>
                    <div class="pb-3">
                        <span class="block font-semibold w-full opacity-90"><i class="fa fa-user p-2"></i>StrikeMedia</span>
                        <span class="block text-sm opacity-90"><i class="fa fa-clock p-2"></i>{{(date('d-m-y', strtotime($single->created_at)))}}</span>
                    </div>
                    @if ($single->thumbnail != 'no thumb')
                        <img src="{{$url}}/{{$single->thumbnail}}" alt="{{$single->title}}" class="w-full clear-both">
                    @endif
                    <div class="p-3 opacity-85 text-md font-sans w-full">
                        <p>{{$single->body}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="clear-both invisible pb-20">
@endsection