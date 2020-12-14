@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">
        Task: {{$task->name}} <a href="{{route('tasks.edit', $task)}}">⚙</a>
    </h1>
    <p>Name: {{$task->name}}</p>
    <p>Status: {{$statusName}}</p>
    <p>Description: {{$task->description}}</p>
    <p>Labels:</p>
    <ul>
        @foreach ($labels as $label)
        <li>{{$label->name}}</li>
        @endforeach
    </ul>
    <h2 class="mb-2 mt-5">Comments</h2>
    @auth
    <form method="post" action="{{ route('tasks.comments.store', $task)}}" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
            <label for="description">Content</label>
            <textarea class="form-control @error('content') is-invalid @enderror" name="content" cols="50" rows="10" id="content">{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror  
        </div>
        <input class="btn btn-primary" type="submit" value="Create">
    </form>
    @endauth
    @foreach ($comments as $comment)
        <div class="mt-2">
            <h6>{{$comment->creator->name}}</h6>
            <p>{{$comment->content}}</p>
        </div>
    @endforeach


</main>
@endsection 

