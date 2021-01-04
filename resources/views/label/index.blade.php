@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">{{ __('label.title') }}</h1>
    @auth
    <div class="row">
        {{ link_to_route('labels.create', __('label.btn.add_new'), [],  ["class" => "btn btn-primary mr-auto"]) }}
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
                    <a href="{{route('labels.destroy', $label)}}"
                       data-confirm="{{ __('messages.alert.confirm') }}"
                       data-method="delete"
                       rel="nofollow"
                       class="btn btn-danger btn-sm">
                       {{ __('label.btn.remove') }}
                    </a>
                    {{ link_to_route('labels.edit', __('label.btn.edit'), [$label], ["class" => "btn btn-secondary btn-sm"] )}}
                </td>
            @endauth
        </tr>
        @endforeach
    </table>
</main>
@endsection
