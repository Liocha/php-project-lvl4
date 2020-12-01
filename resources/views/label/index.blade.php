@extends('layout')

@section('content')
<main class="container py-4">
    <h1 class="mb-5">Labels</h1>
    @auth
    <div class="row">
        <a href="{{route('labels.create')}}" class="btn btn-primary mr-auto">Add new</a>
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
                    <form method="post" action="{{ route('labels.destroy', $label) }}" class="d-inline-block">
                        @method('delete')
                        @csrf
                        <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-danger btn-sm"> Remove </button >
                    </form>
                    <a class="btn btn-secondary btn-sm" href="{{ route('labels.edit', $label)}}"> Edit </a > 
                </td>
            @endauth
        </tr>
        @endforeach
    </table>
</main>
@endsection 