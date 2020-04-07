<?php

class Procedimiento {
	private $id;
	private $nombre;
	private $descripcion;
	
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

	function getDescripcion() {
		return $this->descripcion;
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $this->conexion->real_escape_string($descripcion);
	}
	
	public function getAllProcedimiento(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_PROCEDIMIENTO";
        $result_query = mysqli_query($this->conn, $sql);

        $array_procedimiento = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_procedimiento, $row);
        }

        $result['array_procedimiento'] = $array_procedimiento;

        return $result;
    }

    public function getActives(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_PROCEDIMIENTO where condicion = 1";
        $result_query = mysqli_query($this->conn, $sql);

        $array_procedimiento = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_procedimiento, $row);
        }

        $result['array_procedimiento'] = $array_procedimiento;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_PROCEDIMIENTO VALUES (0, '$this->nombre', " .
                "'$this->descripcion' , 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Procedimiento agregado correctamente.";
        }
        else {
            $result['error'] = true;
            //$result['message'] = "No se pudo agregar el procedimiento.";
            $result['message'] = $sql;
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_PROCEDIMIENTO SET nombre = '$this->nombre'," .
                "descripcion = '$this->descripcion' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Procedimiento actualizado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el procedimiento.";
        }

        return $result;   
    }

    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_PROCEDIMIENTO SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Procedimiento activado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el procedimiento.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_PROCEDIMIENTO SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Procedimiento activado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el procedimiento.";
        }

        return $result;
    }
}