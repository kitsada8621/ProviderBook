<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Returning;
use App\borrow;
use App\Student;
use App\Book;
use DataTables;

class ReturnController extends Controller
{
    public function index() {
        return view('admin.pages.ReturnBooks.returnIndex')->with('header','คืนหนังสือโครงงานที่ยืม')->with('title','ข้อมูลหนังสือที่ถูกยืม');
    }
    public function getBorrowing(Request $request) {
        if($request->ajax()) {
            $borrow = borrow::join('book','book.b_id','=','borrow.b_id')->join('project','project.p_id','=','book.p_id')->join('student','student.std_id','=','borrow.std_id')
            ->select('borrow.br_id','borrow.br_date','borrow.due_date','borrow.returning','book.b_id','book.type','project.p_id','project.p_name','project.category','student.std_id','student.std_name')
            ->where('borrow.status','=',"ยืนยันการยืม")
            ->latest('borrow.created_at')->get();
            return DataTables()->of($borrow)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d-m-Y',\strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d-m-Y',\strtotime($row->due_date));
            })
            ->editColumn('fine',function($row){

                $today = strtotime(date('Y-m-d'));
                $dueday = strtotime($row->due_date);

                if($today > $dueday) {
                    $res = abs( (($today-$dueday) / (60*60*24)) *5 );
                }else{
                    $res = "ไม่มีค่าปรับ";
                }

                return $res;
            })
            ->addColumn('action',function($row){
                if(strtotime(date('Y-m-d')) > strtotime($row->due_date)) {
                    $fine = abs( ((strtotime(date('Y-m-d')) - strtotime($row->due_date)) / (60*60*24)) *5 );
                }else {
                    $fine = "ไม่มีค่าปรับ";
                }
                return '<a href="#" data-id="'.$row->br_id.'" data-std_name="'.$row->std_name.'" data-p_name="'.$row->p_name.'" data-br_date="'.date('d/m/Y H:i:s',strtotime($row->br_date)).'" data-due_date="'.date('d/m/Y H:i:s',strtotime($row->due_date)).'" data-fine="'.$fine.'" class="btn btn-success btn-xs returns">คืนหนังสือ</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function confirmReturn(Request $request) {

        $borrow = borrow::find($request->id);

        if( strtotime(date('Y-m-d')) > strtotime($borrow->due_date) ) {
            return response()->json([
                'success' => false,
                'br_id' => $borrow->br_id
            ]);
        }else{

            /**  Student Retruning */
            Student::where('std_id',$borrow->std_id)->update([
                'borrows' => NULL
            ]);

            /** books Returning */
            Book::where('b_id',$borrow->b_id)->update([
                'status' =>  NULL
            ]);

            /** return insert to tables return */

            Returning::create([
                'br_id' => $borrow->br_id,
                'fine' => NULL
            ]);

            /** borrow returning */
            $borrow->status = "คืนแล้ว";
            $borrow->returning = date('Y-m-d H:i:s');
            $borrow->update();
            
            return response()->json([
                'success' => true,
                'message' => 'คืนหนังสือสำเร็จ'
            ]);
        }
    }

    public function returnFineConfirm(Request $request) {
        $borrow = borrow::find($request->id);

        /** Student Returning */
        Student::where('std_id',$borrow->std_id)->update([
            'borrows' => NULL
        ]);
        /** Books Returning */
        Book::where('b_id',$borrow->b_id)->update([
            'status' => NULL
        ]);
        /** Return push data to db */
        $fine = abs( ((strtotime(date('Y-m-d')) - strtotime($borrow->due_date))/(60*60*24))*5);
        Returning::create([
            'br_id' => $borrow->br_id,
            'fine' => $fine
        ]);
        /** borrow update */
        $borrow->status = "คืนแล้ว";
        $borrow->returning = date('Y-m-d H:i:s');
        $borrow->update();

        return response()->json([
            'success' => true
        ]);
    }

    public function payfine(Request $request) {
        $borrow = borrow::find($request->id);

        /** student status */
        Student::where('std_id',$borrow->std_id)->update(['borrows'=>NULL]);

        /** book status */
        Book::where('b_id',$borrow->b_id)->update(['status'=> NULL]);

        $fine = abs( ((strtotime(date('Y-m-d')) - strtotime($borrow->due_date))/(60*60*24))*5);
        Returning::create(['br_id'=>$borrow->br_id,'fine'=>$fine]);

        $borrow->status = "คืนแล้ว";
        $borrow->returning = date('Y-m-d H:i:s');
        $borrow->update();

        return response()->json([
            'success' => true
        ]);
    }

    public function printfine($id) {
        // $borrow = borrow::join('book','book.b_id','=','borrow.b_id')->join('project','project.p_id','=','book.b_id')->join('student','student.std_id','=','borrow.std_id')
        // ->select('borrow.br_date','borrow.due_date','book.b_id','project.p_name','student.std_id','student.std_name','student.major','student.tel','student.email')
        // ->where('borrow.br_id',$id)->first();
        $borrow = borrow::where('borrow.br_id',$id)
        ->join('book','book.b_id','=','borrow.b_id')
        ->join('student','student.std_id','=','borrow.std_id')
        ->join('project','project.p_id','=','book.p_id')
        ->select('borrow.br_id','borrow.br_date','borrow.due_date','book.b_id','student.std_id','student.std_name','student.major','student.tel','student.email','project.p_name')
        ->first();
        return view('admin.pages.ReturnBooks.fineReceipt')->with('data',$borrow);
    }

    public function sure_printed(Request $request) {
        $borrow = borrow::find($request->id);

        /** student update */
        Student::where('std_id',$borrow->std_id)->update(['borrows'=>NULL]);

        /** book update */
        Book::where('b_id',$borrow->b_id)->update(['status'=>NULL]);

        /** return update */
        $fine = abs( ((strtotime(date('Y-m-d')) - strtotime($borrow->due_date))/(60*60*24))*5);
        Returning::create(['br_id'=>$borrow->br_id,'fine'=>$fine]);

        /** borrow update */
        $borrow->status = "คืนแล้ว";
        $borrow->returning = date('Y-m-d H:i:s');
        $borrow->update();

        return response()->json([
            'success' => true
        ]);


    }

}
