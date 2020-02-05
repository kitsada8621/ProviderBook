<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Returning;
use DataTables;

class BorrowController extends Controller
{
    public function index() {
        return view('admin.pages.HistoryBorrow.list')->with('header','ประวัติการยืม')->with('title','ข้อมูลประวัติการยืม');
    }

    public function getborrow(Request $request) {
        if($request->ajax()) {
            $data = Returning::join('borrow','returning.br_id','=','borrow.br_id')
            ->join('book','book.b_id','=','borrow.b_id')
            ->join('student','student.std_id','=','borrow.std_id')
            ->join('project','project.p_id','=','book.p_id')
            ->select('returning.re_id','returning.fine','book.b_id','project.p_name','student.std_name','borrow.br_date','borrow.due_date','borrow.returning')
            ->latest('returning.created_at')
            ->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d-m-Y H:i:s',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d-m-Y H:i:s',strtotime($row->due_date));
            })
            ->editColumn('returning',function($row){
                return date('d-m-Y H:i:s',strtotime($row->returning));
            })
            ->editColumn('fine',function($row){
                if(!empty($row->fine)) {
                    $result = $row->fine;
                }else {
                    $result = "-";
                }
                return $result;
            })
            ->make(true);
        }
    }
}
