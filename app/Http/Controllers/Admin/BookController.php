<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\Project;
use Datatables;
use App\BookType;

class BookController extends Controller
{
    public function index() {
        $type = BookType::all();
        return view('admin.pages.book.BookIndex')->with('header','จัดการหนังสือโครงงาน')->with('title','ข้อมูลหนังสือ')->with('type',$type);
    }

    public function getBook(Request $request) {
        $data = Book::join('project','project.p_id','book.p_id')
        ->join('student','student.std_id','project.std_id')
        ->join('teacher','teacher.t_id','project.t_id')
        ->select('book.b_id','book.type','book.condition','book.status','book.type','project.p_id','project.p_name','project.category','project.createdate','project.description','student.std_id','student.std_name','teacher.t_id','teacher.t_name')
        ->latest('book.created_at')->get();
        if($request->ajax()) {
            return DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $button = '<a href="javascript:void(0)" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-type="'.$row->type.'" data-category="'.$row->category.'" data-createdate="'.$row->createdate.'" data-adviser="'.$row->t_name.'" data-creator="'.$row->std_name.'" data-description="'.$row->description.'"  class="detail btn btn-info btn-xs"><i class="fa fa-eye"></i></a>';
                $button .= '<a href="javascript:void(0)" data-b_id="'.$row->b_id.'" data-p_id="'.$row->p_id.'" data-p_name="'.$row->p_name.'" data-type="'.$row->type.'" class="edit btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>';
                $button .= '<a href="javascript:void(0);" data-b_id="'.$row->b_id.'" class="delete btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function create(Request $request) {
        if(!empty($request->b_id)) {
            $this->edit($request);
            return response()->json([
                'success' => $request->id
            ]);
        }else {
            $this->insert($request);
            return response()->json([
                'success' => true
            ]);
        }
    }

    protected function insert(Request $request) {
        $this->validate($request,[
            'p_id' => 'required',
            'p_name' => 'required',
            'type' => 'required',
        ]);   

        Book::create([
            'b_id' => mt_rand(1000000000, 9999999999),
            'p_id' => $request->p_id,
            'type' => $request->type
        ]);

    }

    protected function edit(Request $request) {
        $data = Book::find($request->b_id);
        if($request->p_id != $data->p_id) {
            $data->p_id = $request->p_id;
        }
        if($request->type != $data->type) {
            $data->type = $request->type;
        }
        $data->update();
    }

    public function destroy($id) {
        $data = Book::find($id)->delete();
        return response()->json([
            'success' => true
        ]);
    }

    /** Search form textbox show on textbox */
    public function searchProjectById(Request $request) {
        if(!empty($request->id)) {
            $project = Project::where('p_id',$request->id)->first();
            if($project) {
                return response()->json([
                    'success' => true,
                    'p_name' => $project->p_name
                ]);
            }else {
                return response()->json([
                    'success'=> false
                ]);
            }
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function searchProjectByName(Request $request) {
        if(!empty($request->name)) {
            $project = Project::where('p_name',$request->name)->first();
            if($project) {
                return response()->json([
                    'success' => true,
                    'p_id' => $project->p_id
                ]);
            }else {
                return response()->json([
                    'success'=> false
                ]);
            }
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }

    public function viewprints(Request $request) {
        if($request->ajax()) {
            $data = Book::join('project','project.p_id','=','book.p_id')
            ->select('book.b_id','project.p_name','book.type')
            ->latest('book.created_at')->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->addColumn('checking',function($row){
                return '<div class="form-check form-check-inline"><input type="checkbox" name="print_checked[]" id="print_checked" class="form-check-input print_checked" value="'.$row->b_id.'"><label class="form-check-label">เลือก</label></div>';
            })
            ->addColumn('printed',function($row){
                return '<button type="button" data-id="'.$row->b_id.'" class="btn btn-primary btn-xs" id="printing"><i class="fas fa-print"></i></button>';
            })
            ->rawColumns(['checking','printed'])->make(true);
        }
        return view('admin.pages.book.bookPrint',);
    }
    public function allPrint(Request $request) {
        
        foreach($request->print_checked as $id) {
            $book[] = Book::where('b_id',$id)->first();
        }
        return view('admin.pages.book.allprint',\compact('book'));
    }
    public function alonePrint($id) {

        $book = Book::join('project','project.p_id','=','book.p_id')
        ->join('student','student.std_id','=','project.std_id')
        ->join('teacher','teacher.t_id','=','project.t_id')
        ->select('book.b_id','book.type','project.p_id','project.p_name','project.category','project.description','project.createdate','student.std_id','student.std_name','student.major','teacher.t_id','teacher.t_name')
        ->where('book.b_id',$id)->first();
        return view('admin.pages.book.alonePrint',\compact('book'));
    }
}
