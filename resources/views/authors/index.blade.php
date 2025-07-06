@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Authors</h2>
                <a href="{{ route('authors.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Author
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if(isset($authors) && count($authors) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Books Count</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($authors as $author)
                                    <tr>
                                        <td>{{ $author->id }}</td>
                                        <td>{{ $author->name }}</td>
                                        <td>{{ $author->books->count() }}</td>
                                        <td>
                                            <a href="{{ route('authors.show', $author->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                            <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('authors.destroy', $author->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this author?')">
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
                            {{ $authors->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-person display-4 text-muted"></i>
                            <p class="mt-3">No authors found in the library.</p>
                            <a href="{{ route('authors.create') }}" class="btn btn-primary mt-2">Add Your First Author</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection