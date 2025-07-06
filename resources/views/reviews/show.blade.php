@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Review Details</h2>
                <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Reviews
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Review for "{{ $review->book->title }}"</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Book:</strong> 
                        <a href="{{ route('books.show', $review->book_id) }}">
                            {{ $review->book->title }}
                        </a>
                    </div>
                    <div class="mb-3">
                        <strong>Author:</strong> 
                        <a href="{{ route('authors.show', $review->book->author_id) }}">
                            {{ $review->book->author->name }}
                        </a>
                    </div>
                    <div class="mb-3">
                        <strong>Rating:</strong>
                        <div class="mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-muted"></i>
                                @endif
                            @endfor
                            <span class="ms-2">({{ $review->rating }}/5)</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Review:</strong>
                        <p class="mt-2">{{ $review->content }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Created:</strong> {{ $review->created_at->format('F d, Y h:i A') }}
                    </div>
                    <div class="mb-3">
                        <strong>Last Updated:</strong> {{ $review->updated_at->format('F d, Y h:i A') }}
                    </div>
                    
                    <div class="mt-4 d-flex gap-2">
                        <a href="{{ route('reviews.edit', $review->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        <a href="{{ route('books.show', $review->book_id) }}" class="btn btn-info">
                            <i class="bi bi-book"></i> View Book
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
