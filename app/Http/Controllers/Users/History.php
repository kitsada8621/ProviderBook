<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DataTables;
use App\Returning;

class History extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $data = Returning::join('borrow','borrow.br_id','=','returning.br_id')
            ->join('book','book.b_id','=','borrow.b_id')
            ->join('project','project.p_id','=','book.p_id')
            ->join('student','student.std_id','=','borrow.std_id')
            ->select('student.std_id','student.std_name','student.major','book.b_id','project.p_name','borrow.br_date','borrow.due_date','borrow.returning','returning.fine')
            ->where('student.std_id','=',Auth::guard('students')->user()->std_id)
            ->latest('returning.created_at')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('br_date',function($row){
                return date('d-m-Y',\strtotime($row->br_date));
            })
            ->editColumn('due_date',function($row){
                return date('d-m-Y',\strtotime($row->due_date));
            })
            ->editColumn('returning',function($row){
                return date('d-m-Y',\strtotime($row->returning));
            })
            ->addColumn('action',function($row){
                $fine = "ไม่มี";
                if(!empty($row->fine)) {
                    $fine = $row->fine;
                }
                return '<a href="#" class="btn btn-success btn-xs details" data-b_id="'.$row->b_id.'" data-p_name="'.$row->p_name.'" data-std_id="'.$row->std_id.'" data-std_name="'.$row->std_name.'" data-major="'.$row->major.'" data-br_date="'.date('d-m-Y',strtotime($row->br_date)).'" data-due_date="'.date('d-m-Y',strtotime($row->due_date)).'" data-returning="'.date('d-m-Y',strtotime($row->returning)).'" data-fine="'.$fine.'"><i class="ti-eye"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('student.pages.histories.historyIndex');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
