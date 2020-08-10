<?php

namespace App\Http\Controllers\NewControllers\employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    //

    public function create(Request $request)
    {
        $idemployees    = $request->input('idemployees');
        $name           = $request->input('name');
        $last_name      = $request->input('last_name');
        $sex            = $request->input('sex');
        $identification = $request->input('identification');
        $phone          = $request->input('phone');
        $cel            = $request->input('cel');
        $address        = $request->input('address');
        $civil_status   = $request->input('civil_status');
        $bank           = $request->input('bank');
        $account_type   = $request->input('account_type');
        $account_number = $request->input('account_number');
        // $birthdate               = $request->input( 'birthdate' );
        $birthdate               = date('Y-m-d', strtotime($request->input('birthdate'))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input('birthdate')));
        $date_admission          = date('Y-m-d', strtotime($request->date_admission)) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->date_admission));
        $pension_idpension       = $request->input('pension_idpension');
        $arl_idarl               = $request->input('arl_idarl');
        $eps_ideps               = $request->input('eps_ideps');
        $city                    = $request->input('city');
        $department_iddepartment = $request->input('department_iddepartment');
        $phone_contact           = $request->input('phone_contact');

        $state             = $request->state;
        $charges_idcharges = $request->charges_idcharges;

        $age             = $request->age;
        $caja_idbox      = $request->caja_idbox;
        $type_rh         = $request->type_rh;
        $education_level = $request->education_level;
        $location_az     = $request->location_az;
        $expedition_date = $request->expedition_date;

        $search = DB::table('employees')
            ->where('identification', $identification)
            ->first();

        if ($search) {
            return response()->json(['status' => 'ok', 'response' => false], 200);
        }

        $insert = DB::table('employees')
            ->insertGetid([

                'name'                    => $name,
                'last_name'               => $last_name,
                'sex'                     => $sex,
                'identification'          => $identification,
                'phone'                   => $phone,
                'cel'                     => $cel,
                'address'                 => $address,
                'civil_status'            => $civil_status,
                'bank'                    => $bank,
                'account_type'            => $account_type,
                'account_number'          => $account_number,
                'birthdate'               => $birthdate,
                'pension_idpension'       => $pension_idpension,
                'arl_idarl'               => $arl_idarl,
                'eps_ideps'               => $eps_ideps,
                'city'                    => $city,
                'department_iddepartment' => $department_iddepartment,
                'phone_contact'           => $phone_contact,
                'date_admission'          => $date_admission,
                'state'                   => $state,
                'charges_idcharges'       => $charges_idcharges,

                'age'                     => $age,
                'caja_idbox'              => $caja_idbox,
                'type_rh'                 => $type_rh,
                'education_level'         => $education_level,
                'location_az'             => $location_az,
                'expedition_date'         => $expedition_date,

            ]);

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function update(Request $request)
    {
        $idemployees             = $request->input('idemployees');
        $name                    = $request->input('name');
        $last_name               = $request->input('last_name');
        $sex                     = $request->input('sex');
        $identification          = $request->input('identification');
        $phone                   = $request->input('phone');
        $cel                     = $request->input('cel');
        $address                 = $request->input('address');
        $civil_status            = $request->input('civil_status');
        $bank                    = $request->input('bank');
        $account_type            = $request->input('account_type');
        $account_number          = $request->input('account_number');
        $birthdate               = date('Y-m-d', strtotime($request->input('birthdate'))) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->input('birthdate')));
        $date_admission          = date('Y-m-d', strtotime($request->date_admission)) == '1969-12-31' ? null : date('Y-m-d', strtotime($request->date_admission));
        $pension_idpension       = $request->input('pension_idpension');
        $arl_idarl               = $request->input('arl_idarl');
        $eps_ideps               = $request->input('eps_ideps');
        $city                    = $request->input('city');
        $department_iddepartment = $request->input('department_iddepartment');
        $phone_contact           = $request->input('phone_contact');

        $age             = $request->age;
        $caja_idbox      = $request->caja_idbox;
        $type_rh         = $request->type_rh;
        $education_level = $request->education_level;
        $location_az     = $request->location_az;
        $expedition_date = $request->expedition_date;

        $state             = $request->state;
        $charges_idcharges = $request->charges_idcharges;

        $insert = DB::table('employees')
            ->where('idemployees', $idemployees)
            ->update([
                'name'                    => $name,
                'last_name'               => $last_name,
                'sex'                     => $sex,
                'identification'          => $identification,
                'phone'                   => $phone,
                'cel'                     => $cel,
                'address'                 => $address,
                'civil_status'            => $civil_status,
                'bank'                    => $bank,
                'account_type'            => $account_type,
                'account_number'          => $account_number,
                'birthdate'               => $birthdate,
                'pension_idpension'       => $pension_idpension,
                'arl_idarl'               => $arl_idarl,
                'eps_ideps'               => $eps_ideps,
                'city'                    => $city,
                'department_iddepartment' => $department_iddepartment,
                'phone_contact'           => $phone_contact,

                'date_admission'          => $date_admission,
                'state'                   => $state,
                'charges_idcharges'       => $charges_idcharges,
                'age'                     => $age,
                'caja_idbox'              => $caja_idbox,
                'type_rh'                 => $type_rh,
                'education_level'         => $education_level,
                'location_az'             => $location_az,
                'expedition_date'         => $expedition_date,

            ]);

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function autocomplete(Request $request)
    {
        $employee = $request->input('employee');

        $search = DB::table('employees')
            ->where('name', 'like', '%' . $employee . '%')
            ->orWhere('identification', 'like', '%' . $employee . '%')
            ->select('employees.*', DB::raw('CONCAT(employees.name," ",employees.last_name) AS full_name'))
            ->take(10)
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_employee()
    {
        $search = DB::table('employees')
            ->orderBy('name', 'ASC')
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    // crear arl

    public function create_arl(Request $request)
    {
        $idarl    = $request->input('idarl');
        $name_arl = $request->input('name_arl');

        if (!$idarl) {
            $insert = DB::table('arl')
                ->insert([
                    'name_arl' => $name_arl,
                ]);
            return response()->json(['status' => 'ok', 'response' => true], 200);

        } else {
            $update = DB::table('arl')
                ->where('idarl', $idarl)
                ->update([
                    'name_arl' => $name_arl,
                ]);
            return response()->json(['status' => 'ok', 'response' => false], 200);

        }

    }

    //buscar arl

    public function search_arl()
    {

        $search = DB::table('arl')
            ->get();
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function delete_arl(Request $request)
    {
        $idarl = $request->input('idarl');

        $delete = DB::table('arl')
            ->where('idarl', $idarl)
            ->delete();

        return response()->json(['status' => 'ok', 'response' => $delete], 200);
    }

    public function search_eps()
    {
        $search = DB::table('eps')
            ->get();
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function create_eps(Request $request)
    {
        $ideps    = $request->input('ideps');
        $name_eps = $request->input('name_eps');

        if (!$ideps) {
            $insert = DB::table('eps')
                ->insert([
                    'name_eps' => $name_eps,
                ]);
            return response()->json(['status' => 'ok', 'response' => true], 200);

        } else {
            $update = DB::table('eps')
                ->where('ideps', $ideps)
                ->update([
                    'name_eps' => $name_eps,
                ]);
            return response()->json(['status' => 'ok', 'response' => false], 200);
        }

    }

    public function delete_eps(Request $request)
    {
        $ideps = $request->input('ideps');

        $delete = DB::table('eps')
            ->where('ideps', $ideps)
            ->delete();

        return response()->json(['status' => 'ok', 'response' => $delete], 200);
    }

    public function search_pension()
    {
        $search = DB::table('pension')
            ->get();
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function create_pension(Request $request)
    {

        $idpension    = $request->idpension;
        $name_pension = $request->name_pension;
        $type         = $request->type;

        if (!$idpension) {
            $insert = DB::table('pension')
                ->insert([
                    'name_pension' => $name_pension,
                ]);
            return response()->json(['status' => 'ok', 'response' => true], 200);
        } else {
            $update = DB::table('pension')
                ->where('idpension', $idpension)
                ->update([
                    'name_pension' => $name_pension,
                ]);
            return response()->json(['status' => 'ok', 'response' => false], 200);
        }

    }

    public function delete_pension(Request $request)
    {
        $idpension = $request->input('idpension');

        $delete = DB::table('pension')
            ->where('idpension', $idpension)
            ->delete();

        return response()->json(['status' => 'ok', 'response' => $delete], 200);
    }

    public function create_charges(Request $request)
    {
        $name_charge = $request->name_charge;
        $idcharges   = $request->idcharges;

        $insert = DB::table('charges')
            ->insertGetid([
                'name_charge' => $name_charge,
            ]);
        return response()->json(['status' => 'ok', 'response' => $insert], 200);
    }

    public function update_charges(Request $request)
    {
        $name_charge = $request->name_charge;
        $idcharges   = $request->idcharges;

        $update = DB::table('charges')
            ->where('idcharges', $idcharges)
            ->update([
                'name_charge' => $name_charge,
            ]);
        return response()->json(['status' => 'ok', 'response' => $update], 200);
    }

    public function search_charges()
    {
        $search = DB::table('charges')
            ->paginate(5);
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function delete_charges(Request $request)
    {
        $idcharges = $request->idcharges;

        $delete = DB::table('charges')
            ->where('idcharges', $idcharges)
            ->delete();
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function upload_image(Request $request)
    {

        $image       = $_FILES;
        $idemployees = $request->idemployees;

        $name = $image["file"]['name'];
        $file = $image["file"]['tmp_name'];
        $type = $image["file"]['type'];

        $characters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $Typedoc    = explode("/", $type);
        $strlength  = strlen($characters);

        $random = '';
        for ($i = 0; $i < 15; $i++) {
            $random .= $characters[rand(0, $strlength - 1)];
        }

        $namefile = $random . '.' . $Typedoc[1];
        $carpeta  = public_path('/public/employee/images/');

        if (!File::exists($carpeta)) {

            $path = public_path('/public/employee/images/');
            File::makeDirectory($path, 0777, true);

        }

        move_uploaded_file($file, $carpeta . $namefile);

        $update = DB::table('employees')
            ->where('idemployees', $idemployees)
            ->update([

                'url_photo' => $namefile,
            ]);
    }

}
