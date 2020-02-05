<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeProject extends Model
{
    protected $table = 'typeproject';
    protected $fillable = [
        'name'
    ];
}
