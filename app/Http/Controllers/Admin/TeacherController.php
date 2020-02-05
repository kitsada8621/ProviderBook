<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Teacher;
use DataTables;

class TeacherController extends Controller
{
    public function index() {
        return view('admin.pages.teacher.teacherIndex')->with('header','จัดการข้อมูลอาจารย์')->with('title','ข้อมูลอาจารย์');
    }
    public function getData(Request $request) {
        if($request->ajax()) {
            return DataTables()->of(Teacher::latest()->get())
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $btn = '<button type="button" data-id="'.$row->t_id.'" data-name="'.$row->t_name.'" class="btn btn-warning btn-sm edit"><i class="fas fa-edit"></i></button>';
                $btn .= '<button data-id="'.$row->t_id.'" type="button" class="btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function create(Request $request) {

        if(empty($request->t_id)) {
            $this->inserting($request);
        }else {
            $this->editing($request);
        }

        return response([
          'success' => true        
        ]);
    }

    public function inserting(Request $request) {
        $this->validate($request,[
            't_name' => 'required|unique:teacher'
        ]);
        Teacher::create([
            't_id' => mt_rand(1000000000, 9999999999),
            't_name' => $request->t_name
        ]);
    }

    public function editing(Request $request) {
        $this->validate($request,[
            't_name' => 'required'
        ]);
        $data = Teacher::find($request->t_id);
        if($request->t_name != $data->t_name){
            $this->validate($request,[
                't_name' => 'unique:teacher'
            ]);
            $data->t_name = $request->t_name;
            $data->update();
        }

    }

    public function destroy($id) {
        Teacher::find($id)->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
