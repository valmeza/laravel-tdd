<div class="cardz mt-3">
    <ul class="text-xs list-reset">
        @foreach($project->activity as $activity)
            <li class="{{ $loop->last ? '' : 'mb-1' }}">
                @include("projects.activity.$activity->description")
                <span class="text-gray-200">{{ $activity->created_at->diffForHumans() }}</span>
            </li>
        @endforeach
    </ul>
</div>
