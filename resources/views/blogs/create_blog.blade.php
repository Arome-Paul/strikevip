@extends('layouts.admin')
@section('content')
    <div class="w-full p-3">
        <div class="w-full md:w-1/2 float-left">
            <h3 class="opacity-85 mb-1 font-semibold text-lg">Create Post</h3>
            <form enctype="multipart/form-data" method="POST" action="{{ route('blogcreate') }}" class="w-full">
                @csrf
                @method('put')
                <label for="title" class="w-full my-2">Post Title</label>
                <input type="text" placeholder="Post Title" name="title" required autofocus class="w-full p-2 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg">
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <input type="file" name="image">
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                <button class="my-2 p-2 rounded-lg font-semibold ring-0 ring-offset-0 hover:shadow-lg border-solid border-2"><i class="fa fa-image pr-2"></i>Upload Image</button>
                <p class="text-xs mb-2 opacity-50">only JPG, GIF & PNG are allowed ith maximum size of 5mb</p>
                <textarea name="article" id="article" cols="40" rows="10" required autofocus class="w-full p-2 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg">Post Body</textarea>
                <x-input-error :messages="$errors->get('article')" class="mt-2" />
                <button type="submit" class="p-2 rounded-lg font-semibold my-2 bg-blue-800 text-white border-solid border-2 ring-0 ring-offset-0 hover:shadow-lg active:bg-opacity-60 active:underline">Create Post</button>
            </form>
        </div>
        <div class="w-full md:w-2/6 p-2 float-right ml-auto">
            
        </div>
    </div>
@endsection