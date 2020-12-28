@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('task.add_new_task') }}</h1>
    {{ Form::open(['route' => 'tasks.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : null)], __('task.name')) }}
        {{ Form::bsTextarea('description',
            old('description'),
            [
                'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : null),
                'cols' => '50',
                'rows' => '10',
                'id' => 'description'
            ],
            __('task.description'))
        }}
        {{ Form::bsSelect('status_id',
            $taskStatuses,
            [
                'class' => 'form-control' . ($errors->has('status_id') ? ' is-invalid' : null),
                'placeholder' => __('task.status')
            ],
            __('task.status')
            )
        }}
        {{ Form::bsSelect('assigned_to_id',
            $users,
            [
                'class' => 'form-control' . ($errors->has('assigned_to_id') ? ' is-invalid' : null),
                'placeholder' => __('task.assignee'),
            ],
            __('task.assignee'),
            )
        }}
        {{ Form::bsSelect('labels',
            $labels,
            [
                'class' => 'form-control' . ($errors->has('labels') ? ' is-invalid' : null),
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
