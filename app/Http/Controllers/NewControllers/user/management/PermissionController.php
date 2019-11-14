<?php

namespace App\Http\Controllers\NewControllers\user\management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    public function create(Request $request)
    {
        $permission = $request->input("permission");

        $search = DB::table('permission')
            ->where('name_permission', $permission)
            ->first();

        if ($search) {
            return response()->json(['status' => 'ok', 'search' => false], 200);
        }

        $insert = DB::table('permission')
            ->insertGetid([
                'name_permission' => $permission,
            ]);

        $insert_permission = DB::table('action_permission')
            ->insert([
                'idpermission' => $insert,
                'save'         => false,
                'edit'         => false,
                'delete'       => false,
            ]);

        return response()->json(['status' => 'ok', 'search' => true], 200);
    }

    public function search(Request $request)
    {
        $search = DB::table('permission')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function update(Request $request)
    {
        $permission   = $request->input("permission");
        $idpermission = $request->input("idpermission");

        $update = DB::table('permission')
            ->where('idpermission', $idpermission)
            ->update([
                'name_permission' => $permission,
            ]);
        return response()->json(['status' => 'ok', 'response' => $update], 200);
    }

    public function create_rol(Request $request)
    {
        $name_rol = $request->input("name_rol");

        $insert = DB::table('rol')
            ->insertGetid([
                'name_rol' => $name_rol,
            ]);

        // foreach ($rolePermissions as $t) {
        //     $idrol_permission    = isset($t['idrol_permission']) ? $t['idrol_permission'] : null;
        //     $idaction_permission = $t['idaction_permission'];
        //     $idpermission        = $t['idpermission'];
        //     $save                = $t['save'];
        //     $edit                = $t['edit'];
        //     $delete              = $t['delete'];

        //     if (is_null($idrol_permission)) {
        //         $save = DB::table('rol_permission')
        //             ->insert([
        //                 'rol_idrol'           => $insert,
        //                 'idaction_permission' => $idaction_permission,
        //                 'save'                => $save,
        //                 'edit'                => $edit,
        //                 'delete'              => $delete,
        //             ]);
        //     } else {

        //     }

        // }
        return response()->json(['status' => 'ok', 'response' => $insert], 200);
    }

    public function searchs(Request $request)
    {

        $search = DB::table('rol')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_rol(Request $request)
    {
        $idrol = $request->input("idrol");

        $search = DB::table('rol_permission')
            ->where('rol_idrol', $idrol)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);

    }

    public function update_rol(Request $request)
    {
        $name = $request->input("name");
        $id   = $request->input("id");

        $update = DB::table('rol')
            ->where('idrol', $id)
            ->update([
                'name_rol' => $name,

            ]);
        return response()->json(['status' => 'ok', 'response' => $update], 200);
    }

    public function update_permission_rol(Request $request)
    {

        $idrol   = $request->input("idrol");
        $key     = $request->input("key");
        $checked = $request->input("checked");
        $action  = $request->input("action");

        $search = DB::table('rol_permission')
            ->where('idrol_permission', $key)
            ->first();
        // var_dump($search);
        if ($search) {
            // $update = DB::table('rol_permission')
            //     ->where('idrol_permission', $idrol_permission)
            //     ->update([
            //         'save'   => $save,
            //         'edit'   => $edit,
            //         'delete' => $delete,

            //     ]);
            // return response()->json(['status' => 'ok', 'response' => false], 200);
        } else {

            $insert = DB::table('rol_permission')
                ->insertGetid([
                    $action        => $checked,
                    'rol_idrol'    => $idrol,
                    'idpermission' => $key,
                ]);
            return response()->json(['status' => 'ok', 'response' => true, 'result' => $insert], 200);
        }
    }
}
