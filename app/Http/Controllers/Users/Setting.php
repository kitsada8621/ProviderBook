<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Major;
use App\Student;

class Setting extends Controller
{
    public function resume() {
        return view('student.setting.resume')->with('major',Major::latest()->get());
    }

    public function resumeUpdate(Request $request) {

        $this->validate($request,[
            'std_name' => 'required',
            'major' => 'required',
            'email' => 'required|email',
            'tel' => 'required',
        ]);

        $student = Student::find($request->std_id);

        if($request->std_name != $student->std_name) {
            $this->validate($request,[
                'std_name' => 'unique:student'
            ]);
            $student->std_name = $request->std_name;
        }
        if($request->major != $student->major) {
            $student->major = $request->major;
        }
        if($request->email != $student->email) {
            $this->validate($request,[
                'email' => 'unique:student'
            ]);
            $student->email = $request->email;
        }
        if($request->tel != $student->tel) {
            $this->validate($request,[
                'tel' => 'unique:student'
            ]);
            $student->tel = $request->tel;
        }
        $student->update();

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขสำเร็จแล้วค่ะ'
        ]);

    }

    public function passwordUpdate(Request $request,$id) {
        $this->validate($request,[
            'pass_old' => 'required|min:6',
            'pass_new' => 'required|min:6|same:pass_same',
            'pass_same' => 'required|min:6|same:pass_new'
        ]);

        $student = Student::find($id);

        if(Hash::check($request->pass_old, $student->password)) {
            $student->password = Hash::make($request->pass_new);
            $student->update();
        }else {
            return response()->json([
                'success' => false,
                'message' => 'รหัสผ่านไม่ถูกต้องค่ะ'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'แก้ไขรหัสผ่านสำเร็จแล้วค่ะ'
        ]);
    }
}
