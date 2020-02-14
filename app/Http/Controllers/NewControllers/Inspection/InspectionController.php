<?php

namespace App\Http\Controllers\NewControllers\Inspection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InspectionController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    public function create(Request $request)
    {
        $csc              = $request->input('csc');
        $application_date = date('Y-m-d', strtotime($request->input('application_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('application_date')));
        $who_request      = $request->input('who_request');
        $who_attends      = $request->input('who_attends');
        $address          = $request->input('address');
        $phone            = $request->input('phone');
        $city             = $request->input('city');
        $neighborhood     = $request->input('neighborhood');
        $zone             = $request->input('zone');
        $value_review     = $request->input('value_review');
        $attention_day    = $request->input('attention_day');

        $filed_call        = $request->input('filed_call');
        $referred          = $request->input('referred');
        $origin            = $request->input('origin');
        $schedule_date     = date('Y-m-d', strtotime($request->input('schedule_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('schedule_date')));
        $download_date     = date('Y-m-d', strtotime($request->input('download_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('download_date')));
        $number_visits     = $request->input('number_visits');
        $check_matrix      = $request->input('check_matrix');
        $installer_name    = $request->input('installer_name');
        $installation_code = $request->input('installation_code');

        $distribution_date     = date('Y-m-d', strtotime($request->input('distribution_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('distribution_date')));
        $distribution_date_two = date('Y-m-d', strtotime($request->input('distribution_date_two'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('distribution_date_two')));
        $sicerco_date          = date('Y-m-d', strtotime($request->input('sicerco_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('sicerco_date')));
        $epm_date              = date('Y-m-d', strtotime($request->input('epm_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('epm_date')));

        $insert = DB::table('inspecion')
            ->insertGetid([
                'csc'                   => $csc,
                'application_date'      => $application_date,
                'who_request'           => $who_request,
                'who_attends'           => $who_attends,
                'address'               => $address,
                'phone'                 => $phone,
                'neighborhood'          => $neighborhood,
                'zone'                  => $zone,
                'value_review'          => $value_review,
                'attention_day'         => $attention_day,
                'filed_call'            => $filed_call,
                'referred'              => $referred,
                'origin'                => $origin,
                'schedule_date'         => $schedule_date,
                'download_date'         => $download_date,
                'number_visits'         => $number_visits,
                'check_matrix'          => $check_matrix,

                'installer_name'        => $installer_name,
                'installation_code'     => $installation_code,
                'distribution_date'     => $distribution_date,
                'distribution_date_two' => $distribution_date_two,
                'sicerco_date'          => $sicerco_date,
                'epm_date'              => $epm_date,

            ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function update(Request $request)
    {
        $csc              = $request->input('csc');
        $application_date = date('Y-m-d', strtotime($request->input('application_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('application_date')));
        $who_request      = $request->input('who_request');
        $who_attends      = $request->input('who_attends');
        $address          = $request->input('address');
        $phone            = $request->input('phone');
        $city             = $request->input('city');
        $neighborhood     = $request->input('neighborhood');
        $zone             = $request->input('zone');
        $value_review     = $request->input('value_review');
        $attention_day    = $request->input('attention_day');

        $filed_call        = $request->input('filed_call');
        $referred          = $request->input('referred');
        $origin            = $request->input('origin');
        $schedule_date     = date('Y-m-d', strtotime($request->input('schedule_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('schedule_date')));
        $download_date     = date('Y-m-d', strtotime($request->input('download_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('download_date')));
        $number_visits     = $request->input('number_visits');
        $check_matrix      = $request->input('check_matrix');
        $installer_name    = $request->input('installer_name');
        $installation_code = $request->input('installation_code');

        $distribution_date     = date('Y-m-d', strtotime($request->input('distribution_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('distribution_date')));
        $distribution_date_two = date('Y-m-d', strtotime($request->input('distribution_date_two'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('distribution_date_two')));
        $sicerco_date          = date('Y-m-d', strtotime($request->input('sicerco_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('sicerco_date')));
        $epm_date              = date('Y-m-d', strtotime($request->input('epm_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('epm_date')));

        $insert = DB::table('inspecion')
            ->where('csc', $csc)
            ->update([
                'application_date'      => $application_date,
                'who_request'           => $who_request,
                'who_attends'           => $who_attends,
                'address'               => $address,
                'phone'                 => $phone,
                'neighborhood'          => $neighborhood,
                'zone'                  => $zone,
                'value_review'          => $value_review,
                'attention_day'         => $attention_day,
                'filed_call'            => $filed_call,
                'referred'              => $referred,
                'origin'                => $origin,
                'schedule_date'         => $schedule_date,
                'download_date'         => $download_date,
                'number_visits'         => $number_visits,
                'check_matrix'          => $check_matrix,
                'installer_name'        => $installer_name,
                'installation_code'     => $installation_code,
                'distribution_date'     => $distribution_date,
                'distribution_date_two' => $distribution_date_two,
                'sicerco_date'          => $sicerco_date,
                'epm_date'              => $epm_date,

            ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function search()
    {

        $search = DB::table('inspecion')
            ->select()
            ->paginate(10);

        return response()->json(['status' => 'ok', 'response' => $search], 200);

    }
}
