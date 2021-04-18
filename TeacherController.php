<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teacher = Teacher::all();
        return view('backend.pages.teacher.index',compact('teacher'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.pages.teacherregistration');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string',
            'class' => 'required',
            'faculty' => 'required',
        ]);
        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->address = $request->address;
        $teacher->phone = $request->phone;
        $teacher->email = $request->email;
        $img_name = '';
        $img_path = '';
        if($request->file('image')){
            $img_file = $request->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/teacher/';
            $success = $img_file->move($img_path,$img_name);

        }
        $teacher->image = $img_path.$img_name;
        $teacher->save();

        $teacher->schoolclasses()->sync($request->class);
        $teacher->faculties()->sync($request->faculty);
        return redirect()->back()->with('status','teacher Added Sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function showTeachers($id)
    {
        $teacher = Teacher::find($id);
        return view('backend.pages.teacher.edit', compact('teacher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $teacher = Teacher::find($id);
        $teacher->name = $req->name;
        $teacher->email = $req->email;
        $teacher->phone = $req->phone;
        $teacher->address = $req->address;
        $teacher->status = $req->status;
        $img_name = '';
        $img_path = '';
        if($req->file('image')){
            $img_file = $req->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/programs/';
            $success = $img_file->move($img_path,$img_name);
            $teacher->image = $img_path.$img_name;
        }
        $user= User::where('id', $teacher->user_id)->first();
        if($user != null){
            $user->role = $req->role;
            $user->save();
        }else{
            return back()->with('error', 'Sorry Teacher Not Found');
        }
        $teacher->save();
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
    public function changeStatus(Request $request)
    {
        $teacher = Teacher::find($request->id)->update(['status' => $request->status]);

        return response()->json(['success'=>'Status changed successfully.']);
    }
}
