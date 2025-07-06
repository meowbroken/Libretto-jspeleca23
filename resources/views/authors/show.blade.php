@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Author Details</h2>
                <a href="{{ route('authors.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Authors
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">{{ $author->name }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>ID:</strong> {{ $author->id }}
                    </div>
                    <div class="mb-3">
                        <strong>Name:</strong> {{ $author->name }}
                    </div>
                    <div class="mb-3">
                        <strong>Books Count:</strong> {{ $author->books->count() }}
                    </div>
                    <div class="mb-3">
                        <strong>Created:</strong> {{ $author->created_at->format('F d, Y h:i A') }}
                    </div>
                    <div class="mb-3">
                        <strong>Last Updated:</strong> {{ $author->updated_at->format('F d, Y h:i A') }}
                    </div>
                    
                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this author?')">
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
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Books by this Author</h5>
                    <a href="{{ route('books.create') }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle"></i> Add New Book
                    </a>
                </div>
                <div class="card-body">
                    @if($author->books->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Genres</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($author->books as $book)
                                    <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>
                                            @foreach($book->genres as $genre)
                                                <span class="badge bg-info text-dark">{{ $genre->name }}</span>
                                            @endforeach
                                        </td>
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
                        <p class="text-center py-4">No books found for this author.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
