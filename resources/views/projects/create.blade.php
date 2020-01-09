@extends ('layouts.app')
@section('content')

    <form method="POST"
          action="/projects"
          class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 rounded shadow"
    >
        <h1 class="text-2xl font-normal mb-10 text-center">
            Let's Start Something New
        </h1>


        @include ('projects.form', [
            'project'=> new App\Project(),
            'buttonText'=>'Create Project'
            ])

    </form>

@endsection