<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogMatricula extends Model
{
    public $timestamps = false;
    protected $table = 'LogsMatricula';

    protected $fillable = [
        'matricula', 'park_number','datetime','way'
    ];
}
