<?php

namespace App\Http\Controllers\NewControllers\Inventary\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller {

    public function list_cellar( Request $request ) {
        $iduser = $request->iduser;
        $search = DB::table( 'cellar' )
        ->join( 'cellar_user', 'cellar_user.idcellar', '=', 'cellar.idcellar' )
        ->where( 'cellar_user.id_user', $iduser )
        ->get();
        return response()->json( ['status' => 'ok', 'response' => $search], 200 );
    }
}
