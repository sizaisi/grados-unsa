<?php
// Include the main TCPDF library (search for installation path).
require_once '../../librerias/tcpdf/tcpdf.php';
require_once '../../utils/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$expediente = json_decode($_POST['expediente']);	
	$graduando = json_decode($_POST['graduando']);		
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

	$pdf->Write(0, 'DESIGNAR ASESOR', '', 0, 'C', true, 0, false, false, 0);
	$pdf->Ln(); 
	//$pdf->Write(20, 'RESOLUCIÓN DECANAL N° 001/2019-AD/UNSA', '', 0, 'L', true, 0, false, false, 0);
	$pdf->writeHTMLCell(170, '', 20, '', '<u>RESOLUCIÓN DECANAL N° &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(170, '', 20, '', 'VISTO:<br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 
	$texto1 = 'El Plan de Proyecto de Investigación titulado: <b>"'.$expediente->titulo.
				'"</b><br><br>Presentado por el graduando: <b>'.$graduando->apell_nombres.'</b><br>';	
	$texto2 = 'Y, de conformidad con el Reglamento de Grados y Títulos y la Ley Universitaria vigente.<br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto1, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 		
	$pdf->writeHTMLCell(170, '', 20, '', $texto2, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->writeHTMLCell(170, '', 20, '', 'SE RESUELVE:<br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 
	$texto3 = '<b>PRIMERO.- </b>Tener por presentado el Proyecto del Trabajo de Investigación titulado: <b>'.$expediente->titulo.
				'</b><br><br>Presentado por el graduando: <b>'.$graduando->apell_nombres.'</b><br>';
	$texto4 = '<br><b>SEGUNDO.- </b>Designar como Asesor del Proyecto del Trabajo de investigación al docente de la facultad: '.
				'<b>'.$asesor->apn.'</b><br><br><br><br>';
	$pdf->SetFont('helvetica', '', 12);
	//$pdf->writeHTMLCell(180, '', '', '', $parrafo2, 0, 0, 0, true, 'J', true);
	$pdf->writeHTMLCell(170, '', 20, '', $texto3, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 		
	$pdf->writeHTMLCell(170, '', 20, '', $texto4, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	
	$pdf->SetFont('helvetica','',12);
	$pdf->writeHTMLCell(170, '', 20, '', 'Arequipa, '.dia_actual().' de '.mes_actual().' del '.anio_actual().'<br><br><br><br><br><br><br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();
	$pdf->SetFont('helvetica','B',12);
	$pdf->writeHTMLCell(170, '', 20, '', '<span style="text-decoration:overline">DECANO DE LA '.$expediente->facultad.'</span><br><br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();
	$pdf->SetFont('helvetica','',10);
	$pdf->writeHTMLCell(170, '', 20, '', 'c.c. asesor, interesado y archivo', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();

	$pdf->Output('resolucion_designacion_asesor_tema_'.$expediente->codigo.'.pdf', 'D');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>