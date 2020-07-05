<?php

class GradoProcedimiento {
	private $id;
	private $idgrado_modalidad;
    private $idprocedimiento;
    private $idrol_area;
    private $tipo_rol; 
    private $url;
    private $orden;
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

	function getIdRolArea() {
		return $this->idrol_area;
	}

	function setIdRolArea($idrol_area) {
		$this->idrol_area = $idrol_area;
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
    
    function getDescripcion() {
		return $this->descripcion;
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
	}

    public function getAllGradoProcedimiento(){
        $result = array('error' => false);

        $sql = "SELECT gt_gp.*, gt_gt.nombre AS gradname, gt_mo.nombre AS movname, 
                       gt_p.nombre AS procname, gt_ra.nombre AS rolname, gt_gp.url_formulario 
                FROM gt_grado_procedimiento AS gt_gp 
                INNER JOIN gt_grado_modalidad AS gt_gm ON gt_gp.idgrado_modalidad = gt_gm.id 
                INNER JOIN gt_grado_titulo AS gt_gt ON gt_gm.idgrado_titulo = gt_gt.id 
                INNER JOIN gt_modalidad_obtencion AS gt_mo ON gt_gm.idmodalidad_obtencion = gt_mo.id 
                INNER JOIN gt_procedimiento AS gt_p ON gt_gp.idprocedimiento = gt_p.id 
                INNER JOIN gt_rol_area AS gt_ra ON gt_ra.id = gt_gp.idrol_area 
                WHERE gt_gm.condicion = 1";
        $result_query = mysqli_query($this->conn, $sql);

        $array_grado_procedimiento = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_grado_procedimiento, $row);
        }

        $result['array_grado_procedimiento'] = $array_grado_procedimiento;

