<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Student;
use App\Renew;
use DataTables;

class RenewController extends Controller
{
    public function index() {
        return view('admin.pages.Renew.renewIndex')
        ->with('header','ต่ออายุการยืม (นักศึกษา)')->with('title','ข้อมูลนักศึกษา');
    }
    public function getStudent(Request $request) {
        if($request->ajax()) {
            return DataTables::of(Student::latest()->get())
            ->addIndexColumn()
            ->addColumn('action',function($row){
                return '<a href="#" class="badge badge-secondary renew p-2">ต่ออายุ</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function renew(Request $request) {
        $this->validate($request,[
            'std_id' => 'required',
            'std_name' => 'required',
            'password' => 'required',
        ]);

        if(Auth::guard('students')->attempt(['std_id' => $request->std_id,'password'=>$request->password])) {
            $student = Student::find($request->std_id);
            if($student->unit > 2) {
                Student::where('std_id',$request->std_id)->update([
                    'unit' => 2
                ]);
                Renew::create([
                    'std_id' => $request->std_id
                ]);
                return response()->json([
                    'success' => true,
                    'title' => 'สำเร็จ',
                    'msg' => 'ต่ออายุการยืมสำเร็จค่ะ'
                ]);
            }else {
                return response()->json([
                    'success' => false,
                    'title' => 'ระวัง',
                    'msg' => 'การยืมยังไม่ครบกำหนดที่ต้องต่อค่ะ'
                ]);
            }
        }else {
            return response()->json([
                'success' => false,
                'title','เกิดข้อผิดพลาด',
                'msg' => 'รหัสผ่านหรือรหัสนักศึกษา ไม่ถูกต้อง'
            ]);
        }

        // return response()->json([
        //     'success' => true
        // ]);
    }
}
