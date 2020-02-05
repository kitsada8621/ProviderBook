<?php

namespace App\Http\Controllers\BasicController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\TypeProject;

class TypeProjectController extends Controller
{
    public function index() {
        return view('admin.pages.BasicdataFolder.typeProject.typeIndex')->with('header','จัดการประเภทโครงงาน')->with('title','ข้อมูลประเภทโครงงาน');
    }
    public function getTypeProject(Request $request) {
        if($request->ajax()) {
            return DataTables()->of(TypeProject::latest()->get())
            ->addIndexColumn()
            ->addColumn('action',function($row){
                $button = '<a href="#" data-id="'.$row->id.'" data-name="'.$row->name.'" class="btn btn-warning btn-sm edit"><i class="fas fa-edit"></i></a>';
                $button .= '<a href="#" data-id="'.$row->id.'" class=" btn btn-danger btn-sm delete"><i class="fas fa-trash"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }
    public function create(Request $request) {
        
        if(empty($request->id)) {
            $this->validate($request,[
                'name' => 'required|unique:typeproject'
            ]);
            $result = "Created";
            TypeProject::create([
                'name' => $request->name
            ]);
        }else {
            $this->validate($request,[
                'name'=>'required'
            ]);
            
            $type = TypeProject::find($request->id);
            if($request->name != $type->name) {
                $this->validate($request,[
                    'name' => 'unique:typeproject'
                ]);
                $type->name = $request->name;
                $type->update();
            }
            $result = "Updated";
        }

        return response()->json([
            'success' => true,
            'message' => $result
        ]);
    }

    public function destroy($id) {
        TypeProject::find($id)->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
