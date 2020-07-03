<?php

namespace App\Http\Controllers\NewControllers\Soap;

use App\Http\Controllers\Controller;
use SoapClient;

class SoapController extends Controller
{
    //
    public function prueba()
    {
        $opts = array(
            'ssl' => array('ciphers' => 'RC4-SHA', 'verify_peer' => false, 'verify_peer_name' => false),
        );
        $params = array('encoding' => 'UTF-8', 'verifypeer' => false, 'verifyhost' => false, 'soap_version' => SOAP_1_2, 'trace' => 1, 'exceptions' => 1, "connection_timeout" => 180, 'stream_context' => stream_context_create($opts));

        $url = "http://latam.officetrack.com/services/webservices.asmx?WSDL";
        try {
            $client = new SoapClient($url, $params);
            dd($client->GetTaskDetails(['userName' => 'Felipe.Almensa', 'password' => 'Abril123', 'taskNumber' => '5180883']));
        } catch (SoapFault $fault) {
            echo '<br>' . $fault;
        }

    }
}
