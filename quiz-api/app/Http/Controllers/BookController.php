<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::orderby('id', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|max: 100|min: 3',
            'body' => 'string|max: 500|min: 3',
        ]);

        $book = new Book();

        $book->author_id = $request->author_id;
        $book->title = $request->title;
        $book->body = $request->body;

        $book->save();

        return response()->json(['message' => 'book created', 'data' => $book], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Book::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $book->author_id = $request->author_id;
        $book->title = $request->title;
        $book->body = $request->body;

        $book->save();

        return response()->json(['message' => 'book edited', 'data' => $book], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isDeleted = Book::destroy($id);

        if($isDeleted = 1){
            return response()->json(['message' => 'book deleted'], 200);
        }else{
            return response()->json(['message' => 'id not found'], 404);
        }
    }
}
