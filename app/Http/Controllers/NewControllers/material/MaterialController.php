<?php

namespace App\Http\Controllers\NewControllers\material;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    public function create(Request $request)
    {

        $code_materials = $request->input('code_materials');
        $name_materials = $request->input('name_materials');
        $Unit_idUnit    = $request->input('Unit_idUnit');
        $state          = $request->input('state');
        $type_material  = $request->input('type_material');
        $barcode        = $request->input('barcode');

        $insert = DB::table('material')
            ->insert([
                'code_materials'  => $code_materials,
                'name_materials'  => $name_materials,
                'Unit_idUnit'     => $Unit_idUnit,
                'state'           => $state,
                'id_typeMaterial' => $type_material,
                'barcode'         => $barcode,
            ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function update(Request $request)
    {

        $idmaterials    = $request->idmaterials;
        $code_materials = $request->input('code_materials');
        $name_materials = $request->input('name_materials');
        $Unit_idUnit    = $request->input('Unit_idUnit');
        $state          = $request->input('state');
        $type_material  = $request->input('type_material');
        $barcode        = $request->input('barcode');

        $update = DB::table('material')
            ->where('idmaterials', $idmaterials)
            ->update([
                'code_materials'  => $code_materials,
                'name_materials'  => $name_materials,
                'Unit_idUnit'     => $Unit_idUnit,
                'state'           => $state,
                'id_typeMaterial' => $type_material,
                'barcode'         => $barcode,
            ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function delete(Request $request)
    {

        $id_material = $request->id;

        try {
            $delete = DB::table('material')
                ->where('idmaterials', $id_material)
                ->delete();
            return response()->json(['status' => 'ok', 'response' => true], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'not', 'response' => false], 200);
        }
    }

    public function search()
    {

        $search = DB::table('material')
            ->join('Unit', 'material.Unit_idUnit', '=', 'Unit.idUnit')
            ->join('type_material', 'material.id_typeMaterial', '=', 'type_material.id')
            ->select('material.*', 'Unit.*', 'type_material.*')
            ->paginate(10);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_code(Request $request)
    {

        $code = $request->input('code');

        $select = DB::table('material')
            ->where('code_materials', $code)
            ->orderBy('code_materials', 'asc')
            ->paginate('5');

        return response()->json(['status' => 'ok', 'response' => $select], 200);
    }

    public function list_unit(Request $request)
    {

        $search = DB::table('Unit')
            ->get();

        return response()->json(['status' => 'ok', 'response' => true, 'result' => $search], 200);
    }

    public function list_typeMaterial()
    {

        $search = DB::table('type_material')
            ->get();

        return response()->json(['status' => 'ok', 'response' => true, 'result' => $search], 200);
    }

    public function create_barcode(Request $request)
    {

        $code                 = $request->code;
        $description          = $request->description;
        $observations         = $request->observations;
        $material_idmaterials = $request->material_idmaterials;

        $create = DB::table('barcode')
            ->insertGetid([
                'code'                 => $code,
                'description'          => $description,
                'observations'         => $observations,
                'material_idmaterials' => $material_idmaterials,
                'state'                => 1,
            ]);

        return response()->json(['status' => 'ok', 'response' => $create], 200);
    }

    public function update_barcode(Request $request)
    {

        $idbarcode            = $request->idbarcode;
        $code                 = $request->code;
        $description          = $request->description;
        $observations         = $request->observations;
        $material_idmaterials = $request->material_idmaterials;

        $create = DB::table('barcode')
            ->where('idbarcode', $idbarcode)
            ->update([
                'code'         => $code,
                'description'  => $description,
                'observations' => $observations,
            ]);

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function search_barcode(Request $request)
    {

        $material_idmaterials = $request->material_idmaterials;

        $search = DB::table('barcode')
            ->where('material_idmaterials', $material_idmaterials)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function delete_barcode(Request $request)
    {

        $idbarcode = $request->idbarcode;

        $delete = DB::table('barcode')
            ->where('idbarcode', $idbarcode)
            ->where('state', 1)
            ->delete();

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function searchbarcode(Request $request)
    {

        $barcode = $request->barcode;

        $search = DB::table('barcode')
            ->where('code', $barcode)
            ->where('state', 1)
            ->first();
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }
}
