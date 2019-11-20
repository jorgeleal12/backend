<?php

namespace App\Http\Controllers\NewControllers\Work;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\DB;
class WorkController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }
    public function create(Request $request)
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
        $dater    = date('Y-m-d', strtotime($request->input("dater"))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input("dater"))); //fecha de radicacion
        $dayans   = $request->input("dayans"); //dias ans

        $datev   = date('Y-m-d', strtotime($request->input("datev"))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input("datev"))); //fecha de vencimiento
        $dateh   = date('Y-m-d', strtotime($request->input("dateh"))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input("dateh"))); //fecha de habilitacion
        $fechaa  = date('Y-m-d', strtotime($request->input("fechaa"))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input("fechaa"))); //fecha de Aprobacion
        $fechac  = date('Y-m-d', strtotime($request->input("fechac"))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input("fechac"))); //fecha de Construcion
        $fechatc = date('Y-m-d', strtotime($request->input("fechatc"))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input("fechatc"))); //fecha de TC

        $cosntructor = $request->input("cosntructor");
        $tecnico1    = $request->input("tecnico1");
        $enabler     = $request->input("enabler"); //habilitador
        $inspector   = $request->input("inspector"); //inspector
        $obsp        = $request->input("obsp"); //obserbaciones peiddo
        $obs         = $request->input("obs"); //obserbaciones

        $programmed     = $request->input("programmed"); //programado a
        $nameprogrammed = $request->input("nameprogrammed"); //programado a
        $dateinn        = date('Y-m-d', strtotime($request->input("dateinn"))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input("dateinn"))); //fecha inn
        $supervisor     = $request->input("supervisor"); //supervisor
        $namesupervisor = $request->input("namesupervisor"); //supervisor
        $technical      = $request->input("technical"); //Tecnico constructor
        $nametechnical  = $request->input("nametechnical"); //Tecnico constructor
        $assistant      = $request->input("assistant"); //Auxiliar constructor
        $nameassistant  = $request->input("nameassistant"); //Auxiliar constructor
        $datem          = date('Y-m-d', strtotime($request->input("datem"))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input("datem"))); //Fecha mocha

        return response()->json(['status' => 'ok', 'reponse' => true], 200);
    }
}
