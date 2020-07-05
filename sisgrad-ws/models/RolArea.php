<?php

class RolArea {
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
	
	public function getAllRolArea(){
        $result = array('error' => false);

        $sql = "select * from gt_rol_area";
        $result_query = mysqli_query($this->conn, $sql);

        $array_rol_area = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_rol_area, $row);
        }

        $result['array_rol_area'] = $array_rol_area;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO gt_rol_area(nombre, condicion) VALUES ('$this->nombre', 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Rol-Area agregado correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar el Rol-Area.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_rol_area SET nombre = '$this->nombre' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Rol-Area actualizado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el Rol-Area.";
        }

        return $result;   
    }

    
    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_rol_area SET condicion = 'Activo' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Rol-Área activado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el Rol-Área.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_rol_area SET condicion = 'Inactivo' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Rol-Área desactivado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el Rol-Área.";
        }

        return $result;
    }    
}