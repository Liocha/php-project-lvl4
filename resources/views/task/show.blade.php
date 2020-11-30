@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">
        Task: {{$task->name}} <a href="{{route('tasks.edit', $task)}}">⚙</a>
    </h1>
    <p>Name: {{$task->name}}</p>
    <p>Status: {{$statusName}}</p>
    <p>Description: {{$task->description}}</p>
</main>
@endsection 

