<?php
// Include the main TCPDF library (search for installation path).
require_once('../../librerias/tcpdf/tcpdf.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/************************ VARIABLES DE FORMULARIO *********************/
	$titulo_proyecto = $_POST['titulo_proyecto'];
	$codigo_expediente = $_POST['codigo_expediente'];
	$array_nombres = $_POST['array_nombres'];
	$nombre_asesor = $_POST['nombre_asesor'];
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
	$texto1 = 'El Plan de Proyecto de Investigación titulado: <b>"'.$titulo_proyecto.
				'"</b><br><br>Presentado por el(los) graduando(s):<br>';

	$lista_graduandos = '<ul>';
	foreach($array_nombres as $nombre) {
		$lista_graduandos .= '<li><b>'.$nombre.'</b></li>';
	}
	$lista_graduandos .= '</ul>';
	$texto2 = 'Y, de conformidad con el Reglamento de Grados y Títulos y la Ley Universitaria vigente.<br>';
	$pdf->SetFont('helvetica', '', 12);
	$pdf->writeHTMLCell(170, '', 20, '', $texto1, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	$pdf->writeHTMLCell(170, '', 20, '', $lista_graduandos, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(170, '', 20, '', $texto2, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	$pdf->SetFont('helvetica', 'B', 12);
	$pdf->writeHTMLCell(170, '', 20, '', 'SE RESUELVE:<br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln(); 
	$texto3 = '<b>PRIMERO.- </b>Tener por presentado el Proyecto del Trabajo de Investigación titulado: <b>'.$titulo_proyecto.
				'</b><br><br>Presentado por el(los) graduando(s):<br>';
	$texto4 = '<br><b>SEGUNDO.- </b>Designar como Asesor del Proyecto del Trabajo de investigación al docente de la facultad: '.
				'<b>'.$nombre_asesor.'</b><br><br><br><br>';
	$pdf->SetFont('helvetica', '', 12);
	//$pdf->writeHTMLCell(180, '', '', '', $parrafo2, 0, 0, 0, true, 'J', true);
	$pdf->writeHTMLCell(170, '', 20, '', $texto3, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	$pdf->writeHTMLCell(170, '', 20, '', $lista_graduandos, 0, 0, 0, true, 'J', true);
	$pdf->Ln(); 
	$pdf->Ln(); 
	$pdf->writeHTMLCell(170, '', 20, '', $texto4, 0, 0, 0, true, 'J', true);
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
	$pdf->writeHTMLCell(170, '', 20, '', 'Arequipa, '.$dia.' de '.$mes.' del '.$anio_actual.'<br><br><br><br><br><br><br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();
	$pdf->SetFont('helvetica','B',12);
	$pdf->writeHTMLCell(170, '', 20, '', '<span style="text-decoration:overline">DECANO DE LA FACULTAD DE ADMINISTRACIÓN</span><br><br>', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();
	$pdf->SetFont('helvetica','',10);
	$pdf->writeHTMLCell(170, '', 20, '', 'c.c. asesor, interesado y archivo', 0, 0, 0, true, 'L', true); 
	$pdf->Ln();

	$pdf->Output('Resolucion_designacion_asesor_tema_'.$dia.'-'.$mes1.'-'.$anio_actual.'_'.$codigo_expediente.'.pdf', 'I');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>