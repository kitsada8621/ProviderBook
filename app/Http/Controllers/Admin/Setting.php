<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Student;

class Setting extends Controller
{
    public function profileView() {
        return view('admin.profile.profile');
    }

    public function profileUpdate(Request $request) {
        
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        $data = User::find($request->id);

        if($request->name != $data->name) {
            $this->validate($request,[
                'name' => 'unique:users'
            ]);
            $data->name = $request->name;
        }
        if($request->email != $data->email) {
            $this->validate($request,[
                'email' => 'unique:users'
            ]);
            $data->email = $request->email;
        }

        if($request->username != $data->username) {
            $this->validate($request,[
                'username' => 'unique:users'
            ]);
            $data->username = $request->username;
        }

        if(Hash::check($request->password, $data->password)) {
            $data->update();
        }else {
            return response()->json([
                'success' => false,
                'message' => 'รหัสผ่านไม่ถูกต้องค่ะ'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'บันทึกสำเร็จค่ะ'
        ]);
    }

    public function passwordView() {
        return view('admin.profile.password');
    }

    public function passwordUpdate(Request $request,$id) {
        $this->validate($request,[
            'pass_old' => 'required|min:6',
            'pass_new' => 'required|min:6|same:pass_same',
            'pass_same' => 'required|min:6|same:pass_new'
        ]);

        $admin = User::find($id);

        if(Hash::check($request->pass_old,$admin->password)) {
            $admin->password = Hash::make($request->pass_new);
            $admin->update();
        }else {
            return response()->json([
                'success' => false,
                'message' => 'รหัสผ่านเดิมไม่ถูกต้อง'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'บันทึกสำเร็จ'
        ]);
    }

    public function forgetpassview() {
        return view('admin.profile.forgetPass');
    }

    public function forgetpass(Request $request) {

        $this->validate($request,[
            'username' => 'required',
            'email' => 'required|email',
        ]);

        $student = Student::where('std_id',$request->username)->first();
        $admin = User::where('username',$request->username)->first();
        if($student) {
            if($student->email == $request->email) {
                return response()->json([
                    'success' => true,
                    'name'=>$student->std_id
                    ]);
            }
        }elseif($admin) {
            if($admin->email == $request->email) {
                return response()->json([
                    'success' => true,
                    'name'=>$admin->id
                    ]);
            }
        }else {
            return response()->json([
                'success' => false,
                'message' => 'รหัสผ่านหรืออีเมลล์ไม่ถูกต้อง'
            ]);
        }
    }
    public function viewNewPass($id) {
        return view('login.newpassword')->with('id',$id);
    }

    public function passwordUpdates(Request $request,$id) {

        $this->validate($request,[
            'pass' => 'required',
            'passconfirm' => 'required',
        ]);
        
        $student = Student::where('std_id',$id)->first();
        $admin = User::where('id',$id)->first();

        if($student) {
            Student::where('std_id',$id)->update([
                'password' => Hash::make($request->pass)
            ]);
        }elseif($admin) {
            User::where('id',$id)->update([
                'password' => Hash::make($request->pass)
            ]);
        }

        return response()->json([
            'success' => true,
        ]);

    }
}
