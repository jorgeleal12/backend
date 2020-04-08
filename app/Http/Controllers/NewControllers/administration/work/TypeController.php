<?php

namespace App\Http\Controllers\NewControllers\administration\work;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller {

    public function search() {
        $search = db::table( 'typework' )
        ->get();
        return response()->json( ['status' => 'ok', 'response' => $search], 200 );
    }

    public function create( Request $request ) {
        $typework      = $request->input( 'typework' );
        $insert = DB::table( 'typework' )
        ->insert( [
            'typework'=>$typework
        ] );
        return response()->json( ['status' => 'ok', 'response' => $insert], 200 );
    }

    public function update( Request $request ) {
        $typework      = $request->input( 'typework' );
        $idtypework      = $request->input( 'idtypework' );

        $update = DB::table( 'typework' )
        ->where( 'idtypework', $idtypework )
        ->update( [
            'typework'=>$typework
        ] );
        return response()->json( ['status' => 'ok', 'response' => $update], 200 );
    }
}
