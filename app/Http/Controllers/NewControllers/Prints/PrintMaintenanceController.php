<?php

namespace App\Http\Controllers\NewControllers\Prints;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrintMaintenanceController extends Fpdf
{
    //class PrintMaintenanceController extends Controller

    //

    function print(Request $request) {
        // $this->Image('../public/imagenes/documentos/com-1.jpg', '2', '2', '205', '280', 'JPG');

        $idleaves = $request->idleaves;

        $search = DB::table('leaves')
            ->leftjoin('material', 'material.idmaterials', 'leaves.id_code')
            ->leftjoin('barcode', 'barcode.idbarcode', 'leaves.idbarcode')
            ->leftjoin('providers', 'providers.idproviders', 'leaves.idproviders')
            ->where('idleaves', $idleaves)
            ->first();
        //name_provider
        $acquisition_date = date('Y-m-d', strtotime($search->acquisition_date));

        $search_image = DB::table('image_items')
            ->where('leaves_idleaves', $idleaves)
            ->take(4)
            ->get();

        $search_maintenance = DB::table('maintenance')
            ->where('leaves_idleaves', $idleaves)
            ->take(6)
            ->get();

        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Times', '', 12);
        $this->SetAutoPageBreak(true, 10);
        $this->Image('../public/images/formato1.jpg', '2', '2', '205', '280', 'JPG');

        $row = 7;
        foreach ($search_image as $search_image) {

            $document= explode('.',$search_image->name_image);
            if($document[1]!='pdf'){
                $this->Image('https://ares-path.s3.amazonaws.com/Items/' . $search_image->name_image, $row, 44, 48, 40);
                $this->Cell(4, 6, '', 0, 0);
                $row = $row + 48;
                $row++;
            }
        }

        $name_materials = str_replace('”','"',$search->name_materials);
        $service_provided = str_replace('”','"',$search->service_provided);
        $name_materials = str_replace('“','"',$name_materials);
        $service_provided = str_replace('“','"',$service_provided);
        $this->Ln(23);
        $this->SetFont('Arial', '', 7);
        $this->Cell(38, 6, '', 0, 0);
        $this->Cell(23, 3.2,  utf8_decode($name_materials), 0, 0); 
        $this->Ln(5.5);
        $this->SetFont('Arial', '', 7);
        $this->Cell(4, 6, '', 0, 0);
        $this->Cell(23, 3.2,  utf8_decode($search->code), 0, 0);

        $this->Ln(49.5);
        $this->SetFont('Arial', '', 7);
        $this->Cell(22, 6, '', 0, 0);
        $this->Cell(70, 3.2, $acquisition_date, 0, 0);
        $this->Cell(23, 3.2,  utf8_decode($search->name_provider), 0, 0);

        $this->Ln(8.7);
        $this->SetFont('Arial', '', 7);
        $this->Cell(20, 6, '', 0, 0);
        // $this->Cell(23, 3.2,  utf8_decode($service_provided), 0, 0);
        $this->MultiCell(150, 3, utf8_decode($service_provided), 0, 1);

        $this->Ln(6);
        $this->SetFont('Arial', '', 7);
        $this->Cell(3, 6, '', 0, 0);
        $this->Cell(70, 3.2, $search->brand, 0, 0);
        $this->Cell(48, 6, '', 0, 0);

        $data_sheet = 'NO';
        $handbook   = 'NO';

        if ($search->data_sheet == 1) {

            $data_sheet = 'SI';
        }

        if ($search->handbook == 1) {

            $handbook = 'SI';
        }

        $this->Cell(22, 3.2, $data_sheet, 0, 0);
        $this->Cell(23, 3.2, $handbook, 0, 0);

        $this->Ln(4.5);
        $this->SetFont('Arial', '', 7);
        $this->Cell(5, 6, '', 0, 0);
        $this->Cell(15, 3.2, $search->serie, 0, 0);

        $line  = '3.2';
        $line2 = '8.4';
        $this->Ln($line2);
        foreach ($search_maintenance as $t) {

            $date_maintenance   = date('Y-m-d', strtotime($t->date_maintenance));
            $state_maintenance1 = '';
            $state_maintenance2 = '';

            if ($t->state_maintenance == 1) {
                $state_maintenance1 = 'X';
            }if ($t->state_maintenance == 2) {
                $state_maintenance2 = 'X';
            }

            $this->Ln();
            $this->Ln(0.4);
            $this->SetFont('Arial', '', 8);
            $this->Cell(2, 6, '', 0, 0);
            $this->Cell(60, 3.2, $date_maintenance, 0, 0);
            $this->Cell(23, 3.2, $state_maintenance2, 0, 0);

            $this->Ln($line);
            $this->SetFont('Arial', '', 7);
            $this->Cell(62, 6, '', 0, 0);
            $this->Cell(17, 3.2, $state_maintenance1, 0, 0);
            $this->Cell(40, 3.2, $t->who, 0, 0);
            $this->Cell(45, 6, '', 0, 0);
            $this->Cell(23, 3.2, $t->support, 0, 0);
            $this->Ln(7);

            $this->Cell(1, 6, '', 0, 0);
            $y = $this->GetY();
            $this->MultiCell(150, 3, utf8_decode($t->observations_responsable), 0, 1);
            $y2 = $this->GetY();

            $space = (isset($y2) ? $y2 - $y : 0) - 0;

            if ($space == 3) {

                $space = (isset($y2) ? $y2 - $y : 0) + 6;

            } else {

                $line2 = $line2 + 3;
            }
            // $this->SetXY(150, $y);
            //  $this->Cell(45, 6, $space.' y2 '.$y2.' y1 '. $y, 0, 0);
            $this->Ln($space);

            $line2 = $line2 + 3;

        }

        $header = ['Content-Type' => 'application/pdf'];

        return response($this->Output(), 200, $header);
    }

