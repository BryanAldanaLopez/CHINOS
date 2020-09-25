<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Artista;
class PDFController extends Controller
{
    public function index(){
        //crear el objeto pdf
        $pdf = new Fpdf();
        //Añadir pagina
        $pdf->AddPage();

        //Paint
        $pdf->SetFillColor(41, 228, 163);
        $pdf->SetXY(10,10);
        $pdf->setFont('Arial' , 'B' , 14);
        //ESTABLECER CONTENIDO
        $pdf->Cell(110 , 10 , 'Nombre Artista' , 1 , 0, 'C');
        $pdf->Cell(50 , 10 , utf8_decode('Numero Albumes') , 1 , 1, 'C');
        $pdf->SetDrawColor(19, 131, 81);
        
        //Utilizar objeto response
        $response = response($pdf->Output());
        //Definir el tipo mime
        $response->header("Content-Type" , 'application/pdf');
        //retornar respuesta al navegador
        return $response;

        $artistas = Artista::all();
        $pdf->SetFont('Arial' , 'I' , 11);
        foreach ($artistas as $a) {
            $pdf->Cell(110, 10, substr(utf8_decode($a->Name), 0, 10), 1, 0, "L");
            $pdf->Cell(50, 10, $a->albumes()->count(), 1, 1, "C");
        

        }
    }
}
