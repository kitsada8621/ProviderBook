<?php

namespace App\Http\Controllers\BasicController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Major;
use Datatables;

class MajorController extends Controller
{
    public function majorindex() {
        return view('admin.pages.BasicdataFolder.major.majorIndex')
        ->with('header','จัดการข้อมูลสาขา')
        ->with('title','ข้อมูลสาขา');
    }

    public function getMajor(Request $request) {
        return Datatables()->of(Major::latest()->get())
        ->addIndexColumn()
        ->addColumn('action',function($row){
            $button = '<a href="javascript:void(0)" data-id="'.$row->id.'" data-name="'.$row->name.'" class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
            $button .= '<a href="javascript:void(0);" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            return $button;
        })
        ->rawColumns(['action'])->make(true);
    }
    public function create(Request $request) {
        if(empty($request->id)) {
            $this->validate($request,[
                'name' => 'required|unique:major'
            ]);
            Major::create([
                'name' => $request->name
            ]);
        }else {
            $major = Major::find($request->id);
            if($major->name != $request->name) {
                $this->validate($request,[
                    'name'=>'required|unique:major'
                ]);
                $major->name = $request->name;
                $major->update();
            }
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id) {
        Major::find($id)->delete();
        return response()->json(
            [
                'success' => true
            ]
        );
    }
}
