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
        $idcompany  = $request->idcompany;
        $idcontract = $request->idcontract;
        $csc        = $request->csc;
        $dni        = $request->dni;
        $client     = $request->client;
        $phone      = $request->phone;
        $cel        = $request->cel;
        $stratum    = $request->stratum;
        //estrato
        $province = $request->province;
        //provincia
        $adviser = $request->adviser;
        //asesor

        $address = $request->address;
        //direccion
        $district = $request->district;
        //distrito
        $hub   = $request->hub;
        $type  = $request->type;
        $state = $request->state;
        $dater = date('Y-m-d', strtotime($request->dater)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->dater));

        //fecha de radicacion
        $dayans = $request->dayans;
        //dias ans

        $datev = date('Y-m-d', strtotime($request->datev)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->datev));
        //fecha de vencimiento
        $dateh = date('Y-m-d', strtotime($request->dateh)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->dateh));
        //fecha de habilitacion
        $fechaa = date('Y-m-d', strtotime($request->fechaa)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->fechaa));
        //fecha de Aprobacion
        $fechac = date('Y-m-d', strtotime($request->fechac)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->fechac));
        //fecha de Construcion
        $fechatc = date('Y-m-d', strtotime($request->fechatc)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->fechatc));
        //fecha de TC

        $cosntructor = $request->cosntructor;
        $tecnico1    = $request->tecnico1;
        $enabler     = $request->enabler;
        //habilitador
        $inspector = $request->inspector;
        //inspector
        $obsp = $request->obsp;
        //obserbaciones peiddo
        $obs = $request->obs;
        //obserbaciones

        $programmed = $request->programmed;
        //programado a
        $nameprogrammed = $request->nameprogrammed;
        //programado a
        $dateinn = date('Y-m-d', strtotime($request->dateinn)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->dateinn));
        //fecha inn
        $supervisor = $request->supervisor;
        //supervisor
        $namesupervisor = $request->namesupervisor;
        //supervisor
        $technical = $request->technical;
        //Tecnico constructor
        $nametechnical = $request->nametechnical;
        //Tecnico constructor
        $assistant = $request->assistant;
        //Auxiliar constructor
        $nameassistant = $request->nameassistant;
        //Auxiliar constructor
        $datem = date('Y-m-d', strtotime($request->datem)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->datem));
        //Fecha mocha

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
                'idcompany'    => $idcompany,
                'idcontract'   => $idcontract,
                'address'      => $address,

            ]);
        return response()->json(['status' => 'ok', 'response' => $insert], 200);
    }

    public function update(Request $request)
    {
        $csc     = $request->csc;
        $dni     = $request->dni;
        $client  = $request->client;
        $phone   = $request->phone;
        $cel     = $request->cel;
        $stratum = $request->stratum;
        //estrato
        $province = $request->province;
        //provincia
        $adviser = $request->adviser;
        //asesor
        $address = $request->address;
        //direccion
        $district = $request->district;
        //distrito
        $hub   = $request->hub;
        $type  = $request->type;
        $state = $request->state;
        $dater = date('Y-m-d', strtotime($request->dater)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->dater));
        //fecha de radicacion
        $dayans = $request->dayans;
        //dias ans

        $datev = date('Y-m-d', strtotime($request->datev)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->datev));
        //fecha de vencimiento
        $dateh = date('Y-m-d', strtotime($request->dateh)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->dateh));
        //fecha de habilitacion
        $fechaa = date('Y-m-d', strtotime($request->fechaa)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->fechaa));
        //fecha de Aprobacion
        $fechac = date('Y-m-d', strtotime($request->fechac)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->fechac));
        //fecha de Construcion
        $fechatc = date('Y-m-d', strtotime($request->fechatc)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->fechatc));
        //fecha de TC

        $cosntructor = $request->cosntructor;
        $tecnico1    = $request->tecnico1;
        $enabler     = $request->enabler;
        //habilitador
        $inspector = $request->inspector;
        //inspector
        $obsp = $request->obsp;
        //obserbaciones peiddo
        $obs = $request->obs;
        //obserbaciones

        $programmed = $request->programmed;
        //programado a
        $nameprogrammed = $request->nameprogrammed;
        //programado a
        $dateinn = date('Y-m-d', strtotime($request->dateinn)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->dateinn));
        //fecha inn
        $supervisor = $request->supervisor;
        //supervisor
        $namesupervisor = $request->namesupervisor;
        //supervisor
        $technical = $request->technical;
        //Tecnico constructor
        $nametechnical = $request->nametechnical;
        //Tecnico constructor
        $assistant = $request->assistant;
        //Auxiliar constructor
        $nameassistant = $request->nameassistant;
        //Auxiliar constructor
        $datem = date('Y-m-d', strtotime($request->datem)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->datem));
        //Fecha mocha

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
                'address'      => $address,

            ]);
        return response()->json(['status' => 'ok', 'response' => $update], 200);
    }

    public function search()
    {
        $search = DB::table('work')
            ->join('statework', 'statework.idstatework', '=', 'work.statework_id')
            ->join('typework', 'typework.idtypework', '=', 'work.typework_id')

        // ->orderBy( 'csc', 'asc' )
            ->select('work.*', 'statework.*', 'typework.*', DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.adviser) AS nameadviser")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.cosntructor) AS nameconstructor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.tecnico1) AS nametecnico1")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.enabler) AS nameenable")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.programmed) AS nameprogrammed")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.supervisor) AS namesupervisor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.technical) AS nametechnical")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.assistant) AS nameassistant"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);

        // ->orderBy( 'idclient', 'asc' )
        //     ->select( 'client.*', 'client.state as idstate', DB::raw( '(CASE WHEN client.state = "1" THEN "Activo" WHEN client.state = "2" THEN "Inactivo" ELSE "Por confirmar" END) AS state' ) )
    }

    public function search_name(Request $request)
    {
        $client = $request->name;

        $search = DB::table('work')
            ->join('statework', 'statework.idstatework', '=', 'work.statework_id')
            ->join('typework', 'typework.idtypework', '=', 'work.typework_id')

            ->where('client', 'like', $client . '%')
            ->orderBy('client', 'asc')
            ->select('work.*', 'statework.*', 'typework.*', DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.adviser) AS nameadviser")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.cosntructor) AS nameconstructor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.tecnico1) AS nametecnico1")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.enabler) AS nameenable")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.programmed) AS nameprogrammed")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.supervisor) AS namesupervisor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.technical) AS nametechnical")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.assistant) AS nameassistant"))
            ->paginate(10);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_dni(Request $request)
    {
        $dni = $request->dni;

        $search = DB::table('work')
            ->join('statework', 'statework.idstatework', '=', 'work.statework_id')
            ->join('typework', 'typework.idtypework', '=', 'work.typework_id')

            ->where('dni', 'like', $dni . '%')
            ->orderBy('dni', 'asc')
            ->select('work.*', 'statework.*', 'typework.*', DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.adviser) AS nameadviser")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.cosntructor) AS nameconstructor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.tecnico1) AS nametecnico1")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.enabler) AS nameenable")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.programmed) AS nameprogrammed")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.supervisor) AS namesupervisor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.technical) AS nametechnical")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.assistant) AS nameassistant"))
            ->paginate(10);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_hub(Request $request)
    {
        $hub = $request->hub;

        $search = DB::table('work')
            ->join('statework', 'statework.idstatework', '=', 'work.statework_id')
            ->join('typework', 'typework.idtypework', '=', 'work.typework_id')

            ->where('hub', 'like', $hub . '%')
            ->orderBy('hub', 'asc')
            ->select('work.*', 'statework.*', 'typework.*', DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.adviser) AS nameadviser")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.cosntructor) AS nameconstructor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.tecnico1) AS nametecnico1")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.enabler) AS nameenable")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.programmed) AS nameprogrammed")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.supervisor) AS namesupervisor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.technical) AS nametechnical")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.assistant) AS nameassistant"))
            ->paginate(10);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }
}
