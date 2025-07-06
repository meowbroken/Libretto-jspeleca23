<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Genre;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('books.index', [
            'books' => Book::with(['author', 'genres'])->latest()->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all();
        return view('books.create', compact('authors', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::create([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

        if ($request->has('genres')) {
            $book->genres()->attach($request->genres);
        }

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with(['author', 'genres', 'reviews'])->findOrFail($id);
        $relatedBooks = Book::where('author_id', $book->author_id)
                            ->where('id', '!=', $book->id)
                            ->take(5)
                            ->get();
                            
        return view('books.show', compact('book', 'relatedBooks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::with('genres')->findOrFail($id);
        $authors = Author::all();
        $genres = Genre::all();
        
        return view('books.edit', compact('book', 'authors', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'genres' => 'nullable|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $book = Book::findOrFail($id);
        $book->update([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);

     
        if ($request->has('genres')) {
            $book->genres()->sync($request->genres);
        } else {
            $book->genres()->detach();
        }

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
}
