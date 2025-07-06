@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Genre Details</h2>
                <a href="{{ route('genres.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Genres
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Genre Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>ID:</strong> {{ $genre->id }}
                    </div>
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $genre->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Created:</strong> {{ $genre->created_at->format('F d, Y h:i A') }}
                    </div>
                    <div class="mb-3">
                        <strong>Last Updated:</strong> {{ $genre->updated_at->format('F d, Y h:i A') }}
                    </div>
                    
                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this genre?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Books in this Genre</h5>
                </div>
                <div class="card-body">
                    @if($genre->books->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($genre->books as $book)
                                    <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author->name }}</td>
                                        <td>
                                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center">No books found in this genre.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
