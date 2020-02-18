<?php

namespace App\Http\Controllers\NewControllers\operation\ActitiviControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivitiController extends Controller {
    //

    public function __construct() {
        $this->middleware( 'jwt', ['except' => ['login']] );
    }

    public function create( Request $request ) {
        $idactivities   = $request->idactivities;
        $name_activitie = $request->name_activitie;
        $value          = $request->value;
        $idcontract     = $request->idcontract;
        $type           = $request->type;

        $insert = DB::table( 'activities' )
        ->insert( [
            'idactivities'   => $idactivities,
            'name_activitie' => $name_activitie,
            'value'          => $value,
            'idcontract'     => $idcontract,
        ] );
        return response()->json( ['status' => 'ok', 'response' => true], 200 );

    }

    public function update( Request $request ) {

        $idactivities   = $request->idactivities;
        $name_activitie = $request->name_activitie;
        $value          = $request->value;
        $idcontract     = $request->idcontract;
        $type           = $request->type;

        $update = DB::table( 'activities' )
        ->where( 'idactivities', $idactivities )
        ->update( [
            'name_activitie' => $name_activitie,
            'value'          => $value,
            'idcontract'     => $idcontract,
        ] );
        return response()->json( ['status' => 'ok', 'response' => true], 200 );
    }

    public function search( Request $request ) {

        $idcontract = $request->idcontract;

        $search = DB::table( 'activities' )
        ->where( 'idcontract', $idcontract )
        ->get();

        return response()->json( ['status' => 'ok', 'result' => $search] );

    }

    public function delete( Request $request ) {
        $idactivities = $request->idactivities;

        $delete = DB::table( 'activities' )
        ->where( 'idactivities', $idactivities )
        ->delete();

        return response()->json( ['status' => 'ok', 'result' => true] );
    }

    //funcion para guardar las actividades de la obra

    public function save_activities( Request $request ) {
        $contract = $request->contract;
        $idobr = $request->idobr;
        $data = $request->data;

        for ( $i = 0; $i < count( $data );
        $i++ ) {

            $idactivities_obr = $data[$i]['idactivities_obr'] ;
            $idactivities = $data[$i]['idactivities'] ;
            $idemployees =  $data[$i]['idemployees'] ;
            $cuantity =  $data[$i]['cuantity'] ;
            $value =  $data[$i]['value'] ;
            $total =  $data[$i]['total'] ;
            $state = $data[$i]['state'] ;

            $date = date( 'Y-m-d', strtotime( $data[$i]['date'] ) ) == '1970-01-01' ? null : date( 'Y-m-d', strtotime( $data[$i]['date'] ) );

            if ( $idactivities_obr == null ) {

                $insert = DB::table( 'activities_obr' )
                ->insert( [
                    'activities_idactivities'=>$idactivities,
                    'idemployees'=>$idemployees,
                    'cuantity'=>$cuantity,
                    'value'=>$value,
                    'total'=>$total,
                    'state'=>$state,
                    'work_csc'=>$idobr,
                    'date'=>$date
                ] );

            } else {

                $update = DB::table( 'activities_obr' )
                ->where( 'idactivities_obr', $idactivities_obr )
                ->update( [
                    'activities_idactivities'=>$idactivities,
                    'idemployees'=>$idemployees,
                    'cuantity'=>$cuantity,
                    'value'=>$value,
                    'total'=>$total,
                    'state'=>$state
                ] );

            }
        }

        return response()->json( ['status' => 'ok', 'response' => true], 200 );
    }

    public function search_activities( Request $request ) {
        $id_obr = $request->id_obr;

        DB::statement( DB::raw( 'SET @rownum = 0' ) );

        $search = DB::table( 'activities_obr' )
        ->leftjoin( 'employees', 'employees.idemployees', 'activities_obr.idemployees' )
        ->leftjoin( 'activities', 'activities.idactivities', 'activities_obr.activities_idactivities' )
        ->where( 'work_csc', $id_obr )
        ->orderBy( 'idactivities_obr', 'asc' )
        ->select( 'activities_obr.*', 'activities.name_activitie as activities',
        'activities_obr.activities_idactivities as idactivities',
        DB::raw( '@rownum := @rownum + 1 as id' ),
        DB::raw( "(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=activities_obr.idemployees) AS name" ) )
        ->get();

        return response()->json( ['status' => 'ok', 'response' => $search], 200 );
    }
}
