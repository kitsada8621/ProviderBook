<?php

namespace App\Http\Controllers\BasicController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BookType;
use DataTables;

class BookTypeController extends Controller
{
    public function index() {
        return view('DataBasic.BookType.typeindex')->with('header','ประเภทหนังสือ')->with('title','ข้อมูลประเภทหนังสือ');
    }

    public function getBookType(Request $request) {
        return DataTables()->of(BookType::latest()->get())
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" data-name="'.$row->name.'" class="edit btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                $btn .= '<a href="javascript:void(0)" id="delete" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(Request $request) {
        if(empty($request->id)) {
            $this->insert($request);
            return response()->json([
                'success' => true
            ]);
        }else {
            $this->edit($request);
            return response()->json([
                'success' => true
            ]);
        }
    }

    protected function insert(Request $request) {
        $this->validate($request,[
            'name' => 'required'
        ]);
        BookType::create([
            'name' => $request->name
        ]);
    }

    protected function edit(Request $request) {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $data = BookType::find($request->id);
        if($data->name != $request->name) {
            $this->validate($request,[
                'name' => 'unique:booktype'
            ]);
            $data->name = $request->name;
        }
        $data->update();
    }

    public function destroy($id) {
        BookType::find($id)->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
