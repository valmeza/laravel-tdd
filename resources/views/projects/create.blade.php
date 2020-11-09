@extends('layouts.app')


@section('content')

<div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
    <h1 class="text-2xl font-normal mb-10 text-center">Create Project</h1>
    
    <form method="POST" action="{{ route('projects.store') }}">
    
        @include('projects._form', [
            'project' => new App\Models\Project,
            'buttonText' => 'Create Project'
            ])
    
    </form>
</div>

@endsection    