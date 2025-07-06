<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $books = Book::with(['author', 'genres', 'reviews'])->get();
            return response()->json([
                'success' => true,
                'data' => $books
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve books',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author_id' => 'required|exists:authors,id',
                'genre_ids' => 'array',
                'genre_ids.*' => 'exists:genres,id'
            ]);

            $book = Book::create([
                'title' => $validatedData['title'],
                'author_id' => $validatedData['author_id']
            ]);

            // Attach genres if provided
            if (isset($validatedData['genre_ids'])) {
                $book->genres()->attach($validatedData['genre_ids']);
            }

            $book->load(['author', 'genres']);
            
            return response()->json([
                'success' => true,
                'message' => 'Book created successfully',
                'data' => $book
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $book = Book::with(['author', 'genres', 'reviews'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $book
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $book = Book::findOrFail($id);
            
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'author_id' => 'required|exists:authors,id',
                'genre_ids' => 'array',
                'genre_ids.*' => 'exists:genres,id'
            ]);

            $book->update([
                'title' => $validatedData['title'],
                'author_id' => $validatedData['author_id']
            ]);

            // Sync genres if provided
            if (isset($validatedData['genre_ids'])) {
                $book->genres()->sync($validatedData['genre_ids']);
            }

            $book->load(['author', 'genres']);
            
            return response()->json([
                'success' => true,
                'message' => 'Book updated successfully',
                'data' => $book
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update book',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $book = Book::findOrFail($id);
            
            if ($book->reviews()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete book with existing reviews'
                ], 409);
            }
            
            $book->genres()->detach();
            $book->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Book deleted successfully'
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete book',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
