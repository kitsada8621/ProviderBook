<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\borrow;
use DataTables;

class HomeController extends Controller
{
    public function home() {
        return view('student.home');
    }

    public function getBorrow(Request $request) {
        if($request->ajax()) {
            $data = borrow::join('book','book.b_id','=','borrow.b_id')
            ->join('project','project.p_id','=','book.p_id')
            ->join('student','student.std_id','=','borrow.std_id')
            ->select('borrow.br_id','borrow.br_date','borrow.due_date','borrow.status','book.b_id','book.type','project.p_name','project.category','project.createdate','project.description','student.std_id','student.std_name','student.major')
            ->where('student.std_id','=',Auth::guard('students')->user()->std_id)
            ->where('borrow.status','!=','คืนแล้ว')
            ->latest('borrow.created_at')
            ->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d/m/Y',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d/m/Y',strtotime($row->due_date));
            })
            ->addColumn('action',function($row){
                /** fine */
                $fines = "ไม่มี";
                if(\strtotime(date('Y-m-d')) > \strtotime($row->due_date)) {
                    $fines = \abs(((\strtotime(date('Y-m-d'))-\strtotime($row->due_date))/(60*60*24))*5);
                }
                /** end fine */
                if($row->status == "ยืนยันการยืม") {
                    $btn = '<button type="button" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d-m-Y',strtotime($row->br_date)).'" data-due_date="'.date('d-m-Y',strtotime($row->due_date)).'" data-fine="'.$fines.'" data-status="'.$row->status.'" class="btn btn-success btn-xs detail"><i class="fas fa-eye"></i></button>';
                }else {
                    $btn = '<a href="#" class="btn btn-success btn-xs detail" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d-m-Y',strtotime($row->br_date)).'" data-due_date="'.date('d-m-Y',strtotime($row->due_date)).'" data-fine="'.$fines.'" data-status="'.$row->status.'"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="#" class="edit btn btn-warning btn-xs" data-br_id="'.$row->br_id.'" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-due_date="'.date('Y-m-d',strtotime($row->due_date)).'" ><i class="fas fa-edit"></i></a>';
                    $btn .= '<a href="#" class="delete btn btn-danger btn-xs" data-br_id="'.$row->br_id.'"><i class="fas fa-trash"></i></a>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function home1(Request $request) {
        if($request->ajax()) {
            $data = borrow::join('book','book.b_id','=','borrow.b_id')->join('project','project.p_id','=','book.p_id')->join('student','student.std_id','=','borrow.std_id')
            ->select('borrow.br_id','borrow.br_date','borrow.due_date','borrow.status','book.b_id','book.type','project.p_name','project.category','project.createdate','project.description','student.std_id','student.std_name','student.major')
            ->where('borrow.status','=',"ยืนยันการยืม")
            ->where('student.std_id','=',Auth::guard('students')->user()->std_id)
            ->latest('borrow.created_at')
            ->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d/m/Y',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d/m/Y',strtotime($row->due_date));
            })
            ->addColumn('action',function($row){
                /** fine */
                $fines = "ไม่มี";
                if(\strtotime(date('Y-m-d')) > \strtotime($row->due_date)) {
                    $fines = \abs(((\strtotime(date('Y-m-d'))-\strtotime($row->due_date))/(60*60*24))*5);
                }
                /** end fine */
                $btn = '<button type="button" class="btn btn-success btn-xs detail" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d-m-Y',strtotime($row->br_date)).'" data-due_date="'.date('d-m-Y',strtotime($row->due_date)).'" data-fine="'.$fines.'" data-status="'.$row->status.'"><i class="fas fa-eye"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('student.dashboard.comples');
    }
    public function home2(Request $request) {
        if($request->ajax()) {
            $data = borrow::join('book','book.b_id','=','borrow.b_id')->join('project','project.p_id','=','book.p_id')->join('student','student.std_id','=','borrow.std_id')
            ->select('borrow.br_id','borrow.br_date','borrow.due_date','borrow.status','book.b_id','book.type','project.p_name','project.category','project.createdate','project.description','student.std_id','student.std_name','student.major')
            ->where('borrow.status','=',"รอการยืนยัน")
            ->where('student.std_id','=',Auth::guard('students')->user()->std_id)
            ->latest('borrow.created_at')
            ->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d/m/Y',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d/m/Y',strtotime($row->due_date));
            })
            ->addColumn('action',function($row){
                $fines ="ไม่มี";
                $btn = '<a href="#" class="detail btn btn-success btn-xs" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d-m-Y',strtotime($row->br_date)).'" data-due_date="'.date('d-m-Y',strtotime($row->due_date)).'" data-fine="'.$fines.'" data-status="'.$row->status.'"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="#" class="edit btn btn-warning btn-xs" data-br_id="'.$row->br_id.'" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-due_date="'.date('Y-m-d',strtotime($row->due_date)).'" ><i class="fas fa-edit"></i></a>';
                $btn .= '<a href="#" class="delete btn btn-danger btn-xs" data-br_id="'.$row->br_id.'"><i class="fas fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('student.dashboard.waitreply');
    }
    public function home3(Request $request) {
        if($request->ajax()) {
            $data = borrow::join('book','book.b_id','=','borrow.b_id')->join('project','project.p_id','=','book.p_id')->join('student','student.std_id','=','borrow.std_id')
            ->select('borrow.br_id','borrow.br_date','borrow.due_date','borrow.status','book.b_id','book.type','project.p_name','project.category','project.createdate','project.description','student.std_id','student.std_name','student.major')
            ->where('borrow.status','=',"ปฎิเสธ")
            ->where('student.std_id','=',Auth::guard('students')->user()->std_id)
            ->latest('borrow.created_at')
            ->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d/m/Y',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d/m/Y',strtotime($row->due_date));
            })
            ->addColumn('action',function($row){
                $fines = "ไม่มี";
                $btn = '<button type="button" class="btn btn-success btn-xs detail" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d-m-Y',strtotime($row->br_date)).'" data-due_date="'.date('d-m-Y',strtotime($row->due_date)).'" data-fine="'.$fines.'" data-status="'.$row->status.'"><i class="fas fa-eye"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('student.dashboard.reject');
    }
}
