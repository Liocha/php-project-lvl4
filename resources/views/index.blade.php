@extends('layout')

@section('content')
<main class="container py-4">
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">{{ __('home.title') }}</h1>
            <p class="lead">{{ __('home.description') }}</p>
            <hr class="my-4">
            <p>{{ __('home.main') }}</p>
            <a class="btn btn-primary btn-lg" href="https://ru.hexlet.io/?ref=257626" role="button">{{ __('home.learn_more') }}</a>
        </div>
    </div>
</main>
@endsection
