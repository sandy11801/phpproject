<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Student::all();
        return view('backend.pages.student.index',compact('student'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('frontend.pages.studentregister');
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
            'class' => 'required|string',
            'rollnumber' => 'required|string',
            'parentsname' => 'required|string',
        ]);
        $student = new Student();
        $student->name = $request->name;
        $student->class = $request->class;
        $student->rollnumber = $request->rollnumber;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->fathersname = $request->parentsname;
        $img_name = '';
        $img_path = '';
        if($request->file('image')){
            $img_file = $request->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/student/';
            $success = $img_file->move($img_path,$img_name);

        }
        $student->image = $img_path.$img_name;
        $student->save();

        return redirect()->back()->with('status','Student Added Sucessfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function showStudent($id)
    {
        $student = Student::find($id);
        return view('backend.pages.student.edit', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = Student::find($id);
        $student->name = $request->name;
        $student->class = $request->class;
        $student->rollnumber = $request->rollnumber;
        $student->address = $request->address;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->fathersname = $request->fathersname;
        $img_name = '';
        $img_path = '';
        if($request->file('image')){
            $img_file = $request->file('image');
            $img_name = 'image'.Str::lower(Str::random(9)).'.'.$img_file->getClientOriginalExtension();
            $img_path = 'content/upload/student/';
            $success = $img_file->move($img_path,$img_name);
            $student->image = $img_path.$img_name;
        }
        $user= User::where('id', $student->user_id)->first();
        if($user != null){
            $user->role = $request->role;
            $user->save();
        }else{
            return back()->with('error', 'Sorry Teacher Not Found');
        }
        $student->save();
        return $this->index();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
    public function changeStatus(Request $request)
    {
        $student = Student::find($request->id)->update(['status' => $request->status]);

        return response()->json(['success'=>'Status changed successfully.']);
    }
}
