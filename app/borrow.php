<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class borrow extends Model
{
    protected $table = 'borrow';
    protected $fillable = ['br_id','b_id','status','std_id','admin_id','br_date','due_date','returning'];
    public $primaryKey = 'br_id';
}
