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
        $who_request      = $request->who_request;
        $who_attends      = $request->who_attends;
        $address          = $request->address;
        $phone_contact    = $request->phone_contact;
        $city             = $request->city;
        $neighborhood     = $request->neighborhood;
        $zone             = $request->zone;
        $value_review     = $request->value_review;
        $attention_day    = $request->attention_day;

        $filed_call    = $request->filed_call;
        $referred      = $request->referred;
        $origin        = $request->origin;
        $schedule_date = date('Y-m-d', strtotime($request->schedule_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->schedule_date));

        $number_visits     = $request->number_visits;
        $installer_name    = $request->installer_name;
        $installation_code = $request->installation_code;

        $type         = $request->type;
        $use          = $request->use;
        $gas_type     = $request->gas_type;
        $discontinued = $request->discontinued;
        $device       = $request->device;

        $idaddress    = $request->idaddress;
        $scheduled_to = $request->scheduled_to;
        $state        = $request->state;

        $insert = DB::table('inspecion')
            ->insertGetid([
                'csc'               => $csc,
                'application_date'  => $application_date,
                'who_request'       => $who_request,
                'who_attends'       => $who_attends,
                'zone'              => $zone,
                'value_review'      => $value_review,
                'attention_day'     => $attention_day,
                'filed_call'        => $filed_call,
                'referred'          => $referred,
                'origin'            => $origin,
                'schedule_date'     => $schedule_date,
                'number_visits'     => $number_visits,
                'installer_name'    => $installer_name,
                'installation_code' => $installation_code,

                'type'              => $type,
                'use'               => $use,
                'gas_type'          => $gas_type,
                'discontinued'      => $discontinued,
                'device'            => $device,
                'idclient_account'  => $idaddress,
                'phone_contact'     => $phone_contact,
                'scheduled_to'      => $scheduled_to,
                'state'             => $state,

            ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function update(Request $request)
    {
        $csc              = $request->input('csc');
        $application_date = date('Y-m-d', strtotime($request->input('application_date'))) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->input('application_date')));
        $who_request      = $request->who_request;
        $who_attends      = $request->who_attends;
        $address          = $request->address;
        $phone_contact    = $request->phone_contact;
        $city             = $request->city;
        $neighborhood     = $request->neighborhood;
        $zone             = $request->zone;
        $value_review     = $request->value_review;
        $attention_day    = $request->attention_day;

        $filed_call    = $request->filed_call;
        $referred      = $request->referred;
        $origin        = $request->origin;
        $schedule_date = date('Y-m-d', strtotime($request->schedule_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->schedule_date));

        $number_visits     = $request->number_visits;
        $installer_name    = $request->installer_name;
        $installation_code = $request->installation_code;

        $type         = $request->type;
        $use          = $request->use;
        $gas_type     = $request->gas_type;
        $discontinued = $request->discontinued;
        $device       = $request->device;

        $idaddress    = $request->idaddress;
        $scheduled_to = $request->scheduled_to;
        $state        = $request->state;

        $update = DB::table('inspecion')
            ->where('csc', $csc)
            ->update([

                'application_date'  => $application_date,
                'who_request'       => $who_request,
                'who_attends'       => $who_attends,
                'zone'              => $zone,
                'value_review'      => $value_review,
                'attention_day'     => $attention_day,
                'filed_call'        => $filed_call,
                'referred'          => $referred,
                'origin'            => $origin,
                'schedule_date'     => $schedule_date,
                'number_visits'     => $number_visits,
                'installer_name'    => $installer_name,
                'installation_code' => $installation_code,

                'type'              => $type,
                'use'               => $use,
                'gas_type'          => $gas_type,
                'discontinued'      => $discontinued,
                'device'            => $device,
                'idclient_account'  => $idaddress,
                'phone_contact'     => $phone_contact,
                'scheduled_to'      => $scheduled_to,
                'state'             => $state,
            ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function search()
    {

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                      ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                           WHEN inspecion.use = "2" THEN "Comercial"
                          ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                          WHEN inspecion.use = "2" THEN "Periodica"
                          WHEN inspecion.use = "3" THEN "Reformaca"
                         ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);

    }

    public function search_cc(Request $request)
    {
        $cc = $request->cc;

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->where('client.id_client', 'like', $cc . '%')
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_address(Request $request)
    {
        $address = $request->address;

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->where('client_account.address', 'like', $address . '%')
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_client(Request $request)
    {
        $client = $request->client;

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->where('client.name_client', 'like', $client . '%')
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_conse(Request $request)
    {
        $conse = $request->conse;

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->where('inspecion.csc', 'like', $conse . '%')
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function create_certificate(Request $request)
    {

        $idcertificate     = $request->idcertificate;
        $inspecion_csc     = $request->inspecion_csc;
        $inspection_date   = date('Y-m-d', strtotime($request->inspection_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->inspection_date));
        $certified_number  = $request->certified_number;
        $inspection_result = $request->inspection_result;
        $inspector         = $request->inspector;
        $proof_payment     = $request->proof_payment;
        $value             = $request->value;
        $distribution_date = date('Y-m-d', strtotime($request->distribution_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->distribution_date));
        $sicerco_date      = date('Y-m-d', strtotime($request->sicerco_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->sicerco_date));
        $epm_date          = date('Y-m-d', strtotime($request->epm_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->epm_date));
        $download_date     = date('Y-m-d', strtotime($request->download_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->download_date));
        $check_matrix      = $request->check_matrix;

        $productivity = $request->productivity;

        $insert = DB::table('certificate')
            ->insertGetid([
                'inspection_date'   => $inspection_date,

                'certified_number'  => $certified_number,
                'inspection_result' => $inspection_result,
                'inspector'         => $inspector,
                'proof_payment'     => $proof_payment,
                'inspecion_csc'     => $inspecion_csc,
                'value'             => $value,
                'distribution_date' => $distribution_date,
                'sicerco_date'      => $sicerco_date,
                'epm_date'          => $epm_date,
                'download_date'     => $download_date,
                'check_matrix'      => $check_matrix,
                'productivity'      => $productivity,

            ]);

        return response()->json(['status' => 'ok', 'response' => true, 'result' => $insert], 200);

    }

    public function search_certificate(Request $request)
    {

        $inspecion_csc = $request->inspecion_csc;

        $search = DB::table('certificate')
            ->where('inspecion_csc', $inspecion_csc)
            ->select('certificate.*', DB::raw('(CASE WHEN certificate.inspection_result = "1" THEN "Conforme"
              ELSE "No Conforme" END) AS rinspeccion'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=certificate.inspector) AS name_inspector"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function Update_certificate(Request $request)
    {
        $idcertificate     = $request->idcertificate;
        $inspecion_csc     = $request->inspecion_csc;
        $inspection_date   = date('Y-m-d', strtotime($request->inspection_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->inspection_date));
        $certified_number  = $request->certified_number;
        $inspection_result = $request->inspection_result;
        $inspector         = $request->inspector;
        $proof_payment     = $request->proof_payment;
        $value             = $request->value;
        $distribution_date = date('Y-m-d', strtotime($request->distribution_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->distribution_date));
        $sicerco_date      = date('Y-m-d', strtotime($request->sicerco_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->sicerco_date));
        $epm_date          = date('Y-m-d', strtotime($request->epm_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->epm_date));
        $download_date     = date('Y-m-d', strtotime($request->download_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->download_date));
        $check_matrix      = $request->check_matrix;

        $productivity = $request->productivity;

        $insert = DB::table('certificate')
            ->where('idcertificate', $idcertificate)
            ->update([
                'inspection_date'   => $inspection_date,
                'certified_number'  => $certified_number,
                'inspection_result' => $inspection_result,
                'inspector'         => $inspector,
                'proof_payment'     => $proof_payment,
                'value'             => $value,
                'distribution_date' => $distribution_date,
                'sicerco_date'      => $sicerco_date,
                'epm_date'          => $epm_date,
                'download_date'     => $download_date,
                'check_matrix'      => $check_matrix,
                'productivity'      => $productivity,

            ]);

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function search_programming(Request $request)
    {

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->where('inspecion.state', 1)
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"),

                DB::raw('(CASE WHEN inspecion.state = "1" THEN "En Proceso"
                WHEN inspecion.state = "2" THEN "Programado"
                WHEN inspecion.state = "3" THEN "En Ejecución"
                WHEN inspecion.state = "3" THEN "Atendido"
               ELSE "Cancelado" END) AS name_state')
            )
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function update_programming(Request $request)
    {
        $csc           = $request->csc;
        $employee      = $request->employee;
        $schedule_date = date('Y-m-d', strtotime($request->schedule_date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->schedule_date));

        $update = DB::table('inspecion')
            ->where('csc', $csc)
            ->update([
                'scheduled_to'  => $employee,
                'schedule_date' => $schedule_date,
                'state'         => 2,
            ]);

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function search_images(Request $request)
    {

        $idcertificate = $request->idcertificate;
        DB::statement(DB::raw('SET @rownum = 0'));
        $search = DB::table('image_certificate')
            ->where('certificate_idcertificate', $idcertificate)
            ->select('image_certificate.*', DB::raw('@rownum := @rownum  as id'), )
            ->paginate(5);
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

}
