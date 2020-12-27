@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Task Status</h1>
    @auth
    <div class="row">
        {{ link_to_route('task_statuses.create', 'Add new', [],  ["class" => "btn btn-primary"]) }}
    </div>
    @endauth
    <table class="table mt-2">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created At</th>
                @auth
                <th>Actions</th>
                @endauth
            </tr>
        </thead>
        @foreach ($taskStatuses as $taskStatus)
        <tr>
            <td>{{$taskStatus->id}}</td>
            <td>{{$taskStatus->name}}</td>
            <td>{{$taskStatus->created_at}}</td>
            @auth
                <td>
                    {{ Form::open(['route' => ['task_statuses.destroy', $taskStatus], "class" => "d-inline-block", "method" => "delete"]) }}
                        {{ Form::bsBtnSubmit('Remove', ["onclick" => "return confirm('Are you sure?')", 'class' => "btn btn-danger btn-sm"]) }}
                    {{ Form::close() }}
                    {{ link_to_route('task_statuses.edit', 'Edit', [$taskStatus], ["class" => "btn btn-secondary btn-sm"] )}}
                </td>
            @endauth
        </tr>
        @endforeach
    </table>

</main>
@endsection
