@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Task Status</h1>
    <div class="row">
        <a href="{{route('task_statuses.create')}}" class="btn btn-primary">Add new</a>
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        @foreach ($taskStatuses as $taskStatus)    
        <tr>
            <td>{{$taskStatus->id}}</td>
            <td>{{$taskStatus->name}}</td>
            <td>{{$taskStatus->created_at}}</td>
            <td> 
                <form method="post" action="{{ route('task_statuses.destroy', $taskStatus->id) }}" class="d-inline-block">
                        @method('delete')
                        @csrf
                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"> Remove </button >
                </form>    
                <a class="btn btn-secondary btn-sm" href="{{ route('task_statuses.edit', $taskStatus->id)}}"> Edit </a > 
            </td>
        </tr>
        @endforeach
    </table>
</main>
@endsection 