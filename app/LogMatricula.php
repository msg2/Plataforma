<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogMatricula extends Model
{
    public $timestamps = false;
    protected $table = 'logs';

    protected $fillable = [
        'identificador', 'park_number','datetime','way'
    ];
}
