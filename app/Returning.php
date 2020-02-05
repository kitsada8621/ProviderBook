<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Returning extends Model
{
    protected $table = 'returning';
    protected $fillable = [
        're_id','br_id','condition','fine'
    ];

    public $primaryKey = 're_id';
}
