@extends ('layouts.app')
@section('content')
<body>

    <form method="POST" action="/projects">
        @csrf

        <h1>Create a project</h1>

        <div class="field">
            <label for="" class="label">Title</label>

            <div class="control">
                <input name="title" type="text" class="input" placeholder="Title">
            </div>

        </div>

        <div class="field">
            <label class="label">Description</label>
            <div class="control">
                <textarea name="description" class="textarea" placeholder="Description"></textarea>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button is-link">Create Project</button>
                <a href="/projects">Cancel</a>
            </div>
        </div>


    </form>
@endsection