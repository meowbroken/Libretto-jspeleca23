@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Books</h2>
                <a href="{{ route('books.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Book
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if(count($books) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Genres</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($books as $book)
                                    <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->author->name }}</td>
                                        <td>
                                            @foreach($book->genres as $genre)
                                                <span class="badge bg-info text-dark">{{ $genre->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $books->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-book display-4 text-muted"></i>
                            <p class="mt-3">No books found in the library.</p>
                            <a href="{{ route('books.create') }}" class="btn btn-primary mt-2">Add Your First Book</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection