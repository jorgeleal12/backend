<?php

namespace App\Http\Controllers\NewControllers\Inspection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InspectionController extends Controller
{

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
        $schedule_date = date('Y-m-d H:i:s', strtotime($request->schedule_date)) == '1970-01-01' ? null : date('Y-m-d H:i:s', strtotime($request->schedule_date));

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
        $obsp         = $request->obsp;
        $idcontract   = $request->idcontract;
        $idcompany    = $request->idcompany;

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
                'obsp'              => $obsp,

                'idcontract'        => $idcontract,
                'idcompany'         => $idcompany,

            ]);
        return response()->json(['status' => 'ok', 'response' => true, 'result' => $insert], 200);
    }

    public function update(Request $request)
    {
        $request->input('application_date');
        $csc              = $request->input('csc');
        $application_date = date('Y-m-d H:i:s', strtotime($request->input('application_date'))) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->input('application_date')));
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
        $schedule_date = date('Y-m-d H:i:s', strtotime($request->schedule_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->schedule_date));

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
        $obsp         = $request->obsp;

        $idcontract = $request->idcontract;
        $idcompany  = $request->idcompany;

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
                'obsp'              => $obsp,
                'idcontract'        => $idcontract,
                'idcompany'         => $idcompany,
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

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                      ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                           WHEN inspecion.use = "2" THEN "Comercial"
                          ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                          WHEN inspecion.type = "2" THEN "Periodica"
                          WHEN inspecion.type = "3" THEN "Reformaca"
                         ELSE "Solicitud del Usuario" END) AS name_type'),

                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"),

                DB::raw("(select MAX(certified_number)  from certificate  where inspecion_csc=inspecion.csc) as certificate")

            )
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

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = 1 THEN "Residencial"
                       WHEN inspecion.use = 2 THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = 1 THEN "Previa"
                      WHEN inspecion.type = 2 THEN "Periodica"
                      WHEN inspecion.type = 3 THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"),
                DB::raw("(select MAX(certified_number)  from certificate  where inspecion_csc=inspecion.csc) as certificate"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_cert(Request $request)
    {
        $cert = $request->cert;

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->leftjoin('certificate', 'certificate.inspecion_csc', '=', 'inspecion.csc')
            ->where('certificate.certified_number', 'like', '%' . $cert . '%')
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('certificate.*', 'inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.type = "2" THEN "Periodica"
                      WHEN inspecion.type = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"),
                DB::raw("(select MAX(certified_number)  from certificate  where inspecion_csc=inspecion.csc) as certificate"))
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

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.type = "2" THEN "Periodica"
                      WHEN inspecion.type = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"),
                DB::raw("(select MAX(certified_number)  from certificate  where inspecion_csc=inspecion.csc) as certificate"))
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
            ->where('client.name_client', 'like', '%' . $client . '%')
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.type = "2" THEN "Periodica"
                      WHEN inspecion.type = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"),
                DB::raw("(select MAX(certified_number)  from certificate  where inspecion_csc=inspecion.csc) as certificate"))
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

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
                DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
                  ELSE "Gpl" END) AS gastype'),
                DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
                       WHEN inspecion.use = "2" THEN "Comercial"
                      ELSE "Industrial" END) AS name_use'),

                DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
                      WHEN inspecion.type = "2" THEN "Periodica"
                      WHEN inspecion.type = "3" THEN "Reformaca"
                     ELSE "Solicitud del Usuario" END) AS name_type'),
                DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"),
                DB::raw("(select MAX(certified_number)  from certificate  where inspecion_csc=inspecion.csc) as certificate"))
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function create_certificate(Request $request)
    {

        $idcertificate     = $request->idcertificate;
        $inspecion_csc     = $request->inspecion_csc;
        $inspection_date   = date('Y-m-d H:i:s', strtotime($request->inspection_date)) == '1970-01-01' ? null : date('Y-m-d H:i:s', strtotime($request->inspection_date));
        $certified_number  = $request->certified_number;
        $inspection_result = $request->inspection_result;
        $inspector         = $request->inspector;
        $proof_payment     = $request->proof_payment;
        $value             = $request->value;
        $distribution_date = date('Y-m-d H:i:s', strtotime($request->distribution_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->distribution_date));
        $sicerco_date      = date('Y-m-d H:i:s', strtotime($request->sicerco_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->sicerco_date));
        $epm_date          = date('Y-m-d H:i:s', strtotime($request->epm_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->epm_date));
        $download_date     = date('Y-m-d H:i:s', strtotime($request->download_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->download_date));
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
        $inspection_date   = date('Y-m-d H:i:s', strtotime($request->inspection_date)) == null ? null : date('Y-m-d H:i:s', strtotime($request->inspection_date));
        $certified_number  = $request->certified_number;
        $inspection_result = $request->inspection_result;
        $inspector         = $request->inspector;
        $proof_payment     = $request->proof_payment;
        $value             = $request->value;

        $distribution_date = date('Y-m-d H:i:s', strtotime($request->distribution_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->distribution_date));
        $sicerco_date      = date('Y-m-d H:i:s', strtotime($request->sicerco_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->sicerco_date));
        $epm_date          = date('Y-m-d H:i:s', strtotime($request->epm_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->epm_date));
        $download_date     = date('Y-m-d H:i:s', strtotime($request->download_date)) == '1970-01-01 00:00:00' ? null : date('Y-m-d H:i:s', strtotime($request->download_date));
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

        echo $date = date('Y-m-d', strtotime($request->date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->date));
        $state     = $request->state;

        if ($date == null) {
            $search = DB::table('inspecion')
                ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
                ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
                ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
                ->where('inspecion.state', $state)
            // ->whereNull('inspecion.schedule_date')
            // ->orWhereNull('inspecion.schedule_date')
            // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

                ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
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
                ->paginate(10);
        } else {
            $search = DB::table('inspecion')
                ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
                ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
                ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
                ->where('inspecion.state', $state)
                ->where('inspecion.schedule_date', 'like', '%' . $date . '%')

            // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

                ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
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
                ->paginate(10);
        }

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_programming_data(Request $request)
    {

        $date  = date('Y-m-d', strtotime($request->date)) == '1970-01-01' ? null : date('Y-m-d', strtotime($request->date));
        $state = $request->state;

        if ($date == null) {
            $search = DB::table('inspecion')
                ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
                ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
                ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
                ->where('inspecion.state', $state)
                ->whereNull('inspecion.schedule_date')
            // ->orWhereNull('inspecion.schedule_date')
            // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

                ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
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
                ->paginate(10);
        } else {
            $search = DB::table('inspecion')
                ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
                ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
                ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
                ->where('inspecion.state', $state)
                ->where('inspecion.schedule_date', 'like', '%' . $date . '%')

            // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

                ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
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
                ->paginate(10);
        }
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

        $search = DB::table('image_certificate')
            ->where('certificate_idcertificate', $idcertificate)
            ->select('image_certificate.*')
            ->paginate(5);
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function search_pdf(Request $request)
    {

        $idcertificate = $request->idcertificate;

        $search = DB::table('image_certificate')
            ->where('certificate_idcertificate', $idcertificate)
            ->where('pdf', 1)
            ->select('image_certificate.*')
            ->paginate(5);
        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function delete_images(Request $request)
    {

        $idimage_certificate = $request->idimage_certificate;
        $url                 = $request->url;
        $name_image          = $request->name_image;

        // echo $carpeta = $url . $name_image;

        // File::delete($carpeta);

        // $path = Storage::disk('s3')->put();

        if (Storage::disk('s3')->exists('CERTIFICADOS/' . $name_image)) {
            Storage::disk('s3')->delete('CERTIFICADOS/' . $name_image);
            $response = true;
            $delete   = DB::table('image_certificate')
                ->where('idimage_certificate', $idimage_certificate)
                ->delete();
        } else {
            $response = false;
        }

        return response()->json(['status' => 'ok', 'response' => $response], 200);
    }

    public function search_programing(Request $request)
    {
        $contrat = $request->contrat;
        DB::statement("SET lc_time_names = 'es_ES'");
        $search_asi = DB::table('inspecion')
        // ->join('employees', 'employees.idemployees', '=', 'odi.idinspetor')
        // ->where('employees.identification', $user)
            ->where('inspecion.state', 2)
            ->groupBy('inspecion.schedule_date')
            ->select('inspecion.schedule_date', DB::raw('date_format(inspecion.schedule_date, "%M %d") as date'), DB::raw('count(inspecion.csc) as total'))
            ->get();

        return response()->json(['status' => 'ok', 'response' => $search_asi], 200);
    }

    public function search_report(Request $request)
    {

        $schedule_date = $request->schedule_date;
        $idcontract    = $request->contrat;

        // $search = DB::table('inspecion')
        //     ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
        //     ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
        //     ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
        // // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )
        //     ->where('schedule_date', $schedule_date)
        //     ->where('idcontract', $idcontract)
        //     ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
        //         DB::raw('(CASE WHEN inspecion.gas_type = "1" THEN "Natural"
        //               ELSE "Gpl" END) AS gastype'),
        //         DB::raw('(CASE WHEN inspecion.use = "1" THEN "Residencial"
        //                    WHEN inspecion.use = "2" THEN "Comercial"
        //                   ELSE "Industrial" END) AS name_use'),

        //         DB::raw('(CASE WHEN inspecion.type = "1" THEN "Previa"
        //                   WHEN inspecion.use = "2" THEN "Periodica"
        //                   WHEN inspecion.use = "3" THEN "Reformaca"
        //                  ELSE "Solicitud del Usuario" END) AS name_type'),
        //         DB::raw("(SELECT CONCAT(name,' ',last_name) FROM employees where employees.idemployees=inspecion.scheduled_to) AS name_scheduled_to"))
        //     ->paginate(5);

        // return response()->json(['status' => 'ok', 'response' => $serach], 200);

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )
            ->where('schedule_date', $schedule_date)
            ->where('inspecion.idcontract', $idcontract)
            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
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

    public function search_routes(Request $request)
    {
        $csc      = $request->csc;
        $contract = $request->contract;

        $search = DB::table('inspecion')
            ->leftjoin('client_account', 'client_account.idclient_account', 'inspecion.idclient_account')
            ->leftjoin('client', 'client.idclient', 'client_account.client_idclient')
            ->leftjoin('municipality', 'municipality.idmunicipality', '=', 'client_account.city')
            ->where('inspecion.csc', $csc)
            ->where('inspecion.idcontract', $contract)
        // ->leftjoin( 'employees', 'employees.idemployees', '=', 'client_account.scheduled_to' )

            ->select('inspecion.*', 'inspecion.state as i_state', 'client_account.*', 'client.*', 'municipality.name_municipality', 'municipality.id_dane',
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
            ->first();

        return response()->json(['status' => 'ok', 'response' => $search], 200);
    }

    public function import(Request $request)
    {
        $data = $request->input('data');

        for ($i = 0; $i < count($data); $i++) {

            $A = isset($data[$i]['A']) ? $data[$i]['A'] : null; //Fecha De Solicitud
            $B = isset($data[$i]['B']) ? $data[$i]['B'] : null;
            $C = isset($data[$i]['C']) ? $data[$i]['C'] : null; //QUIEN SOLICITA
            $D = isset($data[$i]['C']) ? $data[$i]['D'] : null; //QUIEN ATIENDE
            $E = isset($data[$i]['E']) ? $data[$i]['E'] : null; //DIRECCION
            $F = isset($data[$i]['F']) ? $data[$i]['F'] : null; //TELEFONO
            $G = isset($data[$i]['G']) ? $data[$i]['G'] : null; //TIPO DE INSPECCIÓN
            $H = isset($data[$i]['H']) ? $data[$i]['H'] : null; //USO
            $I = isset($data[$i]['I']) ? $data[$i]['I'] : null; //BARRIO
            $J = isset($data[$i]['J']) ? $data[$i]['J'] : null; //MUNICIPIO
            $K = isset($data[$i]['K']) ? $data[$i]['K'] : null; //ZONA
            $L = isset($data[$i]['L']) ? $data[$i]['L'] : null; //VALOR REVISION
            $M = isset($data[$i]['M']) ? $data[$i]['M'] : null; //JORNADA
            $N = isset($data[$i]['N']) ? $data[$i]['N'] : null; //OBSERVACIONES
            $O = isset($data[$i]['O']) ? $data[$i]['O'] : null; //Radicado Llamada
            $P = isset($data[$i]['P']) ? $data[$i]['P'] : null; //ORIGEN
            $Q = isset($data[$i]['Q']) ? $data[$i]['Q'] : null; //REFERIDO POR REFERIDO / GAMA
            $R = isset($data[$i]['R']) ? $data[$i]['R'] : null; //FECHA PROGRAMADO
            $S = isset($data[$i]['S']) ? $data[$i]['S'] : null; //CÓDIGO DE INSTALCIÓN
            $T = isset($data[$i]['T']) ? $data[$i]['T'] : null; //FECHA DE DESCARGUE
            // PRIMER CERTIFICADO
            $U  = isset($data[$i]['U']) ? $data[$i]['U'] : null; //CERTIFICADO
            $V  = isset($data[$i]['V']) ? $data[$i]['V'] : null; //FECHA DE INSPECCIÓN 1
            $W  = isset($data[$i]['W']) ? $data[$i]['W'] : null; //NOMBRE DE INSTALADOR
            $X  = isset($data[$i]['X']) ? $data[$i]['X'] : null; //SE REVISA LINEA MATRIZ
            $Y  = isset($data[$i]['Y']) ? $data[$i]['Y'] : null; //INTENTO DE VISITA
            $Z  = isset($data[$i]['Z']) ? $data[$i]['Z'] : null; //RESULTADO DE INSPECCIÓN
            $AA = isset($data[$i]['AA']) ? $data[$i]['AA'] : null; //INSPECTOR
            $AB = isset($data[$i]['AB']) ? $data[$i]['AB'] : null; //COMPROBANTE DE PAGO VISITA 1
            $AC = isset($data[$i]['AC']) ? $data[$i]['AC'] : null; //VALOR
            $AD = isset($data[$i]['AD']) ? $data[$i]['AD'] : null; //FECHA DE INGRESO A DISTRIBUIDOR 1
            // SEGUNDO CERTIFICADO
            $AE = isset($data[$i]['AE']) ? $data[$i]['AE'] : null; //FECHA DE INSPECCIÓN 2
            $AF = isset($data[$i]['AF']) ? $data[$i]['AF'] : null; //RESULTADO DE INSPECCIÓN
            $AG = isset($data[$i]['AG']) ? $data[$i]['AG'] : null; //No. CERTIFICADO
            $AH = isset($data[$i]['AH']) ? $data[$i]['AH'] : null; //RECIBO PRODUCTIVIDAD
            $AI = isset($data[$i]['AI']) ? $data[$i]['AI'] : null; //INSPECTOR
            $AJ = isset($data[$i]['AJ']) ? $data[$i]['AJ'] : null; //COMPROBANTE DE PAGO VISITA 2
            $AK = isset($data[$i]['AK']) ? $data[$i]['AK'] : null; //VALOR 2
            $AL = isset($data[$i]['AL']) ? $data[$i]['AL'] : null; //FECHA DE INGRESO A DISTRIBUIDOR 2

            //TERCER CERTIFICADO
            $AM = isset($data[$i]['AM']) ? $data[$i]['AM'] : null; //3 VISITA  FECHA DE INSPECCIÓN
            $AN = isset($data[$i]['AN']) ? $data[$i]['AN'] : null; //RESULTADO DE INSPECCIÓN
            $AO = isset($data[$i]['AO']) ? $data[$i]['AO'] : null; //No. CERTIFICADO
            $AP = isset($data[$i]['AP']) ? $data[$i]['AP'] : null; ////INSPECTOR
            $AQ = isset($data[$i]['AQ']) ? $data[$i]['AQ'] : null; //COMPROBANTE DE PAGO VISITA 3
            $AR = isset($data[$i]['AR']) ? $data[$i]['AR'] : null; //VALOR 3

            //CUARTO CERTIFICADO
            $AS = isset($data[$i]['AS']) ? $data[$i]['AS'] : null; //4 VISITA  FECHA DE INSPECCIÓN
            $AT = isset($data[$i]['AT']) ? $data[$i]['AT'] : null; //RESULTADO DE INSPECCIÓN
            $AU = isset($data[$i]['AU']) ? $data[$i]['AU'] : null; //No. CERTIFICADO
            $AV = isset($data[$i]['AV']) ? $data[$i]['AV'] : null; //INSPECTOR
            $AW = isset($data[$i]['AW']) ? $data[$i]['AW'] : null; //FECHA DE INGRESO A SICERCO
            $AX = isset($data[$i]['AX']) ? $data[$i]['AX'] : null; //FECHA RADICACION A EPM

            $AY = isset($data[$i]['AY']) ? $data[$i]['AY'] : null; //OBSERVACIONES CERTIFICADO 1
            $AZ = isset($data[$i]['AZ']) ? $data[$i]['AZ'] : null; //ABSERVACIONES CERTIFICADO 2

            // consultamos la direcion si no existe creamos el cliente

            if ($J == 'ITAGUI') {

                $J = 'Itagui';
            }
            if ($J == 'ITAGÜÍ') {

                $J = 'Itagui';
            }

            echo $J;
            //consultar el municipio
            $location = $this->city($J);

            if ($location) {
                $idmunicipality = $location['idmunicipality'];
                $id_departament = $location['id_departament'];
            } else {

                $idmunicipality = null;
                $id_departament = null;
            }

            $search_address = DB::table('client_account')
                ->where('address', $E)
                ->first();

            if ($search_address) {

                $client_idclient = $search_address->client_idclient;
                $address         = $search_address->idclient_account;

            } else {

                $create_cliente = DB::table('client')
                    ->insertGetid([
                        'name_client' => $C,
                        'phone'       => $F,
                        'state'       => 1,
                    ]);

                $client_idclient = $create_cliente;

                $create_client_account = DB::table('client_account')
                    ->insertGetid([
                        'client_idclient' => $client_idclient,
                        'address'         => $E,
                        'city'            => $location['idmunicipality'],
                        'iddepartment'    => $location['id_departament'],
                        'state'           => 1,
                    ]);

                $client_idclient = $create_cliente;
                $address         = $create_client_account;
            }

            // creacion der servicio

            if ($M == 'AM') {
                $M = 1;
            }

            if ($M == 'PM') {
                $M = 2;
            }

            if ($M == 'TR DIA') {
                $M = 3;
            }

            if ($G == 'PREVIA') {
                $G = 1;
            }
            if ($G == 'PERIODICA') {
                $G = 2;
            }
            if ($G == 'REFORMA') {
                $G = 3;
            }

            if ($G == 'SOLICITUD DE USUARIO') {
                $G = 4;
            }

            if ($H == 'RESIDENCIAL') {

                $H = 1;
            }

            if ($H == 'COMERCIAL') {

                $H = 2;
            }

            if ($H == 'INDUSTRIAL') {

                $H = 3;
            }

            $create_inspetion = DB::table('inspecion')
                ->insertGetid([
                    'application_date' => $A,
                    'who_request'      => $C,
                    'who_attends'      => $D,
                    'address'          => $address,
                    'phone'            => $F,
                    'city'             => $location['idmunicipality'],

                    'neighborhood'     => $I,
                    'zone'             => $K,
                    'value_review'     => $L,
                    'attention_day'    => $M,
                    'filed_call'       => $O,
                    'referred'         => $Q,
                    'origin'           => $P,
                    'schedule_date'    => $R,
                    'number_visits'    => $Y,
                    'installer_name'   => $W,
                    // 'client'           => $client_idclient,
                    'obsp'             => $N,
                    'code_ins'         => $S,
                    'use'              => $H,
                    'type'             => $G,
                    'idclient_account' => $address,
                    'state'            => 4,

                ]);

            if ($U) { //creacion del primer certificado
                if ($X == 'SI') { // se rvisa linea matriz
                    $X = 1;
                } else {
                    $X = 2;
                }

                if ($Z == 'CONFORME ') { //resultado inspacion 1
                    $Z = '1';
                } else {
                    $Z = '2';
                }

                $create_certificateOne = DB::table('certificate')
                    ->insert([

                        'inspection_date'   => $V,
                        'certified_number'  => $U,
                        'inspection_result' => $Z,
                        // 'inspector'=>,
                        'proof_payment'     => $AB,
                        'inspecion_csc'     => $create_inspetion,
                        'value'             => $AC,
                        'distribution_date' => $AD,
                        'sicerco_date'      => $AW,
                        'epm_date'          => $AX,
                        'download_date'     => $T,
                        'check_matrix'      => $X,
                        // 'productivity'=>,
                        'name_inspector'    => $AA,
                        'obs'               => $AY,
                    ]);

            }

            if ($AG) { //creacion del segundo certificado
                if ($AF == 'CONFORME ') { //resultado inspacion 2
                    $AF = '1';
                } else {
                    $AF = '2';
                }

                $create_certificateOne = DB::table('certificate')
                    ->insert([

                        'inspection_date'   => $AE,
                        'certified_number'  => $AG,
                        'inspection_result' => $AF,
                        // 'inspector'=>,
                        'proof_payment'     => $AJ, //Comprobante de Pago
                        'inspecion_csc'     => $create_inspetion,
                        'value'             => $AK,
                        'distribution_date' => $AL,
                        'sicerco_date'      => $AW,
                        'epm_date'          => $AX,
                        // 'download_date'     => $T,
                        // 'check_matrix'      => $X,
                        // 'productivity'=>,
                        'name_inspector'    => $AI,
                        'obs'               => $AZ,
                    ]);
            }

            if ($AO) { //creacion del Tercer certificado
                if ($AN == 'CONFORME ') { //resultado inspacion 3
                    $AN = '1';
                } else {
                    $AN = '2';
                }

                $create_certificateOne = DB::table('certificate')
                    ->insert([

                        'inspection_date'   => $AM,
                        'certified_number'  => $AO,
                        'inspection_result' => $AN,
                        // 'inspector'=>,
                        'proof_payment'     => $AQ, //Comprobante de Pago
                        'inspecion_csc'     => $create_inspetion,
                        'value'             => $AR,
                        // 'distribution_date' => $AL,
                        'sicerco_date'      => $AW,
                        'epm_date'          => $AX,
                        // 'download_date'     => $T,
                        // 'check_matrix'      => $X,
                        // 'productivity'=>,
                        'name_inspector'    => $AP,
                    ]);
            }

            if ($AU) { //creacion del cuarto certificado
                if ($AT == 'CONFORME ') { //resultado inspacion 4
                    $AT = '1';
                } else {
                    $AT = '2';
                }

                $create_certificateOne = DB::table('certificate')
                    ->insert([

                        'inspection_date'   => $AS,
                        'certified_number'  => $AO,
                        'inspection_result' => $AT,
                        // 'inspector'=>,
                        // 'proof_payment'     => $AQ, //Comprobante de Pago
                        'inspecion_csc'     => $create_inspetion,
                        // 'value'             => $AR,
                        // 'distribution_date' => $AL,
                        'sicerco_date'      => $AW,
                        'epm_date'          => $AX,
                        // 'download_date'     => $T,
                        // 'check_matrix'      => $X,
                        // 'productivity'=>,
                        'name_inspector'    => $AV,
                    ]);
            }

        }
    }

    public function city($J)
    {
        $search = DB::table('municipality')
            ->where('name_municipality', strtolower($J))
            ->first();

        if ($search) {
            $location = [
                'idmunicipality' => $search->idmunicipality,
                'id_departament' => $search->id_departament,
            ];

        } else {
            $location = null;
        }

        return $location;
    }

}
