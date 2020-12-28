@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('taskStatus.create_title')}}</h1>
    {{ Form::open(['route' => 'task_statuses.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), [
            'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : null)
        ], __('taskStatus.name')) }}
        {{ Form::bsBtnSubmit( __('taskStatus.btn.create')) }}
    {{ Form::close() }}
</main>
@endsection
