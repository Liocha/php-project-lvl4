@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Task Status</h1>
    @can('create', App\Models\taskStatus::class)
    <div class="row">
        <a href="{{route('task_statuses.create')}}" class="btn btn-primary">Add new</a>
    </div>
    @endcan
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
                    <form method="post" action="{{ route('task_statuses.destroy', $taskStatus) }}" class="d-inline-block">
                        @method('delete')
                        @csrf
                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"> Remove </button >
                    </form>
                    <a class="btn btn-secondary btn-sm" href="{{ route('task_statuses.edit', $taskStatus)}}"> Edit </a > 
                </td>
            @endauth
        </tr>
        @endforeach
    </table>

</main>
@endsection 