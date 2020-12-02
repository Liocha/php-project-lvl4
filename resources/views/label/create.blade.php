@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Add New Label</h1>
    <form method="post" action="{{ route('labels.store')}}" accept-charset="UTF-8" class="w-50">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control @error('name') is-invalid @enderror"  name="name" type="text" id="name" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" cols="50" rows="10" id="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror  
        </div>
        <input class="btn btn-primary" type="submit" value="Create">
        </form>
</main>
@endsection