@extends('layouts.app')

@section('content')

<h1>{{ $project->title }}</h1>
<p>{{ $project->description }}</p>
<a href="{{route('projects.index')}}">Go Back</a>
    
@endsection