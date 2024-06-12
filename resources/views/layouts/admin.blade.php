<!DOCTYPE html>
@php
    use App\Http\Controllers\AdminPanel\AdminController;
    $h_task = App\Http\Controllers\AdminPanel\AdminController::details()['task'];
    $h_withddraw = App\Http\Controllers\AdminPanel\AdminController::details()['withdrawal'];
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel')}} - {{$title}} </title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{url('storage/logo/logobluebg.jpg')}}"/>

        <style>
            #header.fixed{
                position: fixed;
                top: 0;
                left: 0;
            }
            .active{
                border: solid 2px rgb(22 101 52 );
                background: rgb(134 239 172);
                color: rgb(20 83 45);
            }
            .inactive{
                border: solid 2px rgb(153, 27, 27);
                background: rgb(252 165 165);
                color: rgb(127, 29, 29);
            }
        </style>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/fontawesome-free-5.15.2-web/css/all.css'])
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @vite(['resources/js/jquery.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div id="before" class="w-full h-screen">
            <div id="slider" class="flex flex-wrap w-3/4 border-solid border-r-2 md:w-1/6 fixed top-0 -left-3/4 md:-left-0 duration-500 ease-in-out z-[1] transition-all h-screen bg-gray-100 md:float-left">
                <div class="bg-black w-full py-2 px-2"><img src="{{url('storage/logo/logo.png')}}" class="w-[40%] " alt="{{ config('app.name', 'Laravel') }}"></div>
                <div class="w-full md:hidden px-4 py-1">
                    <div class="float-right ml-auto"><button id="times" class="rounded-full active:bg-black transition-all hover:bg-black hover:bg-opacity-20 active:bg-opacity-20"><i class="fa fa-times p-2"></i></button></div>
                </div>
                <ul class="w-full mt-2 font-semibold h-screen">
                    <li class="w-full"><a href="{{route('dashboard')}}" title="Dashboard" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\AdminPanel\AdminController::marknav($title, 'Admin Dashboard')}}"><i class="fa fa-qrcode text-lg mx-3"></i>Dashboard</a></li>
                    <li class="w-full"><a href="{{route('admin.users')}}" title="Users" class="flex items-center p-2 my-1p-3 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\AdminPanel\AdminController::marknav($title, 'Users')}}"><i class="fa fa-users float-left text-lg mx-3"></i>Users</a></li>
                    @if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3)
                        <li class="w-full"><a href="{{route('admin.admins')}}" title="Admins" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\AdminPanel\AdminController::marknav($title, 'View Admins')}}"><i class="fa fa-user-tag float-left text-lg mx-3"></i>Admins</a></li>
                    @endif
                    <li class="w-full"><a href="{{route('admin.tasks')}}" title="Tasks" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\AdminPanel\AdminController::marknav($title, 'Tasks')}}"><i class="fa fa-hammer float-left text-lg mx-3"></i>Tasks
                    @if(count($h_task) > 0)
                        <span class="float-right ml-auto bg-red-600 w-[20px] h-[20px] text-center py-[1px] rounded-full text-xs font-bold text-white">{{count($h_task)}}</span>
                    @endif
                    </a></li>
                    <li class="w-full"><a href="{{route('admin.profile')}}" title="Profile" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\AdminPanel\AdminController::marknav($title, 'Profile')}}"><i class="fa fa-user float-left text-lg mx-3"></i>Profile</a></li>
                    <li class="w-full"><a href="{{route('pending.withdrawal')}}" title="Withdrawals" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\AdminPanel\AdminController::marknav($title, 'Pending Withdrawals')}}"><i class="fa fa-money-check float-left text-lg mx-3"></i>Withdrawals
                    @if(count($h_withddraw) > 0)
                        <span class="float-right ml-auto bg-red-600 w-[20px] h-[20px] text-center py-[1px] rounded-full text-xs font-bold text-white">{{count($h_withddraw)}}</span>
                    @endif
                    </a></li>
                    </a></li>
                    <li class="w-full"><a href="{{route('blogs')}}" title="Blog Posts" class="flex items-center p-2 my-1 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px] {{App\Http\Controllers\AdminPanel\AdminController::marknav($title, 'Blogs')}}"><i class="fa fa-comment float-left text-lg mx-3"></i>Blog Posts</a></li>
                    <li class="w-full">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" title="Log Out" class="flex items-center p-3 w-full transition-all duration-300 hover:bg-blue-600 hover:text-white rounded-r-[100px]"><i class="fa fa-sign-out-alt float-left text-lg mx-3"></i>{{ __('Log Out') }}</a>
                        </form>
                    </li>
                </ul>           
            </div>
            <div class="h-screen float-right md:border-solid md:border-2 w-full md:w-10/12">
                <div id="header" class="bg-white w-full flex items-center">
                    <div class="inline-flex items-center p-2">
                        <div class=""><img src="{{url('storage/logo/logo.png')}}" alt="User Profile pics" class="w-[50px] h-[50px] bg-black mr-2 rounded-full border-solid border-2 border-black"/></div>
                        <div class="">Hi <span class="inline font-semibold capitalize">{{ Auth::user()->username }}</span>
                            @if(Auth::user()->id == 1 || Auth::user()->id == 2 || Auth::user()->id == 3)
                                <div class="block w-full"><span class="text-xs py-1 px-2 rounded-lg bg-gray-200 font-semibold capitalize">Global</span></div>
                            @endif
                        </div>
                    </div>
                    <div class="float-right ml-auto">
                        <ul class="inline-flex ">
                            <li class="m-2"><a href="{{route('admin.profile')}}" title="Profile" class="shadow-black inline hover:ring-0 hover:ring-offset-0 hover:shadow-sm"><i class="fa fa-user p-3 opacity-80 rounded-full bg-black bg-opacity-20"></i></a></li>
                            <li class="m-2"><a href="{{route('pending.withdrawal')}}" title="Pending Withdrawals" class="shadow-black hover:ring-0  hover:ring-offset-0 hover:shadow-sm"><i class="fa fa-money-check p-3 opacity-80 rounded-full bg-black bg-opacity-20"></i>
                            @if(count($h_withddraw) > 0)
                                <span class="float-right bg-red-600 w-[15px] h-[15px] ml-[-8px] text-center rounded-full text-xs font-semibold text-white">{{count($h_withddraw)}}</span>
                            @endif
                            </a></li>
                            <li class="m-2"><a href="{{route('admin.pending')}}" title="Pending Tasks" class="shadow-black hover:ring-0  hover:ring-offset-0 hover:shadow-sm"><i class="fa fa-hammer p-3 opacity-80 rounded-full bg-black bg-opacity-20"></i>
                            @if(count($h_task) > 0)
                                <span class="float-right bg-red-600 w-[15px] h-[15px] ml-[-8px] text-center rounded-full text-xs font-semibold text-white">{{count($h_task)}}</span>
                            @endif
                            </a></li>
                        </ul>
                    </div>
                </div>

                <div x-data="{ content:false }" x-show="content" x-init="window.addEventListener('load', () => setTimeout(() => content = true, 2000) )" class="h-screen w-full">
                    <!-- Page Content -->
                    @yield('content')
                </div>
                <div class="w-full flex justify-center items-center">
                    <div x-data="{ show:true }" x-show="show" x-init="window.addEventListener('load', () => setTimeout(() => show = false, 2000) )" class="absolute text-center top-1/3"><img src="{{url('storage/logo/logomarkblue.png')}}" alt="" class="w-40 animate-pulse"><span class="font-semibold text-2xl animate-pulse">Loading</span></div>
                </div>
            </div>
            <div id="bottom-nav-cont" class="w-full">
                <ul id="bottom-nav" class="flex items-center w-full bg-white ring-offset-0 ring-0 shadow-lg fixed md:hidden left-0 bottom-0 p-3 border-solid border-2">
                    <li class="w-1/3 text-center"><a href="{{route('dashboard')}}" title="Dashboard" class="w-full"><i class="fa fa-home text-lg"></i></a></li>
                    <li class="w-1/3 text-center"><button id="nav-bar" class=""><i class="fa fa-bars transition-all ring-0 ring-offset-0 duration-300 bg-blue-600 p-4 rounded-full text-white hover:bg-blue-800 hover:shadow-lg"></i></button></li>
                    <li class="w-1/3 text-center"><a href="{{route('admin.tasks')}}" title="Notification" class="w-full"><i class="fa fa-tools text-lg"></i>
                    </a></li>
                </ul>
            </div>
            <div id="after" class="block w-full"></div>
        </div>
    </body>
    <script>
        window.onload = function(){
            var btn = document.getElementById('nav-bar');
            var times = document.getElementById('times');
            var slider = document.getElementById('slider');
            var header = document.getElementById('header');
            var after = document.getElementById('after');

            after.style.height = navHeight;

            btn.onclick = function(){
                if(slider.style.left = "-75%"){
                    slider.style.left = 0;
                }
            };
            times.onclick = function(){

                slider.style.left = "-75%";

            };


        };
    </script>
</html>