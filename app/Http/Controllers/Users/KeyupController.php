<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Teacher;
use App\Student;

class KeyupController extends Controller
{
    public function T_id(Request $request) {
        if(!empty($request->id)) {
            $data = Teacher::where('t_id',$request->id)->first();
            if($data) {
                return response()->json([
                    'success' => true,
                    't_name' => $data->t_name
                ]);
            }else {
                return response()->json([
                    'success' => false,
                ]);
            }
        }else {
            return response()->json([
                'success' => false,
            ]);
        }
    }

    public function T_name(Request $request) {
        if(!empty($request->name)) {
            $data = Teacher::where('t_name',$request->name)->first();
            if($data) {
                return response()->json([
                    'success' => true,
                    't_id' => $data->t_id
                ]);
            }else {
                return response()->json([
                    'success' => false,
                ]);
            }
        }else {
            return response()->json([
                'success' => false,
            ]);
        }
    }
}
