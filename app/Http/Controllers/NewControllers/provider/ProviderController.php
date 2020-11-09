<?php

namespace App\Http\Controllers\NewControllers\provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    public function getLis()
    {

        $providerList = DB::table('providers')
            ->select('providers.*')
            ->paginate(5);

        return response()->json(['status' => 'ok', 'response' => $providerList], 200);
    }

    public function create(Request $request)
    {

        $id_type          = $request->input('id_type');
        $id               = $request->input('id');
        $name_provider    = $request->input('name_provider');
        $address_provider = $request->input('address_provider');
        $mail_provider    = $request->input('mail_provider');
        $phone_provider   = $request->input('phone_provider');
        $cel_provider     = $request->input('cel_provider');
        $contact          = $request->contact;

        $insert = DB::table('providers')
            ->insert([
                'id_type'          => $id_type,
                'id'               => $id,
                'name_provider'    => $name_provider,
                'address_provider' => $address_provider,
                'mail_provider'    => $mail_provider,
                'phone_provider'   => $phone_provider,
                'cel_provider'     => $cel_provider,
                'contact'          => $contact,
            ]);
        return response()->json(['status' => 'ok', 'response' => $insert], 200);
    }

    public function update(Request $request)
    {

        $idproviders = $request->id;

        $id_type          = $request->input('data.id_type');
        $id               = $request->input('data.id');
        $name_provider    = $request->input('data.name_provider');
        $address_provider = $request->input('data.address_provider');
        $mail_provider    = $request->input('data.mail_provider');
        $phone_provider   = $request->input('data.phone_provider');
        $cel_provider     = $request->input('data.cel_provider');
        $contact          = $request->input('data.contact');

        $update = DB::table('providers')
            ->where('idproviders', $idproviders)
            ->update([
                'id_type'          => $id_type,
                'id'               => $id,
                'name_provider'    => $name_provider,
                'address_provider' => $address_provider,
                'mail_provider'    => $mail_provider,
                'phone_provider'   => $phone_provider,
                'cel_provider'     => $cel_provider,
                'contact'          => $contact,
            ]);
        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function delete(Request $request)
    {

        $id_provider = $request->id;

        $delete = DB::table('providers')
            ->where('idproviders', $id_provider)
            ->delete();

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function search_provider(Request $request)
    {

        $name = $request->name;

        $select = DB::table('providers')
            ->where('name_provider', 'like', '%' . $name . '%')
            ->select('providers.*')
            ->paginate('5');
        return response()->json(['status' => 'ok', 'response' => $select], 200);
    }
}
