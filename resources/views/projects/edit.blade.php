@extends('layouts.app')


@section('content')

<form method="POST" action="{{ route('projects.update', $project->id) }}">
    @csrf
    @method('PATCH')
    
    <h1 class="heading is-1">Edit Your Project</h1>

    <div class="field">
        <label class="label" for="title">Title</label>

        <div class="control">
            <input type="text" class="input" name="title" placeholder="Title" value="{{ $project->title }}">
        </div>
    </div>
    <div class="field">
        <label class="label" for="description">Description</label>

        <div class="control">
            <textarea name="description" class="textarea" placeholder="Description">{{ $project->description }}</textarea>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link">Edit Project</button>
            <a href="{{ $project->path() }}">Cancel</a>
        </div>
    </div>
</form>

@endsection