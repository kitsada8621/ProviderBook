<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** home */


/** login and register */
Route::get('/login','Account\UserController@showLoginForm')->name('login');
Route::post('/login','Account\UserController@login')->name('login-submit');
Route::get('/register','Account\UserController@register')->name('register');
Route::post('/register','Account\UserController@registersubmit')->name('register.submit');
Route::post('/register/std','Account\UserController@registerStudentsubmit')->name('registerStudent.submit');
Route::get('/logout','Account\UserController@logout')->name('logout');
Route::get('/logout/student','Account\UserController@studentlogout')->name('student.logout');
/** end login and register */

/** forget password */
Route::group(['prefix' => 'forget/pass'], function () {
    Route::get('/','Admin\Setting@forgetpassview');
    Route::get('/view/{id}','Admin\Setting@viewNewPass');
    Route::post('/','Admin\Setting@forgetpass');
    Route::put('/confirm/{id}','Admin\Setting@passwordUpdates');
});
/** end forget password */


/** Admin Home */
Route::group(['middleware' => ['auth']], function () {
    /** home */
    Route::get('/','Admin\HomeController@home')->name('admin.home');
    Route::group(['prefix' => 'home'], function () {
        Route::get('/wait','Admin\HomeController@waitreply')->name('admin.wait.home');
        Route::get('/reject','Admin\HomeController@reject')->name('admin.reject.home');
        Route::get('/comples','Admin\HomeController@comples')->name('admin.comple.home');
        Route::post('/reject','Admin\HomeController@NoConfirm');
        Route::delete('/borrow/delete/{id}','Admin\HomeController@destroy');
    });

    Route::get('admin/profile','Admin\Setting@profileView');
    Route::get('admin/password','Admin\Setting@passwordView');
    Route::put('admin/password/{id}','Admin\Setting@passwordUpdate');

    /** profile */
    Route::POST('/admin/profile','Admin\Setting@profileUpdate');

    /** User Manage */
    Route::group(['prefix' => 'admins'], function () {
        Route::get('/','Admin\AdminController@index')->name('admins.home');
        Route::get('/create/{id}','Admin\AdminController@show')->name('admin.show');
        Route::post('/create','Admin\AdminController@create')->name('admin.create.submit');
        Route::get('/getAdmins','Admin\AdminController@getAdmin')->name('getAdmins');
        Route::delete('delete/{id}','Admin\AdminController@destroy');
    });
    /** Student */
    Route::group(['prefix' => 'std'], function () {
        Route::get('/','Admin\StudentController@index')->name('std.home');
        Route::get('/getStudent','Admin\StudentController@getStudent')->name('std.getStudent');
        Route::post('/submit/create','Admin\StudentController@submitData')->name('std.create');
        Route::delete('destroy/{id}','Admin\StudentController@destroy');
        Route::post('/import','Admin\Studentcontroller@excelImport');
        Route::get('/view/import',function(){
            return view('admin.pages.student.excel');
        });
    });
    /* Project */
    Route::group(['prefix' => 'projects'], function () {
        Route::get('/','Admin\ProjectController@index')->name('admin.p.home');
        Route::get('/get/project','Admin\ProjectController@getProject')->name('getProject');
        Route::post('/create','Admin\ProjectController@create')->name('admin.p.create');
        Route::delete('delete/{id}','Admin\ProjectController@destroy');
    });
    /** books */
    Route::group(['prefix' => 'book'], function () {
        Route::get('/','Admin\BookController@index')->name('admin.book');
        Route::get('/getbook','Admin\BookController@getBook')->name('admin.getbooks');
        Route::post('/create','Admin\BookController@create')->name('admin.book.create');
        Route::delete('delete/{id}','Admin\BookController@destroy');
        Route::get('/print','Admin\BookController@viewprints')->name('print.books');
        Route::post('/allPrint','Admin\BookController@allPrint');
        Route::get('/print/self/{id}','Admin\BookController@alonePrint');
    });
    /** Borrowing */
    Route::group(['prefix' => 'borrow'], function () {
        Route::get('/', function () {
            return view('admin.pages.borrow.borrowIndex')->with('header','ยืมหนังสือโครงงาน')->with('title','ข้อมูลการยืม');
        });
        Route::get('/book', function () {
            return view('admin.pages.borrow.borrowBook')->with('header','เพิ่มข้อมูลการยืม')->with('title','ข้อมูลหนังสือทีพร้อมยืม');
        });
        // Route::get('edit/{id}', function ($id) {
        //     return view('admin.pages.borrow.borrowedit')->with('header','แก้ไขข้อมูลการยืม')->with('title','ข้อมูลหนังสือที่ยืมได้');
        // })->name('borrow.edit');
        Route::get('/getbooks','Admin\BorrowController@getbooks')->name('borrow.getbooks');
        Route::get('/getborrow','Admin\BorrowController@getBorrowing')->name('borrow.getBorrows');
        Route::post('/create','Admin\BorrowController@create')->name('borrow.create');
        Route::post('edit','Admin\BorrowController@edit')->name('borrow.edit');
        Route::delete('delete/{id}','Admin\BorrowController@destroy');
        /** textbox search */
        Route::get('/borrow/book/id','Admin\BorrowController@borrowGetbookId')->name('borrow.get.book.id');
        Route::get('/borrow/book/name','Admin\BorrowController@borrowGetbookName')->name('borrow.get.book.name');

        Route::post('/yes/confirm','Admin\HomeController@YesConfirm')->name('admin.yesconfirm');
        // Route::get('/comples/get','Admin\HomeController@ComplesGet')->name('admin.comples');
    });
    /** Returning */
    Route::group(['prefix' => 'returns'], function () {
        Route::get('/','Admin\ReturnController@index');
        Route::get('/feth/books','Admin\ReturnController@getBorrowing')->name('re.getBorrowing');
        Route::post('/confirm','Admin\ReturnController@confirmReturn')->name('re.confirm');
        Route::post('/confirm/fine/no','Admin\ReturnController@returnFineConfirm')->name('re.confirm.printno');
        Route::get('/receipt/{id}','Admin\ReturnController@printfine');
        Route::post('/receipt','Admin\ReturnController@sure_printed');
    });
    /** History Borrow */
    Route::group(['prefix' => 'history/borrow'], function () {
        Route::get('/','History\BorrowController@index')->name('his.br.index');
        Route::get('/getborrow','History\BorrowController@getborrow')->name('his.br.get');
    });

     /** Data Basic */
    Route::group(['prefix' => 'major'], function () {
        Route::get('/','BasicController\MajorController@majorindex')->name('major');
        Route::get('/getmajor','BasicController\MajorController@getMajor')->name('getmajor');
        Route::post('/create','BasicController\MajorController@create')->name('major.create');
        Route::delete('/delete/{id}','BasicController\MajorController@destroy');
    });

    /** book type */
    Route::group(['prefix' => 'book/type'], function () {
        Route::get('/','BasicController\BookTypeController@index')->name('type.book');
        Route::get('/get/book/type','BasicController\BookTypeController@getBookType')->name('type.book.getBook');
        Route::post('/create','BasicController\BookTypeController@create')->name('type.book.add');
        Route::delete('delete/{id}','BasicController\BookTypeController@destroy');
    });

    /**  renew  */
    Route::group(['prefix' => 'renew'], function () {
        Route::get('/','Admin\RenewController@index')->name('renew.home');
        Route::get('/get/student','Admin\RenewController@getStudent')->name('renew.get.student');
        Route::post('/submit','Admin\RenewController@renew')->name('renew.submit');
    });

    /** type project */
    Route::group(['prefix' => 'type/project'], function () {
        Route::get('/','BasicController\TypeProjectController@index')->name('typePro.home');
        Route::get('/getting','BasicController\TypeProjectController@getTypeProject')->name('getTypeProject');
        Route::post('/create','BasicController\TypeProjectController@create')->name('typePro.create');
        Route::delete('delete/{id}','BasicController\TypeProjectController@destroy');
    });
    /** teacher */
    Route::group(['prefix' => 'teacher'], function () {
        Route::get('/','Admin\TeacherController@index')->name('admin.t.home');
        Route::get('/geting','Admin\TeacherController@getData')->name('admin.t.get');
        Route::post('/create','Admin\TeacherController@create')->name('admin.t.create');
        Route::delete('/delete/{id}','Admin\TeacherController@destroy');
    });
    /** profile */
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', function () {
            return view('admin.pages.myProfile.profileIndex')
            ->with('header','ข้อมูลส่วนตัว');
        });
    });

});

