<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @php
        use App\Http\Controllers\ProfileController;
    @endphp
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - {{$title}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{url('storage/logo/logobluebg.jpg')}}"/>
        <style>
            #header.stay{
                position: fixed;
                top: 0;
            }
        </style>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/fontawesome-free-5.15.2-web/css/all.css'])
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/js/jquery.js'])

    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="">
            <div id="slider" class="flex flex-wrap w-3/4 md:w-1/6 fixed top-0 -left-3/4 ring-0 ring-offset-0 shadow-lg md:-left-0 duration-500 ease-in-out z-[1] transition-all h-screen bg-gray-100 md:float-left">
                <div class="bg-black w-full py-2 px-2"><img src="{{url('storage/logo/logo.png')}}" class="w-[40%] " alt="{{ config('app.name', 'Laravel') }}"></div>
                <div class="w-full md:hidden px-4 py-1">
                    <div class="float-right ml-auto"><button id="times" class="rounded-full transition-all hover:bg-black hover:bg-opacity-20 active:bg-black active:bg-opacity-20"><i class="fa fa-times p-2"></i></button></div>
                </div>
                <ul class="w-full h-screen font-semibold">
                    <li class="w-full"><a href="{{route('dashboard')}}" title="Dashboard" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\ProfileController::marknav($title, 'Dashboard')}}"><i class="fa fa-qrcode text-lg mx-3"></i>Dashboard</a></li>
                    <li class="w-full"><a href="{{route('tasks')}}" title="Tasks" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\ProfileController::marknav($title, 'Tasks')}}"><i class="fa fa-hammer float-left text-lg mx-3"></i>Tasks</a></li>
                    <li class="w-full"><a href="{{route('profile.edit')}}" title="Profile" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\ProfileController::marknav($title, 'Profile')}}"><i class="fa fa-user float-left text-lg mx-3"></i>Profile</a></li>
                    <li class="w-full"><a href="{{route('notification')}}" title="Notifications" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\ProfileController::marknav($title, 'Notifications')}}"><i class="fa fa-bell float-left text-lg mx-3"></i>Notifications
                    @if ($header['notification']->count() > 0)
                        <span class="float-right ml-auto bg-red-600 w-[20px] h-[20px] text-center py-[1px] rounded-full text-xs font-bold text-white">{{$header['notification']->count()}}</span>
                    @endif
                    </a></li>
                    <li class="w-full"><a href="{{route('transaction')}}" title="Transaction History" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\ProfileController::marknav($title, 'Transactions')}}"><i class="fa fa-chart-line float-left text-lg mx-3"></i>Transactions
                    @if ($header['transaction']->count() > 0)
                        <span class="float-right ml-auto bg-red-600 w-[20px] h-[20px] text-center py-[1px] rounded-full text-xs font-bold text-white">{{$header['transaction']->count()}}</span>
                    @endif
                    </a></li>
                    <li class="w-full"><a href="{{route('withdraw')}}" title="Withdrawal" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\ProfileController::marknav($title, 'Withdrawal')}}"><i class="fa fa-briefcase float-left text-lg mx-3"></i>Withdrawal</a></li>
                    <li class="w-full"><a href="{{route('referal')}}" title="Referals" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\ProfileController::marknav($title, 'Referal')}}"><i class="fa fa-users float-left text-lg mx-3"></i>Referrals</a></li>
                    <li class="w-full"><a href="{{route('blog')}}" title="Blog Posts" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\ProfileController::marknav($title, 'Blogs')}}"><i class="fa fa-comment float-left text-lg mx-3"></i>Blog Posts</a></li>
                    <li class="w-full">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" title="Log Out" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px]"><i class="fa fa-sign-out-alt float-left text-lg mx-3"></i>{{ __('Log Out') }}</a>
                        </form>
                    </li>
                </ul>           
            </div>
            <div class="md:h-screen md:float-right z-20 pb-20 md:ml-auto w-full md:w-10/12">
                <div id="header" class="bg-white ring-0 ring-offset-0 shadow-lg w-full flex items-center">
                    <div class="flex items-center p-2">
                        <div class=""><img src="{{$base}}" alt="User Profile pics" class="w-[50px] h-[50px] mr-2 rounded-full border-solid border-2 border-black"/></div>
                        <div class="">Hi <span class="inline font-semibold capitalize">{{ Auth::user()->username }}</span></div>
                    </div>
                    <div class="float-right ml-auto">
                        <ul class="flex ">
                            <li class="m-2"><a href="{{route('profile.edit')}}" title="Profile" class="shadow-black inline hover:ring-0 hover:ring-offset-0 hover:shadow-sm"><i class="fa fa-user p-3 opacity-80 rounded-full bg-black bg-opacity-20"></i></a></li>
                            <li class="m-2"><a href="#" title="Earning History" class="shadow-black hover:ring-0  hover:ring-offset-0 hover:shadow-sm"><i class="fa fa-chart-line p-3 opacity-80 rounded-full bg-black bg-opacity-20"></i>
                            @if ($header['transaction']->count() > 0)
                                <span class="float-right bg-red-600 w-[15px] h-[15px] ml-[-8px] text-center rounded-full text-xs font-semibold text-white">{{$header['transaction']->count()}}</span>
                            @endif
                            </a></li>
                            <li class="m-2"><a href="{{route('notification')}}" title="Notifications" class="shadow-black hover:ring-0  hover:ring-offset-0 hover:shadow-sm"><i class="fa fa-bell p-3 opacity-80 rounded-full bg-black bg-opacity-20"></i>
                            @if ($header['notification']->count() > 0)
                                <span class="float-right bg-red-600 w-[15px] h-[15px] ml-[-8px] text-center rounded-full text-xs font-semibold text-white">{{$header['notification']->count()}}</span>   
                            @endif</a></li>
                        </ul>
                    </div>
                </div>

                <div x-data="{ content:false }" x-show="content" x-init="window.addEventListener('load', () => setTimeout(() => content = true, 2000) )">
                    <!-- Page Content -->
                    @yield('content')
                </div>
                <div class="w-full flex justify-center items-center">
                    <div x-data="{ show:true }" x-show="show" x-init="window.addEventListener('load', () => setTimeout(() => show = false, 2000) )" class="absolute text-center top-1/3"><img src="{{url('storage/logo/logomarkblue.png')}}" alt="" class="w-40 animate-pulse"><span class="font-semibold text-2xl animate-pulse">Loading</span></div>
                </div>
            </div>
            <ul class="flex items-center w-full bg-white ring-offset-0 ring-0 shadow-lg md:invisible fixed bottom-0 p-3 border-solid border-2">
                <li class="w-1/3 text-center"><a href="{{route('dashboard')}}" title="Dashboard" class="w-full"><i class="fa fa-home text-lg"></i></a></li>
                <li class="w-1/3 text-center"><button id="nav-bar" class=""><i class="fa fa-bars transition-all ring-0 ring-offset-0 duration-300 bg-blue-600 p-4 rounded-full text-white hover:bg-blue-800 hover:shadow-lg"></i></button></li>
                <li class="w-1/3 text-center"><a href="{{route('notification')}}" title="Notification" class="w-full"><i class="fa fa-envelope text-lg"></i>
                @if ($header['notification']->count() > 0)
                    <sup class="bg-red-600 w-[15px] h-[15px] px-[4px] text-center ml-[-6px] rounded-full text-xs text-white">{{$header['notification']->count()}}</sup>
                @endif
                </a></li>
            </ul>

        </div>
        <script>
            window.onload = function(){
                var btn = document.getElementById('nav-bar');
                var times = document.getElementById('times');
                var slider = document.getElementById('slider');
                var header = document.getElementById('header');
                
                btn.onclick = function(){
                    if(slider.style.left = "-75%"){
                        slider.style.left = 0;
                    }
                    else{
                        slider.style.left = "-75%";
                    }

                };
                times.onclick = function(){

                    slider.style.left = "-75%";

                };

                let copybtn = document.getElementById('copy');
                copy.onclick = function(){
                    let copyRef = document.getElementById('copyRef');

                    copyRef.select();
                    copyRef.setSelectionRange(0,99999);
                    navigator.clipboard.writeText(copyRef.value);
                    alert('Copied the referal code');
                };



            };
        </script>
    </body>
</html>