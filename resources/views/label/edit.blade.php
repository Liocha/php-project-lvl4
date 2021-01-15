@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('label.edit_title') }}</h1>
    {{ Form::open(['route' => ['labels.update', $label], 'method' => 'patch', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name', $label->name), [], __('label.name') )}}
        {{ Form::bsTextarea('description', old('description', $label->description), ['id' => 'description'], __('label.description')) }}
        {{ Form::bsBtnSubmit( __('label.btn.update')) }}
    {{ Form::close() }}
</main>
@endsection
