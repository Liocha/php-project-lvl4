@extends('layout')
@php
Helper::setErrorsEnv($errors);
@endphp
@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('label.create_title') }}</h1>
    {{ Form::open(['route' => 'labels.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), [
            'class' => 'form-control' . Helper::getErrorClass('name')
        ], __('label.name') )}}
        {{ Form::bsTextarea('description', old('description'), [
            'class' => 'form-control' . Helper::getErrorClass('description'),
            'cols' => '50',
            'rows' => '10',
            'id' => 'description'],
            __('label.description')
            )}}
        {{ Form::bsBtnSubmit(__('label.btn.create')) }}
    {{ Form::close() }}
</main>
@endsection
