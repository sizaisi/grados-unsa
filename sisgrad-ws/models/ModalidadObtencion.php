<?php

class ModalidadObtencion {
	private $id;
    private $nombre;
    
    private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	function getId() {
		return $this->id;
	}

	function getNombre() {
		return $this->nombre;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $nombre; 
	}	
	
	public function getAllModalidadObtencion(){
        $result = array('error' => false);

        $sql = "SELECT * FROM gt_modalidad_obtencion";
        $result_query = mysqli_query($this->conn, $sql);

        $array_modalidad_obtencion = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_modalidad_obtencion, $row);
        }

        $result['array_modalidad_obtencion'] = $array_modalidad_obtencion;

        return $result;
    }

    public function getActives(){
        $result = array('error' => false);

        $sql = "SELECT * FROM gt_modalidad_obtencion where condicion = 1";
        $result_query = mysqli_query($this->conn, $sql);

        $array_modalidad_obtencion = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_modalidad_obtencion, $row);
        }

        $result['array_modalidad_obtencion'] = $array_modalidad_obtencion;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO gt_modalidad_obtencion(nombre, condicion, fing) VALUES ('$this->nombre', 1, null)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Modalidad de obtencion agregada correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar modalidad de obtencion.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_modalidad_obtencion SET nombre = '$this->nombre' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Modalidad de obtencion actualizada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar la modalidad de obtencion.";
        }

        return $result;   
    }

    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_modalidad_obtencion SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Modalidad de obtencion activada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar la modalidad de obtencion.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_modalidad_obtencion SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Modalidad de obtencion desactivada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar la modalidad de obtencion.";
        }

        return $result;
    }
}