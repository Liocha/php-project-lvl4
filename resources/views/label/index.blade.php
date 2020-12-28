@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('label.title') }}</h1>
    @auth
    <div class="row">
        {{ link_to_route('labels.create', 'Add new', [],  ["class" => "btn btn-primary mr-auto"]) }}
    </div>
    @endauth
    <table class="table mt-2">
        <thead>
            <tr>
                <th>{{ __('label.id') }}</th>
                <th>{{ __('label.name') }}</th>
                <th>{{ __('label.description') }}</th>
                <th>{{ __('label.created_at') }}</th>
                @auth
                    <th>{{ __('label.actions') }}</th>
                @endauth
            </tr>
        </thead>
        @foreach ($labels as $label)
        <tr>
            <td>{{$label->id}}</td>
            <td>{{$label->name}}</td>
            <td>{{$label->description}}</td>
            <td>{{$label->created_at->format('M d Y')}}</td>
            @auth
                <td>
                    {{ Form::open(['route' => ['labels.destroy', $label], "class" => "d-inline-block", "method" => "delete"]) }}
                        {{ Form::bsBtnSubmit('Remove', ["onclick" => "return confirm('Are you sure?')", 'class' => "btn btn-danger btn-sm"]) }}
                    {{ Form::close() }}
                    {{ link_to_route('labels.edit', 'Edit', [$label], ["class" => "btn btn-secondary btn-sm"] )}}
                </td>
            @endauth
        </tr>
        @endforeach
    </table>
</main>
@endsection
