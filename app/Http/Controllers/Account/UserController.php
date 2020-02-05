<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\User;
use App\Student;

class UserController extends Controller
{

    public function showLoginForm()
    {
        return view('login.login');
    }

    public function login(Request $request) {

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if(Auth::attempt(['username'=>$request->username,'password'=>$request->password])) {
            return redirect()->route('admin.home');
        }elseif(Auth::guard('students')->attempt(['std_id'=> $request->username,'password' => $request->password])) {
            return redirect()->route('users.student.home');
        }
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request){
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    public function username() {
        return 'username';
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

    public function studentlogout() {
        Auth::guard('students')->logout();
        return redirect()->route('login');
    }

    /** Register =============================================================================================================== */
    public function register() {
        return view('login.register');
    }
    public function registersubmit(Request $request) {

        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'position' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'position' => $request->position,
            'username' => $request->username,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('login');
    }
    public function registerStudentsubmit(Request $request) {

        $this->validate($request,[
            'std_id' => 'required',
            'std_name' => 'required',
            'std_email' => 'required',
            'major' => 'required',
            'tel' => 'required',
            'std_password' => 'required'
        ]);

        Student::create([
            'std_id' => $request->std_id,
            'std_name' => $request->std_name,
            'email' => $request->std_email,
            'major' => $request->major,
            'tel' => $request->tel,
            'password' => Hash::make($request->std_password)
        ]);

        return redirect()->route('login');
    }

}