    public function download(Request $request)
    {
        // $this->Image('../public/imagenes/documentos/com-1.jpg', '2', '2', '205', '280', 'JPG');

        $idleaves = $request->idleaves;

        $search = DB::table('leaves')
            ->leftjoin('material', 'material.idmaterials', 'leaves.id_code')
            ->leftjoin('barcode', 'barcode.idbarcode', 'leaves.idbarcode')
            ->leftjoin('providers', 'providers.idproviders', 'leaves.idproviders')
            ->where('idleaves', $idleaves)
            ->first();
        //name_provider
        $acquisition_date = date('Y-m-d', strtotime($search->acquisition_date));

        $search_image = DB::table('image_items')
            ->where('leaves_idleaves', $idleaves)
            ->take(4)
            ->get();

        $search_maintenance = DB::table('maintenance')
            ->where('leaves_idleaves', $idleaves)
            ->take(6)
            ->get();

        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Times', '', 12);
        $this->SetAutoPageBreak(true, 10);
        $this->Image('../public/images/formato1.jpg', '2', '2', '205', '280', 'JPG');

        $row = 7;
        foreach ($search_image as $search_image) {

            $document= explode('.',$search_image->name_image);
            if($document[1]!='pdf'){
                $this->Image('https://ares-path.s3.amazonaws.com/Items/' . $search_image->name_image, $row, 44, 48, 40);
                $this->Cell(4, 6, '', 0, 0);
                $row = $row + 48;
                $row++;
            }
        }
        $name_materials = str_replace('”','"',$search->name_materials);
        $service_provided = str_replace('”','"',$search->service_provided);

        $name_materials = str_replace('“','"',$name_materials);
        $service_provided = str_replace('“','"',$service_provided);
        $this->Ln(23);
        $this->SetFont('Arial', '', 7);
        $this->Cell(38, 6, '', 0, 0);
        $this->Cell(23, 3.2, utf8_decode($name_materials), 0, 0);
        $this->Ln(5.5);
        $this->SetFont('Arial', '', 7);
        $this->Cell(4, 6, '', 0, 0);
        $this->Cell(23, 3.2, utf8_decode($search->code), 0, 0);

        $this->Ln(49.5);
        $this->SetFont('Arial', '', 7);
        $this->Cell(22, 6, '', 0, 0);
        $this->Cell(70, 3.2, $acquisition_date, 0, 0);
        $this->Cell(23, 3.2, utf8_decode($search->name_provider), 0, 0);

        $this->Ln(8.7);
        $this->SetFont('Arial', '', 8);
        $this->Cell(20, 6, '', 0, 0);
        $this->Cell(23, 3.2, utf8_decode($service_provided), 0, 0);

        $this->Ln(9.2);
        $this->SetFont('Arial', '', 8);
        $this->Cell(3, 6, '', 0, 0);
        $this->Cell(70, 3.2, $search->brand, 0, 0);
        $this->Cell(48, 6, '', 0, 0);

        $data_sheet = 'NO';
        $handbook   = 'NO';

        if ($search->data_sheet == 1) {

            $data_sheet = 'SI';
        }

        if ($search->handbook == 1) {

            $handbook = 'SI';
        }

        $this->Cell(22, 3.2, $data_sheet, 0, 0);
        $this->Cell(23, 3.2, $handbook, 0, 0);

        $this->Ln(4.5);
        $this->SetFont('Arial', '', 7);
        $this->Cell(5, 6, '', 0, 0);
        $this->Cell(15, 3.2, $search->serie, 0, 0);

        $line  = '3.2';
        $line2 = '8.4';
        $this->Ln($line2);
        foreach ($search_maintenance as $t) {

            $date_maintenance   = date('Y-m-d', strtotime($t->date_maintenance));
            $state_maintenance1 = '';
            $state_maintenance2 = '';

            if ($t->state_maintenance == 1) {
                $state_maintenance1 = 'X';
            }if ($t->state_maintenance == 2) {
                $state_maintenance2 = 'X';
            }

            $this->Ln();
            $this->Ln(0.4);
            $this->SetFont('Arial', '', 8);
            $this->Cell(2, 6, '', 0, 0);
            $this->Cell(60, 3.2, $date_maintenance, 0, 0);
            $this->Cell(23, 3.2, $state_maintenance2, 0, 0);

            $this->Ln($line);
            $this->SetFont('Arial', '', 8);
            $this->Cell(62, 6, '', 0, 0);
            $this->Cell(17, 3.2, $state_maintenance1, 0, 0);
            $this->Cell(40, 3.2, $t->who, 0, 0);
            $this->Cell(45, 6, '', 0, 0);
            $this->Cell(23, 3.2, $t->support, 0, 0);
            $this->Ln(7);

            $this->Cell(1, 6, '', 0, 0);
            $y = $this->GetY();
            $this->MultiCell(150, 3, utf8_decode($t->observations_responsable), 0, 1);
            $y2 = $this->GetY();

            $space = (isset($y2) ? $y2 - $y : 0) - 0;

            if ($space == 3) {

                $space = (isset($y2) ? $y2 - $y : 0) + 6;

            } else {

                $line2 = $line2 + 3;
            }
            // $this->SetXY(150, $y);
            //  $this->Cell(45, 6, $space.' y2 '.$y2.' y1 '. $y, 0, 0);
            $this->Ln($space);

            $line2 = $line2 + 3;

        }

        $header = ['Content-Type' => 'application/pdf'];

        $this->Output("sdsadasd.pdf", "D");
    }
}
