@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Add New Task</h1>
    {{ Form::open(['route' => 'tasks.store', 'class' => 'w-50']) }}
        {{ Form::bsText('name', old('name'), ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : null)]) }}
        {{ Form::bsTextarea('description',
            old('description'),
            [
                'class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : null),
                'cols' => '50',
                'rows' => '10',
                'id' => 'description'
            ])
        }}
        {{ Form::bsSelect('status_id',
            $taskStatuses,
            [
                'class' => 'form-control' . ($errors->has('status_id') ? ' is-invalid' : null),
                'placeholder' => 'Status'
            ],
            'Status'
            )
        }}
        {{ Form::bsSelect('assigned_to_id',
            $users,
            [
                'class' => 'form-control' . ($errors->has('assigned_to_id') ? ' is-invalid' : null),
                'placeholder' => 'Assignee',
            ],
            'Assignee'
            )
        }}
        {{ Form::bsSelect('labels',
            $labels,
            [
                'class' => 'form-control' . ($errors->has('labels') ? ' is-invalid' : null),
                'multiple',
                'name' => 'labels[]'
            ],
            'Labels'
            )
        }}
        {{ Form::bsBtnSubmit('Create') }}
    {{ Form::close() }}
</main>
@endsection
