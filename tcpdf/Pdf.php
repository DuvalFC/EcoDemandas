<?php 
require  'tcpdf/tcpdf.php';
session_start();
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
        mb_internal_encoding('UTF-8');
    }
    public function Header() {
      // Set font
        $this->SetFont('helvetica', 'B', 11);
        // Title
        $this->Ln();//Salto de linea
        $this->Cell(0, 5, 'EcoDenuncias', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->SetFont('helvetica', 'I', 10);
        $this->Ln();//Salto de linea
        $this->Cell(0, 5, 'E-mail: ecodenuncias@info.com', 0, false, 'C', 0, '', 0, false, 'M', 'M');
         }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $fecha=date('d-m-Y H:i');
        $texto='Fecha de impresión:'.$fecha;
        $this->Cell(0, 10, $texto.' Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}//end class
/* application/libraries/Pdf.php */
?>

