@csrf


<div class="field">
    <label for="" class="text-sm text-md-right">Title</label>

    <div class="control">
        <input
                name="title"
                required
                type="text"
                value="{{$project->title}}"
                class="p-2 rounded-lg border-gray-300 border w-full">
    </div>

</div>

<div class="field  mt-3">
    <label class="text-sm text-md-right">Description</label>
    <div class="control">
        <textarea name="description"
                  rows="10"
                  required
                  class="rounded-lg p-2 border-gray-300 border w-full">{{$project->description}}
        </textarea>
    </div>
</div>

<div class="field">
    <div class="control">
        <button type="submit" class="button mt-3 mr-3 is-link">{{$buttonText}}</button>
        <a href="{{$project->path() }}">Cancel</a>
    </div>
</div>

@if ($errors->any())
    <div class="field mt-6">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red">{{$error}}</li>
        @endforeach
    </div>
@endif



