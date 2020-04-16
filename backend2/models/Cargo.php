<?php

class Cargo {
	private $id;
    private $nombre;
    private $tipo;
    
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
    
    function getTipo() {
		return $this->tipo;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setNombre($nombre) {
		$this->nombre = $nombre; 
    }	
    
    function setTipo($tipo) {
		$this->tipo = $tipo; 
	}
	
	public function getAllCargo(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_CARGO";
        $result_query = mysqli_query($this->conn, $sql);

        $array_cargo = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_cargo, $row);
        }

        $result['array_cargo'] = $array_cargo;

        return $result;
    }

    public function getActives(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_CARGO where condicion = 1";
        $result_query = mysqli_query($this->conn, $sql);

        $array_cargo = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_cargo, $row);
        }

        $result['array_cargo'] = $array_cargo;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_CARGO(nombre, tipo, condicion) VALUES ('$this->nombre','$this->tipo', 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Cargo agregado correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar Cargo.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_CARGO SET nombre = '$this->nombre', tipo = '$this->tipo' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Cargo actualizado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el Cargo.";
        }

        return $result;   
    }

    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_CARGO SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Cargo activado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el Cargo.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_CARGO SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Cargo desactivado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el Cargo.";
        }

        return $result;
    }
}