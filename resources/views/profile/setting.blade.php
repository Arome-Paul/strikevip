@extends('layouts.app')
@section('content')
    <h3 class="w-full p-3 text-sm py-5"><span class="opacity-60">Dashboard/</span><span class="font-semibold">Account Settings</span></h3>
    <div class="w-full md:w-1/2 p-3 bg-blue-800 bg-opacity-10 m-3 rounded-xl">
        <h3 class="font-semibold my-3">Profile Details</h3>
        <div class="overflow-hidden">
            <div class="float-left"><img src="{{ $base }}" alt="{{Auth::user()->username}} profile photo" class="w-[80px] h-[80px] rounded-full border-solid border-2"/></div>
            <form method="post" enctype="multipart/form-data" action="{{route('upload.image')}}">
                @csrf
                @method('put')
                <input type="file" name="image"">
                <button type="submit" class="bg-blue-800 text-sm rounded-lg p-2 border-solid border-2 border-blue-800 text-white m-3 hover:bg-opacity-0 hover:text-blue-800 shadow-black ring-offset-0 ring-0 active:shadow-lg">upload image</button>

                <a href="{{route('reset.image')}}" title="Reset Profile Image" class="bg-none text-sm rounded-lg text-blue-800 p-2 border-solid border-2 border-blue-800 hover:bg-blue-800 hover:text-white shadow-black ring-offset-0 ring-0 active:shadow-lg">Reset</a>
                @if (session('status') === 'image-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="fixed transform bg-white rounded-lg p-10 font-bold bottom-1/2 left-1/2 text-xl text-gray-600 dark:text-gray-400"
                    >{{ __('Profile Image Updated Successfully!!!') }}</p>
                @endif
                @if (session('status') === 'image-reset')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="fixed transform bg-white rounded-lg p-10 font-bold bottom-1/2 left-1/2 text-xl text-gray-600 dark:text-gray-400"
                    >{{ __('Profile Image Reset Successful!!!') }}</p>
                @endif
                @if (session('status') === 'structure-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="fixed transform bg-white rounded-lg p-10 font-bold bottom-1/2 left-1/2 text-xl text-gray-600 dark:text-gray-400"
                    >{{ __('Invesment Structure have been set Successfully!!!') }}</p>
                @endif
            </form>
        </div>
        <p class="text-xs opacity-50">only JPG, GIF & PNG are allowed with maximum size of 5mb</p>
            @unless($referred == 'empty')
                <p class="text-sm my-3"><span class="opacity-70">Referred By: </span><span class="capitalize font-semibold">{{$referred->fullname}}</span></p>
            @endunless
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    @if ($details->structure != null)
        <p class="p-3 opacity-80">Investment Structure: <span class="font-bold text-black">VIP {{$details->structure}}</span></p>
    @else
        <form action="{{route('update.structure')}}" method="post" class="w-1/2 p-3">
            @csrf
            <label for="structure" class="w-full my-3">Investment Structure</label>
            <select name="structure" id="structure" class="w-full capitalize p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
                <option value="" select>Select Structure</option>
                <option value="1">Vip 1</option>
                <option value="2">Vip 2</option>
                <option value="3">Vip 3</option>
                <option value="4">Vip 4</option>
                <option value="5">Vip 5</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('structure')" />
            <button class="bg-blue-800 rounded-lg p-3 my-3 text-xs px-5 shadow-black ring-offset-0 ring-0 active:shadow-lg text-white hover:bg-blue-500">SUBMIT</button>
        </form>
    @endif

    <div class="flex flex-wrap w-full mt-5 px-3">
        <h3 class="w-full"><i class="fa fa-user-edit p-4 text-blue-800 bg-white rounded-full"></i><span class="opacity-80 font-bold"> Profile Setup</span></h3>
        
        <form method="post" action="{{ route('profile.update') }}" class="flex flex-wrap w-full">
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
    <div class="flex flex-wrap w-full mt-5 px-3">
        <h3 class="w-full"><i class="fa fa-warehouse p-4 text-blue-800 bg-white rounded-full"></i><span class="opacity-80 font-bold"> Bank Settings</span></h3>
        <p class="p-3 w-full my-1 text-blue-800 text-xs bg-blue-800 bg-opacity-20 rounded-lg capitalize"><span class="font-semibold">Bank Details!</span> Update Bank details to get withdrawal request approved  and recieve payout</p>
        <form method="post" action="{{route('profile.bank')}}" class="flex flex-wrap w-full">
            @csrf
            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="accnumber">Account number</label>
                <input type="text" name="acc_no" value="{{$details->account_number}}" class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
                <x-input-error class="mt-2" :messages="$errors->get('acc_no')" />
            </div>
            <div class="w-full md:w-1/2  p-2 my-2">
                <label for="bankname">Bank Name</label>
                <select name="bankname" id="bankname" class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
                    <option selected>Choose</option>
                    <option value="access">Access Bank</option>
                    <option value="citibank">Citibank</option>
                    <option value="diamond">Diamond Bank</option>
                    <option value="ecobank">Ecobank</option>
                    <option value="fidelity">Fidelity Bank</option>
                    <option value="firstbank">First Bank</option>
                    <option value="fcmb">First City Monument Bank (FCMB)</option>
                    <option value="gtb">Guaranty Trust Bank (GTB)</option>
                    <option value="heritage">Heritage Bank</option>
                    <option value="keystone">Keystone Bank</option>
                    <option value="polaris">Polaris Bank</option>
                    <option value="providus">Providus Bank</option>
                    <option value="stanbic">Stanbic IBTC Bank</option>
                    <option value="standard">Standard Chartered Bank</option>
                    <option value="sterling">Sterling Bank</option>
                    <option value="suntrust">Suntrust Bank</option>
                    <option value="union">Union Bank</option>
                    <option value="uba">United Bank for Africa (UBA)</option>
                    <option value="unity">Unity Bank</option>
                    <option value="wema">Wema Bank</option>
                    <option value="zenith">Zenith Bank</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('bankname')" />
            </div>
            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="accname">Acount Name</label>
                <input type="text" name="acc_name" value="{{$details->account_name}}" class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
                <x-input-error class="mt-2" :messages="$errors->get('acc_name')" />
            </div>
            <div class="p-2 w-full md:w-1/2 my-2">
                <button class="bg-blue-800 rounded-lg p-3 text-xs px-5 font-semibold shadow-black ring-offset-0 ring-0 active:shadow-lg text-white hover:bg-blue-500">SUBMIT</button>
            </div>
        </form>
    </div>
    
    <div class="flex flex-wrap w-full mt-5 px-3">
        <h3 class="w-full"><i class="fa fa-globe p-4 text-blue-800 bg-white rounded-full"></i><span class="opacity-80 font-bold"> Social Media Accounts</span></h3>
        <p class="p-3 w-full my-1 text-blue-800 text-xs bg-blue-800 bg-opacity-20 rounded-lg capitalize"><span class="font-semibold">Social Media Contacts!</span> Social Media contacts are needed to verify social media tasks</p>
        <form method="post" action="{{route('update.socials')}}" class="flex flex-wrap w-full">
            @csrf
            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="facebook">Facebook Username</label>
                <input type="text" name="facebook" value="{{$social->facebook}}" placeholder="Facebook" class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
            </div>
            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="whatsapp">Whatsapp</label>
                <input type="tel" name="whatsapp" value="{{$social->whatsapp}}" placeholder="Whatsapp" class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
            </div>
            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="x">X</label>
                <input type="text" name="x" value="{{$social->x}}" placeholder="x" class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
            </div>
            <div class="w-full md:w-1/2 p-2 my-2">
                <label for="telegram">Telegram</label>
                <input type="tel" name="telegram" value="{{$social->telegram}}" placeholder="telegram" class="w-full p-2 bg-white outline-blue-800 border-solid border-2 rounded-lg">
            </div>
            <div class="p-2 w-full md:w-1/2 my-2">
                <button class="bg-blue-800 rounded-lg p-3 text-xs px-5 shadow-black ring-offset-0 ring-0 active:shadow-lg text-white hover:bg-blue-500">SUBMIT</button>
            </div>
        </form>
    </div>
    <section class="space-y-6 p-3 bg-white mx-3 rounded-lg">
    <header>
        <h2 class="text-lg font-medium text-black">Delete Account</h2>
        <!-- <h2 class="text-lg font-medium text-black dark:text-gray-100">
            {{ __('Delete Account') }}
        </h2> -->

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
    <div class="flex flex-wrap w-full my-3 pb-20 px-3">
            <div class="l">
                <h2 class="text-lg font-medium text-black">Update Password</h2>
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>

@endsection