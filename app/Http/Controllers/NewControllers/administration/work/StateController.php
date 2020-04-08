<?php

namespace App\Http\Controllers\NewControllers\administration\work;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StateController extends Controller {

    public function create( Request $request ) {
        $statework      = $request->input( 'statework' );
        $insert = DB::table( 'statework' )
        ->insert( [
            'statework'=>$statework
        ] );
        return response()->json( ['status' => 'ok', 'response' => $insert], 200 );
    }

    public function update( Request $request ) {
        $statework      = $request->input( 'statework' );
        $idstatework      = $request->input( 'idstatework' );

        $update = DB::table( 'statework' )
        ->where( 'idstatework', $idstatework )
        ->update( [
            'statework'=>$statework
        ] );
        return response()->json( ['status' => 'ok', 'response' => $update], 200 );
    }

    public function search() {
        $search = db::table( 'statework' )
        ->get();
        return response()->json( ['status' => 'ok', 'response' => $search], 200 );
    }
}
