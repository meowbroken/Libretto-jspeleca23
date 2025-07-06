@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('Libretto') }}</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5>Welcome to Libretto!</h5>
                    <p class="text-muted">Select a category below to manage your library resources.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <!-- Books Card -->
        <div class="col-md-5 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-book display-1 text-primary mb-3"></i>
                    <h5 class="card-title">Books</h5>
                    <p class="card-text">Manage your book collection</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-center">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-primary">View Books</a>
                </div>
            </div>
        </div>
        
        <!-- Authors Card -->
        <div class="col-md-5 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-person-circle display-1 text-success mb-3"></i>
                    <h5 class="card-title">Authors</h5>
                    <p class="card-text">Manage authors and their works</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-center">
                    <a href="{{ route('authors.index') }}" class="btn btn-outline-success">View Authors</a>
                </div>
            </div>
        </div>
        
        <!-- Genres Card -->
        <div class="col-md-5 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-tags display-1 text-info mb-3"></i>
                    <h5 class="card-title">Genres</h5>
                    <p class="card-text">Browse and manage genres</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-center">
                    <a href="{{ route('genres.index') }}" class="btn btn-outline-info">View Genres</a>
                </div>
            </div>
        </div>
        
        <!-- Reviews Card -->
        <div class="col-md-5 col-lg-3 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-star display-1 text-warning mb-3"></i>
                    <h5 class="card-title">Reviews</h5>
                    <p class="card-text">See and manage book reviews</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-center">
                    <a href="{{ route('reviews.index') }}" class="btn btn-outline-warning">View Reviews</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
