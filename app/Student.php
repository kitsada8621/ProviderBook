<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $table = 'student';
    protected $fillable = [
        'std_id','std_name','major','email','tel','image','password','borrows','unit'
    ];

    public $primaryKey ='std_id';
    public $incrementing = false;
}
