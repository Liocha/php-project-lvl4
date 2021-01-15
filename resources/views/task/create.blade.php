@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('task.add_new_task') }}</h1>
    {{ Form::open(['route' => 'tasks.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), [], __('task.name')) }}
        {{ Form::bsTextarea('description',
            old('description'),
            [
                'id' => 'description'
            ],
            __('task.description'))
        }}
        {{ Form::bsSelect('status_id',
            $taskStatuses,
            [
                'placeholder' => __('task.status')
            ],
            __('task.status')
            )
        }}
        {{ Form::bsSelect('assigned_to_id',
            $users,
            [
                'placeholder' => __('task.assignee'),
            ],
            __('task.assignee'),
            )
        }}
        {{ Form::bsSelect('labels',
            $labels,
            [
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
