<?php
// Include the main TCPDF library (search for installation path).
require_once '../../librerias/tcpdf/tcpdf.php';
require_once '../../utils/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$titulo_proyecto = $_POST['titulo_proyecto'];
	$codigo_expediente = $_POST['codigo_expediente'];
	$apell_nombres = $_POST['apell_nombres'];
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
	
	$titulo = 'INFORME DE CONFORMIDAD DE ASESORAMIENTO DEL PROYECTO DE TESIS PARA OPTAR EL TÍTULO PROFESIONAL DE INGENIERO EN SISTEMAS<br>';
	
	$pdf->writeHTMLCell(150, '', 30, '', $titulo, 0, 0, 0, true, 'C', true); 	
	$pdf->Ln(); 		
	
	$pdf->setCellHeightRatio(2.5);	
	
	$texto = 'Yo, <b>'.$asesor->apn.'</b> docente de la facultad de Ingenieria de Producción y Servicios ';
	$texto .= 'de la Universidad Nacional de San Agustín de Arequipa, identificado con el DNI N° <b>'.$asesor->dic.'</b> ';
	$texto .= 'acepto y me comprometo a ser asesor del Proyecto de Tesis titulado: ';
	$texto .= '<b>'.$titulo_proyecto.'</b> del Sr. (ta) <b>'.$apell_nombres.'</b>, ';
	$texto .= 'el cual cumple con el Perfil Académico respectivo.<br>';	
	
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(150, '', 30, '', $texto, 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 			
	$pdf->SetFont('helvetica','',12);
	$pdf->writeHTMLCell(150, '', 30, '', 'Arequipa, '.dia_actual().' de '.mes_actual().' del '.anio_actual().'<br><br><br>', 0, 0, 0, true, 'R', true); 
	$pdf->Ln();	
	$pdf->SetFont('helvetica','B',12);	
	$firma = '<span style="text-decoration:overline">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FIRMA DE ASESOR&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';
	$pdf->writeHTMLCell(150, '', 30, '', $firma, 0, 0, 0, true, 'C', true); 
	$pdf->Ln();
	
	$pdf->Output('Informe_conformidad_asesoramiento_'.$codigo_expediente.'.pdf', 'I');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>