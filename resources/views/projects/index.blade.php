@extends('layouts.app')

@section('content')
    
    <div class="flex items-center">
        <a href="{{route('projects.create')}}">Create New Project</a>
    </div>

    <div class="flex">
        @forelse ($projects as $item)
            <div class="bg-white mr-4 rounded p-5 shadow w-1/3" style="height: 200px;">
                <h3 class="font-normal text-xl py-4">{{ $item->title }}</h3>

                <div class="text-gray-200">{{ Str::limit($item->description, 100) }}</div>
            </div>
        @empty
            <div>
                <h3>No Projects Yet.</h3>
            </div>
        @endforelse 
    </div>

@endsection
