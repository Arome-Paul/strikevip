@extends('layouts.admin')
@section('content')
    <h3 class="w-full p-3 text-sm py-5"><span class="opacity-60">Dashboard/</span><span class="font-semibold">Account Settings</span></h3>
    <!-- <div class="w-full md:w-1/2 p-3 bg-blue-800 bg-opacity-10 m-3 rounded-xl">
        <h3 class="font-semibold my-3">Profile Details</h3>
        <p class="text-xs opacity-50">only JPG, GIF & PNG are allowed with maximum size of 5mb</p>
    </div> -->

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>


    <div class="flex flex-wrap w-full mt-5 px-3">
        <h3 class="w-full"><i class="fa fa-user-edit p-4 text-blue-800 bg-white rounded-full"></i><span class="opacity-80 font-bold"> Profile Setup</span></h3>
        
        <form method="post" action="{{ route('update.profile') }}" class="flex flex-wrap w-full">
            @csrf
            @method('patch')

            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="username">Username</label>
                <input type="text" name="username" value="{{Auth::user()->username}}" required autofocus class="w-full capitalize p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
                <x-input-error class="mt-2" :messages="$errors->get('username')" />
            </div>
            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="email">Email</label>
                <input type="email" name="email" value="{{Auth::user()->email}}" required autofocus class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="fixed transform font-bold bottom-1/2 left-1/2 text-xl mt-2 text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif

            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="phone">Phone</label>
                <input type="tel" name="tel" value="{{ Auth::user()->tel }}" required autofocus class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
                <x-input-error class="mt-2" :messages="$errors->get('tel')" />
            </div>
            <div class="p-2 w-full md:w-1/2 my-2">
                <button class="bg-blue-800 rounded-lg p-3 text-xs px-5 shadow-black ring-offset-0 ring-0 active:shadow-lg text-white hover:bg-blue-500">SUBMIT</button>
                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="fixed transform bg-white rounded-lg p-10 font-bold bottom-1/2 left-1/2 text-xl text-gray-600 dark:text-gray-400"
                    >{{ __('Saved.') }}</p>
                @endif
            </div>
        </form>
    </div>
    <div class="flex flex-wrap w-full my-3 pb-20 px-3">
            <div class="l">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
@endsection