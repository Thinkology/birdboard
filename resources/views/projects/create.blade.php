<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create a project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    {{--<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>--}}
</head>
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
            </div>
        </div>


    </form>
</body>
</html>