<?php
// Include the main TCPDF library (search for installation path).
require_once '../../librerias/tcpdf/tcpdf.php';
require_once '../../utils/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$expediente = json_decode($_POST['expediente']);			
	$graduando = json_decode($_POST['graduando']);			
	$asesor = json_decode($_POST['asesor']);
	$array_jurado = json_decode($_POST['jurados'], true);

	$idx_presidente = array_search('presidente', array_map(function($element) {  return $element['tipo'];}, $array_jurado) );
	$idx_secreatario = array_search('secretario', array_map(function($element) {  return $element['tipo'];}, $array_jurado) );
	$idx_suplente = array_search('suplente', array_map(function($element) {  return $element['tipo'];}, $array_jurado) );
	
	$presidente = ucwords(strtolower($array_jurado[$idx_presidente]['apn']));
	$secretario = ucwords(strtolower($array_jurado[$idx_secreatario]['apn']));
	$suplente = ucwords(strtolower($array_jurado[$idx_suplente]['apn']));
	$asesor = ucwords(strtolower($asesor->apn));

	//$fecha_sorteo = $_POST['fecha_sorteo'];
	$fecha_sorteo = '2020-05-24';
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

	$pdf->Write(0, 'DESIGNACIÓN DE JURADOS', '', 0, 'C', true, 0, false, false, 0);
	$pdf->Ln(); 
	$pdf->writeHTMLCell(170, '', 20, '', '<u>RESOLUCIÓN DECANAL N° &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u><br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();
	
	$pdf->SetFont('helvetica','',12);
	$pdf->writeHTMLCell(170, '', 20, '', 'Arequipa, '.dia_actual().' de '.mes_actual().' del '.anio_actual().'<br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 

	$texto1 = 'Vista la solicitud de Don(ña): <b>'.$graduando->apell_nombres.'</b> quien solicita nombramiento de jurado
			   para optar el grado académico de Bachiller en <b> '.$expediente->escuela.'</b> 
			   y sustentar su trabajo de investigación titulado: <b>'.$expediente->titulo.'</b><br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto1, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	$texto2 = '<b>CONSIDERANDO: </b><br><br>Que, los Estudios de Pregrado conducen optar el Grado Académico de Bachiller de
			   conformidad con lo dispuesto en el Estatuto de la UNSA, el Reglamento de Grados y Títulos y la
			   Ley Universitaria vigente.<br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto2, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	$texto3 = 'Que habiéndose realizado en esta Facultad el sorteo de jurados el día: '.$fecha_sorteo.' y en uso de las atribuciones conferidas a esta Facultad.<br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto3, 0, 0, 0, true, 'J', true);
	$pdf->Ln();

	$lista_jurado = '<ul>';
	$lista_jurado .= '<li><b>'.$presidente.' (presidente)</b></li>';    
	$lista_jurado .= '<li><b>'.$secretario.' (secretario)</b></li>';    
	$lista_jurado .= '<li><b>'.$suplente.' (suplente)</b></li>';    
	$lista_jurado .= '<li><b>'.$asesor.' (asesor)</b></li>';    
	$lista_jurado .= '</ul>';
	
	$texto4 = '<b>SE DECRETA: </b><br><br>Nombrar el Jurado integrado por los Señores Docentes:'.$lista_jurado.'<br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto4, 0, 0, 0, true, 'J', true);
	$pdf->Ln();
	$texto5 = 'El Jurado revisará el Trabajo de Investigación adjunto titulado: <b>'.$expediente->titulo.'</b><br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto5, 0, 0, 0, true, 'J', true);
	$pdf->Ln();
	$texto6 = 'Quien emitirá su dictamen en un plazo no mayor de 15 días hábiles.<br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto6, 0, 0, 0, true, 'J', true);
	$pdf->Ln();
	$texto7 = 'De ser favorable el dictamen, se procederá a la sustentación pública de su trabajo en fecha y
			   hora señalada por el jurado (Acta de Dictamen).<br><br>Regístrese, Comuníquese y Archívese.';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto7, 0, 0, 0, true, 'J', true);
	$pdf->Ln();
	$pdf->Ln();

	$pdf->SetFont('helvetica','B',12);
	$pdf->writeHTMLCell(170, '', 20, '', '<span style="text-decoration:overline">DECANO DE LA '.$expediente->facultad.'</span>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();

	$pdf->Output('resolucion_nombramiento_jurados_'.$expediente->codigo.'.pdf', 'D');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>