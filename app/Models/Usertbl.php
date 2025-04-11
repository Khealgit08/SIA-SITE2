<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usertbl extends Model{

    protected $table = 'tblusers';

    // column sa table
    protected $fillable = [
        'username', 'password', 'gender', 'jobid',
    ];

    protected $hidden = [
        'password',
    ];
}