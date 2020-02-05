<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\borrow;
use App\Book;
use App\Student;
use DataTables;

class BorrowController extends Controller
{
    public function index(Request $request) {
        if($request->ajax()) {

            $data = Book::join('project','project.p_id','=','book.p_id')
            ->select('book.b_id','book.type','book.status','project.p_name','project.category','project.createdate','project.description')
            ->where('book.status','=',NULL)
            ->latest('book.created_at')->get();
            return DataTables()->of($data)
            ->addIndexColumn()
            ->editColumn('status',function($row){
                if(!empty($row->status)) {
                    $exp = "ไม่ว่าง";
                }else {
                    $exp = "ว่าง";
                }
                return $exp;
            })
            ->addColumn('action',function($row){
                $status = "ว่าง";
                if(!empty($row->status)) {
                    $status = "ไม่ว่าง";
                }
                $btn = '<button type="button" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-type="'.$row->type.'" data-category="'.$row->category.'" data-status="'.$status.'" data-description="'.$row->description.'" class="detail btn btn-secondary btn-xs" ><i class="fas fa-eye"></i></button>';
                $btn .= '<button type="type" class="btn btn-primary btn-xs" data-b_id="'.$row->b_id.'" id="btnBorrow">ยืม</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('student.pages.borrow.borrowIndex');
    }

    public function Borrowing(Request $request) {
        $this->validate($request,[
            'std_id' => 'required',
            'std_name' => 'required',
            'br_date' => 'required|date',
            'due_date' => 'required|date',
        ]);

        $book = Book::find($request->b_id);
        
        if(empty($book->status)) {
            $student = Student::find($request->std_id);
            if($student->unit <= 2 ) {
                borrow::create([
                    'b_id' => $request->b_id,
                    'status' => 'รอการยืนยัน',
                    'std_id' => $request->std_id,
                    'br_date' => date('Y-m-d H:i:s'),
                    'due_date' => $request->due_date
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'จำนวนครั้งการยืมครบแล้วค่ะ กรุณาติดต่อเจ้าหน้าที่นะคะ'
                ]);
            }
        }else {
            return response()->json([
                'success' => false,
                'message' => 'หนังสือไม่ว่างค่ะ'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'บันทึกสำเร็จค่ะ'
        ]);
    }

    public function edit(Request $request) {
        $this->validate($request,[
            'b_id' => 'required',
            'p_name' => 'required',
            'due_date' => 'required|date'
        ]);

        $borrow = borrow::find($request->br_id);
        if($request->b_id != $borrow->b_id) {
            $book = Book::find($request->b_id);
            if(empty($book->status)) {
                $borrow->b_id = $request->b_id;
            }else {
                return response()->json([
                    'success' => false,
                    'message' => 'หนังสือไม่ว่าง'
                ]);
            }
        }

        if($request->due_date != $borrow->due_date) {
            $borrow->due_date = $request->due_date;
        }

        $borrow->update();

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id) {
        borrow::find($id)->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
