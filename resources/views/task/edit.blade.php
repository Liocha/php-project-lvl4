@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('task.title') }}: {{ $task->name }}</h1>
    {{ Form::open(['route' => ['tasks.update', $task], 'method' => 'patch', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name', $task->name), [], __('task.name')) }}
        {{ Form::bsTextarea('description',
            old('description', $task->description),
            [
                'id' => 'description'
            ],
            __('task.description'))
        }}
        {{ Form::bsSelect('status_id',
            $taskStatuses,
            [
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
