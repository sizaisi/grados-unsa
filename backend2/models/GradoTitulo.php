<?php

class GradoTitulo {
	private $id;
	private $nombre;
	private $codigo;
    private $idprereq;
	private $descripcion;
	private $conexion;
	
	public function __construct() {
		$this->conexion = Database::conectar();
	}
	
	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function setNombre($nombre) {
		$this->nombre = $this->conexion->real_escape_string($nombre);
	}	

	function getCodigo() {
		return $this->codigo;
	}

	function setCodigo($codigo) {
		$this->codigo = $this->conexion->real_escape_string($codigo);
	}

	function getIdprereq() {
		return $this->idprereq;
	}

	function setIdprereq($idprereq) {
		$this->idprereq = $this->conexion->real_escape_string($idprereq);
	}

	function getDescripcion() {
		return $this->descripcion;
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $this->conexion->real_escape_string($descripcion);
	}
	
	public function getAllProgramaEstudios() {

		$result = array('error' => false);

		$sql = "SELECT * FROM grad_programa_estudios";

		$result_query = $this->conexion->query($sql);

		$array_programa_estudios = array();

		while ($row = $result_query->fetch_assoc()) {         
			array_push($array_programa_estudios, $row);
		}

		$result['array_programa_estudios'] = $array_programa_estudios;      

		return $result;
	}

	public function insertar() {      

		$result = array('error' => false);

		$sql = "INSERT INTO grad_programa_estudios(nombre) VALUES ('$this->nombre')";
      
		$result_query = $this->conexion->query($sql);

		if ($result_query) {
			$result['message'] = "Programa de estudios agregado correctamente.";
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo agregar el programa de estudios.";
		}      

		return $result;
	}

	public function actualizar() {      

		$result = array('error' => false);

		$sql = "UPDATE grad_programa_estudios SET nombre = '$this->nombre' WHERE id = $this->id";
		$result_query = $this->conexion->query($sql);

		if ($result_query) {
			$result['message'] = "Programa de estudios actualizado con éxito.";
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo actualizar el programa de estudios.";
		}

		return $result;
	}   

	public function activar() {      

		$result = array('error' => false);

		$sql = "UPDATE grad_programa_estudios SET condicion = 'Activo' WHERE id = $this->id";

		$result_query = $this->conexion->query($sql);

		if ($result_query) {
			$result['message'] = "Programa de estudios activado con éxito.";
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo activar el programa de estudios.";
		}

		return $result;
	}

	public function desactivar() {      

		$result = array('error' => false);

		$sql = "UPDATE grad_programa_estudios SET condicion = 'Inactivo' WHERE id = $this->id";

		$result_query = $this->conexion->query($sql);

		if ($result_query) {
			$result['message'] = "Programa de estudios desactivado con éxito.";
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo desactivar el programa de estudios.";
		}

		return $result;
	}	
}