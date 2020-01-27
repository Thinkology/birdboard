@if (count($activity->changes['after']) == 1)
    {{$activity->user->name}} updated the {{ key($activity->changes['after']) }} of a project
@else
    {{$activity->user->name}} updated the project
@endif