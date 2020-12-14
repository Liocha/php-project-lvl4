@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Task</h1>
    <div class="row">
        <div>
            <form method="get" action="{{route('tasks.index')}}" accept-charset="UTF-8" class="form-inline">
                <select class="form-control mr-2" name="filter[status_id]">
                    <option value="">Status</option>
                    @foreach ($taskStatuses as $taskStatus)
                    <option {{ $acviteFiltrs['status_id'] == $taskStatus->id ? 'selected' : '' }} value="{{$taskStatus->id}}">{{$taskStatus->name}}</option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[created_by_id]">
                    <option value="">Creator</option>
                    @foreach ($users as $user)
                    <option {{ $acviteFiltrs['created_by_id'] == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                <select class="form-control mr-2" name="filter[assigned_to_id]">
                    <option value="">Assignee</option>
                    @foreach ($users as $user)
                    <option {{ $acviteFiltrs['assigned_to_id'] == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{$user->name}}</option>
                    @endforeach
                </select>
                <input class="btn btn-outline-primary mr-2" type="submit" value="Apply">
            </form>
        </div>
        @auth
        <a href="{{route('tasks.create')}}" class="btn btn-primary ml-auto">Add new</a>
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
                    @if($task->created_by_id === Auth::id())
                    <form method="post" action="{{ route('tasks.destroy', $task) }}" class="d-inline-block">
                        @method('delete')
                        @csrf
                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"> Remove </button >
                    </form>
                    @endif
                    <a class="btn btn-secondary btn-sm" href="{{ route('tasks.edit', $task)}}"> Edit </a > 
                </td>
            @endauth
        </tr>
        @endforeach
    </table>
</main>
@endsection 