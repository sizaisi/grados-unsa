<?php

class CargoAutoridad {
	private $id;
    private $idautoridad;
    private $idcargo;
    private $fecha_inicio;
    private $fecha_fin;
    
    private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	function getId() {
		return $this->id;
	}

	function getIdautoridad() {
		return $this->idautoridad;
    }
    
    function getIdcargo() {
		return $this->idcargo;
    }
    
    function getFechaInicio() {
		return $this->fecha_inicio;
    }
    
    function getFechaFin() {
		return $this->fecha_fin;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setIdautoridad($idautoridad) {
		$this->idautoridad = $idautoridad; 
    }	
    
    function setIdcargo($idcargo) {
		$this->idcargo = $idcargo; 
    }

    function setFechaInicio($fecha_inicio) {
		$this->fecha_inicio = $fecha_inicio; 
    }

    function setFechaFin($fecha_fin) {
		$this->fecha_fin = $fecha_fin; 
	}
	
	public function getAllCargoAutoridad(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_CARGO_AUTORIDAD";
        $result_query = mysqli_query($this->conn, $sql);

        $array_cargo_autoridad = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_cargo_autoridad, $row);
        }

        $result['array_cargo_autoridad'] = $array_cargo_autoridad;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_CARGO_AUTORIDAD(id, idcargo, idautoridad, fecha_inicio, fecha_fin) VALUES ('$this->id','$this->idcargo','$this->idautoridad', '$this->fecha_inicio', '$this->fecha_fin')";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Cargo-Autoridad agregada correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar Cargo-Autoridad.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_CARGO_AUTORIDAD SET id = '$this->id', idcargo = '$this->idcargo', idautoridad = '$this->idautoridad', fecha_inicio = '$this->fecha_inicio', fecha_fin = '$this->fecha_fin' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Cargo-Autoridad actualizada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el Cargo-Autoridad.";
        }

        return $result;   
    }

    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_CARGO_AUTORIDAD SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Cargo-Autoridad activada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el Cargo-Autoridad.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_CARGO_AUTORIDAD SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Cargo-Autoridad desactivada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el Cargo-Autoridad.";
        }

        return $result;
    }

    public function getActives(){
        $result = array('error' => false);

        $sql = "SELECT gt_ca.*, gt_car.id AS cargoid, gt_car.nombre AS cargoname, gt_aut.id AS autoridadid, gt_aut.nombre AS autoridadname 
                FROM GT_CARGO_AUTORIDAD as gt_ca 
                INNER JOIN GT_CARGO AS gt_car ON gt_ca.idcargo = gt_car.id 
                INNER JOIN GT_AUTORIDAD AS gt_aut ON gt_ca.idautoridad = gt_aut.id 
                WHERE gt_ca.condicion = 1
                ORDER BY gt_car.nombre";
        $result_query = mysqli_query($this->conn, $sql);

        $array_cargo_autoridades = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_cargo_autoridades, $row);
        }

        $result['array_cargo_autoridades'] = $array_cargo_autoridades;

        return $result;
    }
}