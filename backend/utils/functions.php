<?php

date_default_timezone_set('America/Lima');

//formato Lunes, $dia de $mes del $año
function fecha_extendida($fecha) {
   
	$dias_nombre = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miércoles',
					     'Thursday'=>'Jueves','Friday'=>'Viernes','Saturday'=>'Sábado','Sunday'=>'Domingo');

	$meses_nombre=array(1=>"enero","febrero","marzo","abril","mayo","junio","julio",
					       "agosto","septiembre","octubre","noviembre","diciembre");

	//lookup dia based on day name
	$dia_nombre =  $dias_nombre[date('l', strtotime($fecha))];
	$mes_nombre =  $meses_nombre[date('n', strtotime($fecha))];
	$dia_numero =  date('d', strtotime($fecha));
	$anio =  date('Y', strtotime($fecha));

	return $dia_nombre . ', ' . $dia_numero . ' de ' . $mes_nombre . ' del ' . $anio;     
}  

function dia_actual() {					   	
	return date('d');
}

function mes_actual() {
	$meses_nombre=array(1=>"enero","febrero","marzo","abril","mayo","junio","julio",
					       "agosto","septiembre","octubre","noviembre","diciembre");
						   
	return $meses_nombre[date('n')];
}

function anio_actual() {					   
	return date('Y');
}

?>