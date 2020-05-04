<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Cliente;
use App\Matricula;
use App\User;
use App\LogMatricula;


class SingleControllerAPI extends Controller
{
    public function createClient(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'         => 'required|unique:clientes,name',
            'park_number'    => 'required|unique:clientes,park_number',
            'lugares_max'    => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }

        $client = new Cliente();
        $client->name=$request->name;
        $client->park_number=$request->park_number;
        $client->lugares_max=$request->lugares_max;


        $client->save();
    
        return response()->json($client, 201);
    }

    public function addMatricula(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'matricula'      => 'required',
            'park_number'    => 'required|exists:clientes,park_number',
        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }

        $matricula = new Matricula();
        $matricula->matricula=$request->matricula;
        $matricula->park_number=$request->park_number;

        $matricula->save();
    
        return response()->json($matricula, 201);
    }

    public function addLogMatricula(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'matricula'      => 'required',
            'park_number'    => 'required|exists:clientes,park_number',
            'datetime'    => 'required',
            'way'    => 'required|in:saida,entrada',

        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }

        $log = new LogMatricula();
        $log->matricula=$request->matricula;
        $log->datetime=$request->datetime;
        $log->way=$request->way;
        $log->park_number=$request->park_number;

        $log->save();
    
        return response()->json(['success' => 'success'], 200);
    }

    public function updatelivres(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'park_number'    => 'required|exists:clientes,park_number',
            'lugares_livres'    => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }
        
        DB::table('clientes')
         ->where('park_number', $request->park_number)
         ->update(['lugares_livres' => $request->lugares_livres]);

        return response()->json(['success' => 'success'], 200);

    }

    public function updatemax(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'park_number'    => 'required|exists:clientes,park_number',
            'lugares_max'    => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }
        
        DB::table('clientes')
         ->where('park_number', $request->park_number)
         ->update(['lugares_max' => $request->lugares_max]);

        return response()->json(['success' => 'success'], 200);

    }

    public function getClients() {
        return Cliente::all();
    }

    public function getMatriculas() {
        return Matricula::all();
    }

    public function getLogs() {
        return LogMatricula::all();
    }
    
    public function profile()
    {
        return auth('api')->user();
    }

}
