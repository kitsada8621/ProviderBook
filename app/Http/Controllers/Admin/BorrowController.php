<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\borrow;
use App\Book;
use App\Student;
use DataTables;

class BorrowController extends Controller
{
    public function getBooks(Request $request) {
        if($request->ajax()) {
            $book = Book::join('project','project.p_id','=','book.p_id')
            ->select('book.b_id','book.type','project.p_id','project.p_name','project.category')
            ->where('book.status','=',"")->orwhere('book.status','=',NULL)
            ->latest('book.created_at')->get();
            return DataTables()->of($book)
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $btn = '<a href="#" data-b_id="'.$row->b_id.'" class="btn btn-success p-2" id="btnBorrow">ยืนยัน</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function getBorrowing(Request $request) {
        if($request->ajax()) {
            $borrow = borrow::join('book','book.b_id','=','borrow.b_id')->join('project','project.p_id','=','book.p_id')->join('student','student.std_id','=','borrow.std_id')
            ->select('borrow.br_id','borrow.br_date','borrow.due_date','borrow.returning','book.b_id','book.type','project.p_id','project.p_name','project.category','student.std_id','student.std_name')
            ->where('borrow.status','!=',"คืนแล้ว")
            ->latest('borrow.created_at')->get();
            return DataTables()->of($borrow)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d/m/Y',strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d/m/Y',strtotime($row->due_date));
            })
            ->addColumn('action',function($row){
                $btn = '<a href="#"  data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-std_name="'.$row->std_name.'" data-br_date="'.date('d/m/Y',strtotime($row->br_date)).'" data-due_date="'.date('d/m/Y',strtotime($row->due_date)).'" data-type="'.$row->type.'" class="btn btn-info btn-xs details"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="#" data-br_id="'.$row->br_id.'" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-br_date="'.date('Y-m-d',strtotime($row->br_date)).'" data-due_date="'.date('Y-m-d',strtotime($row->due_date)).'" class="edit btn btn-warning btn-xs"><i class="fas fa-edit"></i></a>';
                $btn .= '<a href="#" id="delete" data-id="'.$row->br_id.'" class=" btn btn-danger btn-xs"><i class="fas fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function create(Request $request) {
        $this->validate($request,[
            'std_id' => 'required',
            'std_name' => 'required',
            'due_date' => 'required',
        ]);

        $studentValidatedId = Student::where('std_id','=',$request->std_id)->first();
        $studentValidatedName = Student::where('std_name','=',$request->std_name)->first();
        $studenUse = Student::where('std_id',$request->std_id)->first();

        /** Student Validate unit borrow say true or faild */
        if($studentValidatedId && $studentValidatedName) {
            if($studenUse->borrows == "") {
                if($studenUse->unit <= 2) {

                    $book = Book::find($request->id);

                    $book->status = "กำลังยืม";
                    $book->save();

                    $student = Student::find($request->std_id);
                    $student->borrows = "กำลังยืม";
                    if(empty($student->unit)) {
                        $unit = 1;
                    }elseif($student->unit == 1) {
                        $unit = 2;
                    }elseif($student->unit == 2) {
                        $unit = 3;
                    }
                    $student->unit = $unit;
                    $student->save();

                    $borrow = new borrow;
                    $borrow->b_id = $book->b_id;
                    $borrow->status = "ยืนยันการยืม";
                    $borrow->std_id = $request->std_id;
                    $borrow->admin_id = Auth::user()->id;
                    $borrow->br_date = date('Y-m-d H:i:s');
                    $borrow->due_date = $request->due_date;
                    $borrow->save();


                    return response()->json([
                        'success' => true,
                        'msg' => 'ยืมหนังสือ สำเร็จค่ะ'
                    ]);
                }else {
                    return response()->json([
                        'success' => false,
                        'msg' => 'การยืมครบกำหนดแล้วค่ะ กรุณาต่ออายุนะคะ'
                    ]);
                }
            }else {
                return response()->json([
                    'success' => false,
                    'msg' => 'กรุณาคืนหนังสือที่ยืมก่อนยืมอิกครั้งนะค่ะ'
                ]);
            }
        }else {
            return response()->json([
                'success' => false,
                'msg' => 'ไม่พบรายชื่อหรือรหัสนี้ค่ะ'
            ]);
        }
    }

    public function edit(Request $request) {
        $this->validate($request,[
            'std_id' => 'required',
            'std_name' => 'required',
            'b_id' => 'required',
            'p_name' => 'required',
            'br_date' => 'required|date',
            'due_date' => 'required|date'
        ]);

        /** old data */
        $borrow = borrow::find($request->id);
        $book = Book::find($borrow->b_id);
        $student = Student::find($borrow->std_id);
        
        /** new data */
        $newbook = Book::find($request->b_id);
        $newStudent = Student::find($request->std_id);

        /** Book Update */
        if($book->b_id != $request->b_id) {
            if($newbook->status != "กำลังยืม") {
                /** new book */
                Book::where('b_id',$request->b_id)->update([
                    'status' => "กำลังยืม"
                ]);
                /** old book */
                Book::where('b_id',$borrow->b_id)->update([
                    'status' => Null
                ]);
                /** borrow book update */
                borrow::where('br_id',$request->id)->update([
                    'b_id' => $request->b_id
                ]);
            }else {
                return response()->json([
                    'success' => false,
                    'msg' =>'หนังสือไม่ว่าง'
                ]);
            }
        }

        /** Student Update */
        if($student->std_id != $request->std_id) {
            if($newStudent->borrows !="กำลังยืม") {
                if($newStudent->unit <= 2) {
                    /** new student  */
                    if(empty($newStudent->unit)) {
                        $newUnit = 1;
                    }elseif($newStudent->unit == 1) {
                        $newUnit = 2;
                    }elseif($newStudent->unit == 2) {
                        $newUnit = 3;
                    }
                    Student::where('std_id',$request->std_id)->update([
                        'unit' => $newUnit,
                        'borrows' => "กำลังยืม"
                    ]);
                    /** old student */
                    if($student->unit == 1) {
                        $oldunit = NULL;
                    }elseif($student->unit == 2) {
                        $oldunit = 1;
                    }elseif($studenUse->unit == 3) {
                        $oldunit = 2;
                    }
                    Student::where('std_id',$borrow->std_id)->update([
                        'unit' => $oldunit,
                        'borrows'=> NULL
                    ]);
                    /** borrow Update */
                    borrow::where('br_id',$request->id)->update([
                        'std_id' => $request->std_id
                    ]);
                }else {
                    return response()->json([
                        'success' => false,
                        'msg' => 'การยืมครบกำหนดแล้วค่ะ กรุณาต่ออายุการยืม'
                    ]);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'msg' =>'กรุณาคืนหนังสือก่อนทำการยืมอิกครั้งค่ะ'
                ]);
            }
        }

        /** Date Validation */
        if($borrow->br_date != $request->br_date) {
            borrow::where('br_id',$request->id)->update([
                'br_date' => $request->br_date
            ]);
        }

        if($borrow->due_date != $request->due_date) {
            borrow::where('br_id',$request->id)->update([
                'due_date' => $request->due_date
            ]);
        }

        return response()->json([
            'success' => true,
            'msg' => 'ยินดีด้วยค่ะ แก้ไขข้อมูลการยืมสำเร็จค่ะ '
        ]);
    }

