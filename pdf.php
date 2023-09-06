<?php
require 'tcpdf/Pdf.php';
include('bd.php');


$pdf = new \Pdf();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('EcoDemeanda');
$pdf->SetTitle('Noticia');
$pdf->SetSubject('Noticia');
$pdf->SetKeywords('PDF, noticias');
$pdf->SetMargins(10, 25.2, 10);
$pdf->SetAutoPageBreak(TRUE, 13.4);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// add a page
$pdf->AddPage('P', 'LETTER');
$pdf->SetFont('times', '', 12, '', true);



$records = $conn->prepare('SELECT publicacion.id, publicacion.id_autor, publicacion.titulo, publicacion.cuerpo, usuarios.usuario FROM publicacion INNER JOIN usuarios ON publicacion.id = :id AND publicacion.id_autor = usuarios.id');

$records->bindParam(':id', $_GET['id']);
$records->execute();
$results = $records->fetch(PDO::FETCH_ASSOC);
$html = ' <h1><b> ' . $results['titulo'] . '</b></h1>
             <p color="#4b3f24">Autor(a): <b color="#000000">' . $results['usuario'] . '</b></p>
                <p color="#4b3f24">' . str_replace("\n", "<br>", $results['cuerpo']). '</p>';
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->lastPage();
ob_end_clean();
$pdf->Output('Listado_clientes.pdf', 'I');
