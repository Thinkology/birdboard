<div class="card" style="height: 200px;">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 border-blue-400 pl-4">
        <a href="{{$project->path()}}">{{$project->title}}</a>
    </h3>
    <div class="text-gray-600 mb-4">{{Str::limit($project->description,80)}}</div>
    <footer>
        <form method="POST" action="{{$project->path()}}" class="text-right">
            @method('DELETE')
            @csrf
            <button class="text-xs" type="submit">Delete</button>
        </form>
    </footer>
</div>
