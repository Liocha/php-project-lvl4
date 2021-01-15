@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('task.title') }}</h1>
    <div class="row p-3">
        <div>
            {{ Form::open(['route' => ['tasks.index'], 'method' => 'get', 'class' => 'form-inline']) }}
                {{ Form::bsSelect('filter[status_id]',
                    $taskStatuses,
                    [
                        'class' => 'form-control mr-2',
                        'placeholder' => __('task.search_form.status')
                    ],
                    false,
                    $activeFilters['status_id'],

                )}}
                {{ Form::bsSelect('filter[created_by_id]',
                    $users,
                    [
                        'class' => 'form-control mr-2',
                        'placeholder' => __('task.search_form.creator')
                    ],
                    false,
                    $activeFilters['created_by_id'],

                )}}
                {{ Form::bsSelect('filter[assigned_to_id]',
                    $users,
                    [
                        'class' => 'form-control mr-2',
                        'placeholder' => __('task.search_form.assignee')
                    ],
                    false,
                    $activeFilters['assigned_to_id'],

                )}}
                {{ Form::bsBtnSubmit(__('task.search_form.apply')) }}
            {{ Form::close() }}
        </div>
        @auth
        {{ link_to_route('tasks.create', __('task.btn.add_new'), [],  ["class" => "btn btn-primary ml-auto"]) }}
        @endauth
    </div>
    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('task.id') }}</th>
                <th>{{ __('task.status') }}</th>
                <th>{{ __('task.name') }}</th>
                <th>{{ __('task.creator') }}</th>
                <th>{{ __('task.assignee') }}</th>
                <th>{{ __('task.created_at') }}</th>
                @auth
                <th>{{ __('task.actions') }}</th>
                @endauth
            </tr>
        </thead>
        @foreach ($tasks as $task)
        <tr>
            <td>{{$task->id}}</td>
            <td>{{optional($task->status)->name}}</td>
            <td><a href="{{route('tasks.show', $task)}}">{{$task->name}}</a></td>
            <td>{{optional($task->creator)->name}}</td>
            <td>{{optional($task->assignee)->name}}</td>
            <td>{{$task->created_at->format('M d Y')}}</td>
            @auth
            <td>
                @if($task->created_by_id == Auth::id())
                <a href="{{route('tasks.destroy', $task)}}"
                   data-confirm="{{ __('messages.alert.confirm') }}"
                   data-method="delete"
                   rel="nofollow"
                   class="btn btn-danger btn-sm">
                   {{ __('task.btn.remove') }}
                </a>
                @endif
                {{ link_to_route('tasks.edit',  __('task.btn.edit'), [$task], ["class" => "btn btn-secondary btn-sm"] )}}
            </td>
            @endauth
        </tr>
        @endforeach
    </table>
</main>
@endsection
