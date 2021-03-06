<?php

namespace App\Http\Controllers\NewControllers\lists;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    //

    public function list_eps(Request $request)
    {
        $search = DB::table('eps')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_arl(Request $request)
    {
        $search = DB::table('arl')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_pension(Request $request)
    {
        $search = DB::table('pension')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_service(Request $request)
    {
        $search = DB::table('type_service')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_photos(Request $request)
    {
        $search = DB::table('photos')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_ubigeos(Request $request)
    {

        $search = DB::table('provinces')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_provinces(Request $request)
    {
        $id_departamento = $request->id_departamento;

        $search = DB::table('district')
            ->where('provinces_idprovinces', $id_departamento)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_municipality(Request $request)
    {
        $id_departamento = $request->input('id_departamento');
        $search          = DB::table('municipality')
            ->where('id_departament', $id_departamento)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_type_network(Request $request)
    {
        $type = $request->input('type');

        $search = DB::table('type_network')
            ->where('type_service_idtype_service', $type)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_photos_service(Request $request)
    {
        $type_network_idtype_network = $request->input('type_network_idtype_network');

        $search = DB::table('photos_service')
            ->join('photos', 'photos.idphotos', 'photos_service.photos_idphotos')
            ->where('type_network_idtype_network', $type_network_idtype_network)
            ->get();
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_typework()
    {
        $search = DB::table('typework')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_statework()
    {
        $search = DB::table('statework')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_company()
    {
        $search = DB::table('company')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_contract_params(Request $request)
    {

        $company_idcompany = $request->company_idcompany;

        $search = DB::table('contract')
            ->where('company_idcompany', $company_idcompany)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_project_params(Request $request)
    {

        $idcompany = $request->idcompany;

        $search = DB::table('projects')
            ->where('idcompany', $idcompany)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_cellar()
    {
        $search = DB::table('cellar')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function list_cellar_user(Request $request)
    {
        $idusers = $request->idusers;

        $search = DB::table('cellar_user')
            ->leftjoin('cellar', 'cellar.idcellar', '=', 'cellar_user.id_user')
            ->where('id_user', $idusers)
            ->select('cellar_user.idcellar', 'cellar.name_cellar')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }
}
