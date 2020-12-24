@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Add New Label</h1>
    {{ Form::open(['route' => 'labels.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), [
            'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : null)
        ]) }}
        {{ Form::bsTextarea('description', old('description'), [
            'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : null),
            'cols' => '50',
            'rows' => '10',
            'id' => 'description'
        ]) }}
        {{ Form::bsBtnSubmit('Create') }}
    {{ Form::close() }}
</main>
@endsection
