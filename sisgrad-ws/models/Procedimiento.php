<?php

class Procedimiento {
	private $id;
	private $nombre;	
    
    private $conn;

	public function __construct() {
		$this->conn = Database::conectar();
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
		$this->nombre = $nombre;
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

        $sql = "INSERT INTO GT_PROCEDIMIENTO(nombre, condicion) VALUES ('$this->nombre', 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Procedimiento agregado correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar el procedimiento.";
            
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_PROCEDIMIENTO SET nombre = '$this->nombre' WHERE id = $this->id";

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

        $sql = "UPDATE GT_PROCEDIMIENTO SET condicion = 1 WHERE id = $this->id";

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

        $sql = "UPDATE GT_PROCEDIMIENTO SET condicion = 0 WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Procedimiento desactivado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el procedimiento.";
        }

        return $result;
    }
}