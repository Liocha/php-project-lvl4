@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('label.create_title') }}</h1>
    {{ Form::open(['route' => 'labels.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), [], __('label.name')) }}
        {{ Form::bsTextarea('description', old('description'), ['id' => 'description'], __('label.description')) }}
        {{ Form::bsBtnSubmit(__('label.btn.create')) }}
    {{ Form::close() }}
</main>
@endsection
