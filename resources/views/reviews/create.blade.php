@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Add New Review</h2>
                <a href="{{ route('reviews.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Reviews
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('reviews.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="book_id" class="form-label">Book</label>
                            <select class="form-select @error('book_id') is-invalid @enderror" 
                                id="book_id" name="book_id" required>
                                <option value="">Select Book</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                        {{ $book->title }} (by {{ $book->author->name }})
                                    </option>
                                @endforeach
                            </select>
                            @error('book_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating</label>
                            <div class="rating-select">
                                <div class="btn-group" role="group">
                                    @for($i = 1; $i <= 5; $i++)
                                        <input type="radio" class="btn-check" name="rating" id="rating{{ $i }}" 
                                            value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }} required>
                                        <label class="btn btn-outline-warning" for="rating{{ $i }}">
                                            {{ $i }} <i class="bi bi-star-fill"></i>
                                        </label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Review Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('reviews.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Create Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
