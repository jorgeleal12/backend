<?php

namespace App\Http\Controllers\NewControllers\autocomplete;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutocompleteController extends Controller
{
    public function AutocompleteMaterial(Request $request)
    {
        $name_materials = $request->input('name_materials');

        $search = DB::table('materials')
            ->where('name_materials', 'like', '%' . $name_materials . '%')
            ->select('materials.*')
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function AutocompleteConstructor(Request $request)
    {
        $name_builder = $request->input('name_builder');

        $search = DB::table('builder')
            ->where('name_builder', 'like', '%' . $name_builder . '%')
            ->select('builder.*')
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function autocomplete_city(Request $request)
    {
        $name         = $request->name;
        $iddepartment = $request->iddepartment;

        $search = DB::table('municipality')
            ->where('name_municipality', 'like', $name . '%')
            ->where('id_departament', $iddepartment)
            ->select('municipality.*')
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function autocomplete_certicate(Request $request)
    {
        $number    = $request->input('number');
        $inspector = $request->input('inspector');

        $search = DB::table('Number_cetificate')
            ->join('counter_certificate', 'counter_certificate.Number_cetificate_idNumber_cetificate', '=', 'Number_cetificate.idNumber_cetificate')
            ->where('counter_certificate.number_', 'like', $number . '%')
            ->select('Number_cetificate.*', 'counter_certificate.*')
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function autocomplete_activities(Request $request)
    {
        $name = $request->input('name');

        $search = DB::table('activities')
            ->where('name_activitie', 'like', $name . '%')
            ->select('activities.*')
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function autocomplete_provider(Request $request)
    {
        $name = $request->input('name');

        $search = DB::table('providers')
            ->where('name_provider', 'like', $name . '%')
            ->select('providers.*', 'providers.name_provider as name', 'idproviders as id')
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function autocomplete_code_material(Request $request)
    {
        $name = $request->input('name');

        $search = DB::table('material')
            ->where('code_materials', 'like', $name . '%')
            ->select('material.*', 'material.code_materials as name', 'idmaterials as id')
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function autocomplete_descr_material(Request $request)
    {
        $name = $request->input('name');

        $search = DB::table('material')
            ->where('name_materials', 'like', $name . '%')
            ->select('material.*', 'material.name_materials as name', 'idmaterials as id')
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }
}
