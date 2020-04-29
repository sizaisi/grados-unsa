<?php

class Database {
	public static function conectar() {
		$conexion = new mysqli("localhost", "root", "", "siac_pruebas");
		$conexion->query("SET NAMES 'utf8'");
		
		return $conexion;
	}
}
