@extends('layouts.app')

@section('content')
    
    <div class="flex items-center">
        <a href="{{route('projects.create')}}">Create New Project</a>
    </div>

    <ul>
        @forelse ($projects as $item)
            <li>
                <a href="{{$item->path()}}">{{$item->title}}</a>
            </li> 

        @empty
        
            <li>No Projects Yet</li>

        @endforelse
    </ul>   

@endsection