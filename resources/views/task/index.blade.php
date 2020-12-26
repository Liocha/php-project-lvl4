@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Task</h1>
    <div class="row">
        <div>
            {{ Form::open(['route' => ['tasks.index'], 'method' => 'get', 'class' => 'form-inline']) }}
                {{ Form::bsSelect('filter[status_id]',
                    $taskStatuses,
                    [
                        'class' => 'form-control mr-2',
                        'placeholder' => 'Status'
                    ],
                    'Status',
                    $acviteFiltrs['status_id'],
                    false
                )}}
                {{ Form::bsSelect('filter[created_by_id]',
                    $users,
                    [
                        'class' => 'form-control mr-2',
                        'placeholder' => 'Creator'
                    ],
                    'Creator',
                    $acviteFiltrs['created_by_id'],
                    false
                )}}
                {{ Form::bsSelect('filter[assigned_to_id]',
                    $users,
                    [
                        'class' => 'form-control mr-2',
                        'placeholder' => 'Assignee'
                    ],
                    'Assignee',
                    $acviteFiltrs['assigned_to_id'],
                    false
                )}}
                {{ Form::bsBtnSubmit('Apply') }}
            {{ Form::close() }}
        </div>
        @auth
        {{ link_to_route('tasks.create', 'Add new', [],  ["class" => "btn btn-primary ml-auto"]) }}
        @endauth
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
                @auth
                    <th>Actions</th>
                @endauth
            </tr>
        </thead>
        @foreach ($tasks as $task)
        <tr>
            <td>{{$task->id}}</td>
            <td>{{optional($task->status)->name}}</td>
            <td><a href="{{route('tasks.show', $task)}}">{{$task->name}}</a></td>
            <td>{{optional($task->creator)->name}}</td>
            <td>{{optional($task->assignee)->name}}</td>
            <td>{{$task->created_at}}</td>
            @auth
            <td>
                @if($task->created_by_id == Auth::id())
                {{ Form::open(['route' => ['tasks.destroy', $task], "class" => "d-inline-block", "method" => "delete"]) }}
                    {{ Form::bsBtnSubmit('Remove', ["onclick" => "return confirm('Are you sure?')", 'class' => "btn btn-danger btn-sm"]) }}
                {{ Form::close() }}
                @endif
                {{ link_to_route('tasks.edit', 'Edit', [$task], ["class" => "btn btn-secondary btn-sm"] )}}
            </td>
            @endauth
        </tr>
        @endforeach
    </table>
</main>
@endsection
