<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('authors.index', [
            'authors' => Author::with('books')->latest()->paginate(5),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::create([
            'name' => $request->name,
        ]);

        return redirect()->route('authors.index')
            ->with('success', 'Author created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::with('books.genres')->findOrFail($id);
        return view('authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $author = Author::findOrFail($id);
        return view('authors.edit', compact('author'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author = Author::findOrFail($id);
        $author->update([
            'name' => $request->name,
        ]);

        return redirect()->route('authors.index')
            ->with('success', 'Author updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = Author::findOrFail($id);
        
        // Check if author has books before deleting
        if ($author->books()->count() > 0) {
            return redirect()->route('authors.index')
                ->with('error', 'Cannot delete author with associated books');
        }
        
        $author->delete();
        
        return redirect()->route('authors.index')
            ->with('success', 'Author deleted successfully');
    }
}
