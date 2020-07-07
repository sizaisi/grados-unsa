<?php

class CajaDatabase {
	public static function conectar() {		
		$conexion = new mysqli("localhost", "prueba", "prueba", "db_caja");		
		
		if ($conexion->connect_errno) {
            die("Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error);
        }
		
		$conexion->query("SET NAMES 'utf8'");		
		
		return $conexion;
	}
}
