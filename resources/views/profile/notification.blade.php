@extends('layouts.app')
@section('content')
<h2 class="p-3 w-full font-semibold">Notifications ({{$notification->count()}})</h2>
<div class="w-full md:w-1/2">
    <ul class="m-1 bg-white md:ml-3 rounded-lg mt-2 border-solid border-2">
        @if ($notification->count() >0)
            @for ($i = 0; $i < count($notification); $i++)
                    @if ($notification[$i]->link_to == 'profile')
                        <a href="{{route('profile.edit')}}" class="opacity-100 ml-auto hover:underline">
                            <li class="flex flex-nowrap p-2">
                                <span class=""><i class="fa fa-users-cog bg-black bg-opacity-40 px-4 py-5 rounded-full m-2 text-white p-1"></i></span>
                                <div class="opacity-70"><span class="block w-full font-bold">{{$notification[$i]->subject}}</span><span class="w-full">
                                    @if (date('d', strtotime($notification[$i]->created_at)) === date('d', time()))
                                        <span><i class="fa fa-clock m-1"></i>Today</span>
                                    @elseif (date('d', time()) - date('d', strtotime($notification[$i]->created_at)) == 1)
                                        <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                                    @else
                                        <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($notification[$i]->created_at))}}</span>
                                    @endif</span>
                                </div>
                            </li>
                            <hr class="opacity-100">
                        </a>
                    @elseif ($notification[$i]->link_to == 'referal')
                        <a href="{{route('referal')}}" class="opacity-100 ml-auto hover:underline">
                            <li class="flex flex-nowrap p-2">
                                <span class=""><i class="fa fa-users bg-black bg-opacity-40 px-4 py-5 rounded-full m-2 text-white p-1"></i></span>
                                <div class="opacity-70"><span class="block w-full font-bold">{{$notification[$i]->subject}}</span><span class="w-full">
                                    @if (date('d', strtotime($notification[$i]->created_at)) === date('d', time()))
                                        <span><i class="fa fa-clock m-1"></i>Today</span>
                                    @elseif (date('d', time()) - date('d', strtotime($notification[$i]->created_at)) == 1)
                                        <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                                    @else
                                        <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($notification[$i]->created_at))}}</span>
                                    @endif</span>
                                </div>
                            </li>
                            <hr class="opacity-100">
                        </a>
                        
                    @elseif ($notification[$i]->link_to == 'blog')
                        <a href="{{route('myposts')}}" class="opacity-100 ml-auto hover:underline">
                            <li class="flex flex-nowrap p-2">
                                <span class=""><i class="fa fa-comment bg-black bg-opacity-40 px-4 py-4 rounded-full m-2 text-white p-1"></i></span>
                                <div class="opacity-70"><span class="block w-full font-bold">{{$notification[$i]->subject}}</span><span class="w-full">
                                    @if (date('d', strtotime($notification[$i]->created_at)) === date('d', time()))
                                        <span><i class="fa fa-clock m-1"></i>Today</span>
                                    @elseif (date('d', time()) - date('d', strtotime($notification[$i]->created_at)) == 1)
                                        <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                                    @else
                                        <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($notification[$i]->created_at))}}</span>
                                    @endif</span>
                                </div>
                            </li>
                            <hr class="opacity-100">
                        </a>
                    @elseif ($notification[$i]->link_to == 'transaction')
                        <a href="{{route('transaction')}}" class="opacity-100 ml-auto hover:underline">
                            <li class="flex flex-nowrap p-2">
                                <span class=""><i class="fa fa-chart-line bg-black bg-opacity-40 px-4 py-4 rounded-full m-2 text-white p-1"></i></span>
                                <div class="opacity-70"><span class="block w-full font-bold">{{$notification[$i]->subject}}</span><span class="w-full">
                                    @if (date('d', strtotime($notification[$i]->created_at)) === date('d', time()))
                                        <span><i class="fa fa-clock m-1"></i>Today</span>
                                    @elseif (date('d', time()) - date('d', strtotime($notification[$i]->created_at)) == 1)
                                        <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                                    @else
                                        <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($notification[$i]->created_at))}}</span>
                                    @endif</span>
                                </div>
                            </li>
                            <hr class="opacity-100">
                        </a>
                    @elseif ($notification[$i]->link_to == 'task')
                        <a href="{{route('transaction')}}" class="opacity-100 ml-auto hover:underline">
                            <li class="flex flex-nowrap p-2">
                                <span class=""><i class="fa fa-chart-line bg-black bg-opacity-40 px-4 py-4 rounded-full m-2 text-white p-1"></i></span>
                                <div class="opacity-70"><span class="block w-full font-bold">{{$notification[$i]->subject}}</span><span class="w-full">
                                    @if (date('d', strtotime($notification[$i]->created_at)) === date('d', time()))
                                        <span><i class="fa fa-clock m-1"></i>Today</span>
                                    @elseif (date('d', time()) - date('d', strtotime($notification[$i]->created_at)) == 1)
                                        <span><i class="fa fa-clock m-1"></i>Yesterday</span>
                                    @else
                                        <span><i class="fa fa-clock m-1"></i>{{date('d-m-y', strtotime($notification[$i]->created_at))}}</span>
                                    @endif</span>
                                </div>
                            </li>
                            <hr class="opacity-100">
                        </a>
                    @endif
            @endfor
        @else
            <p class="w-full text-lg opacity-70 text-center">No Transaction have been done!</p>
        @endif
    </ul>
    <p class="py-3">{{$notification->links()}}</p>
</div>
@endsection