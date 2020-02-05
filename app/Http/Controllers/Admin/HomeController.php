<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\borrow;
use App\Book;
use App\Student;
use DataTables;

class HomeController extends Controller
{
    public function home(Request $request) {

        if($request->ajax()) {
            /** data opject */
            $data = borrow::join('book','book.b_id','=','borrow.b_id')->join('student','student.std_id','=','borrow.std_id')
            ->join('project','project.p_id','=','book.p_id')
            ->select('borrow.br_id','borrow.br_date','borrow.status','borrow.due_date','project.p_name','student.std_name','student.major','book.b_id','book.type')
            ->where('borrow.status','!=',"คืนแล้ว")
            ->latest('borrow.created_at')->get();
            /* end data opject */

            /** DataTable response to fontHome */
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d-m-Y',\strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d-m-Y',\strtotime($row->due_date));
            })
            ->addColumn('action',function($row){
                if($row->status == "รอการยืนยัน") {
                    $btn = '<button type="button" data-id="'.$row->br_id.'" class="borrow-confirm btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                    $btn .= '<button type="button" data-id="'.$row->br_id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>';
                }else {                
                    
                    $fine = "ไม่มี";
                    
                    if( \strtotime(date('Y-m-d') > \strtotime($row->due_date) ) ) {
                        $fine = \abs( ((\strtotime(date('Y-m-d')) - \strtotime($row->due_date)) / (60*60*24)) *5 );
                    }
                    
                    $btn = '<button type="button" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-type="'.$row->type.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d/m/Y',strtotime($row->br_date)).'" data-due_date="'.date('d/m/Y',strtotime($row->due_date)).'" data-fine="'.$fine.'" class="detils btn btn-info btn-xs"><i class="fas fa-eye"></i></button>';
                    $btn .= '<button type="button" data-id="'.$row->br_id.'" class="delete btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>';
                }
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
            /** end dataTables response */

        }
        return view('admin.home');
    }

    public function comples(Request $request) {
        if($request->ajax()) {

            $data = borrow::join('book','book.b_id','=','borrow.b_id')->join('student','student.std_id','=','borrow.std_id')
            ->join('project','project.p_id','=','book.p_id')
            ->select('borrow.br_id','borrow.br_date','borrow.status','borrow.due_date','project.p_name','student.std_name','student.major','book.b_id','book.type')
            ->where('borrow.status','=',"ยืนยันการยืม")
            ->latest('borrow.created_at')->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d/m/Y',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d/m/Y',strtotime($row->due_date));
            })
            ->addColumn('action',function($row){

                $fine = "ไม่มีค่าปรับ";
                if(\strtotime(date('Y-m-d')) > \strtotime($row->due_date)) {
                    $fine = \abs( (( strtotime(date('Y-m-d')) - strtotime($row->due_date) ) / (60*60*24) * 5) );
                }

                return '<button type="button" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-type="'.$row->type.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d/m/Y',strtotime($row->br_date)).'" data-due_date="'.date('d/m/Y',strtotime($row->due_date)).'" data-fine="'.$fine.'" class="detils btn btn-info btn-xs" ><i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.dashboard.comple');
    }

    public function waitreply(Request $request) {
        if($request->ajax()) {
            $data = borrow::join('book','book.b_id','=','borrow.b_id')->join('student','student.std_id','=','borrow.std_id')
            ->join('project','project.p_id','=','book.p_id')
            ->select('borrow.br_id','borrow.br_date','borrow.status','borrow.due_date','project.p_name','student.std_name','student.major','book.type')
            ->where('borrow.status','=',"รอการยืนยัน")
            ->latest('borrow.created_at')->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d/m/Y',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d/m/Y',strtotime($row->due_date));
            })
            ->addColumn('action',function($row){
                $btn ='<button type="button" data-id="'.$row->br_id.'" class="borrow-confirm btn btn-success btn-sm" ><i class="fas fa-check"></i></button>';
                $btn .='<button type="button" data-id="'.$row->br_id.'" class="btn btn-danger btn-sm" ><i class="fas fa-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.dashboard.wait_reply');
    }

    public function reject(Request $request) {
        if($request->ajax()) {
            $data = borrow::join('book','book.b_id','=','borrow.b_id')->join('student','student.std_id','=','borrow.std_id')
            ->join('project','project.p_id','=','book.p_id')
            ->select('borrow.br_id','borrow.br_date','borrow.status','borrow.due_date','project.p_name','student.std_name','student.major','book.b_id','book.type')
            ->where('borrow.status','=',"ปฎิเสธ")
            ->latest('borrow.created_at')->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d/m/Y',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d/m/Y',strtotime($row->due_date));
            })
            ->addColumn('action',function($row){
                $fine ="ไม่มี";
                return '<button type="button" data-id="'.$row->br_id.'" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-type="'.$row->type.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d/m/Y',strtotime($row->br_date)).'" data-due_date="'.date('d/m/Y',strtotime($row->due_date)).'" data-fine="'.$fine.'"  class="btn btn-info btn-xs detail"><i class="fas fa-eye"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.dashboard.reject');
    }

    public function YesConfirm(Request $request) {

        $borrow = borrow::find($request->id);
        
        /** student */
        $student = Student::find($borrow->std_id);
        $student->borrows = "กำลังยืม";
        if($student->unit == NULL) {
            $student->unit = 1;
        }elseif($student->unit == 1) {
            $student->unit = 2;
        }elseif($student->unit == 2) {
            $student->unit = 3;
        }
        $student->update();

        /** book */
        $book = Book::find($borrow->b_id);
        $book->status = "กำลังยืม";
        $book->update();

        /** borrow */
        $borrow->status = "ยืนยันการยืม";
        $borrow->update();

        return response()->json([
            'success' => true
        ]);
    }

    public function NoConfirm(Request $request) {
        $borrow = borrow::find($request->id);

        $borrow->status = "ปฎิเสธ";
        $borrow->update();

        return response()->json([
            'success'=> true
        ]);

    }

    public function destroy($id) {
        $borrow = borrow::find($id);

        if($borrow->status == "ยืนยันการยืม") {
            
            Book::where('b_id',$borrow->b_id)
            ->update([
                'status' => NULL
            ]);

            $student = Student::find($borrow->std_id);
            if($student->unit == 1) {
                $unit = NULL;
            }elseif ($student->unit == 2) {
                $unit = 1;
            }elseif($student->unit == 3) {
                $unit = 2;
            }

            $student->unit = $unit;
            $student->borrows = NULL;
            $student->update();

            $borrow->delete();


        }elseif($borrow->status == "คืนแล้ว") {
            $borrow->delete();
        }elseif($borrow->status == "ปฎิเสธ") {
            $borrow->delete();
        }elseif($borrow->status == "รอการยืนยัน") {
            $borrow->delete();
        }

        return response()->json([
            'success' => true
        ]);
    }
}
