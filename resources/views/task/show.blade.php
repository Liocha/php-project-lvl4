@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">
        {{ __('task.title') }}: {{$task->name}} <a href="{{route('tasks.edit', $task)}}">⚙</a>
    </h1>
    <p>{{__('task.name')}}: {{$task->name}}</p>
    <p>{{__('task.status')}}: {{$statusName}}</p>
    <p>{{__('task.description')}}: {{$task->description}}</p>
    <p>{{__('task.labels')}}: </p>
    <ul>
        @foreach ($labels as $label)
        <li>{{$label->name}}</li>
        @endforeach
    </ul>
    <h2 class="mb-2 mt-5">{{__('task.comments')}}</h2>
    @auth
    <form method="post" action="{{ route('tasks.comments.store', $task)}}" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
            <label for="description">{{ __('task.comment_content')}}</label>
            <textarea class="form-control @error('body') is-invalid @enderror" name="body" cols="50" rows="10" id="content">{{ old('body') }}</textarea>
            @error('body')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <input class="btn btn-primary" type="submit" value="{{ __('task.btn.comment_create')}}">
    </form>
    @endauth
    @foreach ($comments as $comment)
        <div class="mt-2">
            <h6>{{$comment->creator->name}}</h6>
            <p>{{$comment->body}}</p>
        </div>
    @endforeach


</main>
@endsection

