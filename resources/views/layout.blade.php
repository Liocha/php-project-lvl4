
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-param" content="_token" />
        <title>{{config('app.name', 'Task Manager') }}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{route('home')}}">
                        {{config('app.name', __('layout.nav.name') ) }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ Helper::getActivClass('tasks.index') }}" href="{{route('tasks.index')}}">{{ __('layout.nav.tasks') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Helper::getActivClass('task_statuses.index') }}" href="{{route('task_statuses.index')}}">{{ __('layout.nav.taskStatuses') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Helper::getActivClass('labels.index') }}" href="{{route('labels.index')}}">{{ __('layout.nav.labels') }}</a>
                            </li>
                        </ul>
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                   <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('layout.nav.login') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('layout.nav.register') }}</a>
                                    </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item"
                                           href="{{route('logout')}}"
                                           data-method="post"
                                           rel="nofollow">
                                            {{ __('layout.nav.logout') }}
                                        </a>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @include('flash::message')
        @yield('content')
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}" defer></script>
