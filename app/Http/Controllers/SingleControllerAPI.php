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
use App\MatriculaImport;
use App\QRcode;



use Excel;


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
            return response()->json("Matricula Inválida!", 400);
        }

        $existe = DB::table('matriculas')->where('matricula', trim($request->matricula))->get(); // se for [] é porque não existe
        
        if(trim($request->matricula[2])!='-' || trim($request->matricula[5])!='-' || strlen(trim($request->matricula))!=8 || count($existe)!=0 ){
            return response()->json("Matricula Inválida!", 400);
        }

        $matricula = new Matricula();
        $matricula->matricula=$request->matricula;
        $matricula->park_number=$request->park_number;

        $matricula->save();
    
        return response()->json($matricula, 201);
    }

    public function addLog(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'identificador'      => 'required',
            'park_number'    => 'required|exists:clientes,park_number',
            'datetime'    => 'required',
            'way'    => 'required|in:saida,entrada',

        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }

        $log = new LogMatricula();
        $log->identificador=$request->identificador;
        $log->datetime=$request->datetime;
        $log->way=$request->way;
        $log->park_number=$request->park_number;

        $log->save();
    
        return response()->json(['success' => 'success'], 200);
    }

    public function updatelivres(Request $request)
    {
        //return "ola";
        $validator = Validator::make($request->all(),[
            'park_number'    => 'required|exists:clientes,park_number',
            'lugares_livres'    => 'required|numeric|min:0',
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

    public function getNumClients() {
        return Cliente::all()->count();
    }

    public function getNumUsers() {
        return User::all()->count();
    }

    public function getClientByParkNum(int $pn) {
        return Cliente::where('park_number', $pn)->get();
    }

    public function getMatriculas() {
        return Matricula::all();
    }

    public function getMatriculasPark(int $park) {
        return DB::table('matriculas')
        ->where('park_number', $park)->get('matricula');
    }

    public function getQRPark(int $park) {
        return DB::table('qrcodes')
        ->where('park_number', $park)->get('value');
    }

    public function getNMatrPark(int $park) {
        return DB::table('matriculas')
        ->where('park_number', $park)->count();
    }

    public function getLogs() {
        return LogMatricula::all();
    }

    public function getLogsPark(int $park) {
        return DB::table('logs')
        ->where('park_number', $park)->orderBy('id', 'desc')->get();
    }
    
    public function profile()
    {
        return auth('api')->user();
    }

    public function deleteMatricula(string $id){
        return Matricula::where('matricula', $id)->delete();
    }

    public function deleteCliente(int $id){
        return Cliente::where('id', $id)->delete();
    }

    public function deleteQRcode(string $id){
        return QRcode::where('value', $id)->delete();
    }

    public function deleteUser(int $id){
        return User::where('id', $id)->delete();
    }

    public function importMatricula(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            'file'    => 'required|mimes:csv,txt'
        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }
        $park_number=$request->park_number;
        $file=fopen($request->file, 'r');
        //$newPath = $request->photo
        $header= fgetcsv($file);

        $escapedHeader=[];
        $lheader=strtolower($header[0]); //pode ser assim porque so ha 1 header, com +1 tinha de ser com foreach
        $escapedItem=preg_replace('/[^a-z]/', '', $lheader);
        array_push($escapedHeader, $escapedItem);

        while($columns=fgetcsv($file))
        {
            if($columns[0]=="")
            {
                continue;
            }
            //trim data

           $data= array_combine($escapedHeader, $columns);

           $obj= Matricula::firstOrCreate(['matricula'=>$data['matriculas'],'park_number'=>$park_number]);
        }
        
        return response()->json(['success' => 'success'], 200);
    }

    public function changeOccupied(Request $request) {
        $validator = Validator::make($request->all(),[
            'arduino'    => 'required|exists:arduinos,arduino',
            'ocupados'    => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }

        DB::table('arduinos')
        ->where('arduino', $request->arduino)->update(['ocupados' => $request->ocupados]); //atualizar os ocupados

        $park = DB::table('arduinos')
        ->where('arduino', $request->arduino)->get('park_number'); //saber o park_number
        $park_number = $park[0]->park_number;
        
        $totalOccupied = DB::table('arduinos')
        ->where('park_number', $park_number)->sum('ocupados'); //calcular o total dos ocupados desse parque

        $park_max = Cliente::where('park_number', $park_number)->get('lugares_max'); //get do maximo desse parque

        $free=$park_max[0]['lugares_max']-$totalOccupied; 
        
        Cliente::where('park_number', $park_number)->update(['lugares_livres' => $free]); //atualizar os livres na tabela clientes
    
        return response()->json(['success' => 'success'], 200);
    }

    public function freeSpotsPark(int $id){   
        $free = Cliente::where('park_number', $id)->get('lugares_livres');
        //return $free[0]['lugares_livres'];

        return response()->json($free[0]['lugares_livres'], 203);

    }

    public function usoButoes(Request $request){
        $validator = Validator::make($request->all(),[
            'botao'    => 'required|exists:estados,name',
            'estado'    => 'required|numeric|min:0', #0 ou 1, desligado ou ligado
        ]);

        if ($validator->fails()) {
            return response()->json("Dados invalidos!", 400);
        }

        //os botões vão funcionar ao pares, botão1 com botão2, botão3 com botão4, sempre assim para ser possivel automatizar 
        //para alem disso o botão1 liga o micro1 e à coluna1, o botão 2 liga o micro2 e à coluna2
        //o botão1 está ao pé do micro1, mas a coluna1 está longe (quero transmitir o som para outro lado do paque)
        //o botão2 está ao pé do micro2, mas a coluna2 está longe
        //o objetivo é clicar no botão, isso ativa o meu micro, e o som sai no outro extremo((no segurança, caso eu ative o botão da entrada || ou na entrada, caso eu seja o segurança e ative o botao do segurança)
        
        $nrBotao= substr($request->botao, -1);  //apanhar o ultimo digito do nome do botão, ou seja o nr 

        DB::table('estados')->where('name','botao'.$nrBotao )->update(['estado' => $request->estado]);
        DB::table('estados')->where('name','micro'.$nrBotao )->update(['estado' => $request->estado]);
        DB::table('estados')->where('name','coluna'.$nrBotao )->update(['estado' => $request->estado]);
        
        
        return response()->json(['success' => 'success'], 200);

    }

    public function getColunaState(int $id) {
        $estado= DB::table('estados')->where('name','coluna'.$id)->get('estado');
        //return $estado[0]->'estado';
        return $estado[0]->estado;
    }

    public function addQRcode(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'value'      => 'required|numeric',
            'park_number'    => 'required|exists:clientes,park_number',
        ]);

        if ($validator->fails()) {
            return response()->json("Value invalido!", 400);
        }
        $existe = DB::table('qrcodes')->where('value', trim($request->value))->get(); // se for [] é porque não existe

        if(trim($request->value) > 999999999 || trim($request->value)<10000 || count($existe)!=0){
            return response()->json("Value invalido!", 400);
        }

        $qrcode = new QRcode();
        $qrcode->value=$request->value;
        $qrcode->park_number=$request->park_number;

        $qrcode->save();
        
        return response()->json($qrcode, 201);
    }
}
