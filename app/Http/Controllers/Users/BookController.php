<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use DataTables;

class BookController extends Controller
{
    public function index(Request $request) {
        if($request->ajax()) {
            $data = Book::join('project','project.p_id','=','book.p_id')
            ->join('student','student.std_id','=','project.std_id')
            ->join('teacher','teacher.t_id','=','project.t_id')
            ->select('book.b_id','project.p_name','book.type','project.category','book.status','project.description','student.std_name','teacher.t_name')
            ->latest('book.created_at')->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('status',function($row){

                if(empty($row->status)) {
                    $result = "ว่าง";
                }else {
                    $result = "ไม่ว่าง";
                }

                return $result;
            })
            ->addColumn('action',function($row){

                $status = "ว่าง";
                if(!empty($row->status)) {
                    $status = "ไม่ว่าง";
                }

                $btn = '<button type="button" class="detail btn btn-success btn-xs" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-type="'.$row->type.'" data-category="'.$row->category.'" data-status="'.$status.'" data-t_name="'.$row->t_name.'" data-std_name="'.$row->std_name.'" data-description="'.$row->description.'"><i class="fas fa-eye"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('student.pages.book.bookIndex');
    }
}
