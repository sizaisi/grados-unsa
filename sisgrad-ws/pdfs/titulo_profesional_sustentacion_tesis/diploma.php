<?php
// Include the main TCPDF library (search for installation path).
require_once '../../librerias/tcpdf/tcpdf.php';
require_once '../../utils/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /************************ VARIABLES DE FORMULARIO *********************/
	$expediente = json_decode($_POST['expediente']);		
    $graduando = json_decode($_POST['graduando']);	    
	/**********************************************************************/
    //make tcpdf object
    $pdf = new TCPDF('l','mm','A3');

    // set default header data con espacio desde UNSA
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'UNSA                                                                                                                                                                                                                                                                                                                     |REPÚBLICA DEL PERÚ');

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
    $pdf->SetFont('antiqueno14', 'B', 24);

    //add page
    $pdf->AddPage(); 

    //add Header
    $pdf->writeHTMLCell(450, '', 0, '', '<br><br><br><br>UNIVERSIDAD NACIONAL DE SAN AGUSTÍN DE AREQUIPA', 0, 0, 0, true, 'C', true);
    $pdf->Ln(); 
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->writeHTMLCell(450, '', 0, '', '', 0, 0, 0, true, 'C', true);
    $pdf->Ln(); 
    $pdf->SetFont('helvetica', 'B', 18);
    $pdf->writeHTMLCell(450, '', 0, '', 'EN NOMBRE DE LA NACIÓN', 0, 0, 0, true, 'C', true);
    $pdf->Ln(); 
    $pdf->writeHTMLCell(450, '', 0, '', $expediente->facultad, 0, 0, 0, true, 'C', true);
    $pdf->Ln(); 
    $pdf->writeHTMLCell(450, '', 0, '', 'ESCUELA PROFESIONAL DE '.$expediente->escuela, 0, 0, 0, true, 'C', true);
    $pdf->Ln(); 
    $pdf->SetFont('z003i', '', 20);
    $pdf->writeHTMLCell(450, '', 0, '', 'El Rector de la Universidad Nacional de San Agustín de Arequipa, ortorga a:', 0, 0, 0, true, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->writeHTMLCell(450, '', 0, '', '', 0, 0, 0, true, 'C', true);
    $pdf->Ln();
    //ordenamiento de nombres y apellidos
    $apell_nombres=explode(", ", $graduando->apell_nombres);
    $apell_nombres=$apell_nombres[1]." ".$apell_nombres[0];
    $pdf->SetFont('antiqueno14', 'B', 26);
    $pdf->writeHTMLCell(450, '', 0, '', $apell_nombres, 0, 0, 0, true, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->writeHTMLCell(450, '', 0, '', '', 0, 0, 0, true, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('z003i', '', 20);
    $pdf->writeHTMLCell(450, '', 0, '', 'El título Profesional de:', 0, 0, 0, true, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->writeHTMLCell(450, '', 0, '', '', 0, 0, 0, true, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('antiqueno14', 'B', 19);
    $pdf->writeHTMLCell(450, '', 0, '', 'LICENCIADO EN '.$expediente->escuela, 0, 0, 0, true, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('helvetica', 'B', 8);
    $pdf->writeHTMLCell(450, '', 0, '', '', 0, 0, 0, true, 'C', true);
    $pdf->Ln();
    $pdf->SetFont('z003i', '', 20);

    //add Text
    $exp='<br>Por haber cumplido con lo que estipula la ley Universitaria, el Estatuto y el Reglamento General de Grados y Títulos y en uso de sus atribuciones, El Consejo Universitario confiere el respectivo Diploma para su reconocimiento como tal.<br>';
    $pdf->writeHTMLCell(365, '', 41, '', $exp, 0, 0, 0, true, 'C', true); 
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
    $pdf->SetFont('z003i','',20);
    $pdf->writeHTMLCell(450, '', 0, '', 'Dado y firmado en Arequipa, el '.$dia.' de '.$mes.' del '.$anio_actual.'<br><br><br><br><br>', 0, 0, 0, true, 'C', true); 
    $pdf->Ln(); 
    //$pdf->SetFont('lobster','B',12);
    $pdf->SetFont('helvetica','B',16);
    $html2='
        <table>
            <tr>
                <td>___________________________________</td>
                <td>___________________________________</td>
                <td>___________________________________</td>
            </tr>
            <tr>
                <td>Secretario General</td>
                <td>Rector</td>
                <td>Decano</td>
            </tr>
            <tr>
                <td>Mg. ORLANDO FREDI ANGULO SALAS</td>
                <td>Dr. ROHEL SANCHEZ SANCHEZ</td>
                <td>Dr. JUAN LUNA CARPIO</td>
            </tr>
        </table>
        <br>';

    $pdf->writeHTMLCell(375, '', 37, '', $html2, 0, 0, 0, true, 'C', true); 
    $pdf->Ln(); 

    //add page
    $pdf->AddPage(); 
    $dni = $graduando->dni;

    if(strlen($dni)==8){
        $tipo='DNI';
    }elseif (strlen($dni)==12) {
        $tipo='PASAPORTE';
    }
    $pdf->SetFont('helvetica','',12);
    $html3='&nbsp;&nbsp;REGISTRO GENERAL DE GRADOS Y TITULOS<br><br>
            Código de la Universidad:&nbsp;005<br>
            Tipo de documento: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$tipo.'<br>
            Nro de Documento: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$dni.'<br>
            Abreviatura del grado: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;B<br>
            Modalidad de Obtención del grado o Título: AUTOMÁTICO<br>
            Modalidad de Estudios: &nbsp;&nbsp;&nbsp;&nbsp;PRESENCIAL<br>
            <br>
            Número de Diploma: B-0016820<br>
            Tipo de Emisión de Diploma: ORIGINAL<br>
            Procedencia de Reválida País:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----------------------<br>
            Procedencia de Reválida Universidad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----------------------<br>
            Denominación del Grado o Título Revalidado:&nbsp;----------------------<br>
            Fecha de Diploma Duplicado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;----------------------<br>';
    $pdf->writeHTMLCell(375, '', 37, '', $html3, 0, 0, 0, true, 'L', true); 
    $pdf->Ln(); 
    $pdf->SetFont('helvetica','',12);
    $html4='&nbsp;&nbsp;LICENCIA INSTITUCIONAL SEGÚN RESOLUCIÓN DE CONSEJO DIRECTIVO N° 098-2017-SUNEDU/CD<br>';
    $pdf->writeHTMLCell(375, '', 37, '', $html4, 0, 0, 0, true, 'L', true); 
    $pdf->Ln(); 
    $pdf->SetFont('helvetica','',12);
    $html5='&nbsp;&nbsp;Título Profesional o Grado académico aprobado por R.C.U. N°:O.G.Y.T. 009-2019<br>
            Fecha: &nbsp;&nbsp;&nbsp;&nbsp;24/05/2019<br>       
            Registro:&nbsp;65734<br>
            Inscrito a folios 0422 del libro E-05<br><br><br><br><br><br><br>
            ';
    $pdf->writeHTMLCell(375, '', 37, '', $html5, 0, 0, 0, true, 'L', true); 
    $pdf->Ln(); 
    $pdf->SetFont('helvetica','',12);
    $html2='
        <table>
            <tr>
                <td>___________________________________</td>
            </tr>
            <tr>
                <td style="text-align:center;vertical-align:middle">Jefe de la Oficina de Grados y Títulos</td>
            </tr>
            <tr>
                <td style="text-align:center;vertical-align:middle">Lic. Gicella Claudia Butiler Pacheco</td>
            </tr>
        </table>
        <br>';

    $pdf->writeHTMLCell(86, '', 35, '', $html2, 0, 0, 0, true, 'L', true); 
    $pdf->Ln();    

    //output
    $pdf->Output('diploma_'.$dia.'-'.$mes1.'-'.$anio_actual.'_'.$expediente->codigo.'.pdf', 'D');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>