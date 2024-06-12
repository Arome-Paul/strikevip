@extends('layouts.admin')
@section('content')
    <h2 class="font-bold text-lg p-3">Add Admin</h2>
    <form method="POST" action="{{ route('new.admin') }}" class="w-full md:w-1/2 p-3"">
        @csrf
        <label for="fullname" class="w-full my-2">Fullname</label>
        <input type="text" id="fullname" name="fullname" placeholder="Full Name" required autofocus class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg"/>
        <x-input-error :messages="$errors->get('fullname')" class="mt-2" />

        <label for="username" class="w-full my-2">username</label>
        <input type="text" id="username" name="username" placeholder="Username" required autofocus class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg"/>
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
        @if (session('status') === 'username')
            <p class="text-red text-sm px-3">User with username {{session('username')}} already exist!</p>
        @endif

        <label for="email" class="w-full my-2">Email</label>
        <input type="email" id="email" name="email" placeholder="Email" required autofocus class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg"/>
        <x-input-error :messages="$errors->get('enail')" class="mt-2" />

        <label for="tel" class="w-full my-2">Tel</label>
        <input type="tel" id="phone" name="tel" placeholder="Tel" required autofocus class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg"/>
        <x-input-error :messages="$errors->get('tel')" class="mt-2" />

        <label for="password" class="w-full my-2">Password</label>
        <input type="password" id="password" name="password" placeholder="Password" required autofocus class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg"/>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <label for="password_confirmation" class="w-full my-2">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Comfirm Password" required autofocus class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg"/>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        <button type="submit" class="bg-blue-800 float-right rounded-lg p-3 my-3 text-xs px-5 shadow-black ring-offset-0 ring-0 active:shadow-lg text-white hover:bg-blue-500">Sign Up</button>
    </form>

@endsection