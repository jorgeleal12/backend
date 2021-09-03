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
            ->where('type_document', '!=', 'pdf')
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
           // if($search_image->type_document!='pdf'){
         
                $this->Image($search_image->url, $row, 44, 48, 40);
                $this->Cell(4, 6, '', 0, 0);
                $row = $row + 48;
                $row++;
           // }
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
        $this->Cell(23, 3.2,  utf8_decode($service_provided), 0, 0);

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

        $line  = '3';
        $line2 = '8.4';
        $this->Ln($line2);
        foreach ($search_maintenance as $t) {

            $date_maintenance   = date('Y-m-d', strtotime($t->date_maintenance));
            $state_maintenance1 = '';
            $state_maintenance2 = '';
            $name_maintenance = '';

            if ($t->maintenance_type == 1) {
                $state_maintenance1 = 'X';
                $name_maintenance = 'Correctivo';
            }if ($t->maintenance_type == 2) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Preventivo';
            }
            if ($t->maintenance_type == 3) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Certificación equipos';
            }
            if ($t->maintenance_type == 4) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Calibración y puesta a punto';
            }
            if ($t->maintenance_type == 5) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Ensayo dielectrico';
            }
            if ($t->maintenance_type == 6) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Pruebas de resistencias';
            }
            if ($t->maintenance_type == 7) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Ensayos y pruebas';
            }
            

            $this->Ln();
            $this->Ln(0.3);
            $this->SetFont('Arial', '', 8);
            $this->Cell(2, 6, '', 0, 0);
            $this->Cell(60, 3.2, $date_maintenance, 0, 0);
            $this->Cell(23, 3.2,'', 0, 0);

            $this->Ln($line);
            $this->SetFont('Arial', '', 8);
            $this->Cell(36, 6, '','', '', 'C');
            $this->Cell(42, 3.2, $name_maintenance, '', '', 'C');
            $this->Cell(68, 3.2, $t->who,'', '', 'C');
            $this->Cell(15, 6, '', '', '', 'C');
            $this->Cell(23, 3.2, $t->support, '', '', 'C');
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
            ->where('type_document', '!=', 'pdf')
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
           // if($search_image->type_document!='pdf'){
                $this->Image($search_image->url, $row, 44, 48, 40);
                $this->Cell(4, 6, '', 0, 0);
                $row = $row + 48;
                $row++;
           // }
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

        $line  = '3';
        $line2 = '8.4';
        $this->Ln($line2);
        foreach ($search_maintenance as $t) {

            $date_maintenance   = date('Y-m-d', strtotime($t->date_maintenance));
            $state_maintenance1 = '';
            $state_maintenance2 = '';

            $name_maintenance = '';

            if ($t->maintenance_type == 1) {
                $state_maintenance1 = 'X';
                $name_maintenance = 'Correctivo';
            }if ($t->maintenance_type == 2) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Preventivo';
            }
            if ($t->maintenance_type == 3) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Certificación equipos';
            }
            if ($t->maintenance_type == 4) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Calibración y puesta a punto';
            }
            if ($t->maintenance_type == 5) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Ensayo dielectrico';
            }
            if ($t->maintenance_type == 6) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Pruebas de resistencias';
            }
            if ($t->maintenance_type == 7) {
                $state_maintenance2 = 'X';
                $name_maintenance = 'Ensayos y pruebas';
            }

            $this->Ln();
            $this->Ln(0.3);
            $this->SetFont('Arial', '', 8);
            $this->Cell(2, 6, '', 0, 0);
            $this->Cell(60, 3.2, $date_maintenance, 0, 0);
            $this->Cell(23, 3.2,'', 0, 0);

            $this->Ln($line);
            $this->SetFont('Arial', '', 8);
            $this->Cell(36, 6, '','', '', 'C');
            $this->Cell(42, 3.2, $name_maintenance, '', '', 'C');
            $this->Cell(68, 3.2, $t->who,'', '', 'C');
            $this->Cell(15, 6, '', '', '', 'C');
            $this->Cell(23, 3.2, $t->support, '', '', 'C');
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