Route::group(['middleware' => ['auth:students']], function () {

    Route::group(['prefix' => 'user'], function () {    

        Route::group(['prefix' => '/student'], function () {
            Route::get('/home','Users\HomeController@home')->name('users.student.home');  
            Route::get('/home1','Users\HomeController@home1')->name('users.student.home1');  
            Route::get('/home2','Users\HomeController@home2')->name('users.student.home2');  
            Route::get('/home3','Users\HomeController@home3')->name('users.student.home3');  
        });
        
        Route::group(['prefix' => 'dashboard'], function () {
            Route::get('getbr','Users\HomeController@getBorrow');
        });
        // Route::post('/create','Users\HomeController@create')->name('student.create');

        /** project */
        Route::group(['prefix' => 'project'], function () {
            Route::get('/','Users\ProjectController@index')->name('users.p.home');
            Route::post('/create','Users\ProjectController@createProject')->name('users.p.create');
        });
        /** book */
        Route::group(['prefix' => 'book'], function () {
            Route::get('/','Users\BookController@index')->name('users.b.home');
        });
        /** borrow */
        Route::group(['prefix' => 'borrow'], function () {
            Route::get('/','Users\BorrowController@index')->name('users.br.home');
            Route::post('/create','Users\BorrowController@Borrowing')->name('users.br.create');
            Route::post('/edit','Users\BorrowController@edit')->name('users.br.edit');
            Route::delete('/delete/{id}','Users\BorrowController@destroy');
        });

        /** history */
        Route::resource('/history', 'Users\History');

        /** setting anything */
        Route::group(['prefix' => 'setting'], function () {
            Route::get('/resume','Users\Setting@resume')->name('users.resume');
            Route::put('resume','Users\Setting@resumeUpdate')->name('users.resume.put');
            Route::get('/password', function () {
                return view('student.setting.password');
            })->name('studentPasswordView');
            Route::put('password/{id}','Users\Setting@passwordUpdate')->name('StudentPasswordUpdate');
        });

    });

    Route::get('/student/home','Users\HomeController@home');
});
    



/** getData Student to chang in textbox to show */
Route::get('/get/Student/show','Admin\ProjectController@getStudentId')->name('student.get.show');
Route::get('/get/Student/show/name','Admin\ProjectController@getStudentName')->name('student.get.show.name');
/** getData Teacher to chang in textbox to show */
Route::get('/get/teacher/id','Admin\ProjectController@getTeacherId')->name('teacher.get.id');
Route::get('/get/teacher/name','Admin\ProjectController@getTeacherName')->name('teacher.get.name');
/** getProject  */
Route::get('get/project/id','Admin\BookController@searchProjectById')->name('project.get.id');
Route::get('get/project/name','Admin\BookController@searchProjectByName')->name('project.get.name');
/** get books */
Route::get('/get/books/id','BasicController\AutocompleController@AtBook_id');
Route::get('/get/books/names','BasicController\AutocompleController@AtBook_name');