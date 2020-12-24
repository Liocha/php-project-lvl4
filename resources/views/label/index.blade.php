@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Labels</h1>
    @auth
    <div class="row">
        {{ link_to_route('labels.create', 'Add new', [],  ["class" => "btn btn-primary mr-auto"]) }}
    </div>
    @endauth
    <table class="table mt-2">
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                @auth
                    <th>Actions</th>
                @endauth
            </tr>
        </thead>
        @foreach ($labels as $label)
        <tr>
            <td>{{$label->id}}</td>
            <td>{{$label->name}}</td>
            <td>{{$label->description}}</td>
            <td>{{$label->created_at}}</td>
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
