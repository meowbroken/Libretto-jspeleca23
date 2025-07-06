@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Book Details</h2>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Books
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">{{ $book->title }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Author:</strong> {{ $book->author->name }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Genres:</strong>
                        @if(count($book->genres) > 0)
                            @foreach($book->genres as $genre)
                                <span class="badge bg-info text-dark me-1">{{ $genre->name }}</span>
                            @endforeach
                        @else
                            <span class="text-muted">No genres assigned</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong>Added on:</strong> {{ $book->created_at->format('F d, Y') }}
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this book?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Reviews Section -->
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Reviews</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#addReviewForm">
                        <i class="bi bi-plus-circle"></i> Add Review
                    </button>
                </div>
                
                <div class="collapse" id="addReviewForm">
                    <div class="card-body border-bottom">
                        <form action="{{ route('reviews.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                            
                            <div class="mb-3">
                                <label for="rating" class="form-label">Rating</label>
                                <select class="form-select" name="rating" id="rating" required>
                                    <option value="">Select Rating</option>
                                    <option value="1">1 - Poor</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="3">3 - Good</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="5">5 - Excellent</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="content" class="form-label">Review</label>
                                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-success">Submit Review</button>
                        </form>
                    </div>
                </div>
                
                <div class="card-body">
                    @if(count($book->reviews) > 0)
                        @foreach($book->reviews as $review)
                            <div class="mb-4 p-3 border-bottom">
                                <div class="d-flex justify-content-between mb-2">
                                    <div>
                                        <strong>Rating:</strong>
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <i class="bi bi-star text-muted"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                                <p class="mb-0">{{ $review->content }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center py-4">No reviews yet. Be the first to review this book!</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Related books by same author -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">More from {{ $book->author->name }}</h5>
                </div>
                <div class="card-body">
                    @if(count($relatedBooks) > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($relatedBooks as $relatedBook)
                                <li class="list-group-item">
                                    <a href="{{ route('books.show', $relatedBook->id) }}">
                                        {{ $relatedBook->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No other books by this author.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection