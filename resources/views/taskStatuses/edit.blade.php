@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Edit Task Status</h1>
    {{ Form::open(['route' => ['task_statuses.update', $taskStatus], 'method' => 'patch', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name', $taskStatus->name), [
            'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : null)
        ]) }}
        {{ Form::bsBtnSubmit('Update') }}
    {{ Form::close() }}
</main>
@endsection
