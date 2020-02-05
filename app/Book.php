<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'book';
    protected $fillable = [
        'b_id','p_id','type','condition','status'
    ];
    public $primaryKey='b_id';
    public $incrementing= false;
}
