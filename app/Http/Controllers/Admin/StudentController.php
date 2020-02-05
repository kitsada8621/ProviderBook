<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Student;
use App\Major;
use Datatables;

class StudentController extends Controller
{
    public function index() {
        $major = Major::all();
        return view('admin.pages.student.studentList')
        ->with('title','ข้อมูลนักศึกษา')
        ->with('header','จัดการข้อมูลนักศึกษา')
        ->with('major',$major);
    }

    public function getStudent(Request $request) {
        return Datatables()->of(Student::latest()->get())
        ->addIndexColumn()
        ->addColumn('action',function($row){
            $button = '<a href="javascript:void(0)" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-email="'.$row->email.'" data-tel="'.$row->tel.'" data-image="'.$row->image.'"  class="detail btn btn-success btn-xs"><i class="fa fa-eye"></i></a>';
            $button .= '<a href="javascript:void(0)" data-id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-email="'.$row->email.'" data-tel="'.$row->tel.'" data-password="'.$row->password.'" data-image="'.$row->image.'"  class="edit btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>';
            $button .= '<a href="javascript:void(0);" data-id="'.$row->std_id.'" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
            return $button;
        })
        ->rawColumns(['action'])->make(true);
    }

    public function submitData(Request $request) {
        if(!empty($request->id)) {
            /** update */
            $this->update($request);
            return response()->json([
                'success' => true
            ]);
        }else {
            /** Insert */
            $this->insert($request);
            return response()->json([
                'success' => true
            ]);
        }

    }

    protected function insert(Request $request) {
        $this->validate($request,[
            'std_id' => 'required|unique:student',
            'std_name' => 'required|unique:student',
            'major' => 'required',
            'email' => 'required|email|unique:student',
            'tel' => 'required|numeric|unique:student',
            'password' => 'required|same:confirmpassword|min:4',
            'confirmpassword' => 'required|min:4',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $student = new Student;
        $student->std_id = $request->std_id;
        $student->std_name = $request->std_name;
        $student->major = $request->major;
        $student->email = $request->email;
        $student->tel = $request->tel;
        if(!empty($request->image)) {
            $image = $request->file('image');
            $filename = \uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(\public_path('uploads'),$filename);
            $student->image = $filename;
        }
        $student->password = Hash::make($request->password);
        $student->save();
    }
    protected function update(Request $request) {
        $this->validate($request,[
            'std_id' => 'required',
            'std_name' => 'required',
            'major' => 'required',
            'email' => 'required',
            'tel' => 'required',
            'password' => 'required',
            'confirmpassword' => 'min:6|same:password'
        ]);
        $student = Student::find($request->id);
        if($student->std_name != $request->std_name) {
            $this->validate($request,[
                'std_name' => 'unique:student'
            ]);
            $student->std_name = $request->std_name;
        }
        $student->major = $request->major;
        if($student->email != $request->email) {
            $this->validate($request,[
                'email' => 'unique:student'
            ]);
            $student->email = $request->email;
        }
        if($student->tel != $request->tel) {
            $this->validate($request,[
                'tel' => 'unique:student'
            ]);
            $student->tel = $request->tel;
        }
        if($student->password != $request->password) {
            $this->validate($request,[
                'password' => 'same:confirmpassword|min:6'
            ]);
            $student->password = Hash::make($request->password);
        }
        if(!empty($request->image)) {
            
            /** Old Image */
            $images = $student->image;
            $namefiled = \public_path().'/uploads/'.$images;
            File::delete($namefiled);

            /** New Image */
            $imaging = $request->file('image');
            $imagingname = uniqid().'.'.$imaging->getClientOriginalExtension();
            $imaging->move(public_path('uploads'), $imagingname);

            /** update profile */
            $student->image = $imagingname;

        }
        $student->update();
    }

    public function destroy($id) {
        $student = Student::find($id);

        $images = $student->image;
        $namefiled = \public_path().'/uploads/'.$images;
        File::delete($namefiled);

        $student->delete();

        return response()->json([
            'success' => true
        ]);

    }

    public function excelImport(Request $request) {    

        $this->validate($request,[
            'file' => 'required|file|max:1024|mimes:xls,xlsx'
        ]);
        $messge = "สำเร็จ";
        return redirect()->back()->with('success','successfully');
    }
}
