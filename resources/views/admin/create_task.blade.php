@extends('layouts.admin')
@section('content')
<h2 class="p-3 text-lg font-semibold">Create Task</h2>
<form action="{{route('create.task')}}" method="post" class="w-full md:w-1/2 p-3">
    @csrf
    <label for="description" class="w-full my-2">Description</label>
    <textarea name="description" id="description" class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg">Task Description</textarea>

    <label for="url" class="w-full my-2">Task Link</label>
    <input type="url" name="url" placeholder="Task Link" required autoficus class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg">

    <label for="social" class="w-full my-2">Social Media Platform</label>
    <select name="social" id="social" class="w-full capitalize p-2 my-1 bg-white outline-blue-800 border-solid border-2 rounded-lg">
        <option value="0">Social Media Platform</option>
        <option value="facebook">Facebook</option>
        <option value="whatsapp">Whatsapp</option>
        <option value="x">X</option>
        <option value="youtube">Youtube</option>
        <option value="telegram">Telegram</option>
    </select>

    <label for="type" class="w-full my-2">Task Type</label>
    <select name="type" id="type" class="w-full capitalize p-2 my-1 bg-white outline-blue-800 border-solid border-2 rounded-lg">
        <option value="0">Type</option>
        <option value="likes">Like</option>
        <option value="comment">Comment</option>
        <option value="follow">Follow</option>
    </select>

    <label for="limit" class="w-full my-2">Limits</label>
    <input type="number" name="limit" placeholder="Limit" id="limits" class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg">

    <label for="amount" class="w-full my-2">Amount</label>
    <input type="text" name="amount" placeholder="amount" class="w-full p-2 my-1 rounded-lg outline-none focus:outline-blue-800 ring-offset-0 ring-0 focus:shadow-lg hover:shadow-lg">
    <button type="submit" class="bg-blue-800 float-right rounded-lg p-3 my-3 text-xs px-5 shadow-black ring-offset-0 ring-0 active:shadow-lg text-white hover:bg-blue-500">Create</button>
</form>
@endsection