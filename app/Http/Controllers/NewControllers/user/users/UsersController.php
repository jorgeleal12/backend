<?php

namespace App\Http\Controllers\NewControllers\user\users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller {

    public function create( Request $request ) {

        $name              = $request->name;
        $last_name         = $request->last_name;
        $email             = $request->email;
        $password          = $request->password;
        $state             = $request->state;
        $rol_idrol         = $request->rol_idrol;
        $company_idcompany = $request->company_idcompany;
        $id                = $request->id;
        $contract          = $request->selectedUser;
        $type              = $request->type;
        $cellar            = $request->cellar;

        $insert = DB::table( 'users' )
        ->insertGetid( [
            'name'              => $name,
            'last_name'         => $last_name,
            'email'             => $email,
            'password'          => Hash::make( $password ),
            'state'             => $state,
            'rol_idrol'         => $rol_idrol,
            'company_idcompany' => $company_idcompany,
            'id'                => $id,
            // 'type'              => $type,
        ] );

        $this->contract_user( $contract, $insert );
        $this->cellar_user( $cellar, $insert );
        return response()->json( ['status' => 'ok', 'reponse' => true, 'result' => $insert], 200 );
    }

    public function contract_user( $contract, $insertid ) {
        foreach ( $contract as $contracts ) {

            $insert = DB::table( 'contract_user' )
            ->insert( [
                'users_idusers' => $insertid,
                'idcontract'    => $contracts,
            ] );
        }
    }

    public function cellar_user( $cellar, $insertid ) {
        foreach ( $cellar as $cellars ) {

            $insert = DB::table( 'cellar_user' )
            ->insert( [
                'id_user'  => $insertid,
                'idcellar' => $cellars,
            ] );
        }
    }

    public function searchs( Request $request ) {

        $search = DB::table( 'users' )
        ->leftjoin( 'rol', 'rol.idrol', '=', 'users.rol_idrol' )
        ->select( 'users.*', 'rol.*', 'users.state as id_state', DB::raw( '(CASE WHEN users.state = "1" THEN "Activo" ELSE "Cancelado" END) AS state' ) )
        ->get();

        return response()->json( ['status' => 'ok', 'reponse' => true, 'result' => $search], 200 );
    }

    public function update( Request $request ) {
        $idusers           = $request->idusers;
        $name              = $request->name;
        $last_name         = $request->last_name;
        $email             = $request->email;
        $state             = $request->state;
        $rol_idrol         = $request->rol_idrol;
        $company_idcompany = $request->company_idcompany;
        $id                = $request->id;
        //cedula o identificacion del usuario
        $type     = $request->type;
        $contract = $request->selectedUser;
        $cellar   = $request->cellar;

        $insert = DB::table( 'users' )
        ->where( 'idusers', $idusers )
        ->update( [
            'name'              => $name,
            'last_name'         => $last_name,
            'email'             => $email,
            'state'             => $state,
            'rol_idrol'         => $rol_idrol,
            'company_idcompany' => $company_idcompany,
            'id'                => $id,
            // 'type'              => $type,
        ] );

        $this->update_contrat( $contract, $idusers );
        $this->update_cellar( $cellar, $idusers );

        return response()->json( ['status' => 'ok', 'reponse' => true], 200 );
    }

    public function update_contrat( $contract, $idusers ) {

        $delete = DB::table( 'contract_user' )
        ->where( 'users_idusers', $idusers )
        ->delete();

        foreach ( $contract as $contracts ) {

            $insert = DB::table( 'contract_user' )
            ->insert( [
                'users_idusers' => $idusers,
                'idcontract'    => $contracts,
            ] );
        }

    }

    public function update_cellar( $cellar, $idusers ) {

        $delete = DB::table( 'cellar_user' )
        ->where( 'id_user', $idusers )
        ->delete();

        foreach ( $cellar as $cellars ) {

            $insert = DB::table( 'cellar_user' )
            ->insert( [
                'id_user'  => $idusers,
                'idcellar' => $cellars,
            ] );
        }

    }

    public function search_contract( Request $request ) {

        $idusers = $request->input( 'idusers' );

        $search = DB::table( 'contract_user' )
        ->leftjoin( 'contract', 'contract.idcontract', '=', 'contract_user.idcontract' )
        ->where( 'users_idusers', $idusers )
        ->select( 'contract_user.idcontract', 'contract.contract_name' )
        ->get();

        return response()->json( ['status' => 'ok', 'response' => $search], 200 );
    }

    public function search_cellar( Request $request ) {
        $idusers = $request->input( 'idusers' );

        $search = DB::table( 'cellar_user' )
        ->leftjoin( 'cellar', 'cellar.idcellar', '=', 'cellar_user.id_user' )
        ->where( 'id_user', $idusers )
        ->select( 'cellar_user.idcellar', 'cellar.name_cellar' )
        ->get();

        return response()->json( ['status' => 'ok', 'response' => $search], 200 );
    }

    public function delete( Request $request ) {
        $iduser = $request->input( 'iduser' );

        $delete = DB::table( 'users' )
        ->where( 'idusers', $iduser )
        ->delete();
        return response()->json( ['status' => 'ok', 'response' => true], 200 );

    }

    public function search_user( Request $request ) {
        $cedula = $request->input( 'cedula' );

        $search = DB::table( 'employees' )
        ->where( 'identification', $cedula )
        ->first();

        if ( $search ) {
            $search_user = DB::table( 'users' )
            ->where( 'id', $search->identification )
            ->first();

            if ( $search_user ) {
                return response()->json( ['status' => 'ok', 'response' => false], 200 );
            } else {

                return response()->json( ['status' => 'ok', 'response' => true, 'result' => $search], 200 );
            }
        } else {
            echo '2';
        }

    }
}
