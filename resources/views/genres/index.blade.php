@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Genres</h2>
                <a href="{{ route('genres.create') }}" class="btn btn-primary">Add New Genre</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if(count($genres) > 0)
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($genres as $genre)
                                <tr>
                                    <td>{{ $genre->id }}</td>
                                    <td>{{ $genre->name }}</td>
                                    <td>
                                        <a href="{{ route('genres.show', $genre->id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        <a href="{{ route('genres.edit', $genre->id) }}" class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this genre?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
           </table>
                    @else
                        <p class="text-center">No genres found.</p>
                    @endif
                                                  <div class="mt-4">
        {{ $genres->links() }}
    </div>
             
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection