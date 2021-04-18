<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Books::all();
        return view('backend.pages.books.index',compact('books'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.books.create');
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
            'name' => 'required|string',
            'image' => 'required|file',
        ]);
        $books = new Books();
        $books->name = $request->name;
        $books->author = $request->author;
        $books->class = $request->class;
        $books->status = $request->status;
        $books->description = $request->description;
        $books->image = $request->image;
        $img_name = '';
        $img_path = '';
        if($request->file('image')){
            $img_file = $request->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/books/';
            $success = $img_file->move($img_path,$img_name);

        }
        $books->image = $img_path.$img_name;
        $books->save();

        return redirect()->back()->with('status','Book Added Sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function showBooks($id)
    {
        $books = Books::find($id);
        return view('backend.pages.books.edit', ['data' => $books]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function edit(Books $books)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $books = Books::find($id);
        $books->name = $req->name;
        $books->author = $req->author;
        $books->class = $req->class;
        $books->status = $req->status;
        $books->description = $req->description;
        $books->image = $req->image;
        $img_name = '';
        $img_path = '';
        if($req->file('image')){
            $img_file = $req->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/books/';
            $success = $img_file->move($img_path,$img_name);
            $books->image = $img_path.$img_name;
        }
        $books->save();
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function deleteBooks($books_id)
    {
        $books = Books::where('id',$books_id)->first();
        $books->delete();
        return back()->with('status', 'Book has been successfully delete!');
    }
}
