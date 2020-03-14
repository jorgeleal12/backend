<?php

namespace App\Http\Controllers\NewControllers\UploadImage;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UploadController extends Controller
{
    //

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

        return response()->json(['status' => 'ok', 'response' => 1], 200);
    }

    public function upload_image_certificate(Request $request)
    {

        $image         = $_FILES;
        $idcertificate = $request->idcertificate;

        $search = DB::table('inspecion')
            ->leftjoin('certificate', 'certificate.inspecion_csc', 'inspecion.csc')
            ->where('idcertificate', $idcertificate)
            ->first();

        $id_inspection = $search->csc;
        $idcontract    = $search->idcontract;

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
        $carpeta  = public_path('/public/inspection/' . $idcontract . '/' . $id_inspection . '/' . $idcertificate . '/');

        if (!File::exists($carpeta)) {

            $path = public_path('/public/inspection/' . $idcontract . '/' . $id_inspection . '/' . $idcertificate . '/');
            File::makeDirectory($path, 0777, true);

        }
        $url = 'inspection/' . $idcontract . '/' . $id_inspection . '/' . $idcertificate . '/';

        move_uploaded_file($file, $carpeta . $namefile);

        $insert = DB::table('image_certificate')
            ->insert([
                'url'                       => $url,
                'name'                      => $namefile,
                'certificate_idcertificate' => $idcertificate,
            ]);

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }

    public function upload_pdf_certificate(Request $request)
    {

        $image         = $_FILES;
        $idcertificate = $request->idcertificate;

        $search = DB::table('inspecion')
            ->leftjoin('certificate', 'certificate.inspecion_csc', 'inspecion.csc')
            ->where('idcertificate', $idcertificate)
            ->first();

        $id_inspection = $search->csc;
        $idcontract    = $search->idcontract;

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
        $carpeta  = public_path('/public/inspection/' . $idcontract . '/' . $id_inspection . '/' . $idcertificate . '/');

        if (!File::exists($carpeta)) {

            $path = public_path('/public/inspection/' . $idcontract . '/' . $id_inspection . '/' . $idcertificate . '/');
            File::makeDirectory($path, 0777, true);

        }
        $url = 'inspection/' . $idcontract . '/' . $id_inspection . '/' . $idcertificate . '/';

        move_uploaded_file($file, $carpeta . $namefile);

        $insert = DB::table('image_certificate')
            ->insert([
                'url'                       => $url,
                'name'                      => $namefile,
                'certificate_idcertificate' => $idcertificate,
                'pdf'                       => 1,
            ]);

        return response()->json(['status' => 'ok', 'response' => true], 200);
    }
}
