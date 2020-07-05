<?php

class Autoridad {
	private $id;
    private $nombre;
    private $grado;
    
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
    
    function getGrado() {
		return $this->grado;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $nombre; 
    }	
    
    function setGrado($grado) {
		$this->grado = $grado; 
	}	
	
	public function getAllAutoridad(){
        $result = array('error' => false);

        $sql = "SELECT * FROM gt_autoridad";
        $result_query = mysqli_query($this->conn, $sql);

        $array_autoridad = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_autoridad, $row);
        }

        $result['array_autoridad'] = $array_autoridad;

        return $result;
    }

    public function getActives(){
        $result = array('error' => false);

        $sql = "SELECT * FROM gt_autoridad WHERE condicion = 1";
        $result_query = mysqli_query($this->conn, $sql);

        $array_actives_autoridad = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_actives_autoridad, $row);
        }

        $result['array_actives_autoridad'] = $array_actives_autoridad;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO gt_autoridad(nombre, grado, condicion) VALUES ('$this->nombre', '$this->grado', 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Autoridad agregada correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar Autoridad.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_autoridad SET nombre = '$this->nombre', grado ='$this->grado' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Autoridad actualizada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar la Autoridad.";
        }

        return $result;   
    }

    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_autoridad SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Autoridad activada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar la Autoridad.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_autoridad SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Autoridad desactivada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar la Autoridad.";
        }

        return $result;
    }
}