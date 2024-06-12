@extends('layouts.guest')
@section('content')
    <section class="w-full h-[70vh] md:h-[90vh] flex items-center bg-blue-600 border-solid border-b-4 border-black border-opacity-20 ring-offset-0 shadow-xl">
        <div class="w-full md:w-[70%] p-5 mx-4 md:p-10 md:ml-16">
            <p class="font-semibold md:font-bold text-md md:text-xl w-[75%] md:w-1/2 text-white"><span class="text-yellow-500">STRIKE MEDIA</span> IS HERE AND STRONG. NOTE THAT MILLIONAIRA WILL</p>
            <h1 class="text-6xl md:text-8xl block text-white font-bold">SURELY BE <br> MADE ON <br>STRIKE MEDIA.</h1>
            <p class="p-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-lg md:text-2xl px-3 md:px-6 py-2 font-bold bg-blue-900 ring-0 ring-offset-0 rounded-xl text-white transition-all duration-500 hover:bg-blue-700 hover:shadow-lg">Dashboard</a>
                @else
                    <a href="{{route('register')}}" class="text-lg md:text-2xl px-3 md:px-6 py-2 font-bold bg-blue-900 ring-0 ring-offset-0 rounded-xl text-white transition-all duration-500 hover:bg-blue-700 hover:shadow-lg">JOIN US</a>
                @endauth
            </p>
            <p class="w-full text-white text-md md:text-lg md:mt-14 font-semibold capitalize">Your Gateway to diverse earning opportunity, your financial stability is guaranteed</p>
        </div>
        
    </section>

    <section class="flex justify-center flex-wrap mt-3 p-4 md:p-14 md:py-3">
        <h3 class="w-full text-3xl font-semibold py-3 capitalize">What is strike media</h3>
        <p class="w-full text-black text-md md:text-lg font-semibold">Strike Media is a Network Marketing and Social advert Company, Built to give people opportunities to Learn, Earn and also turn their everyday social media life into a tool for Learning and Earning</p>
        <p class="w-full text-black text-md md:text-lg font-semibold">At Strike Media, We are dedicated to providing our Users with a platform where they can explore various earning opportunities and learn high income digital skills. Our goal is to  help individuals uncover diverse earning opportunities by offering multiple ways to transform their time and effort valuable rewards. Join us today and start your journey towards financial success.</p>
    </section>

    <section class="flex  flex-wrap p-4 md:p-14 md:py-3">
        <h3 class="w-full text-3xl font-semibold capitalize">Why Choose Us?</h3>
        <ul class="flex flex-wrap w-full mt-3 md:flex-nowrap">
            <li class="w-full text-black my-2 md:mx-2 text-xl bg-white rounded-lg border-solid border-2 border-black border-opacity-10 p-8 ring-0 ring-offset-0 shadow-lg font-semibold md:w-1/4"><i class="fa fa-handshake text-3xl bg-gray-400 rounded-full p-3"></i> <span class="block w-full py-3">Live Time Affiliate Account</span> </li>
            <li class="w-full text-black my-2 md:mx-2 text-xl bg-white rounded-lg border-solid border-2 border-black border-opacity-10 p-8 ring-0 ring-offset-0 shadow-lg font-semibold md:w-1/4"><i class="fa fa-coins text-3xl bg-gray-400 rounded-full p-3"></i> <span class="block w-full py-3">Easy Access To Earn Either as an Affiliate/Non Affiliate</span> </li>
            <li class="w-full text-black my-2 md:mx-2 text-xl bg-white rounded-lg border-solid border-2 border-black border-opacity-10 p-8 ring-0 ring-offset-0 shadow-lg font-semibold md:w-1/4"><i class="fa fa-money-check text-3xl bg-gray-400 rounded-full p-3"></i> <span class="block w-full py-3">Easy Withdrawal System and Fast Payout</span> </li>
            <li class="w-full text-black my-2 md:mx-2 text-xl bg-white rounded-lg border-solid border-2 border-black border-opacity-10 p-8 ring-0 ring-offset-0 shadow-lg font-semibold md:w-1/4"><i class="fa fa-user text-3xl bg-gray-400 rounded-full p-3"></i> <span class="block w-full py-3">Promote and Make Money as an Affiliate</span> </li>
        </ul>
    </section>

    <section class="flex md:justify-center bg-blue-600 flex-wrap p-4 md:p-14 md:py-3">
        <h3 class="w-full text-2xl flex justify-center text-white font-bold px-2 text-center capitalize">How To Earn On Strike Media</h3>
        <ul class="flex flex-wrap w-full md:justify-center md:flex-nowrap">
            <li class="w-full border-solid border-2 text-white my-2 md:mx-2 rounded-lg p-8 font-semibold md:w-1/4"><span class="text-md block w-full font-bold"><i class="fa fa-users p-2"></i>Affiliate Bonus</span><span class="text-lg font-semibold">This is a Commission Given when you Successfully Register a New User using Unique affiliate link</span></li>
            <li class="w-full border-solid border-2 text-white my-2 md:mx-2 rounded-lg p-8 font-semibold md:w-1/4"><span class="text-md block w-full font-bold"><i class="fa fa-globe-africa p-2"></i>Strike Media Advert Share</span><span class="text-lg font-semibold">Bonus Given as a Registered User When You Successfully Share our Advert</span></li>
            <li class="w-full border-solid border-2 text-white my-2 md:mx-2 rounded-lg p-8 font-semibold md:w-1/4"><span class="text-md block w-full font-bold"><i class="fa fa-users-cog p-2"></i>Strike Media Social</span><span class="text-lg font-semibold">Bonus Given When You Successfully Perform Social Tasks Given Only for Active Register Users</span></li>
        </ul>
    </section>

    <section class="px-10 py-5">
        <h3 class="w-full text-center text-2xl font-semibold">Steps to get Started</h3>
        <div class="flex flex-wrap md:px-20">
            <ul class="w-full md:w-1/3 p-3 flex-nowrap justify-center">
                <li class="w-full py-3 text-center"><i class="fa fa-user-shield text-5xl"></i></li>
                <li class="w-full py-3 text-center text-2xl font-semibold">Sign Up</li>
                <li class="text-center py-3 px-20 w-full font-semibold">Click on "Join Us" On the Homepage, Enter the required Informations and Click The "Signup" Button To get Started</li>
            </ul>
            <ul class="w-full md:w-1/3 p-3 flex-nowrap justify-center">
                <li class="w-full py-3 text-center"><i class="fa fa-user-cog text-5xl"></i></li>
                <li class="w-full py-3 text-center text-2xl font-semibold">Set Up Profile</li>
                <li class="text-center py-3 px-20 w-full font-semibold">Click on "Profile" on the Dashboard, Setup User Information</li>
            </ul>
            <ul class="w-full md:w-1/3 p-3 flex-nowrap justify-center">
                <li class="w-full py-3 text-center"><i class="fa fa-users-cog text-5xl"></i></li>
                <li class="w-full py-3 text-center text-2xl font-semibold">Set Up Profile</li>
                <li class="text-center py-3 px-20 w-full font-semibold">Start Earning from Affiliate Bonus, Media Advert Sharing and Social media Tasks</li>
            </ul>
        </div>
    </section>
    <section class="flex justify-center">
        <div class="flex flex-wrap bg-white rounded-lg p-4 mx-4 mb-3 shadow-lg ring-0 ring-offset-0 w-full md:w-[40%]">
            <p class="w-full text-center text-lg font-semibold py-2">All the pesuasive reason why user should join All the pesuasive reason why user should join All the pesuasive reason why user should join All the pesuasive reason why user should join</p>
            <ul class="flex w-full justify-center py-2 flex-nowrap">
                <li class="m-3"><a href="#" class="p-3 px-4 bg-blue-600 text-white ring-0 ring-offset-0 rounded-xl transition-all duration-300 hover:shadow-lg hover:bg-blue-800 active:underline">Get Started</a></li>
                <li class="m-3"><a href="#" class="p-3 px-4 bg-black text-white ring-0 ring-offset-0 rounded-xl transition-all duration-300 hover:shadow-lg hover:bg-opacity-70 active:underline">My Account</a></li>
            </ul>
        </div>
    </section>
@endsection