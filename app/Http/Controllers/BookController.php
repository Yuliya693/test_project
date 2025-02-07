<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Просмотр всех книг
    public function index()
    {
        return Book::all();
    }

    // Создание книги (для библиотекаря)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $book = Book::create($request->all());

        return response()->json([
            'message' => 'Book created successfully',
            'book' => $book,
        ], 201);
    }

    // Обновление книги (для библиотекаря)
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'string',
            'author' => 'string',
            'description' => 'nullable|string',
        ]);

        $book->update($request->all());

        return response()->json([
            'message' => 'Book updated successfully',
            'book' => $book,
        ]);
    }

    // Удаление книги (для библиотекаря)
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(['message' => 'Book deleted successfully']);
    }

    // Взять книгу (для пользователя)
    public function borrow(Book $book)
    {
        if (!$book->is_available) {
            return response()->json(['error' => 'Book is not available'], 400);
        }

        $book->update(['is_available' => false]);
        auth()->user()->borrowedBooks()->attach($book);

        return response()->json(['message' => 'Book borrowed successfully']);
    }

    // Вернуть книгу (для пользователя)
    public function return(Book $book)
    {
        if ($book->is_available) {
            return response()->json(['error' => 'Book is already returned'], 400);
        }

        $book->update(['is_available' => true]);
        auth()->user()->borrowedBooks()->detach($book);

        return response()->json(['message' => 'Book returned successfully']);
    }
}
