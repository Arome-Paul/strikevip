@extends('layouts.admin')
@section('content')
    <h2 class="font-bold text-lg p-3">Admins ({{$users->count()}})</h2>

    <div class="overflow-x-scroll">
        @if($users->count() > 0)
            <table class="w-[1200px] table bg-white ring-0 ring-offset-0 shadow-lg mx-2 rounded-lg p-3 border-solid border-b-2 border-b-gray-300">
                <thead>
                    <tr class="flex w-full text-left py-3 border-solid border-b-2 border-opacity-50">
                        <th class="w-[10%] text-center">ID</th>
                        <th class="w-[25%] text-center">NAME</th>
                        <th class="w-[10%] text-center">STATUS</th>
                        <th class="w-[15%] text-center">JOINED AT</th>
                        <th class="w-[10%] text-center"></th>
                        <th class="w-[10%] text-center">LEVEL</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->count() > 0)
                        @for($i = 0; $i < count($users); $i++)
                            <tr class="flex w-full my-5 pb-3">
                                <td class="flex w-[10%] justify-center items-center font-semibold">{{$users[$i]->id}}</td>
                                <td class="flex justify-center w-[25%]"><div class="flex flex-wrap justify-center items-center"><span class="font-semibold capitalize w-full">{{$users[$i]->fullname}}</span><span class="w-full text-xs font-semibold">{{$users[$i]->email}}</span><span class="w-full text-xs font-semibold">{{$users[$i]->tel}}</span></div></td>
                                <td class="w-[10%] flex justify-center items-center"><span class="{{$users[$i]->status}} text-xs p-2 rounded-lg font-bold">{{$users[$i]->status}}</span></td>
                                <td class="w-[15%] flex justify-center items-center">{{date('d-m-y', strtotime($users[$i]->created_at))}}</td>
                                <td class="w-[10%] flex justify-center items-center">
                                    @if($users[$i]->id == 1 || $users[$i]->id == 2 || $users[$i]->id == 3)

                                    @else
                                        <a href="{{route('remove.admin', ['id' => $users[$i]->id])}}" class="text-red-700 font-semibold hover:underline hover:text-black"><i class="fa fa-minus-circle p-2"></i>Remove</a>
                                    @endif
                                </td>
                                <td class="w-[15%] flex justify-center items-center">
                                    @if($users[$i]->id == 1 || $users[$i]->id == 2 || $users[$i]->id == 3)
                                        <span class="text-xs py-1 px-2 rounded-lg bg-gray-200 font-semibold capitalize">Global Admin</span>
                                    @else
                                        <span class="text-xs py-1 px-2 rounded-lg bg-gray-200 font-semibold capitalize">Admin</span>
                                    @endif
                                </td>
                            </tr>
                        @endfor
                    @endif
                </tbody> 
                <tfoot>
                    <tr>
                        <td><a href="{{route('add.admin')}}" class="bg-blue-600 px-4 text-white m-2 py-2 rounded-lg font-semibold float-right ring-offset-0 ring-0 transition-all hover:shadow-lg active:bg-opacity-50 hover:bg-blue-800"><i class="fa fa-user-plus p-2"></i>Add Admin</a></td>
                    </tr>
                </tfoot>
            </table>
            <p class="py-3">{{$users->links()}}</p>
        @else
            <p class="capitalize flex items-center justify-center w-full text-2xl pt-16">No User</p>
        @endif
    </div>
    <hr class="clear-both invisible pb-20">
@endsection