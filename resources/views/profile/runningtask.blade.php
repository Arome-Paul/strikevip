@extends('layouts.app')
@section('content')
    <div class="w-full flex justify-center">
        <div class="w-full my-5 p-3 md:w-1/2 bg-white rounded-lg ring-0 ring-offset-0 shadow-lg">
            <span></span>
            <h2 class="w-full text-center text-2xl font-semibold my-4">Task Process Is Running Already!</h2>
            <p class="w-full text-center font-semibold my-3">Proceed to complete task, click done after task have been completed, get task validated</p>
            <p class="w-full text-center text-[rgb(225,0,0)] text-sm font-semibold">Process will Expires after 2 hours</p>
            <ul class="flex flex-nowrap w-full my-3 justify-center">
                <li class="mx-2"><a href="{{$task->link}}" class="bg-blue-600 font-semibold text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all duration-300 hover:bg-none hover:bg-blue-800 hover:shadow-xl"><i class="fa fa-arrow-right p-1 bg-white rounded-full text-blue-600 mx-1"></i>Proceed To Task</a></li>
                <li class="mx-2"><a href="{{route('submit.task')}}" class="bg-green-600 font-semibold text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all duration-300 hover:bg-none hover:bg-green-800 hover:shadow-xl"><i class="fa fa-check p-1 bg-white rounded-full text-green-600 mx-1"></i>Done</a></li>
                <li class="mx-2"><a href="{{route('cancel.task')}}" class="bg-red-600 font-semibold text-xs py-2 px-4 float-right ml-auto rounded-full text-white transition-all duration-300 hover:bg-none hover:bg-red-800 hover:shadow-xl"><i class="fa fa-times p-1 bg-white rounded-full text-red-600 mx-1"></i>Cancel</a></li>
            </ul>
        </div>
    </div>
@endsection