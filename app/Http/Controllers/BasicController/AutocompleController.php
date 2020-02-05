<?php

namespace App\Http\Controllers\BasicController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;

class AutocompleController extends Controller
{
    public function AtBook_id(Request $request) {
        if(!empty($request->id)) {
            $data = Book::join('project','project.p_id','=','book.p_id')->select('book.b_id','project.p_name')
            ->where('book.b_id',$request->id)->first();
            if($data) {
                return response()->json([
                    'success' => true,
                    'p_name' => $data->p_name
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
    public function AtBook_name(Request $request) {
        if(!empty($request->name)) {
            $data = Book::join('project','project.p_id','=','book.p_id')->select('book.b_id','project.p_name')
            ->where('project.p_name',$request->name)->first();
            if($data) {
                return response()->json([
                    'success' => true,
                    'b_id' => $data->b_id
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
