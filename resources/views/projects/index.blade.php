@extends('layouts.app')

@section('content')
    
    <div class="flex items-center">
        <a href="{{route('projects.create')}}">Create New Project</a>
    </div>

    <div class="flex">
        @forelse ($projects as $item)
            <div class="bg-white mr-4 rounded shadow">
                <h3>{{ $item->title }}</h3>

                <div>{{ $item->description }}</div>
            </div>
        @empty
            <div>
                <h3>No Projects Yet.</h3>
            </div>
        @endforelse 
    </div>

@endsection