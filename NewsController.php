<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $news = News::all();
        return view('backend.pages.news.index',compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.news.create');
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
        $news = new News();
        $news->title = $request->title;
        $news->export = $request->export;
        $news->news = $request->news;
        $news->author = Auth::user()->id;
        $news->slug = Str::slug($request->name) . Str::random(8);
        $news->image = $request->image;
        $img_name = '';
        $img_path = '';
        if($request->file('image')){
            $img_file = $request->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/news/';
            $success = $img_file->move($img_path,$img_name);

        }
        $news->image = $img_path.$img_name;
        $news->save();

        return redirect()->back()->with('status','Event Added Sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function showNews($id)
    {
        $news = News::find($id);
        return view('backend.pages.news.edit', ['data' => $news]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $news = News::find($id);
        $news->title = $req->title;
        $news->export = $req->export;
        $news->news = $req->news;
        $news->image = $req->image;
        $img_name = '';
        $img_path = '';
        if($req->file('image')){
            $img_file = $req->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/news/';
            $success = $img_file->move($img_path,$img_name);
            $news->image = $img_path.$img_name;
        }
        $news->save();
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function deleteNews($news_id)
    {
        $news = news::where('id',$news_id)->first();
        $news->delete();
        return back()->with('status', 'news has been successfully delete!');
    }        //

}
