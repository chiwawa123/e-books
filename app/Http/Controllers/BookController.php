<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
       // Display a list of books
       public function index()
       {
           $books = Book::all();
           return response()->json($books);
       }

       // Create a new book
       public function store(Request $request)
       {
           // Validate incoming data
           $request->validate([
               'title' => 'required|string|max:255',
               'author' => 'required|string|max:255',
               'year' => 'required|integer',
               'description' => 'required|string',
               'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
           ]);

           // Handle file upload for cover_image (if any)
           $coverImagePath = $request->file('cover_image')
               ? $request->file('cover_image')->store('covers', 'public')
               : null;

           // Create the book
           $book = Book::create([
               'title' => $request->title,
               'author' => $request->author,
               'year' => $request->year,
               'description' => $request->description,
               'cover_image' => $coverImagePath,
           ]);

           return response()->json($book, 201);
       }

       // Show a specific book by ID
       public function show($id)
       {
           $book = Book::findOrFail($id);
           return response()->json($book);
       }

       // Update a book by ID
       public function update(Request $request, $id)
       {
           $book = Book::findOrFail($id);

           // Validate incoming data
           $request->validate([
               'title' => 'required|string|max:255',
               'author' => 'required|string|max:255',
               'year' => 'required|integer',
               'description' => 'required|string',
               'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
           ]);

           // Handle file upload for cover_image (if any)
           if ($request->hasFile('cover_image')) {
               $coverImagePath = $request->file('cover_image')->store('covers', 'public');
               $book->cover_image = $coverImagePath;
           }

           // Update the book details
           $book->update($request->only('title', 'author', 'year', 'description'));

           return response()->json($book);
       }

       // Delete a book by ID
       public function destroy($id)
       {
           $book = Book::findOrFail($id);
           $book->delete();

           return response()->json(['message' => 'Book deleted successfully']);
       }
}
