<?php
// Include the main TCPDF library (search for installation path).
require_once '../../librerias/tcpdf/tcpdf.php';
require_once '../../utils/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /************************ VARIABLES DE FORMULARIO *********************/
	$expediente = json_decode($_POST['expediente']);		
    $graduando = json_decode($_POST['graduando']);	
    $fecha_acto_academico = '25-05-2020';
    $fecha_acuerdo = '25-05-2020';
    $resolucion_consejo_directivo = '276-2028-UNSA';
    $total_creditos = '210';
    $link = 'http://bibliotecas.unsa.edu.pe/bitstream/handle/UNSA/10966/EDchbag.pdf';
    $modalidad_obtencion = 'Sustentación de tesis';
    $programa_estudios = 'CICLO REGULAR';
    $modalidad_estudios = 'PRESENCIAL';
    $ley = '23733';
	/**********************************************************************/

    //make tcpdf object
    $pdf = new TCPDF('p','mm','A4');

    // set default header data con espacio desde UNSA
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'UNSA                                                                                                                       |Escuela de Posgrado');

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
    $pdf->SetFont('helvetica', 'B', 11);

    //add page
    $pdf->AddPage();

    //add Header
    $pdf->writeHTMLCell(170, '', 20, '', '<u>AUTORIZACIÓN DE EMISIÓN DE DIPLOMA N° 200-2020</u><br>', 0, 0, 0, true, 'C', true);
    $pdf->Ln(); 
    $pdf->writeHTMLCell(170, '', 20, '', $expediente->facultad.'<br>', 0, 0, 0, true, 'C', true);
    $pdf->Ln(); 
    $pdf->SetFont('helvetica', '', 11);
    $pdf->writeHTMLCell(170, '', 20, '', 'Los que suscriben, bajo responsabilidad, AUTORIZAN Y HACEN CONSTAR QUE:<br>', 0, 0, 0, true, 'L', true);
    $pdf->Ln(); 

    $pdf->SetFont('helvetica', '', 11);
    //add content
    $html='
        <table cellpadding="2">
            <tr>
                <td><b>Don(ña):</b></td>
                <td align="center">'.$graduando->apell_nombres.'</td>
            </tr>
            <tr>
                <td><b>Con DNI/CE/PASAPORTE:</b></td>
                <td align="center">'.$graduando->dni.'</td>
            </tr>
            <tr>
                <td><b>Opto el Grado Académico o título Profesional de:</b></td>
                <td align="center">'.$expediente->escuela.'</td>
            </tr>
            <tr>
                <td><b>Código Único de Ingreso</b></td>
                <td align="center">'.$graduando->cui.'</td>
            </tr>
            <tr>
                <td><b>Fecha de Acto Académico</b></td>
                <td align="center">'.$fecha_acto_academico.'</td>
            </tr>
            <tr>
                <td><b>Fecha de Acuerdo de Consejo Directivo</b></td>
                <td align="center">'.$fecha_acuerdo.'</td>
            </tr>
            <tr>
                <td><b>N° de Resolución de Consejo Directivo</b></td>
                <td align="center">'.$resolucion_consejo_directivo.'</td>
            </tr>
            <tr>
                <td><b>Número total de Créditos</b></td>
                <td align="center">'.$total_creditos.'</td>
            </tr>
            <tr>
                <td><b>Enlace o Link de la URL del Trabajo de Investigación, Tesis, etc</b></td>
                <td align="center"><u>'.$link.'</u></td>
            </tr>
            <tr>
                <td><b>Nombre completo de: Trabajo de investigación/Tesis/Trabajo Académico/trabajo de Suficiencia Profesional</b></td>
                <td>'.$expediente->titulo.'</td>
            </tr>
            <tr>
                <td><b>N° de Recibo por pago de Diploma</b></td>
                <td align="center">B005-00084481</td>
            </tr>
            <tr>
                <td><b>Monto por pago del diploma</b></td>
                <td align="center">S/ 784.00</td>
            </tr>
            <tr>
                <td><b>Modalidad de Obtención</b></td>
                <td align="center">'.$modalidad_obtencion.'</td>
            </tr>
            <tr>
                <td><b>Nombre del Programa de Estudios Académicos</b></td>
                <td align="center">'.$programa_estudios.'</td>
            </tr>
            <tr>
                <td><b>Modalidad de Estudios</b></td>
                <td align="center">'.$modalidad_estudios.'</td>
            </tr>
            <tr>
                <td><b>Ley Universitaria con la que inició Estudios</b></td>
                <td align="center">'.$ley.'</td>
            </tr>
            <tr>
                <td><b>Número de Teléfono Fijo</b></td>
                <td align="center">'.$graduando->telefono_fijo.'</td>
            </tr>
            <tr>
                <td><b>Número de Teléfono Móvil</b></td>
                <td align="center">'.$graduando->telefono_movil.'</td>
            </tr>
            <tr>
                <td><b>Dirección de Residencia</b></td>
                <td align="center">'.$graduando->direccion.'</td>
            </tr>
            <tr>
                <td><b>Correo Electrónico</b></td>
                <td align="center">'.$graduando->email.'</td>
            </tr>
        </table><br>
        <style>

        th, td {
            border: 1px solid #060606;
        }

        </style>
    ';

    //using cell HTMl
    $pdf->writeHTMLCell(170, '', 20, '', $html, 0, 0, 0, true, 'J', true);
    $pdf->Ln(); 

    //add Text
    $exp='Se expide la presente autorización para que la parte interesada adquiera el diploma respectivo, en la oficina de Grados y Títulos de la UNSA. Dado que, se ha cumplido con todos los requisitos normados en la Ley Universitaria y demás reglamentos.<br>';
    $pdf->writeHTMLCell(170, '', 20, '', $exp, 0, 0, 0, true, 'J', true); 
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
    $pdf->SetFont('helvetica','',11);
    $pdf->writeHTMLCell(170, '', 20, '', 'Arequipa, '.$dia.' de '.$mes.' del '.$anio_actual.'<br><br><br>', 0, 0, 0, true, 'R', true); 
    $pdf->Ln(); 
    $pdf->SetFont('helvetica','B',12);
    $html2='
        <table>
            <tr>
                <td><SPAN STYLE="text-decoration:overline">DR. JUAN LUNA CARPIO</span></td>
                <td><SPAN STYLE="text-decoration:overline">SRA. SONIA CHEVARRIA DUEÑAS</span></td>
            </tr>
            <tr>
                <td>DECANO</td>
                <td>SECRETARIA DE FACULTAD</td>
            </tr>
        </table>
        <br>';

    $pdf->writeHTMLCell(170, '', 20, '', $html2, 0, 0, 0, true, 'C', true); 
    $pdf->Ln(); 

    //output
    $pdf->Output('Autorizacion_emision_diploma_'.$dia.'-'.$mes1.'-'.$anio_actual.'_'.$expediente->codigo.'.pdf', 'D');
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}

?>