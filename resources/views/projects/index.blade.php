@extends('layouts.app')

@section('content')
    
    <header class="flex items-center mb-3 py-4">

        <div class="flex justify-between items-center w-full">

            <h2 class="text-gray-200 text-sm font-normal">My Projects</h2>

            <a href="{{route('projects.create')}}" class="button" >New Project</a>

        </div>

    </header>

    <main class="lg:flex flex-wrap -mx-3">
        @forelse ($projects as $item)
        <div class="lg:w-1/3 px-3 pb-6">
            <div class="bg-white rounded-lg p-5 shadow" style="height: 200px;">
                <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-400 pl-4">
                    <a href="{{ $item->path() }}">{{ $item->title }}</a>
                </h3>

                <div class="text-gray-200">{{ Str::limit($item->description, 100) }}</div>
            </div>
        </div>
        @empty
            <div>
                <h3>No Projects Yet.</h3>
            </div>
        @endforelse 
    </main>

@endsection
