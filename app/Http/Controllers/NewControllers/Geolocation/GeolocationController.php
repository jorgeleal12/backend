<?php

namespace App\Http\Controllers\NewControllers\Geolocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use proj4php\Point;
use proj4php\Proj4php;
use proj4php\Proj;

class GeolocationController extends Controller {
    //

    public function medellin( Request $request ) {
        $address = $request->address;
        $city    = $request->city;

        $address = urlencode( $address );

        $string  = '';
        $fullurl = "https://www.medellin.gov.co/MapGIS/Geocod/AjaxGeocod?accion=2&valor={$address}&f=json";
        $string .= file_get_contents( $fullurl );
        // get json content
        $json_a = json_decode( $string, true );
        //json decoder

        $y = $json_a['y'];
        $x = $json_a['x'];

        $proj4 = new Proj4php();

        // Create two different projections.
        $projL93   = new Proj( 'PROJCS["MAGNA-SIRGAS / Colombia Bogota zone",GEOGCS["MAGNA-SIRGAS",DATUM["Marco_Geocentrico_Nacional_de_Referencia",SPHEROID["GRS 1980",6378137,298.257222101,AUTHORITY["EPSG","7019"]],TOWGS84[0,0,0,0,0,0,0],AUTHORITY["EPSG","6686"]],PRIMEM["Greenwich",0,AUTHORITY["EPSG","8901"]],UNIT["degree",0.0174532925199433,AUTHORITY["EPSG","9122"]],AUTHORITY["EPSG","4686"]],PROJECTION["Transverse_Mercator"],PARAMETER["latitude_of_origin",4.596200416666666],PARAMETER["central_meridian",-74.07750791666666],PARAMETER["scale_factor",1],PARAMETER["false_easting",1000000],PARAMETER["false_northing",1000000],UNIT["metre",1,AUTHORITY["EPSG","9001"]],AUTHORITY["EPSG","3116"]]', $proj4 );
        $projWGS84 = new Proj( 'EPSG:4326', $proj4 );

        // Create a point.
        $pointSrc = new Point( $x, $y, $projL93 );

        // Transform the point between datums.
        $pointDest = $proj4->transform( $projWGS84, $pointSrc );

        $datos          = $pointDest->toShortString();
        $onlyconsonants = str_replace( ' ', ',', $datos );

        $lat = explode( ',', $onlyconsonants );

        return response()->json( ['status' => 'ok', 'x' => $lat[0], 'y' => $lat[1], 'dir' => $json_a['DIR']], 200 );
    }

    public function geocodegoogle( Request $request ) {
        $address = $request->address;
        $city    = $request->city;
        $address = $address;
        $address = urlencode( $address );
        $city    = urlencode( $city );
        $address = str_replace( '+', '%20', $address );

        $string  = '';
        $fullurl = "https://maps.googleapis.com/maps/api/geocode/json?address={$address},+{$city},+Antioquia&key=AIzaSyBpuE2yQcSPdrF1nsTFzapSk1CAfofRmTU";
        $string .= file_get_contents( $fullurl );
        // get json content
        $json_a = json_decode( $string, true );
        //json decoder

        // var_dump( $json_a['results'][0]['geometry'] );
        // return $cor = $json_a['results'][0]['geometry']['location']['lng'] . ',' . $json_a['results'][0]['geometry']['location']['lat'];

        return response()->json( ['status' => 'ok', 'x' => $json_a['results'][0]['geometry']['location']['lng'], 'y' => $json_a['results'][0]['geometry']['location']['lat'], 'dir' => $json_a['results'][0]['formatted_address']], 200 );
    }

    public function geocode_dian( Request $request ) {
        $address         = $request->address;
        $city            = $request->city;
        $position        = $request->position;
        $position_number = $request->position_number;
        $via_generadora  = $request->via_generadora;
        $dane            = $request->dane;
        $address         = $address;

        $position     = str_replace( 'CR', 'KR', $position );
        $viaprincipal = $position . '%20' . $position_number;
        $address      = urlencode( $address );
        $string1      = 'codigo_municipio=' . $dane . '&viaprincipal=';
        $string       = '';
        $fullurl      = "http://geoportal.dane.gov.co/laboratorio/serviciosjson/catastro/catastro.php?codigo_departamento=05&codigo_municipio={$dane}&viaprincipal={$viaprincipal}&via_generadora={$via_generadora}&cuadrante=NO%20APLICA&clase=1";

        $string .= file_get_contents( $fullurl );
        // get json content
        $json_a = json_decode( $string, true );
        //json decoder

        // var_dump( $json_a );
        // return $cor = $json_a['results'][0]['geometry']['location']['lng'] . ',' . $json_a['results'][0]['geometry']['location']['lat'];

        return response()->json( ['status' => 'ok', 'x' => $json_a['resultado'][0]['LONGITUD'], 'y' => $json_a['resultado'][0]['LATITUD'], 'dir' => $json_a['resultado'][0]['CLASE']], 200 );
    }
}
