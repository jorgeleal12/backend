<?php

namespace App\Http\Controllers\NewControllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    public function create(Request $request)
    {

        $idclient    = $request->input('idclient');
        $name_client = $request->input('Nom_cli');
        $idcontract  = $request->input('idcontract');
        //cedula
        $last_name    = $request->input('Ape_cli');
        $id_client    = $request->input('Ced_cli');
        $Cod_Poli_Cta = $request->input('Cod_Poli_Cta');
        $email        = $request->input('Mail_Cli');
        $cel          = $request->input('Cel_Cli');
        $phone        = $request->input('Tel_fi_Cli');

        if ($idclient == null) {

            $insert = DB::table('client')
                ->insertGetid([
                    'name_client' => $name_client,
                    'last_name'   => $last_name,
                    'email'       => $email,
                    'id_client'   => $id_client,
                    'phone'       => $phone,
                    'cel'         => $cel,
                    'Cod_Poli'    => $Cod_Poli_Cta,
                ]);

            return response()->json(['status' => 'ok', 'response' => true, 'id' => $insert], 200);
        } else {

            $insert = DB::table('client')
                ->where('idclient', $idclient)
                ->update([
                    'name_client' => $name_client,
                    'last_name'   => $last_name,
                    'email'       => $email,
                    'id_client'   => $id_client,
                    'phone'       => $phone,
                    'cel'         => $cel,
                    'Cod_Poli'    => $Cod_Poli_Cta,
                ]);
            return response()->json(['status' => 'ok', 'response' => false, 'id' => $idclient], 200);
        }
    }

    public function search()
    {
        $search = DB::table('client')
            ->select('client.*')
            ->orderBy('client.idclient', 'asc')
            ->paginate(10);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function create_account(Request $request)
    {
        $idclient_account = $request->idclient_account;
        $city             = $request->city;
        $iddepartment     = $request->department_iddepartment;
        $address          = $request->Dir_Cli;
        $neighborhood     = $request->Bar_Cli;
        // $indications      = $request->indications;
        // $state            = $request->state;
        $client_idclient = $request->client_idclient;
        // $number_acount    = $request->number_acount;

        if ($idclient_account == null) {

            $insert = DB::table('client_account')
                ->insertGetid([
                    'city'            => $city,
                    'address'         => $address,
                    'iddepartment'    => $iddepartment,
                    'neighborhood'    => $neighborhood,
                    // 'indications'     => $indications,
                    // 'state'           => $state,
                    'client_idclient' => $client_idclient,
                    // 'number_acount'   => $number_acount,
                ]);
            return response()->json(['status' => 'ok', 'response' => true, 'idaccount' => $insert], 200);
        } else {
            $update = DB::table('client_account')
                ->where('idclient_account', $idclient_account)
                ->update([
                    'city'         => $city,
                    'address'      => $address,
                    'iddepartment' => $iddepartment,
                    'neighborhood' => $neighborhood,
                ]);
            return response()->json(['status' => 'ok', 'response' => false], 200);
        }
    }

    public function search_account(Request $request)
    {
        $idclient = $request->idclient;

        $search = DB::table('client_account')
            ->leftjoin('departments', 'departments.departments_dane', '=', 'client_account.iddepartment')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->where('client_idclient', $idclient)
            ->select('client_account.*', 'municipality.name_municipality as name_city', 'departments.name_departments')
            ->orderBy('client_account.idclient_account', 'asc')
            ->paginate(5);
        return response()->json(['status' => 'ok', 'response' => $search], 200);

    }

    public function delete_account(Request $request)
    {

        $idclient_account = $request->idclient_account;

        $delete = DB::table('client_account')
            ->where('idclient_account', $idclient_account)
            ->delete();

        return response()->json(['status' => 'ok', 'response' => $delete], 200);
    }

    public function delete_client(Request $request)
    {

        $idclient = $request->idclient;

        $delete = DB::table('client')
            ->where('idclient', $idclient)
            ->delete();

        return response()->json(['status' => 'ok', 'response' => $delete], 200);
    }

    public function autocomplete(Request $request)
    {
        $client = $request->client;

        $search = DB::table('client')
            ->where('name_client', 'like', '%' . $client . '%')

            ->select('client.*', DB::raw('CONCAT_WS("", client.name_client," ",client.last_name) AS full_name'))
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function autocomplete_address(Request $request)
    {
        $address = $request->address;

        $search = DB::table('client_account')
            ->where('address', 'like', '%' . $address . '%')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->select('client.*', 'client_account.*', 'municipality.name_municipality', DB::raw('CONCAT(client.name_client," ",client.last_name) AS full_name'))
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }
}
