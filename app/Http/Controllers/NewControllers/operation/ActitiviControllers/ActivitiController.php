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
}
