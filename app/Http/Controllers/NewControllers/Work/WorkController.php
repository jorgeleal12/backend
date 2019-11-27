<?php

namespace App\Http\Controllers\NewControllers\Work;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }
    public function create(Request $request)
    {
        $idcompany      = $request->input("idcompany");
        $idcontract      = $request->input("idcontract");
        $csc      = $request->input("csc");
        $dni      = $request->input("dni");
        $client   = $request->input("client");
        $phone    = $request->input("phone");
        $cel      = $request->input("cel");
        $stratum  = $request->input("stratum"); //estrato
        $province = $request->input("province"); //provincia
        $adviser  = $request->input("adviser"); //asesor
        $district = $request->input("district"); //distrito
        $hub      = $request->input("hub");
        $type     = $request->input("type");
        $state    = $request->input("state");
        $dater    = date('Y-m-d', strtotime($request->input("dater"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("dater"))); //fecha de radicacion
        $dayans   = $request->input("dayans"); //dias ans

        $datev   = date('Y-m-d', strtotime($request->input("datev"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("datev"))); //fecha de vencimiento
        $dateh   = date('Y-m-d', strtotime($request->input("dateh"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("dateh"))); //fecha de habilitacion
        $fechaa  = date('Y-m-d', strtotime($request->input("fechaa"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("fechaa"))); //fecha de Aprobacion
        $fechac  = date('Y-m-d', strtotime($request->input("fechac"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("fechac"))); //fecha de Construcion
        $fechatc = date('Y-m-d', strtotime($request->input("fechatc"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("fechatc"))); //fecha de TC

        $cosntructor = $request->input("cosntructor");
        $tecnico1    = $request->input("tecnico1");
        $enabler     = $request->input("enabler"); //habilitador
        $inspector   = $request->input("inspector"); //inspector
        $obsp        = $request->input("obsp"); //obserbaciones peiddo
        $obs         = $request->input("obs"); //obserbaciones

        $programmed     = $request->input("programmed"); //programado a
        $nameprogrammed = $request->input("nameprogrammed"); //programado a
        $dateinn        = date('Y-m-d', strtotime($request->input("dateinn"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("dateinn"))); //fecha inn
        $supervisor     = $request->input("supervisor"); //supervisor
        $namesupervisor = $request->input("namesupervisor"); //supervisor
        $technical      = $request->input("technical"); //Tecnico constructor
        $nametechnical  = $request->input("nametechnical"); //Tecnico constructor
        $assistant      = $request->input("assistant"); //Auxiliar constructor
        $nameassistant  = $request->input("nameassistant"); //Auxiliar constructor
        $datem          = date('Y-m-d', strtotime($request->input("datem"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("datem"))); //Fecha mocha

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
                'dayans'       => $dayans,
                'datev'        => $datev,
                'dateh'        => $dateh,
                'fechaa'       => $fechaa,
                'fechac'       => $fechac,
                'fechatc'      => $fechatc,
                'cosntructor'  => $cosntructor,
                'tecnico1'     => $tecnico1,
                'enabler'      => $enabler,
                'inspector'    => $inspector,
                'obsp'         => $obsp,
                'obs'          => $obs,
                'programmed'   => $programmed,
                'dateinn'      => $dateinn,
                'supervisor'   => $supervisor,
                'technical'    => $technical,
                'assistant'    => $assistant,
                'datem'        => $datem,
                'typework_id'  => $type,
                'statework_id' => $state,
                'idcompany'  => $idcompany,
                'idcontract' => $idcontract,

            ]);
        return response()->json(['status' => 'ok', 'response' => $insert], 200);
    }

    public function update(Request $request)
    {
        $csc      = $request->input("csc");
        $dni      = $request->input("dni");
        $client   = $request->input("client");
        $phone    = $request->input("phone");
        $cel      = $request->input("cel");
        $stratum  = $request->input("stratum"); //estrato
        $province = $request->input("province"); //provincia
        $adviser  = $request->input("adviser"); //asesor
        $district = $request->input("district"); //distrito
        $hub      = $request->input("hub");
        $type     = $request->input("type");
        $state    = $request->input("state");
        $dater    = date('Y-m-d', strtotime($request->input("dater"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("dater"))); //fecha de radicacion
        $dayans   = $request->input("dayans"); //dias ans

        $datev   = date('Y-m-d', strtotime($request->input("datev"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("datev"))); //fecha de vencimiento
        $dateh   = date('Y-m-d', strtotime($request->input("dateh"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("dateh"))); //fecha de habilitacion
        $fechaa  = date('Y-m-d', strtotime($request->input("fechaa"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("fechaa"))); //fecha de Aprobacion
        $fechac  = date('Y-m-d', strtotime($request->input("fechac"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("fechac"))); //fecha de Construcion
        $fechatc = date('Y-m-d', strtotime($request->input("fechatc"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("fechatc"))); //fecha de TC

        $cosntructor = $request->input("cosntructor");
        $tecnico1    = $request->input("tecnico1");
        $enabler     = $request->input("enabler"); //habilitador
        $inspector   = $request->input("inspector"); //inspector
        $obsp        = $request->input("obsp"); //obserbaciones peiddo
        $obs         = $request->input("obs"); //obserbaciones

        $programmed     = $request->input("programmed"); //programado a
        $nameprogrammed = $request->input("nameprogrammed"); //programado a
        $dateinn        = date('Y-m-d', strtotime($request->input("dateinn"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("dateinn"))); //fecha inn
        $supervisor     = $request->input("supervisor"); //supervisor
        $namesupervisor = $request->input("namesupervisor"); //supervisor
        $technical      = $request->input("technical"); //Tecnico constructor
        $nametechnical  = $request->input("nametechnical"); //Tecnico constructor
        $assistant      = $request->input("assistant"); //Auxiliar constructor
        $nameassistant  = $request->input("nameassistant"); //Auxiliar constructor
        $datem          = date('Y-m-d', strtotime($request->input("datem"))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input("datem"))); //Fecha mocha

        $update = DB::table('work')
            ->where('csc', $csc)
            ->update([
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
                'dayans'       => $dayans,
                'datev'        => $datev,
                'dateh'        => $dateh,
                'fechaa'       => $fechaa,
                'fechac'       => $fechac,
                'fechatc'      => $fechatc,
                'cosntructor'  => $cosntructor,
                'tecnico1'     => $tecnico1,
                'enabler'      => $enabler,
                'inspector'    => $inspector,
                'obsp'         => $obsp,
                'obs'          => $obs,
                'programmed'   => $programmed,
                'dateinn'      => $dateinn,
                'supervisor'   => $supervisor,
                'technical'    => $technical,
                'assistant'    => $assistant,
                'datem'        => $datem,
                'typework_id'  => $type,
                'statework_id' => $state,

            ]);
        return response()->json(['status' => 'ok', 'response' => $update], 200);
    }

    public function search()
    {
        $search = DB::table('work')
            ->join('statework', 'statework.idstatework', '=', 'work.statework_id')
            ->join('typework', 'typework.idtypework', '=', 'work.typework_id')

        // ->orderBy('csc', 'asc')
            ->select()
            ->paginate(10);

        return response()->json(['status' => 'ok', 'response' => $search], 200);

        // ->orderBy('idclient', 'asc')
        //     ->select('client.*', 'client.state as idstate', DB::raw('(CASE WHEN client.state = "1" THEN "Activo" WHEN client.state = "2" THEN "Inactivo" ELSE "Por confirmar" END) AS state'))
    }

    public function search_name(Request $request)
    {
        $client = $request->input("name");

        $search = DB::table('work')
            ->where('client', 'like', '%' . $client . '%')
            ->orderBy('client', 'asc')
            ->paginate(10);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }
}
