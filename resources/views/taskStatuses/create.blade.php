@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Add New Task Status</h1>
    <form method="post" action="{{ route('task_statuses.store')}}" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" id="name" value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <input class="btn btn-primary" type="submit" value="Create">
    </form>
</main>
@endsection