<?php

namespace App;

use App\User;
use App\Matricula;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;

class MatriculaImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        $user = Auth::user();

        return new Matricula([
           'matricula'     => $row[0],
           'park_number'    => $row[0], 
        ]);
    }
}