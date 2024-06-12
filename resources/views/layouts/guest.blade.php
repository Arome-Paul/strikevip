<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Laravel') }} || Dashboard</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{url('storage/logo/logo.png')}}"/>
        
        <!-- Scripts -->
        @vite(['resources/css/fontawesome-free-5.15.2-web/css/all.css'])
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            #header.fixed{
                position: fixed;
                top: 0;
                left: 0;
                z-index: 10;
            }
        </style>
        
    </head>
    <body class="bg-gray-100">
        <header id="header" class="w-full ring-0 z-1 border-solid border-b-4 border-black border-opacity-20 ring-offset-0 shadow-xl transition-all duration-500 bg-blue-600">
            <div id="Top" class="flex md:flex flex-nowrap items-center">
                <div class="w-28 ml-5 py-3"><img src="{{url('storage/logo/logo.png')}}" alt="Strikevip logo"></div>
                <div class="flex w-[150px] md:hidden float-right ml-auto">
                    <ul class="flex w-full items-center px-2 flex-nowrap">
                        <li>
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-1 py-2 text-md text-blue-600 border-solid bg-white border-white border-2 rounded-full transition-all duration-500 hover:bg-transparent hover:text-white ring-offset-0 ring-0 active:shadow-lg font-bold active:underline"><i class="fa fa-user-circle text-lg"></i>Dashboard</a></li>
                            @else
                                <a href="{{route('login')}}" class="px-3 py-2 text-md text-blue-600 border-solid bg-white border-white border-2 rounded-full transition-all duration-500 hover:bg-transparent hover:text-white ring-offset-0 ring-0 active:shadow-lg font-bold active:underline"><i class="fa fa-user-circle text-lg p-1"></i> Login</a></li>
                            @endauth
                        <li><button id="btn" class="p-2 px-1 text-white rounded-full hover:opacity-50"><i class="fa fa-bars"></i></button></li>
                    </ul>
                </div>
                <div id="nav-slider" class="flex w-1/2 -right-1/2 overflow-hidden pb-3 md:h-full md:w-auto transition-all duration-500 fixed top-0 md:static md:ml-auto items-center">
                    <ul class="flex flex-wrap w-full md:w-auto border-solid border-b-2 border-l-2 border-black border-opacity-20 md:border-none ring-0 ring-offset-0 shadow-xl md:shadow-none rounded-lg md:rounded-none bg-blue-600 md:flex-nowrap">
                        <button id="times" class="text-white p-3 md:hidden hover:opacity-50"><i class="fa fa-times"></i></button>
                        <li class="w-full md:w-auto"><a href="#" class="block w-full md:w-auto md:p-2 py-4 px-3 text-md text-white rounded-lg transition-all duration-700 shadow-black ring-offset-0 ring-0 active:shadow-lg hover:bg-black hover:bg-opacity-30 font-bold active:underline"><i class="fa fa-pen p-2"></i> Home</a></li>
                        <li class="w-full md:w-auto"><a href="{{route('blogs.post')}}" class="block w-full md:w-auto md:p-2 py-4 px-3 text-md text-white rounded-lg transition-all duration-700 shadow-black ring-offset-0 ring-0 active:shadow-lg hover:bg-black hover:bg-opacity-30 font-bold active:underline"><i class="fa fa-pager p-2"></i>Blog</a></li>
                        <li class="w-full md:w-auto"><a href="#" class="block w-full md:w-auto md:p-2 py-4 px-3 text-md text-white rounded-lg transition-all duration-700 shadow-black ring-offset-0 ring-0 active:shadow-lg hover:bg-black hover:bg-opacity-30 font-bold active:underline"><i class="fa fa-shopping-bag p-2"></i> Market Place</a></li>
                        <li class="w-full md:w-auto"><a href="#" class="block w-full md:w-auto md:p-2 py-4 px-3 text-md text-white rounded-lg transition-all duration-700 shadow-black ring-offset-0 ring-0 active:shadow-lg hover:bg-black hover:bg-opacity-30 font-bold active:underline"><i class="fa fa-file-signature p-2"></i>Terms of Service</a></li>
                        <li class="w-full md:w-auto"><a href="#" class="block w-full md:w-auto md:p-2 py-4 px-3 text-md text-white rounded-lg transition-all duration-700 shadow-black ring-offset-0 ring-0 active:shadow-lg hover:bg-black hover:bg-opacity-30 font-bold active:underline"><i class="fa fa-address-book p-2"></i>About Us</a></li>
                        <li class="w-full md:w-auto"><a href="#" class="block w-full md:w-auto md:p-2 py-4 px-3 text-md text-white rounded-lg transition-all duration-700 shadow-black ring-offset-0 ring-0 active:shadow-lg hover:bg-black hover:bg-opacity-30 font-bold active:underline"><i class="fa fa-phone p-2"></i> Contact Us</a></li>
                    </ul>
                    <ul class="hidden md:flex items-center mx-2 flex-nowrap">
                        <li>
                            @auth
                                <a href="{{ url('/dashboard') }}"  class="px-4 py-2 text-md text-blue-600 border-solid bg-white border-white border-2 rounded-full transition-all duration-500 hover:bg-transparent hover:text-white ring-offset-0 ring-0 active:shadow-lg font-bold active:underline"><i class="fa fa-user-circle text-lg p-1"></i>Dashboard</a>
                            @else
                                <a href="{{route('login')}}"  class="px-4 py-2 text-md text-blue-600 border-solid bg-white border-white border-2 rounded-full transition-all duration-500 hover:bg-transparent hover:text-white ring-offset-0 ring-0 active:shadow-lg font-bold active:underline"><i class="fa fa-user-circle text-lg p-2"></i> Login</a>
                            @endauth
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- Page Content -->
        @yield('content')
        <footer class="flex flex-wrap justify-center p-4 text-white bg-black">
            <div class="w-[100px]"><img src="{{url('storage/logo/logo.png')}}" alt="Strikevip logo"></div>
            <div class="flex flex-wrap w-full justify-center my-2">
                <!-- <h3 class="w-full text-center">Useful Links</h3> -->
                <ul class="flex flex-wrap md:flex-nowrap w-full justify-center">
                    <li class="m-1 md:m-2"><a href="#" class="p-3 py-1 rounded-md text-md font-semibold hover:bg-white hover:bg-opacity-30 active:underline">Aboust Us</a></li>
                    <li class="m-1 md:m-2"><a href="#" class="p-3 py-1 rounded-md text-md font-semibold hover:bg-white hover:bg-opacity-30 active:underline">How it works</a></li>
                    <li class="m-1 md:m-2"><a href="#" class="p-3 py-1 rounded-md text-md font-semibold hover:bg-white hover:bg-opacity-30 active:underline">Terms of Service</a></li>
                    <li class="m-1 md:m-2"><a href="{{route('blogs.post')}}" class="p-3 py-1 rounded-md text-md font-semibold hover:bg-white hover:bg-opacity-30 active:underline">Blogs</a></li>
                    <li class="m-1 md:m-2"><a href="#" class="p-3 py-1 rounded-md text-md font-semibold hover:bg-white hover:bg-opacity-30 active:underline">Privacy Policy</a></li>
                    <li class="m-1 md:m-2"><a href="#" class="p-3 py-1 rounded-md text-md font-semibold hover:bg-white hover:bg-opacity-30 active:underline">Contact Us</a></li>
                </ul>
            </div>
            <div class="flex flex-wrap w-full justify-center my-2">
                <p>&copy; 2024 <a href="#" class="font-semibold hover:underline">Strikevip</a> - All right reserved</p>
            </div>
            <div class="flex flex-wrap w-full justify-center my-2">
                <ul class="flex box-content">
                    <li class="m-4"><a class="text-lg hover:text-2xl active:text-blue-900" href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="m-4"><a class="text-lg hover:text-2xl active:text-blue-900" href="#"><i class="fab fa-facebook"></i></a></li>
                    <li class="m-4"><a class="text-lg hover:text-2xl active:text-blue-900" href="#"><i class="fab fa-instagram"></i></a></li>
                    <li class="m-4"><a class="text-lg hover:text-2xl active:text-blue-900" href="#"><i class="fab fa-youtube"></i></a></li>
                    <li class="m-4"><a class="text-lg hover:text-2xl active:text-blue-900" href="#"><i class="fab fa-whatsapp"></i></a></li>
                </ul>
            </div>
        </footer>
        <a href="#top" id="" class="bg-blue-800 hidden rounded-full ring-offset-0 ring-0 shadow-lg fixed bottom-10 right-4"><i class="fa fa-arrow-up p-3 text-white"></i></a>
        <script>
            window.onload = function(){
                var header = document.getElementById('header');
                var btn = document.getElementById('btn');
                var times = document.getElementById('times');
                var top = document.getElementById('top');
                var nav = document.getElementById('nav-slider');

                window.addEventListener('scroll', () => {
                    const scrollPosition = window.scrollY;
                    if(scrollPosition > 100){
                        header.classList.add('fixed');
                        top.style.display = 'block';
                    }
                    else{
                        header.classList.remove('fixed');
                        top.style.display = "none"
                    }
                });

                btn.onclick = function(){
                    nav.style.right = 0;
                }
                times.onclick = function(){
                    
                    nav.style.right = '-50%';
                }
            };
        </script>
    </body>
</html>