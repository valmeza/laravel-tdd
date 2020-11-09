@extends('layouts.app')


@section('content')

    <form method="POST" action="{{route('projects.store')}}">
        @csrf

        <h1 class="heading is-1">Create a Project</h1>

        <div class="field">
            <label class="label" for="title">Title</label>

            <div class="control">
                <input type="text" class="input" name="title" placeholder="Title">
            </div>
        </div>
        <div class="field">
            <label class="label" for="description">Description</label>

            <div class="control">
                <textarea name="description" class="textarea" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Create Project</button>
                <a href="{{route('projects.index')}}">Cancel</a>
            </div>
        </div>
    </form>
    
@endsection    