<?php

class GradoModalidad {
	private $id;
	private $idgrado_titulo;
    private $idmodalidad_obtencion;
	
	public function __construct() {
		$this->conexion = Database::conectar();
	}
	
	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	function getIdgrado_Titulo() {
		return $this->idgrado_titulo;
	}

	function setIdgrado_Titulo($idgrado_titulo) {
		$this->idgrado_titulo = $this->conexion->real_escape_string($idgrado_titulo);
	}	

	function getIdmodalidad_Obtencion() {
		return $this->idmodalidad_obtencion;
	}

	function setIdmodalidad_Obtencion($idmodalidad_obtencion) {
		$this->idmodalidad_obtencion = $this->conexion->real_escape_string($idmodalidad_obtencion);
	}
	
	public function getAllModalidadEscritorio($codi_usuario) {
        $result = array('error' => false);

        $sql = "SELECT idrol_area
                 FROM GT_USUARIO                                  
                 WHERE codi_usuario = '$codi_usuario'"; 

        $result_query = mysqli_query($this->conn, $sql);

        $row = $result_query->fetch_assoc();
        $idrol_area = $row['idrol_area'] != null ? $row['idrol_area'] : 0;

        $sql = "SELECT GM.id AS idgrado_modalidad, GT.nombre AS nombre_grado_titulo, GMO.nombre AS nombre_modalidad_obtencion
                FROM GT_GRADO_MODALIDAD AS GM 
                INNER JOIN GT_GRADO_TITULO AS GT ON GM.idgrado_titulo = GT.id 
                INNER JOIN GT_MODALIDAD_OBTENCION AS GMO ON GM.idmodalidad_obtencion = GMO.id
                WHERE GM.condicion = 1
                ORDER BY nombre_grado_titulo ASC, idgrado_modalidad ASC";

        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_modalidad = array();

        while ($row = $result_query->fetch_assoc()) {            

            $sql2 = "SELECT COUNT(*) AS total_expedientes 
                        FROM GT_GRADO_PROCEDIMIENTO AS GP INNER JOIN GT_EXPEDIENTE AS GE
                        ON GP.id = GE.idgrado_procedimiento
                        WHERE GE.estado_expediente = 'En proceso'
                        AND GP.idrol_area = $idrol_area
                        AND GE.nues IN (SELECT codi_depe FROM SIAC_OPER_DEPE WHERE codi_oper='$codi_usuario') 
                        AND GP.idgrado_modalidad = ".$row['idgrado_modalidad'];
                        
            $result_query2 = mysqli_query($this->conn, $sql2);

            $row2 = $result_query2->fetch_assoc();

            if ($row2['total_expedientes'] > 0) { //obtener solo aquellos items que tengan expedientes en proceso
                $row['total_expedientes'] = $row2['total_expedientes'];                        
                array_push($array_grado_modalidad, $row);
            }            
        }

        $result['array_grado_modalidad'] = $array_grado_modalidad;

        return $result;
    }

    public function getGradoModalidad() {
        $result = array('error' => false);

        $sql = "SELECT GT.nombre AS nomb_grado_titulo, MO.nombre AS nomb_mod_obtencion
                FROM GT_GRADO_MODALIDAD AS GM 
                INNER JOIN GT_GRADO_TITULO AS GT ON GM.idgrado_titulo = GT.id
                INNER JOIN GT_MODALIDAD_OBTENCION AS MO ON GM.idmodalidad_obtencion = MO.id
                WHERE GM.id = $this->id"; 

        $result_query = mysqli_query($this->conn, $sql);

        $row = $result_query->fetch_assoc();

        $result['grado_modalidad'] = $row;

        return $result;
    }

    public function getAllGradoModalidad(){
        $result = array('error' => false);

        $sql = "select gt_gm.*, gt_gt.nombre as gradname, gt_mo.nombre as movname from GT_GRADO_MODALIDAD as gt_gm inner join GT_GRADO_TITULO as gt_gt on gt_gm.idgrado_titulo = gt_gt.id inner join GT_MODALIDAD_OBTENCION as gt_mo on gt_gm.idmodalidad_obtencion = gt_mo.id";
        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_modalidad = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_grado_modalidad, $row);
        }

        $result['array_grado_modalidad'] = $array_grado_modalidad;

        return $result;
    }

    public function getActives(){
        $result = array('error' => false);

        $sql = "SELECT gt_gm.*, gt_gt.nombre AS gradname, gt_mo.nombre AS movname 
                FROM GT_GRADO_MODALIDAD as gt_gm 
                INNER JOIN GT_GRADO_TITULO AS gt_gt ON gt_gm.idgrado_titulo = gt_gt.id 
                INNER JOIN GT_MODALIDAD_OBTENCION AS gt_mo ON gt_gm.idmodalidad_obtencion = gt_mo.id 
                WHERE gt_gm.condicion = 1
                ORDER BY gt_gt.nombre";
        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_modalidad = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_grado_modalidad, $row);
        }

        $result['array_grado_modalidad'] = $array_grado_modalidad;

        return $result;
    }

    public function searchByIdGradoTitulo($id){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_GRADO_MODALIDAD WHERE idgrado_titulo = $id";
        $result_query = mysqli_query($this->conn, $sql);

        $array_result = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_result, $row);
        }

        $result['array_result'] = $array_result;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_GRADO_MODALIDAD VALUES (0, " .
                "$this->idgrado_titulo, $this->idmodalidad_obtencion, 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado modalidad agregado correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar el grado modalidad.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_MODALIDAD  SET idgrado_titulo = $this->idgrado_titulo, " .
            "idmodalidad_obtencion = $this->idmodalidad_obtencion WHERE id = $this->id";
        
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado modalidad actualizado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el grado modalidad.";
        }

        return $result;   
    }

    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_MODALIDAD SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado modalidad activadio con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el grado modalidad.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_MODALIDAD SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado modalidad desactivada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el grado modalidad.";
        }

        return $result;
    }
}