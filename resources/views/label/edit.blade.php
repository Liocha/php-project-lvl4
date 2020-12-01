@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Label:{{ $label->name }}</h1>
    <form method="post" action="{{ route('labels.update', $label )}}" accept-charset="UTF-8" class="w-50">
        @method('patch')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control @error('name') is-invalid @enderror"  name="name" type="text" id="name" value="{{ $label->name }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" cols="50" rows="10" id="description">{{ $label->description }}</textarea>  
        </div>
        <input class="btn btn-primary" type="submit" value="Update">
        </form>
</main>
@endsection