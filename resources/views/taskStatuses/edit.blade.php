@extends('layout')
@php
Helper::setErrorsEnv($errors);
@endphp
@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('taskStatus.edit_title')}}</h1>
    {{ Form::open(['route' => ['task_statuses.update', $taskStatus], 'method' => 'patch', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name', $taskStatus->name), [
            'class' => 'form-control' . Helper::getErrorClass('name')
    ], __('taskStatus.name')) }}
        {{ Form::bsBtnSubmit( __('taskStatus.btn.update') )}}
    {{ Form::close() }}
</main>
@endsection
