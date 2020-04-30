<?php
// Include the main TCPDF library (search for installation path).
require_once '../../librerias/tcpdf/tcpdf.php';
require_once '../../utils/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$titulo_proyecto = $_POST['titulo_proyecto'];
	$codigo_expediente = $_POST['codigo_expediente'];
	$apell_nombres = $_POST['apell_nombres'];	
	$fecha_sesion = $_POST['fecha_sesion'];
	$fecha_sustentacion = $_POST['fecha_sustentacion'];
	$hora_sustentacion = $_POST['hora_sustentacion'];
	$array_jurado = json_decode($_POST['array_jurado'], true);	
	
	$idx_presidente = array_search('presidente', array_column($array_jurado, 'tipo'));
	$idx_secreatario = array_search('secretario', array_column($array_jurado, 'tipo'));
	$idx_suplente = array_search('suplente', array_column($array_jurado, 'tipo'));
	
	$presidente = ucwords(strtolower($array_jurado[$idx_presidente]['nombre']));
	$secretario = ucwords(strtolower($array_jurado[$idx_secreatario]['nombre']));
	$suplente = ucwords(strtolower($array_jurado[$idx_suplente]['nombre']));
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
	$pdf->SetFont('helvetica', 'B', 14);

	//add page
	$pdf->AddPage();

	//add Header
	$pdf->writeHTMLCell(150, '', 30, '', 'ACTA DICTAMEN<br>', 0, 0, 0, true, 'C', true);
	$pdf->Ln(); 

	$pdf->SetFont('helvetica', '', 12);
	//add content
	//interlineado
	$pdf->setCellHeightRatio(1.50);
	//using cell HTMl
	$pdf->writeHTMLCell(150, '', 30, '', 'Visto la Resolución Decanal N°<u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>, así como el expediente adjunto, el Jurado Dictaminador integrado por los docentes:<br>', 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 

	$pdf->SetFont('helvetica','B',12);
	$pdf->setCellHeightRatio(1.50);
	$lista_jurado = '<ul>';
	$lista_jurado .= '<li><b>'.$presidente.'</b></li>';
	$lista_jurado .= '<li><b>'.$secretario.'</b></li>';
	$lista_jurado .= '<li><b>'.$suplente.'</b></li>';    	
	$lista_jurado .= '</ul>';
	
	$pdf->writeHTMLCell(150, '', 25, '', $lista_jurado, 0, 0, 0, true, 'C', true); 	
	$pdf->Ln(); 	
	$pdf->SetFont('helvetica','',12);
	$pdf->setCellHeightRatio(2);
	$pdf->writeHTMLCell(150, '', 30, '', 'Reunidos en sesión de fecha, <b>'.date("d/m/Y", strtotime($fecha_sesion)).'</b> con el objeto de <b>DICTAMINAR</b> la tesis titulada:<br><b>'.strtoupper($titulo_proyecto).'</b>', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(150, '', 30, '', 'Presentado por Don(ña): <b>'.$apell_nombres.'</b>.', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(150, '', 30, '', 'Luego de haber revisado y evaluado la Tesis correspondiente.', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(150, '', 30, '', '<b>SE ACORDÓ:</b>', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(150, '', 30, '', 'Dictaminar FAVORABLE la Tesis titulada: <b>'.strtoupper($titulo_proyecto).'.</b> y por tanto señalar la fecha de SUSTENTACION al Sr.(ta). <b>'.$apell_nombres.'</b> para optar por el título Profesional de <>INGENIERO EN SISTEMAS</b>, el <b>'.fecha_extendida($fecha_sustentacion).'</b> a horas <b>'.$hora_sustentacion.'</b>, con el jurado presidido por el <b>DR. '.$presidente.'</b>.', 0, 0, 0, true, 'J', true); 
	$pdf->Ln();
	$pdf->writeHTMLCell(150, '', 30, '', '<br>En fé de lo cual firmamos a los '.dia_actual().' días del mes de '.mes_actual().' del año '.anio_actual().'<br><br>', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->SetFont('helvetica','B',12);			
	
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
	$pdf->Output('Acta_dictamen_'.$codigo_expediente.'.pdf', 'I');
	
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>