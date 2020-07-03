<?php

class Cargo {
    private $id;
    private $codigo;
    private $nombre;    
    
    private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	function getId() {
		return $this->id;
    }
    
    function getCodigo() {
		return $this->codigo;
	}

	function getNombre() {
		return $this->nombre;
    }       
    
	function setId($id) {
		$this->id = $id;
    }
    
    function setCodigo($codigo) {
		$this->codigo = $codigo; 
	}

	function setNombre($nombre) {
		$this->nombre = $nombre; 
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

        $sql = "SELECT * FROM GT_CARGO WHERE condicion = 1";
        $result_query = mysqli_query($this->conn, $sql);

        $array_actives_cargo = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_actives_cargo, $row);
        }

        $result['array_actives_cargo'] = $array_actives_cargo;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_CARGO(codigo, nombre, condicion) VALUES ('$this->codigo', '$this->nombre', 1)";
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

        $sql = "UPDATE GT_CARGO SET codigo = '$this->codigo', nombre = '$this->nombre' WHERE id = $this->id";

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