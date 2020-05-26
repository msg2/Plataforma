<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QRcode extends Model
{
    public $timestamps = false;
    protected $table = 'qrcodes';

    protected $fillable = [
        'value', 'park_number',
    ];
}
