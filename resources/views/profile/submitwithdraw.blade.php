@extends('layouts.app')
@section('content')
    <div class="w-full flex justify-center">
        <div class="w-full my-5 p-3 md:w-1/2 bg-white rounded-lg ring-0 ring-offset-0 shadow-lg">
            <p class="w-full text-center"><i class="fa fa-check text-5xl text-green-700 "></i></p>
            <h2 class="w-full text-center text-2xl font-semibold my-4">Withdrawal Request have been Submitted!</h2>
            <!-- <p class="w-full text-center text-[rgb(0,0,0)] text-sm font-semibold">You will Receive a notification if task is been approved</p> -->
            <a href="{{route('dashboard')}}" class="bg-blue-600 font-semibold text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all duration-300 hover:bg-none hover:bg-blue-800 hover:shadow-xl">Continue</a>
        </div>
    </div>
@endsection