<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }} || Login</title>
    <!-- <link rel="stylesheet" href="../style.css"> -->
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" type="image/png" href="{{url('storage/logo/logobluebg.jpg')}}"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="p-0 m-0 bg-cover bg-opacity-10" style="background-image: url(../asset/images/bg.jpeg);">
    <div id="form-container" class="flex justify-center">
        <div id="signin-form" class="p-8 py-4 mt-16 w-96 bg-white bg-opacity-70 ring-offset-0 ring-0 shadow-lg border-solid  border-black-600 border-2 rounded-2xl">
            <div id="form-header">
                <div id="header-logo"><img src="{{url('storage/logo/logoblue.png')}}" alt="Strikevip logo" class="w-[120px] py-2"></div>
            </div>
            <div id="form-heading">
                <div id="form-heading" class="text-3xl">Sign In</div>
                <div id="signup-link" class="text-base mt-2">Don't have an account? <a href="{{route('register')}}" class="underline text-blue-600">Sign up here</a></div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <input type="text" id="email" name="email" placeholder="Email" class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl hover:outline-blue-700"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <input type="password" id="password" name="password" placeholder="password" class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl hover:outline-blue-700"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="underline text-base text-blue-600">Forgot password?</a>
            @endif
                <button type="submit" class="bg-blue-600 text-white font-bold p-3 mt-3 rounded-xl w-full hover:bg-blue-500 active:bg-blue-300">Sign In</button>
            </form>
        </div>
    </div>
</body>
</html>