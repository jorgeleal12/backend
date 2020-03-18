<?php

namespace App\Http\Controllers\NewControllers\material;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller {
    
    public function __construct() {
        $this->middleware( 'jwt', ['except' => ['login']] );
    }

    public function create(Request $request){

        $code_materials = $request->input('code_materials');
        $name_materials = $request->input('name_materials');
        $Unit_idUnit    = $request->input('Unit_idUnit');
        $state	        = $request->input('state');
        $type_material  = $request->input('type_material');

        $insert = DB::table('material')
                -> insert([
                    'code_materials'  => $code_materials,
                    'name_materials'  => $name_materials,
                    'Unit_idUnit'     => $Unit_idUnit,
                    'state'           => $state,
                    'id_typeMaterial' => $type_material,  
                ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function update(Request $request){

        $id             = $request->id;
        $code_materials = $request->input('data.code_materials');
        $name_materials = $request->input('data.name_materials');
        $Unit_idUnit    = $request->input('data.Unit_idUnit');
        $state          = $request->input('data.state');
        $type_material  = $request->input('data.type_material');

        $update = DB::table('material')
                ->where('idmaterials', $id)
                ->update([
                    'code_materials'  => $code_materials,
                    'name_materials'  => $name_materials,
                    'Unit_idUnit'     => $Unit_idUnit,
                    'state'           => $state,
                    'id_typeMaterial' => $type_material,  
                ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function delete(Request $request){

        $id_material = $request->id;

        $delete = DB::table('material')
                ->where('idmaterials', $id_material)
                ->delete();
        
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function search(){
    
        $search = DB::table('material')
                ->join('Unit', 'material.Unit_idUnit', '=', 'Unit.idUnit' )
                ->join('type_material', 'material.id_typeMaterial', '=', 'type_material.id')
                ->select('material.*', 'Unit.*', 'type_material.*')
                ->paginate(5);
        
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_code(Request $request){

        $code = $request->input('code');

        $select = DB::table('material')
                ->where('code_materials', $code)
                ->orderBy('code_materials', 'asc')
                ->paginate('5');
        
        return response()->json(['status' => 'ok', 'response' => $select], 200);
    }

    public function list_unit(Request $request){

        $search = DB::table('Unit')
                ->get();
        
        return response()->json(['status' => 'ok', 'response' => true, 'result' => $search], 200);
    }

    public function list_typeMaterial(){

        $search = DB::table('type_material')
                ->get();
        
        return response()->json(['status' => 'ok', 'response' => true, 'result' => $search],200);
    }

}