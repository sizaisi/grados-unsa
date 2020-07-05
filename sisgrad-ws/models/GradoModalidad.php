<?php

class GradoModalidad {
	private $id;
	private $idgrado_titulo;
    private $idmodalidad_obtencion;

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

	function getIdGradoTitulo() {
		return $this->idgrado_titulo;
	}

	function setIdGradoTitulo($idgrado_titulo) {
		$this->idgrado_titulo = $idgrado_titulo;
	}	

	function getIdModalidadObtencion() {
		return $this->idmodalidad_obtencion;
	}

	function setIdModalidadObtencion($idmodalidad_obtencion) {
		$this->idmodalidad_obtencion = $idmodalidad_obtencion;
	}
	
	public function getAllGradoModalidadAdministrativo($codi_usuario, $idrol_area) {
        $result = array('error' => false);

        $sql = "SELECT GM.id, GT.nombre AS nombre_grado_titulo, GMO.nombre AS nombre_modalidad_obtencion
                FROM gt_grado_modalidad AS GM 
                INNER JOIN gt_grado_titulo AS GT ON GM.idgrado_titulo = GT.id 
                INNER JOIN gt_modalidad_obtencion AS GMO ON GM.idmodalidad_obtencion = GMO.id
                WHERE GM.condicion = 1
                ORDER BY nombre_grado_titulo ASC, GM.id ASC";

        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_modalidad = array();

        while ($row = $result_query->fetch_assoc()) {            

            $sql2 = "SELECT COUNT(*) AS total_expedientes 
                        FROM gt_grado_procedimiento AS GP INNER JOIN gt_expediente AS GE
                        ON GP.id = GE.idgrado_procedimiento
                        WHERE GP.idrol_area = $idrol_area
                        AND GE.nues IN (SELECT codi_depe FROM SIAC_OPER_DEPE WHERE codi_oper='$codi_usuario') 
                        AND GP.idgrado_modalidad = ".$row['id'];
                        
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

    public function getAllGradoModalidadDocente($codi_usuario, $idrol_area) {
        $result = array('error' => false);

        $sql = "SELECT GM.id, GT.nombre AS nombre_grado_titulo, GMO.nombre AS nombre_modalidad_obtencion
                FROM gt_grado_modalidad AS GM 
                INNER JOIN gt_grado_titulo AS GT ON GM.idgrado_titulo = GT.id 
                INNER JOIN gt_modalidad_obtencion AS GMO ON GM.idmodalidad_obtencion = GMO.id
                WHERE GM.condicion = 1
                ORDER BY nombre_grado_titulo ASC, GM.id ASC";

        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_modalidad = array();

        while ($row = $result_query->fetch_assoc()) {            

            $sql2 = "SELECT COUNT(*) AS total_expedientes 
                        FROM gt_grado_procedimiento AS GP INNER JOIN gt_expediente AS GE
                        ON GP.id = GE.idgrado_procedimiento
                        WHERE GP.idrol_area = $idrol_area
                        AND GE.id IN (SELECT R.idexpediente
                                        FROM gt_recurso R 
                                        INNER JOIN gt_persona P ON P.idrecurso = R.id
                                        INNER JOIN gt_usuario U ON U.id = P.iddocente
                                        WHERE IF(GP.tipo_rol='asesor', P.tipo='asesor', P.tipo IN ('presidente', 'secretario', 'suplente')) 
                                        AND P.estado = 1 
                                        AND U.codi_usuario='$codi_usuario') 
                        AND GP.idgrado_modalidad = ".$row['id'];
                        
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

    public function getAllGradoModalidad(){
        $result = array('error' => false);

        $sql = "SELECT gt_gm.*, gt_gt.nombre as gradname, gt_mo.nombre as movname 
                FROM gt_grado_modalidad as gt_gm 
                INNER JOIN gt_grado_titulo as gt_gt on gt_gm.idgrado_titulo = gt_gt.id 
                INNER JOIN gt_modalidad_obtencion as gt_mo on gt_gm.idmodalidad_obtencion = gt_mo.id";
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
                FROM gt_grado_modalidad as gt_gm 
                INNER JOIN gt_grado_titulo AS gt_gt ON gt_gm.idgrado_titulo = gt_gt.id 
                INNER JOIN gt_modalidad_obtencion AS gt_mo ON gt_gm.idmodalidad_obtencion = gt_mo.id 
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

        $sql = "SELECT * FROM gt_grado_modalidad WHERE idgrado_titulo = $id";
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

        $sql = "INSERT INTO gt_grado_modalidad(idgrado_titulo, idmodalidad_obtencion) VALUES ($this->idgrado_titulo, $this->idmodalidad_obtencion, 1)";
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

        $sql = "UPDATE gt_grado_modalidad  SET idgrado_titulo = $this->idgrado_titulo, 
                       idmodalidad_obtencion = $this->idmodalidad_obtencion 
                WHERE id = $this->id";
        
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

        $sql = "UPDATE gt_grado_modalidad SET condicion = 1 WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado modalidad activado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el grado modalidad.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE gt_grado_modalidad SET condicion = 0 WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado modalidad desactivado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el grado modalidad.";
        }

        return $result;
    }
}