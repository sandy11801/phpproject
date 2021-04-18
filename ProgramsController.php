<?php

namespace App\Http\Controllers;

use App\Models\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProgramsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $programs = Programs::all();
        return view('backend.pages.programs.index',compact('programs'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.programs.create');
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
            'title' => 'required|string',
            'image' => 'required|file',
        ]);
        $programs = new Programs();
        $programs->title = $request->title;
        $programs->news = $request->news;
        $programs->author = Auth::user()->id;
        $programs->slug = Str::slug($request->name) . Str::random(8);
        $programs->image = $request->image;
        $img_name = '';
        $img_path = '';
        if($request->file('image')){
            $img_file = $request->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/programs/';
            $success = $img_file->move($img_path,$img_name);

        }
        $programs->image = $img_path.$img_name;
        $programs->save();

        return redirect()->back()->with('status','Programs Added Sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Programs  $programs
     * @return \Illuminate\Http\Response
     */
    public function showPrograms($id)
    {
        $programs = Programs::find($id);
        return view('backend.pages.programs.edit', ['data' => $programs]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Programs  $programs
     * @return \Illuminate\Http\Response
     */
    public function edit(Programs $programs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Programs  $programs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $programs = Programs::find($id);
        $programs->title = $req->title;
        $programs->news = $req->news;
        $programs->status = $req->status;
        $programs->image = $req->image;
        $img_name = '';
        $img_path = '';
        if($req->file('image')){
            $img_file = $req->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/programs/';
            $success = $img_file->move($img_path,$img_name);
            $programs->image = $img_path.$img_name;
        }
        $programs->save();
        return $this->index();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Programs  $programs
     * @return \Illuminate\Http\Response
     */
    public function deletePrograms($news_id)
    {
        $programs = Programs::where('id',$news_id)->first();
        $programs->delete();
        return back()->with('status', 'Programs has been successfully delete!');
    }
}
