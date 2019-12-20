@extends ('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 w-1/2 mx-auto">
                <div class="card">
                    <div class="card-header text-center text-xl">{{ __('Let\'s start something new') }}</div>

                    <div class="card-body">

                        <form method="POST" action="/projects">
                            @csrf

                            <div class="field">
                                <label for="" class="text-sm text-md-right">Title</label>

                                <div class="control">
                                    <input name="title" type="text" class="p-2 rounded-lg border-gray-300 border w-full" >
                                </div>

                            </div>

                            <div class="field  mt-3">
                                <label class="text-sm text-md-right">Description</label>
                                <div class="control">
                                    <textarea name="description" class="rounded-lg p-2 border-gray-300 border w-full"></textarea>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <button type="submit" class="button mt-3 mr-3 is-link">Create Project</button>
                                    <a href="/projects">Cancel</a>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection