<?php
// Include the main TCPDF library (search for installation path).
require_once '../../librerias/tcpdf/tcpdf.php';
require_once '../../utils/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$expediente = json_decode($_POST['expediente']);		
	$graduando = json_decode($_POST['graduando']);
	//$fecha_sesion = $_POST['fecha_sesion'];
	//$fecha_sustentacion = $_POST['fecha_sustentacion'];
	//$hora_sustentacion = $_POST['hora_sustentacion'];
	$fecha_sesion = '2020-05-20';
	$fecha_sustentacion = '2020-05-25';
	$hora_sustentacion = '10:00';
	
	//$array_jurado = json_decode($_POST['array_jurado'], true);	
	$array_jurado = json_decode($_POST['jurados'], true);
	
	/*$idx_presidente = array_search('presidente', array_column($array_jurado, 'tipo'));
	$idx_secreatario = array_search('secretario', array_column($array_jurado, 'tipo'));
	$idx_suplente = array_search('suplente', array_column($array_jurado, 'tipo'));*/

	$idx_presidente = array_search('presidente', array_map(function($element) {  return $element['tipo'];}, $array_jurado) );
	$idx_secreatario = array_search('secretario', array_map(function($element) {  return $element['tipo'];}, $array_jurado) );
	$idx_suplente = array_search('suplente', array_map(function($element) {  return $element['tipo'];}, $array_jurado) );
	
	$presidente = ucwords(strtolower($array_jurado[$idx_presidente]['apn']));
	$secretario = ucwords(strtolower($array_jurado[$idx_secreatario]['apn']));
	$suplente = ucwords(strtolower($array_jurado[$idx_suplente]['apn']));
	/**********************************************************************/
	
	// create new PDF document
	$pdf = new TCPDF('p','mm','A4'); 

	// set default header data con espacio desde UNSA
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'UNSA                                                                                                                       |Escuela de Marketing');

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

	//add page
	$pdf->AddPage();

    //add Header
    $pdf->writeHTMLCell(150, '', 30, '', $expediente->facultad.' – ESCUELA PROFESIONAL DE '.$expediente->escuela.'<br>', 0, 0, 0, true, 'C', true);
    $pdf->Ln();	
	$pdf->writeHTMLCell(150, '', 30, '', 'ACTA DE SUSTENTACIÓN<br>', 0, 0, 0, true, 'C', true);
	$pdf->Ln();	
	//add content
	//interlineado
	$pdf->setCellHeightRatio(1.50);
	//using cell HTMl	
	$pdf->SetFont('helvetica','',10);
    $pdf->setCellHeightRatio(2);
    $texto1 = 'Don (ña): '.$graduando->apell_nombres . ' en Arequipa, siendo las 13:00 horas, del dia 25 de mayo del 2020 en el salón de Grados ';
    $texto1 .= ' de la Escuela Profesional de '.$expediente->escuela.' de la Universidad Nacional de San Agustín de Arequipa, en cumplimiento de la ';
    $texto1 .= '<b>RESOLUCIÓN DECANAL Nº 000-2019-FA/UNSA</b> se reunió el Jurado:';
    $pdf->writeHTMLCell(150, '', 30, '', $texto1, 0, 0, 0, true, 'J', true); 
    $pdf->Ln();     
    $pdf->SetFont('helvetica','B',10);	
	$lista_jurado = '<ul>';
	$lista_jurado .= '<li><b>'.$presidente.'</b></li>';
	$lista_jurado .= '<li><b>'.$secretario.'</b></li>';
	$lista_jurado .= '<li><b>'.$suplente.'</b></li>';    	
	$lista_jurado .= '</ul>';	
	$pdf->writeHTMLCell(150, '', 25, '', $lista_jurado, 0, 0, 0, true, 'C', true); 	
    $pdf->Ln(); 	
    $pdf->SetFont('helvetica','',10);
    $pdf->writeHTMLCell(150, '', 30, '', 'Presidida por el primero de los nombrado.', 0, 0, 0, true, 'J', true); 
    $pdf->Ln(); 	

    $texto2 = 'Dándose inicio al Acto Público de Sustentación y Evaluación, de conformidad con el Reglamento de Grados y Títulos para optar el <b>TÍTULO PROFESIONAL EN: ';
    $texto2 .= 'INGENIERÍA DE SISTEMAS</b> en la que Don (ña) '.$graduando->apell_nombres.' expuso la Tesis titulado: <b>'.$expediente->titulo.'</b>';

	$pdf->writeHTMLCell(150, '', 30, '', $texto2, 0, 0, 0, true, 'J', true);
    $pdf->Ln(); 	
    $texto3 = 'Rendida la sustentación, absueltas las observaciones y preguntas formuladas por cada uno ';
    $texto3 .= 'de los miembros del Jurado y efectuada la Evaluación correspondiente, el resultado fue:<br>';
    $texto3 .= '______________________________________________________________<br>';
    $texto3 .= 'En fe de los cual se asentó la presente Acta que firman los miembros del Jurado<br><br><br>';
    $pdf->writeHTMLCell(150, '', 30, '', $texto3, 0, 0, 0, true, 'J', true);
    $pdf->Ln();     
	$pdf->SetFont('helvetica','B',10);			
	
	$html2='
		<table>
			<tr>
				<td><SPAN STYLE="text-decoration:overline">'.$presidente.'</span></td>
				<td><SPAN STYLE="text-decoration:overline">'.$secretario.'</span></td>
			</tr>
			<tr>
				<td>PRESIDENTE</td>
				<td>SECRETARIO</td>
			</tr>
		</table>
		<br><br><br>';

	$pdf->writeHTMLCell(150, '', 25, '', $html2, 0, 0, 0, true, 'C', true); 
	$pdf->Ln();	
	$html2='
		<table>
			<tr>
				<td><SPAN STYLE="text-decoration:overline">'.$suplente.'</span></td>				
			</tr>
			<tr>
				<td>SUPLENTE</td>
			</tr>
		</table>
		<br>';

	$pdf->writeHTMLCell(150, '', 30, '', $html2, 0, 0, 0, true, 'C', true); 
	$pdf->Ln(); 	
	
	//output
	$pdf->Output('Acta_sustentancion_'.$expediente->codigo.'.pdf', 'D');
	
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>