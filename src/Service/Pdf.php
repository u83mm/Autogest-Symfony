<?php

namespace App\Service;

use Fpdf\Fpdf;

class Pdf extends Fpdf
{
    public $fecha;
    public $nombreCliente;
    public $telefono1;
    public $contacto;
    public $telefono;
    public $email;
    public $localidad;
    public $cif;
    public $comentario;
    public $vin;
    public $marca;
	public $logo;

    public function Header()
    {
        $this->Image('images/logo_pb.png', 10, 8, 33);
		$this->SetFont('Arial', 'B', 15);
		$this->Cell(40);
		$this->Cell(0, 10, 'Pedido de Call Center', 1, 0, 'C');
		$this->Ln(20);		
		$this->SetFont('Arial', 'B', 12);
		$this->Ln();
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(13, 8, 'Fecha:', 0, 0, 'c');
        $this->SetFont('');							
		$this->Cell(20, 8, $this->fecha, 0, 0, 'c');
		$this->Ln();

		// Datos del cliente
		$this->SetFont('Arial', 'B', 12);
		$this->Cell(40, 10, 'Datos del cliente', 0, 0, 'l');		
		$this->Line(10, 57, 200,57);
		$this->Ln(12);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(15, 6, 'Cliente:', 0, 0, 'l');
		$this->SetFont('');
		$this->Cell(59, 6, iconv('UTF-8', 'ISO-8859-1', $this->nombreCliente), 0, 0, 'l');
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(11, 6, 'Tfno:', 0, 0, 'l');
		$this->SetFont('');
		$this->Cell(35, 6, iconv('UTF-8', 'ISO-8859-1', $this->telefono1), 0, 0, 'l');
		$this->Ln();			
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(19, 6, 'Contacto:', 0, 0, 'L');
		$this->SetFont('');
		$this->Cell(55, 6, iconv('UTF-8', 'ISO-8859-1', $this->contacto), 0, 0, 'l');				
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(27, 6, 'Tfno contacto:', 0, 0, 'l');
		$this->SetFont('');
		$this->Cell(40, 6, iconv('UTF-8', 'ISO-8859-1', $this->telefono), 0, 0, 'l');
		$this->Ln();
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(13, 6, 'E-mail:', 0, 0, 'l');
		$this->SetFont('');
		$this->Cell(30, 6, iconv('UTF-8', 'ISO-8859-1', $this->email), 0, 0, 'l');
		$this->Ln();
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(20, 6, 'Localidad:', 0, 0, 'l');
		$this->SetFont('');
		$this->Cell(40, 6, iconv('UTF-8', 'ISO-8859-1', $this->localidad), 0, 0, 'l');
		$this->Ln();
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(8, 6, 'Cif:', 0, 0, 'l');
		$this->SetFont('');
		$this->Cell(30, 6, iconv('UTF-8', 'ISO-8859-1', $this->cif), 0, 0, 'l');
		$this->Ln();
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(23, 6, 'Comentario:', 0, 0, 'l');
		$this->SetFont('');
		$this->Cell(40, 6, iconv('UTF-8', 'ISO-8859-1', $this->comentario), 0, 0, 'l');
		$this->Ln(12);

        // Datos del pedido
		$this->SetFont('Arial', 'B', 12);
		$this->Cell(30, 6, 'Datos del pedido', 0, 0, 'l');
		$this->Line(10, 109, 200, 109);
		$this->Ln(10);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(8, 6, 'VIN:', 0, 0, 'l');
		$this->SetFont('');
		$this->Cell(60, 6, iconv('UTF-8', 'ISO-8859-1', $this->vin), 0, 0, 'l');
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(13, 6, 'Marca:', 0, 0, 'L');
		$this->SetFont('');
		$this->Cell(25, 6, iconv('UTF-8', 'ISO-8859-1', $this->marca), 0, 0, 'L');		
		$this->Image("uploads/logo_marca/$this->logo", 180, 109, 20, 20);
		$this->Ln(12);

        // Detalle del pedido
		$this->SetFont('Arial', 'B', 12);
		$this->Cell(30, 6, 'Detalle del pedido', 0, 0, 'L');
		$this->Line(10, 131, 200, 131);
		$this->Ln(10);
		$this->SetFont('Arial', 'B', 10);
		$this->Cell(40, 6, 'Referencia', 0, 0, 'l');
		$this->Cell(77, 6, iconv('UTF-8', 'ISO-8859-1', 'Descripción'), 0, 0, 'L');
		$this->Cell(18, 6, iconv('UTF-8', 'ISO-8859-1', 'Cant.'), 0, 0, 'C');
		$this->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', 'P.V.P'), 0, 0, 'C');
		$this->Cell(20, 6, iconv('UTF-8', 'ISO-8859-1', 'Dto.'), 0, 0, 'C');
		$this->Cell(18, 6, iconv('UTF-8', 'ISO-8859-1', 'Neto'), 0, 0, 'C');
		$this->Ln();

		// Crea cuadricula
		$this->SetLineWidth(0.2);
		$this->Line(10, 140, 203, 140);	 // primera línea horizontal
		$this->Line(10, 140, 10, 240);	 // primera línea margen izquierdo
		$this->Line(10, 240, 203, 240);	 // última línea horizontal
		$this->Line(50, 140, 50, 240);	 // segunda línea margen izquierdo
		$this->Line(127, 140, 127, 240); // tercera línea margen izquierdo
		$this->Line(145, 140, 145, 240); // cuarta línea margen izquirdo
		$this->Line(165, 140, 165, 240); // quinta línea margen izquierdo
		$this->Line(185, 140, 185, 240); // sexta línea margen izquierdo
		$this->Line(203, 140, 203, 240); // última lína margen

    }
    public function Footer()
    {
        // Go to 1.5cm form bottom
        $this->SetY(-15);
        // Selet Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Print centererd page number
        $this->Cell(0, 10, iconv('UTF-8', 'ISO-8859-1', 'Página ' . $this->PageNo()), 0, 0, 'C');
    }
}

?>