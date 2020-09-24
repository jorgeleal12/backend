<?php

namespace App\Http\Controllers\NewControllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function ReportObra(Request $request)
    {

        $date_ini = $request->date_ini;
        $date_end = $request->date_end;
        $state    = $request->stete;
        $type     = $request->type;

        $search = DB::table('work')
            ->join('statework', 'statework.idstatework', '=', 'work.statework_id')
            ->join('typework', 'typework.idtypework', '=', 'work.typework_id')
            ->whereIn('statework_id', $state)
            ->whereIn('typework_id', $type)

        // ->orderBy( 'csc', 'asc' )
            ->select('work.*', 'statework.*', 'typework.*', DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.adviser) AS nameadviser")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.cosntructor) AS nameconstructor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.tecnico1) AS nametecnico1")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.enabler) AS nameenable")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.programmed) AS nameprogrammed")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.supervisor) AS namesupervisor")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.technical) AS nametechnical")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.assistant) AS nameassistant")
                , DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.inspector) AS nameinspector"))
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);

    }

    public function search_inspetion(Request $request)
    {

        $date_ini = $request->date_ini;
        $date_end = $request->date_end;
        $state    = $request->stete;
        $type     = $request->type;

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->leftjoin('employees', 'employees.idemployees', '=', 'inspecion.scheduled_to')
            ->whereIn('inspecion.state', $state)
            ->whereIn('type', $type)

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane', 'employees.name', 'employees.last_name',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                      ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                           WHEN inspecion.use = "2" THEN "Comercial"
                          ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.state = "1" THEN "En Proceso"
                          WHEN inspecion.state = "2" THEN "Programado"
                          WHEN inspecion.state = "3" THEN "En Ejecución"
                          WHEN inspecion.state = "4" THEN "Atendido"
                         ELSE "Cancelado" END) AS name_stete'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                          WHEN inspecion.use = "2" THEN "Periodica"
                          WHEN inspecion.use = "3" THEN "Reformaca"
                         ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"),

                DB::raw("(select MAX(certified_number)  from certificate  where inspecion_csc=inspecion.csc) as certificate")
            )
            ->get(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

}
