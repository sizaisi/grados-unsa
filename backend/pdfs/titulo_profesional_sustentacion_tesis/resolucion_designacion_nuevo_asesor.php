<?php
// Include the main TCPDF library (search for installation path).
require_once '../../librerias/tcpdf/tcpdf.php';
require_once '../../utils/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$expediente = json_decode($_POST['expediente']);	
	$graduando = json_decode($_POST['graduando']);
	//$movimiento = json_decode($_POST['movimiento']);
	$asesor_anterior = 'Jeiken Sizaisi';
	$asesor = json_decode($_POST['asesor']);
	/**********************************************************************/

	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'UNSA');

	// remove default header/footer
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	// set font
	$pdf->SetFont('helvetica', 'B', 12);
	// add a page
	$pdf->AddPage();	

	$pdf->Write(0, 'RENUNCIA DE ASESOR', '', 0, 'C', true, 0, false, false, 0);
	$pdf->Ln(); 
	//$pdf->Write(20, 'RESOLUCIÓN DECANAL N° 001/2019-AD/UNSA', '', 0, 'L', true, 0, false, false, 0);
	$pdf->writeHTMLCell(160, '', 25, '', '<u>RESOLUCIÓN DECANAL N° &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(160, '', 25, '', 'VISTO:', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 
	$pdf->setCellHeightRatio(2.5);
	$texto1 = 'El informe del Docente-Asesor Dr./Mg. : <b>'.$asesor_anterior.'</b>';
	$texto1 .= ' en el que renuncia a continuar asesorando el Proyecto de Tesis Titulada:<br><b>'.$expediente->titulo.'</b><br>';
	$texto1 .= 'Del ciudadano Don(ña): <b>'.$graduando->apell_nombres.'</b>';	
	
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(160, '', 25, '', $texto1, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 	
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->writeHTMLCell(160, '', 25, '', 'SE RESUELVE:', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 
	$texto2 = '<b>PRIMERO.- </b>Designar como nuevo Asesor al Docente Dr/Mg. <b>'.$asesor->apn.
			  '</b> docente de la facultad, a partir del 20 de abril del 2020 del proyecto de Tesis titulado:<br>'.
			  '<b>'.$expediente->titulo.'</b><br>';
	
	$pdf->SetFont('helvetica', '', 12);	
	$pdf->writeHTMLCell(160, '', 25, '', $texto2, 0, 0, 0, true, 'J', true);	
	$pdf->Ln(); 	
	$pdf->SetFont('helvetica','',12);
	$pdf->writeHTMLCell(160, '', 25, '', 'Arequipa, '.dia_actual().' de '.mes_actual().' del '.anio_actual().'<br><br><br>', 0, 0, 0, true, 'R', true); 
	$pdf->Ln();
	$pdf->SetFont('helvetica','B',10);
	$pdf->writeHTMLCell(160, '', 25, '', '<span style="text-decoration:overline">DECANO DE LA '.$expediente->facultad.'</span>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();
	$pdf->SetFont('helvetica','',10);
	$pdf->writeHTMLCell(160, '', 25, '', 'c.c. asesor, interesado y archivo', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();

	$pdf->Output('Resolucion_designacion_nuevo_asesor_'.$expediente->codigo.'.pdf', 'I');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>