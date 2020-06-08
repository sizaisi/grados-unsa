<?php

class Database {
	public static function conectar() {
		//$conexion = new mysqli("localhost", "root", "", "siac_pruebas"); //local
		$conexion = new mysqli("localhost", "prueba", "prueba", "siac"); // administrativo
		//$conexion = new mysqli("10.100.100.49", "prueba", "prueba", "siac"); // docente
		
		if ($conexion->connect_errno) {
            die("Fallo al conectar a MySQL: (" . $conexion->connect_errno . ") " . $conexion->connect_error);
        }
		
		$conexion->query("SET NAMES 'utf8'");		
		
		return $conexion;
	}
}
