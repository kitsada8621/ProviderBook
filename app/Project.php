<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table ='project';
    protected $fillable = [
        'p_id','p_name','category','t_id','std_id','createdate','description'
    ];
    public $primaryKey = 'p_id';
    public $incrementing = false;
}
