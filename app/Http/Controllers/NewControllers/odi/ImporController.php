<?php

namespace App\Http\Controllers\NewControllers\odi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImporController extends Controller
{
    //

    public function import(Request $request)
    {

        $data    = $request->input('data');
        $contrat = $request->input('contrat');
        $company = $request->input('company');

        for ($i = 0; $i < count($data); $i++) {

            $cliente       = $data[$i]['N'];
            $cedula        = isset($data[$i]["E"]) ? $data[$i]["E"] : null;
            $addres        = $data[$i]['L'];
            $telefono      = $data[$i]['O'];
            $departamento  = $data[$i]['A'];
            $municipio     = $data[$i]['B'];
            $barrio        = $data[$i]['D'];
            $zona          = isset($data[$i]["C"]) ? $data[$i]["C"] : null;
            $type_obr      = $data[$i]['G'];
            $ot            = isset($data[$i]["H"]) ? $data[$i]["H"] : null;
            $codigo        = isset($data[$i]["I"]) ? $data[$i]["I"] : null;
            $f_asig        = date("Y-m-d", strtotime($data[$i]['J']));
            $f_instalacion = isset($data[$i]["K"]) ? $data[$i]["K"] : null;
            $categoria     = $data[$i]['M'];
            $f_vencimiento = isset($data[$i]["Q"]) ? $data[$i]["Q"] : null;
            $tgas          = strtoupper($data[$i]['R']);

            $priority  = strtoupper($data[$i]['S']);
            $fatencion = strtoupper($data[$i]['V']);
            $tservicio = $data[$i]['T'];
            $tred      = $data[$i]['U'];
            $tobra     = $data[$i]['W'];
            $obs       = isset($data[$i]["X"]) ? $data[$i]["X"] : null;

            $location = $this->searc_municipio($municipio);
            $type     = $this->searc_type($type_obr);
            $type_gas = $this->tgas($tgas);

            $r_priority  = $this->priority($priority);
            $r_fatencion = $this->fatention($fatencion);
            $r_tobra     = $this->tobra($tobra);
            $r_tservicio = $this->tservicio($tservicio);
            $r_network   = $this->type_red($tred, $r_tservicio);

            $search_client = DB::table('client')
                ->where('id_client', $cedula)
                ->first();

            if ($search_client) {

                $search_acount = DB::table('client_account')
                    ->where('client_idclient', $search_client->idclient)
                    ->where('address', $addres)
                    ->first();

                if ($search_acount) {

                    $idclient_account = $search_acount->idclient_account;

                } else {

                    $idclient_account = $this->insert_acount($search_client->idclient, $addres, $location['idmunicipality']);

                }

                $idclient = $search_client->idclient;
            } else {

                $insert_client = DB::table('client')
                    ->insertGetid([
                        'id_client'   => $cedula,
                        'name_client' => $cliente,
                        'phone'       => $telefono,
                        'state'       => 1,
                    ]);

                $idclient_account = $this->insert_acount($insert_client, $addres, $location['idmunicipality']);

                $idclient = $insert_client;
            }

            $insert_service = DB::table('odi')
                ->insert([
                    'client'                      => $idclient,
                    'identifacation'              => $cedula,
                    'address'                     => $idclient_account,
                    'phone'                       => $telefono,
                    'city'                        => $location['idmunicipality'],
                    'barrio'                      => $barrio,
                    'zona'                        => $zona,
                    'date_assignment'             => $f_asig,
                    'type'                        => $type,
                    'obsr_order'                  => $obs,
                    'contract_idcontract'         => $contrat,
                    'company_idcompany'           => $company,
                    'department_iddepartment'     => $location['id_departament'],
                    'type_gas'                    => $type_gas,
                    'priority'                    => $r_priority,
                    'Attention'                   => $r_fatencion,
                    'type_service_idtype_service' => $r_tservicio,
                    'type_network_idtype_network' => $r_network,
                    'service_type_idservice_type' => $r_tobra,
                    'state'                       => 1,
                ]);
        }
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function insert_acount($idclient, $addres, $location)
    {
        $insert_acount = DB::table('client_account')
            ->insertGetid([
                'client_idclient' => $idclient,
                'address'         => $addres,
                'state'           => 1,
                'city'            => $location,
            ]);

        return $insert_acount;
    }

    public function searc_municipio($municipio)
    {

        $search = DB::table('municipality')
            ->where('name_municipality', $municipio)
            ->first();

        $location = [
            "idmunicipality" => $search->idmunicipality,
            "id_departament" => $search->id_departament,
        ];
        return $location;

    }

    public function searc_type($type_obr)
    {

        $search = DB::table('service_type')
            ->where('name_type', $type_obr)
            ->first();

        return $search->idservice_type;

    }

    public function tgas($tgas)
    {
        $array = array(1 => 'NATURAL', 2 => 'GPL');

        $clave = array_search($tgas, $array); // $clave = 2;

        return $clave;
    }

    public function priority($priority)
    {
        $array = array(1 => 'ALTA', 2 => 'MEDIA', 2 => 'BAJA');
        $clave = array_search($priority, $array); // $clave = 2;

        return $clave;
    }

    public function fatention($fatencion)
    {
        $array = array(1 => 'MAÑANA', 2 => 'TARDE');
        $clave = array_search($fatencion, $array); // $clave = 2;

        return $clave;
    }

    public function tobra($tobra)
    {
        $array = array(1 => 'REVISION PERIODICA', 2 => 'NUEVA');
        $clave = array_search($tobra, $array); // $clave = 2;

        return $clave;
    }

    public function tservicio($tservicio)
    {
        $search = DB::table('type_service')
            ->where('name_type', $tservicio)
            ->first();
        return $search->idtype_service;
    }

    public function type_red($tred, $r_tservicio)
    {
        $search = DB::table('type_network')
            ->where('type_service_idtype_service', $r_tservicio)
            ->where('name_network', $tred)
            ->first();
        return $search->idtype_network;
    }

}
