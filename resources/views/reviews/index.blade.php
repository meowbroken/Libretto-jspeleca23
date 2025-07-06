@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Reviews</h2>
                <a href="{{ route('reviews.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Review
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if(isset($reviews) && count($reviews) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Book</th>
                                        <th>Rating</th>
                                        <th>Content</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $review)
                                    <tr>
                                        <td>{{ $review->id }}</td>
                                        <td>
                                            <a href="{{ route('books.show', $review->book_id) }}">
                                                {{ $review->book->title }}
                                            </a>
                                        </td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-muted"></i>
                                                @endif
                                            @endfor
                                        </td>
                                        <td>{{ \Str::limit($review->content, 50) }}</td>
                                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <a href="{{ route('reviews.show', $review->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                            <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
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
                            {{ $reviews->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-chat-quote display-4 text-muted"></i>
                            <p class="mt-3">No reviews found.</p>
                            <a href="{{ route('reviews.create') }}" class="btn btn-primary mt-2">Add Your First Review</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