        return $result;
    }

    public function getGradoProcedimientos($idusuario, $codi_usuario, $tipo_usuario) {

        $result = array('error' => false);
        
        $sql = "SELECT idgrado_procedimiento FROM gt_usuario_GRADO_PROCEDIMIENTO WHERE idusuario = $idusuario";
        $result_query = mysqli_query($this->conn, $sql);       
  
		if ($result_query && mysqli_num_rows($result_query) == 0) {

            if ($tipo_usuario == 'Administrativo') {
                $sql = "SELECT GT_GP.*, GT_P.id AS idproc, COUNT(GT_E.id) AS total_expedientes,
                        GT_P.nombre AS proc_nombre, GT_GP.descripcion AS proc_descripcion 
                        FROM gt_grado_procedimiento AS GT_GP
                        INNER JOIN gt_procedimiento AS GT_P ON GT_P.id = GT_GP.idprocedimiento 
                        INNER JOIN gt_expediente AS GT_E ON GT_E.idgrado_procedimiento = GT_GP.id
                        INNER JOIN SIAC_OPER_DEPE AS AC_OP ON AC_OP.codi_depe = GT_E.nues
                        WHERE GT_P.condicion = 1 AND GT_GP.idgrado_modalidad = $this->idgrado_modalidad 
                        AND GT_GP.idrol_area =  $this->idrol_area
                        AND AC_OP.codi_oper = '$codi_usuario'
                        GROUP BY GT_GP.id 
                        ORDER BY GT_GP.id ASC";

            }
            else if ($tipo_usuario == 'Docente') {	
                $sql = "SELECT GT_GP.*, GT_P.id AS idproc, COUNT(GT_E.id) AS total_expedientes,
                        GT_P.nombre AS proc_nombre, GT_GP.descripcion AS proc_descripcion 
                        FROM gt_grado_procedimiento AS GT_GP
                        INNER JOIN gt_procedimiento AS GT_P ON GT_P.id = GT_GP.idprocedimiento 
                        INNER JOIN gt_expediente AS GT_E ON GT_E.idgrado_procedimiento = GT_GP.id                    
                        WHERE GT_P.condicion = 1 AND GT_GP.idgrado_modalidad = $this->idgrado_modalidad 
                        AND GT_GP.idrol_area =  $this->idrol_area
                        AND GT_E.id IN (SELECT R.idexpediente
                                        FROM gt_recurso AS R
                                            INNER JOIN gt_persona AS P ON P.idrecurso = R.id
                                            INNER JOIN gt_usuario AS U ON U.id = P.iddocente
                                        WHERE IF(GT_GP.tipo_rol='asesor', P.tipo='asesor', P.tipo IN ('presidente', 'secretario', 'suplente')) 
                                            AND P.estado = 1  
                                            AND U.codi_usuario='$codi_usuario')                    
                        GROUP BY GT_GP.id 
                        ORDER BY GT_GP.id ASC";
            }
            else if ($tipo_rol == 'jurado') {
                $sql = "SELECT GT_GP.*, GT_P.id AS idproc, COUNT(GT_E.id) AS total_expedientes,
                        GT_P.nombre AS proc_nombre, GT_GP.descripcion AS proc_descripcion 
                        FROM gt_grado_procedimiento AS GT_GP
                        INNER JOIN gt_procedimiento AS GT_P ON GT_P.id = GT_GP.idprocedimiento 
                        INNER JOIN gt_expediente AS GT_E ON GT_E.idgrado_procedimiento = GT_GP.id                    
                        WHERE GT_P.condicion = 1 AND GT_GP.idgrado_modalidad = $this->idgrado_modalidad 
                        AND GT_GP.idrol_area =  $this->idrol_area
                        AND GT_E.id IN (SELECT R.idexpediente
										FROM gt_recurso AS R
										INNER JOIN gt_persona AS P ON P.idrecurso = R.id
										INNER JOIN gt_usuario AS U	ON U.id = P.iddocente									
										WHERE P.tipo IN ('presidente', 'secretario', 'suplente') 
										AND P.estado = 1 
										AND U.codi_usuario='$codi_usuario')
                        GROUP BY GT_GP.id 
                        ORDER BY GT_GP.id ASC";
            }          
		}
		else {
            /*$array_idgrado_procedimiento = array();

            while($row = $result_query->fetch_assoc()) {
                $array_idgrado_procedimiento[] = $row['idgrado_procedimiento'];
            }

			$sql = "SELECT GT_GP.*, GT_P.id AS idproc, GT_P.nombre AS proc_nombre, GT_P.descripcion AS proc_descripcion 
                    FROM gt_grado_procedimiento AS GT_GP
                    INNER JOIN gt_procedimiento AS GT_P ON GT_P.id = GT_GP.idprocedimiento 
                    WHERE GT_P.condicion = 1 AND GT_GP.idgrado_modalidad = $this->idgrado_modalidad 
                    AND GT_GP.idrol_area =  $this->idrol_area 
                    AND GT_GP.id IN (" . implode(',', $array_idgrado_procedimiento) . ") ORDER BY GT_GP.id ASC";*/
		}        

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
                FROM gt_grado_procedimiento AS gt_gp
                INNER JOIN gt_procedimiento AS gt_p ON gt_gp.idprocedimiento = gt_p.id
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

        $sql = "INSERT INTO gt_grado_procedimiento(idgrado_modalidad, idprocedimiento, idrol_area, tipo_rol, url_formulario, orden, descripcion, condicion) 
                VALUES ($this->idgrado_modalidad, $this->idprocedimiento, $this->idrol_area, '$this->tipo_rol', '$this->url', $this->orden, '$this->descripcion', 1)";
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

        $sql = "UPDATE gt_grado_procedimiento SET idgrado_modalidad = $this->idgrado_modalidad,
                       idprocedimiento = $this->idprocedimiento, idrol_area = $this->idrol_area,
                       tipo_rol = '$this->tipo_rol', orden = $this->orden,
                       url_formulario = '$this->url', descripcion = '$this->descripcion'
                WHERE id = $this->id";

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

        $sql = "UPDATE gt_grado_procedimiento SET condicion = 1 WHERE id = $this->id";

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

        $sql = "UPDATE gt_grado_procedimiento SET condicion = 0 WHERE id = $this->id";

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