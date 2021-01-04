@extends('layout')
@php
Helper::setErrorsEnv($errors);
@endphp
@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('task.add_new_task') }}</h1>
    {{ Form::open(['route' => 'tasks.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), ['class' => 'form-control' . Helper::getErrorClass('name')], __('task.name')) }}
        {{ Form::bsTextarea('description',
            old('description'),
            [
                'class' => 'form-control' . Helper::getErrorClass('description'),
                'cols' => '50',
                'rows' => '10',
                'id' => 'description'
            ],
            __('task.description'))
        }}
        {{ Form::bsSelect('status_id',
            $taskStatuses,
            [
                'class' => 'form-control' . Helper::getErrorClass('status_id'),
                'placeholder' => __('task.status')
            ],
            __('task.status')
            )
        }}
        {{ Form::bsSelect('assigned_to_id',
            $users,
            [
                'class' => 'form-control' . Helper::getErrorClass('assigned_to_id'),
                'placeholder' => __('task.assignee'),
            ],
            __('task.assignee'),
            )
        }}
        {{ Form::bsSelect('labels',
            $labels,
            [
                'class' => 'form-control' . Helper::getErrorClass('labels'),
                'multiple',
                'name' => 'labels[]'
            ],
            __('task.labels')
            )
        }}
        {{ Form::bsBtnSubmit(__('task.btn.create')) }}
    {{ Form::close() }}
</main>
@endsection
