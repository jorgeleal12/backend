<?php

namespace App\Http\Controllers\NewControllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {

    public function ReportObra( Request $request ) {
        $date_ini = $request->date_ini;
        $date_end = $request->date_end;
        $state    = $request->stete;
        $type     = $request->type;

        $search = DB::table( 'work' )
        ->join( 'statework', 'statework.idstatework', '=', 'work.statework_id' )
        ->join( 'typework', 'typework.idtypework', '=', 'work.typework_id' )
        ->whereIn( 'statework_id', $state )
        ->whereIn( 'typework_id', $type )

        // ->orderBy( 'csc', 'asc' )
        ->select( 'work.*', 'statework.*', 'typework.*', DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.adviser) AS nameadviser" )
        , DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.cosntructor) AS nameconstructor" )
        , DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.tecnico1) AS nametecnico1" )
        , DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.enabler) AS nameenable" )
        , DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.programmed) AS nameprogrammed" )
        , DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.supervisor) AS namesupervisor" )
        , DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.technical) AS nametechnical" )
        , DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.assistant) AS nameassistant" )
        , DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=work.inspector) AS nameinspector" ) )
        ->get();

        return response()->json( ['status' => 'ok', 'response' => $search], 200 );

    }
}
