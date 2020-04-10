<?php

class GradoProcedimiento {
	private $id;
	private $idgrado_modalidad;
    private $idprocedimiento;
    private $idrol;
    private $tipo_rol;    
    private $url;
    private $orden;

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

	function getIdGradoModalidad() {
		return $this->idgrado_modalidad;
	}

	function setIdGradoModalidad($idgrado_modalidad) {
		$this->idgrado_modalidad = $idgrado_modalidad;
	}	

	function getIdProcedimiento() {
		return $this->idprocedimiento;
	}

	function setIdProcedimiento($idprocedimiento) {
		$this->idprocedimiento = $idprocedimiento;
	}

	function getIdrol() {
		return $this->idrol;
	}

	function setIdRol($idrol) {
		$this->idrol = $idrol;
	}

	function getTipoRol() {
		return $this->tipo_rol;
	}

	function setTipoRol($tipo_rol) {
		$this->tipo_rol = $tipo_rol;
	}

	function getUrl() {
		return $this->url;
	}

	function setUrl($url) {
		$this->url = $url;
	}

	function getOrden() {
		return $this->orden;
	}

	function setOrden($orden) {
		$this->orden = $orden;
	}
	
	public function getGradoProcedimiento(){
        $result = array('error' => false);

        $sql = "SELECT GT_GP.idgrado_modalidad, GT_P.nombre, GT_P.descripcion
                FROM GT_GRADO_PROCEDIMIENTO GT_GP
                INNER JOIN GT_PROCEDIMIENTO GT_P ON GT_GP.idprocedimiento = GT_P.id
                WHERE GT_GP.id = $this->id";
        $result_query = mysqli_query($this->conn, $sql);        

        $row = $result_query->fetch_assoc();      

        $result['grado_procedimiento'] = $row;      

        return $result;
    }

    public function getAllGradoProcedimiento(){
        $result = array('error' => false);

        $sql = "select gt_gp.*, gt_gt.nombre as gradname, gt_mo.nombre as movname," .
                "gt_p.nombre as procname, gt_ra.nombre as rolname, gt_gp.url_formulario " .
                   "from GT_GRADO_PROCEDIMIENTO as gt_gp " .
                "inner join GT_GRADO_MODALIDAD as gt_gm on gt_gp.idgrado_modalidad = gt_gm.id " .
                "inner join GT_GRADO_TITULO as gt_gt on gt_gm.idgrado_titulo = gt_gt.id " .
                "inner join GT_MODALIDAD_OBTENCION as gt_mo on gt_gm.idmodalidad_obtencion = gt_mo.id ".
                "inner join GT_PROCEDIMIENTO as gt_p on gt_gp.idprocedimiento = gt_p.id " .
                "inner join GT_ROL_AREA as gt_ra on gt_ra.id = gt_gp.idrol_area where gt_gm.condicion = 1 ";
        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_procedimiento = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_grado_procedimiento, $row);
        }

        $result['array_grado_procedimiento'] = $array_grado_procedimiento;

        return $result;
    }

    public function getListByIds($idgrado_modalidad, $codi_usuario){

        $result = array('error' => false);        

        $sql = "SELECT idrol_area
                 FROM GT_USUARIO                                  
                 WHERE codi_usuario = '$codi_usuario'"; 

        $result_query = mysqli_query($this->conn, $sql);

        $row = $result_query->fetch_assoc();
        $idrol_area = $row['idrol_area'] != null ? $row['idrol_area'] : 0;        

        $sql = "SELECT gt_gp.*, gt_p.id AS idproc, gt_p.nombre AS proc_nombre, gt_p.descripcion AS proc_descripcion " .
               "FROM GT_GRADO_PROCEDIMIENTO AS gt_gp " .                
               "INNER JOIN GT_PROCEDIMIENTO AS gt_p ON gt_gp.idprocedimiento = gt_p.id " .
               "WHERE gt_p.condicion = 1 AND gt_gp.idgrado_modalidad=" . $idgrado_modalidad .
               " AND gt_gp.idrol_area = " . $idrol_area .
               " ORDER BY gt_gp.id ASC";

        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_procedimiento = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_grado_procedimiento, $row);
        }

        $result['array_grado_procedimiento'] = $array_grado_procedimiento;

        return $result;
    }

    public function getListByIdGradoModalidad() { //obtener todos los grado procedimientos por idgradomodalidad

        $result = array('error' => false);        
        
        $sql = "SELECT gt_gp.id AS idgradoproc, gt_p.nombre AS proc_nombre
                FROM GT_GRADO_PROCEDIMIENTO AS gt_gp
                INNER JOIN GT_PROCEDIMIENTO AS gt_p ON gt_gp.idprocedimiento = gt_p.id
                WHERE gt_gp.condicion = 1 AND gt_gp.idgrado_modalidad = $this->idgrado_modalidad
                ORDER BY gt_p.nombre ASC";

        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_procedimiento = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_grado_procedimiento, $row);
        }

        $result['array_grado_procedimiento'] = $array_grado_procedimiento;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_GRADO_PROCEDIMIENTO(idgrado_modalidad, idprocedimiento, idrol_area, tipo_rol, url_formulario, orden, condicion) 
                VALUES ($this->idgrado_modalidad, $this->idprocedimiento, $this->idrol, '$this->tipo_rol', '$this->url', $this->orden, 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado-Procedimiento agregado correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar el Grado-Procedimiento.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_PROCEDIMIENTO SET idgrado_modalidad = $this->idgrado_modalidad,
                idprocedimiento = $this->idprocedimiento, idrol_area = $this->idrol,
                tipo_rol = '$this->tipo_rol', orden = $this->orden,
                url_formulario = '$this->url' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado-Procedimiento actualizado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el Grado-Procedimiento.";
        }

        return $result;   
    }
    
    public function activar() {
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_PROCEDIMIENTO SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado-Procedimiento activado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el Grado-Procedimiento.";
        }

        return $result;
    }

    public function desactivar() {
        $result = array('error' => false);

        $sql = "UPDATE GT_GRADO_PROCEDIMIENTO SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Grado-Procedimiento desactivado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el Grado-Procedimiento.";
        }

        return $result;
    }    
}