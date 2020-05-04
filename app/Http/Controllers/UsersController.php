<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function index() {
        return User::all();
    }

    public function create(Request $request)
    {

         Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => ['required', 'in:admin,user'], //problema ao validar que existe e dar 0 ao admin --
            'park_number' => ['nullable', 'exists:clientes,park_number'],
            

        ])->validate();

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'type' => $request['type'],
            'park_number' => $request['park_number'],
        ]);

    }
}
