<?php

class GradoTitulo {
	private $id;
	private $nombre;
	private $codigo;
    private $idprereq;
	private $descripcion;

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

	function getCodigo() {
		return $this->codigo;
	}

	function setCodigo($codigo) {
		$this->codigo = $codigo;
	}

	function getIdprereq() {
		return $this->idprereq;
	}

	function setIdprereq($idprereq) {
		$this->idprereq = $idprereq;
	}

	function getDescripcion() {
		return $this->descripcion;
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
	}
	
	public function getAllGradoTitulo(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_GRADO_TITULO";
        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_titulo = array();

        while ($row = $result_query->fetch_assoc()) {
            $gt = new GradoTitulo();
            $gt->id = $row['idprereq'];
            $gt->getById();
            $row['prerequisito'] = $gt->nombre;
            array_push($array_grado_titulo, $row);
        }

        $result['array_grado_titulo'] = $array_grado_titulo;

        return $result;
    }

    public function getActives(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_GRADO_TITULO where condicion = 1";
        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_titulo = array();

        while ($row = $result_query->fetch_assoc()) {
            $gt = new GradoTitulo();
            $gt->id = $row['idprereq'];
            $gt->getById();
            $row['prerequisito'] = $gt->nombre;
            array_push($array_grado_titulo, $row);
        }

        $result['array_grado_titulo'] = $array_grado_titulo;

        return $result;
    }

    public function getById(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_GRADO_TITULO WHERE id = $this->id";
        $result_query = mysqli_query($this->conn, $sql);
        $row = $result_query->fetch_assoc();
        $this->nombre = $row['nombre'];
        $this->codigo = $row['codigo'];
        $this->idprereq = $row['idprereq'];
        $this->descripcion = $row['descripcion'];

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_GRADO_TITULO VALUES (0, '$this->nombre', '$this->codigo'," .
                  " $this->idprereq, '$this->descripcion', 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado-Titulo agregado correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar el Grado-Titulo.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_TITULO SET nombre = '$this->nombre', " . 
            "codigo = '$this->codigo', idprereq = '$this->idprereq', " .
            "descripcion = '$this->descripcion' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado-Titulo actualizado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el Grado-Titulo.";
        }

        return $result;   
    }

    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_TITULO SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado-Titulo activado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el Grado-Titulo.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_TITULO SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado-Titulo desactivado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el Grado-Titulo.";
        }

        return $result;
    }
}