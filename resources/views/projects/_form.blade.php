    @csrf

    <div class="field mb-6">
        <label class="label mb-2 block" for="title">Title</label>

        <div class="control">
            <input type="text" class="input bg-transparent border border-gray-300 rounded p-2 w-full" name="title" placeholder="Title" value="{{ $project->title }}" required>
        </div>
    </div>
    <div class="field">
        <label class="label mb-2 block" for="description">Description</label>

        <div class="control">
            <textarea name="description" rows="10" class="textarea bg-transparent border border-gray-300 rounded p-2 w-full"
                placeholder="Description" required>{{ $project->description }}</textarea>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button type="submit" class="button is-link mr-2">{{ $buttonText }}</button>
            <a href="{{ $project->path() }}">Cancel</a>
        </div>
    </div>
    
@if ($errors->any())
    <div class="field mt-6">
        @foreach ($errors->all() as $error)
            <li class="text-red-600">{{ $error }}</li>
        @endforeach
    </div>
 @endif
        