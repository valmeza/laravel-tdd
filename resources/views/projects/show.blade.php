@extends('layouts.app')

@section('content')

 <header class="flex items-center mb-3 py-4">

    <div class="flex justify-between items-end w-full">

        <p class="text-gray-200 text-sm font-normal">
            <a href="{{ route('projects.index') }}">My Projects</a> / {{$project->title}}
        </p>

        <a href="{{route('projects.create')}}" class="button" >New Project</a>

    </div>

</header>

<main>
    <div class="lg:flex -mx-3">
        <div class="lg:w-3/4 px-3 mb-6">

            <div class="mb-8">
                {{-- tasks --}}
                <h2 class="text-gray-200 font-normal mb-3">Tasks</h2>

                <div class="cardz mb-3">Lorem ipsum</div>
                <div class="cardz mb-3">Lorem ipsum</div>
                <div class="cardz mb-3">Lorem ipsum</div>
                <div class="cardz">Lorem ipsum</div>


            </div>

             <div>

                <h2 class="text-gray-200 font-normal mb-3">General Notes</h2>

                {{-- general notes --}}
                <textarea class="cardz w-full" style="min-height: 200px;">Lorem ipsum</textarea>

             </div>

        </div>

        <div class="lg:w-1/4 px-3 my-3">

            <div class="my-6">

                @include('projects.card')

            </div>

        </div>
    </div>
</main>

@endsection