<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Project;
use App\TypeProject;
use DataTables;

class ProjectController extends Controller
{
    public function index(Request $request) {
        if($request->ajax()) {
            $id = Auth::guard('students')->user()->std_id;
            $data = Project::where('student.std_id','=',$id)
            ->join('student','student.std_id','=','project.std_id')
            ->join('teacher','teacher.t_id','=','project.t_id')
            ->select('project.p_id','project.p_name','project.createdate','project.description','project.category','student.std_id','student.std_name','student.major','teacher.t_id','teacher.t_name')
            ->latest('project.created_at')->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $btn = '<a href="#" class="detail btn btn-success btn-xs" data-p_id="'.$row->p_id.'" data-p_name="'.$row->p_name.'" data-category="'.$row->category.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-t_name="'.$row->t_name.'" data-description="'.$row->description.'" data-createdate="'.date('d-m-Y',strtotime($row->createdate)).'"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="#" class="edit btn btn-warning btn-xs" data-p_id="'.$row->p_id.'" data-p_name="'.$row->p_name.'" data-category="'.$row->category.'" data-createdate="'.date('Y-m-d',strtotime($row->createdate)).'" data-description="'.$row->description.'" data-std_id="'.$row->std_id.'"  data-std_name="'.$row->std_name.'" data-t_id="'.$row->t_id.'" data-t_name="'.$row->t_name.'"><i class="fas fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('student.pages.project.projectIndex')->with('type',TypeProject::get());
    }

    public function createProject(Request $request) {

        if(!empty($request->id)) {
            $this->editing($request);
        }else {
            $this->inserting($request);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function inserting(Request $request) {
        $this->validate($request,[
            'p_name' => 'required|unique:project',
            'category' => 'required',
            't_id' => 'required',
            't_name' => 'required',
            'std_id' => 'required',
            'std_name' => 'required',
            'createdate' => 'required|date',
            'description' => 'required',
        ]);

        Project::create([
            'p_id' => mt_rand(1000000000, 9999999999),
            'p_name' => $request->p_name,
            'category' => $request->category,
            't_id' => $request->t_id,
            'std_id' => $request->std_id,
            'createdate' => $request->createdate,
            'description' => $request->description
        ]);
    }

    public function editing(Request $request) {
        $this->validate($request,[
            'p_name' => 'required',
            'category' => 'required',
            't_id' => 'required',
            't_name' => 'required',
            'std_id' => 'required',
            'std_name' => 'required',
            'createdate' => 'required|date',
            'description' => 'required',
        ]);

        $project = Project::find($request->id);

        if($project->p_name != $request->p_name) {
            $this->validate($request,[
                'p_name' => 'unique:project'
            ]);
            $project->p_name = $request->p_name;
        }

        if($project->category != $request->category) {
            $project->category = $request->category;
        }

        if($project->t_id != $request->t_id) {
            $project->t_id = $request->t_id;
        }

        if($project->std_id != $request->std_id) {
            $project->std_id = $request->std_id;
        }

        if($project->createdate != $request->createdate) {
            $project->createdate = $request->createdate;
        }

        if($project->description != $request->description) {
            $project->description = $request->description;
        }
        $project->update();
    }
}
