<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'matricula', 'park_number',
    ];
}
