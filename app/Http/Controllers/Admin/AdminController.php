<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\User;
use App\Student;
use Datatables;

class AdminController extends Controller
{
    public function index() {
        return view('admin.pages.users.list')->with('title','จัดการข้อมูลผู้ดูแลระบบ');
    }

    public function show($id) {
        return view('admin.pages.users.create')->with('title',"เพิ่มข้อมูลผู้ใช้งาน");
    }

    public function getAdmin(Request $request) {
        if($request->ajax()) {
            return datatables()->of(User::latest()->get())
                ->addIndexColumn()
                ->editColumn('position',function($data){
                    $result = "";
                    if($data->position == 1) {
                        $result = "Manager";
                    }else {
                        $result = "Admins";
                    }
                    return $result;
                })
                ->addColumn('action', function($data){
                $button = '<a href="javascript:void(0)" data-id="'.$data->id.'" data-name="'.$data->name.'" data-position="'.$data->position.'" data-email="'.$data->email.'"  data-username="'.$data->username.'" data-password="'.$data->password.'" data-image="'.$data->image.'"  class="edit btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>';
                $button .= '<a href="javascript:void(0);"  data-id="'.$data->id.'" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(Request $request) {

        if(!empty($request->id)) {
            $this->edit($request);
            return response()->json([
                'success'=> true
            ]);
        }else {
            $this->insert($request);
            return response()->json([
                'success'=>true
            ]);
        }

    }

    public function insert(Request $request) {
        $this->validate($request,[
            'name'=>'required|unique:users|string',
            'email'=>'required|unique:users|email',
            'position'=>'required',
            'username'=>'required|unique:users',
            'password'=>'required|same:conformpassword|min:4',
            'conformpassword'=>'required|min:4',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $useres = new User;
        $useres->name = $request->name;
        $useres->email = $request->email;
        $useres->position = $request->position;
        $useres->username = $request->username;
        $useres->password = Hash::make($request->password);
        if(!empty($request->image)) {
            $image = $request->file('image');
            $filename = \uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(\public_path('uploads'),$filename);
            $useres->image = $filename;
        }
        $useres->save();

    }

    public function edit(Request $request) {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'position'=>'required',
            'username'=>'required',
            'password'=>'required',
            'conformpassword'=>'required'
        ]);
        $user = User::find($request->id);
        if($request->name != $user->name) {
            $this->validate($request,[
                'name' =>'unique:users'
            ]);
            $user->name = $request->name;
        }
        if($request->email != $user->email) {
            $this->validate($request,[
                'email' =>'unique:users|email'
            ]);
            $user->email = $request->email;
        }
        if($request->username != $user->username) {
            $this->validate($request,[
                'username' =>'unique:users'
            ]);
            $user->username = $request->username;
        }
        if($request->position != $user->position) { 
            $user->position = $request->position;
        }
        if(!empty($request->image)) {

            /** Old Image */
            $images = $user->image;
            $namefiled = \public_path().'/uploads/'.$images;
            File::delete($namefiled);

            /** New Image */
            $imaging = $request->file('image');
            $imagingname = uniqid().'.'.$imaging->getClientOriginalExtension();
            $imaging->move(public_path('uploads'), $imagingname);

            /** Update proiled */
            $user->image = $imagingname;

        }
        $user->password = $request->password;
        $user->update();
    }

    public function destroy($id) {

        $user = User::find($id);
        if(!empty($user->image)){
            $images = $user->image;
            $namefiled = \public_path().'/uploads/'.$images;
            File::delete($namefiled);
        }
        $user->delete();

        return response()->json('success');
    }
}
