@extends('layout')
@php
Helper::setErrorsEnv($errors);
@endphp
@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('task.title') }}: {{ $task->name }}</h1>
    {{ Form::open(['route' => ['tasks.update', $task], 'method' => 'patch', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name', $task->name), ['class' => 'form-control' . Helper::getErrorClass('name')], __('task.name')) }}
        {{ Form::bsTextarea('description',
            old('description', $task->description),
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
                'placeholder' => __('task.status'),
                'value' => old('status_id', $task->status_id),
            ],
            __('task.status'),
            old('status_id', $task->status_id)
            )
        }}
        {{ Form::bsSelect('assigned_to_id',
                $users,
                [
                    'class' => 'form-control' . Helper::getErrorClass('assigned_to_id'),
                    'placeholder' => __('task.assignee'),
                    'value' => old('assigned_to_id', $task->assigned_to_id),
                ],
                __('task.assignee'),
                old('assigned_to_id', $task->assigned_to_id)
                )
        }}
        {{ Form::bsSelect('labels',
                $labels,
                [
                    'class' => 'form-control' . Helper::getErrorClass('labels'),
                    'multiple',
                    'name' => 'labels[]'
                ],
                __('task.labels'),
                old('labels', $taskLabels)
                )
        }}
        {{ Form::bsBtnSubmit(__('task.btn.update')) }}
    {{ Form::close() }}
</main>
@endsection
