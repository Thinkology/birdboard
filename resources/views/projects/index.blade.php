@extends ('layouts.app')
@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between items-end w-full">
            <h2 class="text-gray-600 text-sm font-normal">My Projects</h2>
            <a href="/projects/create" class="button no-underline">Create project</a>
        </div>

    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-white  p-5 rounded-lg shadow " style="height: 200px;">
                    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-400 pl-4">
                        <a href="{{$project->path()}}">{{$project->title}}</a>
                    </h3>
                    <div class="text-gray-600">{{Str::limit($project->description,130)}}</div>
                </div>
            </div>

        @empty
            <div class="text-grey">No projects yet</div>
        @endforelse
    </main>


@endsection