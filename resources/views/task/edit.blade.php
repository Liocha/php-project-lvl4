@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Task:{{ $task->name }}</h1>
    <form method="post" action="{{ route('tasks.update', $task )}}" accept-charset="UTF-8" class="w-50">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control @error('name') is-invalid @enderror"  name="name" type="text" id="name" value="{{ $task->name }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description">{{ $task->description }}</textarea>  
        </div>
        <div class="form-group">
            <label for="status_id">Status</label>
            <select class="form-control @error('status_id') is-invalid @enderror" id="status_id" name="status_id" value={{$task->status_id}} >
                @foreach ($taskStatuses as $taskStatus)
                <option {{ $task->status_id === $taskStatus->id ? 'selected' : '' }} value="{{$taskStatus->id}}">{{$taskStatus->name}}</option>
                @endforeach
            </select>
            @error('status_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="assigned_to_id">Assignee</label>
            <select class="form-control" id="assigned_to_id" name="assigned_to_id">
                @foreach ($users as $user)
                <option  {{ $task->assigned_to_id === $user->id ? 'selected' : '' }} value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="labels">Labels</label>
            <select class="form-control" multiple name="labels[]">
                <option value=""></option>
                @foreach ($labels as $label)
                <option {{ in_array($label->id, $taskLables) ? 'selected' : '' }} value="{{$label->id}}">{{$label->name}}</option>
                @endforeach
            </select>
            </div>
        <input class="btn btn-primary" type="submit" value="Update">
        </form>
</main>
@endsection