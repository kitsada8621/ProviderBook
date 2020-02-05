<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $table = 'teacher';
    protected $fillable = [
        't_id','t_name'
    ];
    public $primaryKey ='t_id';
    public $incrementing = false;
}
