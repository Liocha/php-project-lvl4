@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Task</h1>
    <div class="row">
        <a href="{{route('task.create')}}" class="btn btn-primary ml-auto">Add new</a>
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>Id</th>
                <th>Status</th>
                <th>Name</th>
                <th>Creator</th>
                <th>Assignee</th>
                <th>Created At</th>
            </tr>
        </thead>
        @foreach ($tasks as $task)    
        <tr>
            <td>{{$task->id}}</td>
            <td>{{optional($task->status)->name}}</td>
            <td><a href="{{route('task.show', $task)}}">{{$task->name}}</a></td>
            <td>{{optional($task->creator)->name}}</td>
            <td>{{optional($task->assignee)->name}}</td>
            <td>{{$task->created_at}}</td>
        </tr>
        @endforeach
    </table>
</main>
@endsection 