<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use Datatables;
use App\Student;
use App\Teacher;
use App\TypeProject;

class ProjectController extends Controller
{
    public function index() {
        return view('admin.pages.project.projectIndex')
        ->with('header','จัดการข้อมูลโครงงาน')
        ->with('title','ข้อมูลโครงงาน')
        ->with('type',TypeProject::get());
    }

    public function getProject(Request $request) {
        $data = Project::join('student','student.std_id','project.std_id')
        ->join('teacher','teacher.t_id','project.t_id')
        ->select('project.p_id','project.p_name','project.category','project.createdate','project.description','teacher.t_id','teacher.t_name','student.std_id','student.std_name')
        ->latest('project.created_at')->get();
        return Datatables()->of($data)
        ->addIndexColumn()
        ->addColumn('action',function($row){
            $button = '<a href="javascript:void(0)"  data-p_id="'.$row->p_id.'" data-p_name="'.$row->p_name.'" data-category="'.$row->category.'" data-t_id="'.$row->t_id.'" data-t_name="'.$row->t_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-createdate="'.date('d-m-Y H:i:s',strtotime($row->createdate)).'" data-description="'.$row->description.'" class="detail btn btn-success btn-sm"><i class="fa fa-eye"></i></a>';
            $button .= '<a href="javascript:void(0)" data-p_id="'.$row->p_id.'" data-p_name="'.$row->p_name.'" data-category="'.$row->category.'" data-t_id="'.$row->t_id.'" data-t_name="'.$row->t_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-createdate="'.date('Y-m-d',strtotime($row->createdate)).'" data-description="'.$row->description.'" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
            $button .= '<a href="javascript:void(0);" data-id="'.$row->p_id.'" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            return $button;
        })
        ->rawColumns(['action'])->make(true);
    }

    public function create(Request $request) {
        if(empty($request->id)) {
            $this->insertingvalidation($request);
            $this->insert($request);
            return response()->json([
                'success' => true,
                'msg' => 'บันทึกข้อมูลสำเร็จ'
            ]);
        }else {
            $this->edit($request);
            return response()->json([
                'success' => true,
                'msg' => 'แก้ไข'
            ]);
        }   

    }

    protected function insertingvalidation(Request $request) {
        $this->validate($request,[
            'p_name'=>'required|unique:project',
            'category'=>'required',
            't_id'=>'required',
            'adviser'=>'required',
            'std_id'=>'required',
            'creator'=>'required',
            'createdate'=>'required|date',
            'description'=>'required',
        ]);   
    }

    public function insert(Request $request) {
        Project::create([
            'p_id'=>mt_rand(1000000000, 9999999999),
            'p_name'=>$request->p_name,
            'category'=>$request->category,
            't_id'=>$request->t_id,
            'std_id'=>$request->std_id,
            'createdate'=>$request->createdate,
            'description'=>$request->description
        ]);
    }

    public function edit(Request $request) {
        $this->editValidation($request);
        $project = Project::find($request->id);
        if($request->p_name != $project->p_name) {
            $this->validate($request,[
                'p_name' => 'unique:project',
            ]);
            $project->p_name = $request->p_name;
        }
        if($request->category != $project->category) {
            $project->category = $request->category;
        }
        if($request->t_id != $project->t_id) {
            $project->t_id = $request->t_id;
        }
        if($request->std_id != $project->std_id) {
            $project->std_id = $request->std_id;
        }
        if($request->createdate != $project->createdate) {
            $project->createdate = $request->createdate;
        }
        if($request->description != $project->description) {
            $project->description = $request->description;
        }
        $project->update();
    }

    protected function editValidation(Request $request) {
        $this->validate($request,[
            'p_name' => 'required',
            'category' => 'required',
            't_id' => 'required',
            'adviser' => 'required',
            'std_id' => 'required',
            'creator' => 'required',
            'createdate' => 'required',
            'description' => 'required',
        ]);
    }

    public function destroy($id) {
        Project::find($id)->delete();
        return response()->json([
            'success' => true,
            'msg' => 'ลบข้อมูล'
        ]);
    }

    public function getStudentId(Request $request) {
        $student = Student::where('std_id',$request->id)->first();
        if($student) {
            return response()->json([
                'success' => true,
                'std_id' => $student->std_id,
                'std_name' => $student->std_name,
                'msg' => 'ถูกต้อง'
            ]);
        }else {
            return response()->json([
                'success' => false,
                'msg' => 'ข้อมูลไม่มีในระบบ'
            ]);
        }
    }
    public function getStudentName(Request $request) {
        $student = Student::where('std_name',$request->name)->first();
        if($student) {
            return response()->json([
                'success' => true,
                'std_id' => $student->std_id,
                'std_name' => $student->std_name,
                'msg' => 'ถูกต้อง'
            ]);
        }else {
            return response()->json([
                'success' => false,
                'msg' => 'ข้อมูลไม่มีในระบบ'
            ]);
        }
    }
    public function getTeacherId(Request $request) {
        $data = Teacher::where('t_id',$request->id)->first();
        if($data) {
            return response()->json([
                'success' => true,
                't_id' => $data->t_id,
                't_name' => $data->t_name,
                'msg' => 'ถูกต้อง'
            ]);
        }else {
            return response()->json([
                'success' => true,
                'msg' => 'ไม่มีข้อมูล'
            ]);
        }
    }
    public function getTeacherName(Request $request) {
        $data = Teacher::where('t_name',$request->name)->first();
        if($data) {
            return response()->json([
                'success' => true,
                't_id' => $data->t_id,
                't_name' => $data->t_name,
                'msg' => 'ถูกต้อง'
            ]);
        }else {
            return response()->json([
                'success' => true,
                'msg' => 'ไม่มีข้อมูล'
            ]);
        }
    }

}
