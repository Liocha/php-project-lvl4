@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Add New Task Status</h1>
    {{ Form::open(['route' => 'task_statuses.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), [
            'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : null)
        ]) }}
        {{ Form::bsBtnSubmit('Create') }}
    {{ Form::close() }}
</main>
@endsection