    public function destroy($id) {
        $borrow = borrow::find($id);

        /** delete student */
        $student = Student::find($borrow->std_id);
        if($student->unit == 1) {
            $unit = NULL;
        }elseif($student->unit == 2) {
            $unit = 1;
        }elseif($student->unit == 3) {
            $unit = 2;
        }
        Student::where('std_id',$borrow->std_id)->update([
            'borrows' => NULL,
            'unit' => $unit
        ]);
        /** books delete */
        Book::where('b_id',$borrow->b_id)->update([
            'status' => NULL
        ]);
        /** borrow remove */
        $borrow->delete();

        return response()->json([
            'success' => true
        ]);
    }

    /** searching autocomple */
    public function borrowGetbookId(Request $request) {
        if($request->id) {
            $id = Book::join('project','project.p_id','book.p_id')->select('book.b_id','project.p_name')->where('book.b_id','=',$request->id)->first();
            if($id) {
                return response()->json([
                    'success' => true,
                    'p_name' => $id->p_name
                ]);
            }else {
                return response()->json([
                    'success' => false
                ]);
            }
        }else {
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function borrowGetbookName(Request $request) {
        if($request->name) {
            $name = Book::join('project','project.p_id','book.p_id')->select('book.b_id','project.p_name')->where('project.p_name','=',$request->name)->first();
            if($name) {
                return response()->json([
                    'success' => true,
                    'b_id' => $name->b_id
                ]);
            }else {
                return response()->json([
                    'success' => false
                ]);
            }
        }else {
            return response()->json([
                'success' => false
            ]);
        }
    }
}
