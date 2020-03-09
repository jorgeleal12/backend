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
        $insert       = DB::table('inspecion')
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

            ->select('inspecion.*', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                      ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                           WHEN inspecion.use = "2" THEN "Comercial"
                          ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                          WHEN inspecion.use = "2" THEN "Periodica"
                          WHEN inspecion.use = "3" THEN "Reformaca"
                         ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"), )
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

            ->select('inspecion.*', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"), )
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

            ->select('inspecion.*', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"), )
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

            ->select('inspecion.*', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"), )
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

            ->select('inspecion.*', 'client_account.*', 'client.*', 'municipality.name_municipality',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.use = "2" THEN "Periodica"
                      WHEN inspecion.use = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"), )
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function create_certificate(Request $request)
    {
        $idcertificate   = $request->idcertificate;
        $inspection_date = $request->inspection_date;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
        $idcertificate   = $request->idcertificate;
    }
}
