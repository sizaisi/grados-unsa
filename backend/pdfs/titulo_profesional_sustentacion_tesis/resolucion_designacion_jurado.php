<?php
// Include the main TCPDF library (search for installation path).
require_once('../../librerias/tcpdf/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$expediente = json_decode($_POST['expediente']);

	$codigo_expediente = $expediente->codigo;
	$titulo_proyecto = $expediente->titulo;
	$nesc = $expediente->nesc;
	$array_nombres = $_POST['array_nombres'];
	$apell_nombres = $array_nombres[0]; //nombres y apellidos del primer graduando
	$array_jurado = $_POST['array_jurado'];
	$nombre_asesor = $_POST['nombre_asesor'];
	$fecha_sorteo = $_POST['fecha_sorteo'];
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
	$pdf->writeHTMLCell(170, '', 20, '', 'Arequipa, '.$dia.' de '.$mes.' del '.$anio_actual.'<br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 

	$texto1 = 'Vista la solicitud de Don(ña): <b>'.$apell_nombres.'</b> quien solicita nombramiento de jurado
			   para optar el grado académico de Bachiller en <b> '.$nesc.'</b> 
			   y sustentar su trabajo de investigación titulado: <b>'.$titulo_proyecto.'</b><br>';
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

	foreach(json_decode($array_jurado) as $jurado) {
		$lista_jurado .= '<li><b>'.$jurado->nombre.' ('.$jurado->tipo.')</b></li>';    
	}

	$lista_jurado .= '<li><b>'.$nombre_asesor.' (asesor)</b></li>';    

	$lista_jurado .= '</ul>';
	$texto4 = '<b>SE DECRETA: </b><br><br>Nombrar el Jurado integrado por los Señores Docentes:'.$lista_jurado.'<br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto4, 0, 0, 0, true, 'J', true);
	$pdf->Ln();
	$texto5 = 'El Jurado revisará el Trabajo de Investigación adjunto titulado: <b>'.$titulo_proyecto.'</b><br>';
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
	$pdf->writeHTMLCell(170, '', 20, '', '<span style="text-decoration:overline">Decano de la Facultad de Ingeniería de Producción y Servicios</span>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();

	$pdf->Output('Resolucion_nombramiento_jurados_'.$dia.'-'.$mes1.'-'.$anio_actual.'_'.$codigo_expediente.'.pdf', 'I');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>