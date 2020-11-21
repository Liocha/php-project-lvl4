@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Edit Task Status</h1>
    <form method="post" action="{{ route('task_statuses.update', $taskStatus->id) }}" accept-charset="UTF-8" class="w-50">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="name">{{$taskStatus->name}}</label>
            <input class="form-control" name="name" type="text" value="{{$taskStatus->name}}" id="name">
        </div>
        <input class="btn btn-primary" type="submit" value="Update">
    </form>
</main>
@endsection 