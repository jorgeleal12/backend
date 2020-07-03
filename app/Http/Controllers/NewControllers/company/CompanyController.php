<?php

namespace App\Http\Controllers\NewControllers\company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function create(Request $request)
    {

        $company_name    = $request->company_name;
        $company_address = $request->company_address;
        $company_nit     = $request->company_nit;
        $phone           = $request->phone;

        $insert = DB::table('company')
            ->insert([
                'company_name'    => $company_name,
                'company_address' => $company_address,
                'company_nit'     => $company_nit,
                'phone'           => $phone,
            ]);

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function searchs(Request $request)
    {
        $searchs = DB::table('company')
            ->get();

        return response()->json(['status' => 'ok', 'response' => true, 'result' => $searchs], 200);

    }

    public function update(Request $request)
    {
        $idcompany       = $request->idcompany;
        $company_name    = $request->company_name;
        $company_address = $request->company_address;
        $company_nit     = $request->company_nit;
        $phone           = $request->phone;

        $update = DB::table('company')
            ->where('idcompany', $idcompany)
            ->update([
                'company_name'    => $company_name,
                'company_address' => $company_address,
                'company_nit'     => $company_nit,
                'phone'           => $phone,
            ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function companyfind(Request $request)
    {

        $idcompany = $request->company;

        $search = DB::table('company')
            ->where('idcompany', $idcompany)
            ->first();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

}
