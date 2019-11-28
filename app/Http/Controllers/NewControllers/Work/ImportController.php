<?php

namespace App\Http\Controllers\NewControllers\Work;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    public function check(Request $request)
    {
        $idcompany  = $request->input("idcompany");
        $idcontract = $request->input("idcontract");
        $data       = $request->input("data");

        $response = $this->check_data($idcompany, $idcontract, $data);

        return $response;
    }

    public function check_data($idcompany, $idcontract, $data)
    {
        $data1 = [];
        // $servicio_num    = 0;
        $Tipo_num  = 0;
        $type_num  = 0;
        $state_num = 0;

        for ($i = 0; $i < count($data); $i++) {
            $hub       = isset($data[$i]['A']) ? $data[$i]["A"] : null;
            $dater     = isset($data[$i]['B']) ? $data[$i]["B"] : null;
            $stratum   = isset($data[$i]['C']) ? $data[$i]["C"] : null;
            $dni       = isset($data[$i]['D']) ? $data[$i]["D"] : null;
            $client    = isset($data[$i]['E']) ? $data[$i]["E"] : null;
            $phone     = isset($data[$i]['F']) ? $data[$i]["F"] : null;
            $cel       = isset($data[$i]['G']) ? $data[$i]["G"] : null;
            $district  = isset($data[$i]['H']) ? $data[$i]["H"] : null;
            $province  = isset($data[$i]['I']) ? $data[$i]["I"] : null;
            $address   = isset($data[$i]['J']) ? $data[$i]["J"] : null;
            $cod       = isset($data[$i]['K']) ? $data[$i]["K"] : null; //codigo de manzana
            $agreement = isset($data[$i]['L']) ? $data[$i]["L"] : null; //convenio fise
            $type      = isset($data[$i]['M']) ? $data[$i]["M"] : null;
            $adviser   = isset($data[$i]['N']) ? $data[$i]["N"] : null; //((asesor))
            $state     = isset($data[$i]['O']) ? $data[$i]["O"] : null;

            $selecttype = DB::table('typework')
                ->where('typework', '=', $type)
                ->first();

            $selectstate = DB::table('statework')
                ->where('statework', '=', $state)
                ->first();

            if (!$selecttype) {
                $type_num += 1;
                array_push($data1, array('Hub' => $hub, 'Resultado' => $type));
            }

            if (!$selectstate) {
                $state_num += 1;
                array_push($data1, array('Hub' => $hub, 'Resultado' => $state));
            }
        }

        return response()->json(['status' => 'ok', 'data' => $data1], 200);
    }

    public function dataimport(Request $request)
    {
        $idcompany  = $request->input("idcompany");
        $idcontract = $request->input("idcontract");
        $data       = $request->input("data");

        $response = $this->import($idcompany, $idcontract, $data);

        return $response;
    }

    public function import($idcompany, $idcontract, $data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $hub       = isset($data[$i]['A']) ? $data[$i]["A"] : null;
            $dater     = isset($data[$i]['B']) ? date('Y-m-d', strtotime($data[$i]["B"])) : null;
            $stratum   = isset($data[$i]['C']) ? $data[$i]["C"] : null;
            $dni       = isset($data[$i]['D']) ? $data[$i]["D"] : null;
            $client    = isset($data[$i]['E']) ? $data[$i]["E"] : null;
            $phone     = isset($data[$i]['F']) ? $data[$i]["F"] : null;
            $cel       = isset($data[$i]['G']) ? $data[$i]["G"] : null;
            $district  = isset($data[$i]['H']) ? $data[$i]["H"] : null;
            $province  = isset($data[$i]['I']) ? $data[$i]["I"] : null;
            $address   = isset($data[$i]['J']) ? $data[$i]["J"] : null;
            $cod       = isset($data[$i]['K']) ? $data[$i]["K"] : null; //codigo de manzana
            $agreement = isset($data[$i]['L']) ? $data[$i]["L"] : null; //convenio fise
            $type      = isset($data[$i]['M']) ? $data[$i]["M"] : null;
            $adviser   = isset($data[$i]['N']) ? $data[$i]["N"] : null; //((asesor))
            $state     = isset($data[$i]['O']) ? $data[$i]["O"] : null;

            $selecttype = DB::table('typework')
                ->where('typework', '=', $type)
                ->first();

            $selectstate = DB::table('statework')
                ->where('statework', '=', $state)
                ->first();

            $insert = DB::table('work')
                ->insertGetId([
                    'dni'          => $dni,
                    'client'       => $client,
                    'phone'        => $phone,
                    'cel'          => $cel,
                    'stratum'      => $stratum,
                    'province'     => $province,
                    'adviser'      => $adviser,
                    'district'     => $district,
                    'hub'          => $hub,
                    'dater'        => $dater,
                    'typework_id'  => $selecttype->idtypework,
                    'statework_id' => $selectstate->idstatework,
                    'idcompany'    => $idcompany,
                    'idcontract'   => $idcontract,
                    'address'      => $address,
                    'cod'          => $cod,
                    'agreement'    => $agreement,

                ]);
        }

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }
}
