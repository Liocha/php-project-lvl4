@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Task:{{ $task->name }}</h1>
    <form method="post" action="{{ route('tasks.update', $task )}}" accept-charset="UTF-8" class="w-50">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control @error('name') is-invalid @enderror"  name="name" type="text" id="name" value="{{ old('name', $task->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" cols="50" rows="10" id="description">{{ old('description', $task->description) }}</textarea>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror 
        </div>
        <div class="form-group">
            <label for="status_id">Status</label>
            <select class="form-control @error('status_id') is-invalid @enderror" id="status_id" name="status_id" value={{$task->status_id}} >
                <option value="">Status</option>
                @foreach ($taskStatuses as $taskStatus)
                    <option {{ old('status_id', $task->status_id) == $taskStatus->id ? 'selected' : '' }} value="{{$taskStatus->id}}">{{$taskStatus->name}}</option>
                @endforeach
            </select>
            @error('status_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="assigned_to_id">Assignee</label>
            <select class="form-control @error('assigned_to_id') is-invalid @enderror" id="assigned_to_id" name="assigned_to_id">
                <option value="">Assignee</option>
                @foreach ($users as $user)
                    <option  {{ old('assigned_to_id', $task->assigned_to_id) == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{$user->name}}</option>
                @endforeach
            </select>
            @error('assigned_to_id')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="labels">Labels</label>
            <select class="form-control" multiple name="labels[]">
                <option value=""></option>
                @foreach ($labels as $label)
                @if (old('labels'))
                    <option {{ in_array($label->id, old('labels')) ? 'selected' : '' }} value="{{$label->id}}">{{$label->name}}</option> 
                @else
                    <option {{ in_array($label->id, $taskLables) ? 'selected' : '' }} value="{{$label->id}}">{{$label->name}}</option>    
                @endif
                @endforeach
            </select>
            </div>
        <input class="btn btn-primary" type="submit" value="Update">
        </form>
</main>
@endsection