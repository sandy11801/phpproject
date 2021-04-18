<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notice = Notice::all();
        return view('backend.pages.notice.index',compact('notice'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.pages.notice.create');
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
        $notice = new Notice();
        $notice->name = $request->name;
        $notice->author = $request->author;
        $notice->class = $request->class;
        $notice->description = $request->description;
        $notice->image = $request->image;
        $img_name = '';
        $img_path = '';
        if($request->file('image')){
            $img_file = $request->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/notice/';
            $success = $img_file->move($img_path,$img_name);

        }
        $notice->image = $img_path.$img_name;
        $notice->save();

        return redirect()->back()->with('status','Notice Added Sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function showNotice($id)
    {
        $notice = Notice::find($id);
        return view('backend.pages.notice.edit', ['data' => $notice]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $notice = notice::find($id);
        $notice->name = $req->name;
        $notice->author = $req->author;
        $notice->class = $req->class;
        $notice->status = $req->status;
        $notice->description = $req->description;
        $notice->image = $req->image;
        $img_name = '';
        $img_path = '';
        if($req->file('image')){
            $img_file = $req->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/notice/';
            $success = $img_file->move($img_path,$img_name);
            $notice->image = $img_path.$img_name;
        }
        $notice->save();
        return $this->index();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notice  $notice
     * @return \Illuminate\Http\Response
     */
    public function deletenotice($notice_id)
    {
        $notice = notice::where('id',$notice_id)->first();
        $notice->delete();
        return back()->with('status', 'Notice has been successfully delete!');
    }
}
