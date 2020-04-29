<?php
// Include the main TCPDF library (search for installation path).
require_once('../../librerias/tcpdf/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$titulo_proyecto = $_POST['titulo_proyecto'];
	$codigo_expediente = $_POST['codigo_expediente'];
	$apell_nombres = $_POST['apell_nombres'];
	$nombre_asesor = $_POST['nombre_asesor'];
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
	$pdf->writeHTMLCell(150, '', 30, '', 'Visto la Resolución Decanal N°<u>              </u>, así como el expediente adjunto, el Jurado Dictaminador integrado por los docentes:<br>', 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 

	$pdf->SetFont('helvetica','B',12);
	$pdf->setCellHeightRatio(1.50);
	$html2='<ul><li><u>DR. ALEJANDRO OSCAR SILVA VELA</u></li></ul>
			<ul><li><u>DR. OSCAR SILVA VELA</u></li></ul>        
			<ul><li><u>DR. ALONSO SILVA VELA<br></u></li></ul>    
			';
	$pdf->writeHTMLCell(150, '', 25, '', $html2, 0, 0, 0, true, 'C', true); 
	$pdf->Ln(); 
	//lugar y fecha
	$dia = date("d");
	$mes1 = date("m");
	$anio_actual = date("Y");

	switch($mes1)
	{
		case "01": $mes='enero';   break;
		case "02": $mes='febrero'; break;
		case "03": $mes='marzo';   break;
		case "04": $mes='abril';   break;
		case "05": $mes='mayo';    break;
		case "06": $mes='junio';   break;
		case "07": $mes='julio';   break;
		case "08": $mes='agosto';  break;
		case "09": $mes='setiembre'; break;
		case "10": $mes='octubre'; 	 break;
		case "11": $mes='noviembre'; break;
		case "12": $mes='diciembre'; break;
	}
	$pdf->SetFont('helvetica','',12);
	$pdf->setCellHeightRatio(2);
	$pdf->writeHTMLCell(150, '', 30, '', 'Reunidos en sesión de fecha, <u>'.$dia.' de '.$mes.' del '.$anio_actual.'</u> con el objeto de <b>DICTAMINAR</b> la tesis titulada: '.strtoupper($titulo_proyecto).'.', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(150, '', 30, '', 'Presentado por Don(ña): <u>'.ucwords(strtolower($apell_nombres)).'</u>.', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(150, '', 30, '', 'Luego de haber revisado y evaluado la Tesis correspondiente.', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(150, '', 30, '', '<b>SE ACORDÓ:</b>', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(150, '', 30, '', 'Dictaminar FAVORABLE la Tesis titulada: <u>'.strtoupper($titulo_proyecto).'.</u> y por tanto señalar la fecha de SUSTENTACION al Sr.(ta). <u>'.ucwords(strtolower($apell_nombres)).'</u> para optar por el título Profesional de <U>LICENCIADO EN MARKETING</U>, el <u>5</u> de <u>marzo</u> del <u>2020</u> a horas <u>15:30</u>, con el jurado presidido por el <u>DR. ALEJANDRO OSCAR SILVA VELA</u>.', 0, 0, 0, true, 'J', true); 
	$pdf->Ln();
	$pdf->writeHTMLCell(150, '', 30, '', 'En fé de lo cual firmamos a los <u>'.$dia.'</u> días del mes de <u>'.$mes.'</u> del año <u>'.$anio_actual.'</u><BR><BR>', 0, 0, 0, true, 'J', true); 
	$pdf->Ln(); 
	$pdf->SetFont('helvetica','B',12);
	$html2='
		<table>
			<tr>
				<td><SPAN STYLE="text-decoration:overline">DR. ALEJANDRO OSCAR SILVA VELA</span></td>
				<td><SPAN STYLE="text-decoration:overline">DR. JUAN JOSE VELA ESPARRA</span></td>
			</tr>
			<tr>
				<td>PRESIDENTE</td>
				<td>SECRETARIO</td>
			</tr>
		</table>
		<br>';

	$pdf->writeHTMLCell(160, '', 25, '', $html2, 0, 0, 0, true, 'C', true); 
	$pdf->Ln(); 
	$html2='
		<table>
			<tr>
				<td><SPAN STYLE="text-decoration:overline">ING. ALBERTO REYES REYES</span></td>
				
			</tr>
			<tr>
				<td>INTEGRANTE</td>
			</tr>
		</table>
		<br>';

	$pdf->writeHTMLCell(150, '', 30, '', $html2, 0, 0, 0, true, 'C', true); 
	$pdf->Ln(); 

	//output
	$pdf->Output('Acta_dictamen_'.$dia.'-'.$mes1.'-'.$anio_actual.'_'.$codigo_expediente.'.pdf', 'I');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}

?>