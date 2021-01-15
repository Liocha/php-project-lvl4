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
    {{ Form::open(['route' => ['tasks.comments.store', $task], 'class' => 'w-50']) }}
        {{ Form::bsTextarea('body', old('body'), ['id' => 'content'], __('task.comment_content')) }}
        {{ Form::bsBtnSubmit( __('task.btn.comment_create')) }}
    {{ Form::close() }}
    @endauth
    @foreach ($comments as $comment)
        <div class="mt-2">
            <h6>{{$comment->creator->name}}</h6>
            <p>{{$comment->body}}</p>
        </div>
    @endforeach


</main>
@endsection

