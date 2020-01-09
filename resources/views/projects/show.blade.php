@extends ('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-600 text-sm font-normal">
                <a href="/projects">My Projects</a> / {{$project->title}}
            </p>
            <a href="{{$project->path()}}/edit" class="button no-underline">Edit Project</a>
        </div>

    </header>
    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-600 font-normal mb-3">Tasks</h2>
                    {{--tasks--}}
                    @foreach($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="POST" action="{{$task->path()}}">
                                @method('PATCH')
                                @csrf

                                <div class="flex">
                                    <input type="text" value="{{ $task->body }}" name="body" class="w-full {{$task->completed ? 'text-gray-600' : ''}}">
                                    <input type="checkbox" name="completed" onclick="this.form.submit()" {{$task->completed ? 'checked' : ''}} >
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{$project->path()}}/tasks" method="POST">
                            @csrf
                            <input name="body" type="text" placeholder="Add a new task...">
                        </form>
                    </div>
                </div>
                {{--General Notes--}}
                <form  action="{{$project->path()}}" method="POST">
                    @csrf
                    @method('PATCH')
                    <h2 class="text-lg text-gray-600 font-normal mb-3">General Notes</h2>
                    <textarea name="notes" class="card w-full mb-2" style="min-height: 200px;" placeholder="Add notes here...">{{$project->notes}}</textarea>
                    <button type="submit" class="button">Save</button>
                </form>

                @if ($errors->any())
                    <div class="field mt-6">
                        @foreach($errors->all() as $error)
                            <li class="text-sm text-red">{{$error}}</li>
                        @endforeach
                    </div>
                @endif


            </div>
            <div class="lg:w-1/4 px-3">
                @include ('projects.card')
            </div>
        </div>
    </main>

@endsection