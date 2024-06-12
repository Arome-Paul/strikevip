<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }} || Register</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{url('storage/logo/logobluebg.jpg')}}"/>

    <style>
        #submit.disable{
            opacity: 0.5;
        }
    </style>

    <!-- <link rel="stylesheet" href="../style.css"> -->

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="p-0 m-0 bg-cover bg-opacity-10" style="background-image: url(../asset/images/bg.jpeg);">
    <div id="form-container" class="flex justify-center">
        <div id="signup-form" class="p-8 py-4 mt-16 w-96 bg-white ring-offset-0 ring-0 shadow-lg border-solid  border-black-600 bg-opacity-70 border-2 rounded-2xl">
            <div id="form-header">  
                <div id="header-logo"><img src="{{url('storage/logo/logoblue.png')}}" alt="Strikevip logo" class="w-[120px] py-2"></div>
            </div>
            <div id="form-heading">
                <div id="form-heading" class="text-3xl">Sign Up</div>
                <div id="signup-link" class="text-base mt-2">{{ __('Already registered?') }}<a  href="{{ route('login') }}" class="underline text-blue-600">Sign In here</a></div>
            </div>
            <form id="form" method="POST" action="{{ route('register') }}" class="flex flex-wrap">
                @csrf
                <input type="text" id="fullname" name="fullname" placeholder="Full Name" required autofocus class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl focus:outline-blue-700"/>
                <x-input-error :messages="$errors->get('fullname')" class="mt-2" />

                <input type="text" id="username" name="username" placeholder="Username" required autofocus class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl focus:outline-blue-700"/>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                @if (session('status') === 'username')
                    <p class="text-red text-sm px-3">User with username {{session('username')}} already exist!</p>
                @endif

                <input type="email" id="email" name="email" placeholder="Email" required autofocus class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl focus:outline-blue-700"/>
                <x-input-error :messages="$errors->get('enail')" class="mt-2" />

                <input type="tel" id="phone" name="tel" placeholder="Tel" required autofocus class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl focus:outline-blue-700"/>
                <x-input-error :messages="$errors->get('tel')" class="mt-2" />

                <input type="password" id="password" name="password" placeholder="Password" required autofocus class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl focus:outline-blue-700"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Comfirm Password" required autofocus class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl focus:outline-blue-700"/>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

                @if (isset($ref))
                    <input type="text" id="referer" name="referer" value="{{$ref}}" placeholder="referer Code" class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl focus:outline-blue-700"/>
                    <x-input-error :messages="$errors->get('referer')" class="mt-2" />
                @else
                    <input type="text" id="referer" name="referer" placeholder="referer Code" class="flex p-2 my-3 w-full border-solid  border-black-600 border-2  text-black rounded-xl focus:outline-blue-700"/>
                    <x-input-error :messages="$errors->get('referer')" class="mt-2" />
                @endif

                <input id="check" type="checkbox" name="tnc" value="1"><span class="opacity-80 font-semibold pl-1">I agree to <a href="#" class="text-blue-800 hover:underline shadow-black ring-offset-0 ring-0 active:shadow-lg"> Privacy Policy & Terms</a></span>
                <button id="submit" type="submit" class="bg-blue-600 text-white font-bold p-3 mt-3 rounded-xl w-full duration:500 hover:bg-blue-400 active:bg-blue-300">Sign Up</button>
            </form>
        </div>
    </div>
    <script>
        window.onload = function(){
                var form = document.getElementById('form');
                var check = document.getElementById('check');
                var submit = document.getElementById('submit');
                submit.classList.add('disable');
                
                form.addEventListener('submit', (e) => {
                    if(!check.checked){
                        e.preventDefault();
                    }
                });

                check.addEventListener('change', () => {
                    if(check.checked){
                        submit.disabled = false;
                        submit.classList.remove('disable');
                    }
                    else{
                        submit.disabled = true;
                        submit.classList.add('disable');
                    }
                });

            };
    </script>
</body>
</html>