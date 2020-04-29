<?php

class Expediente {
	private $id;

	private $conn;

	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	public function getListExpByIds($idgrado_procedimiento, $codi_usuario, $tipo_usuario, $tipo_rol) {
		$result = array('error' => false);
  
		if ($tipo_usuario == 'Administrativo') {
			$sql = "SELECT gt_e.*, a.nesc               
					FROM GT_EXPEDIENTE AS gt_e
					INNER JOIN actescu AS a ON gt_e.nues = a.nues
					WHERE gt_e.estado_expediente = 'En proceso' AND gt_e.idgrado_procedimiento=$idgrado_procedimiento
					AND gt_e.nues IN (SELECT codi_depe FROM SIAC_OPER_DEPE WHERE codi_oper='$codi_usuario')
					ORDER BY gt_e.fecha_inicio ASC";
		}
		else if ($tipo_usuario == 'Docente') {			

			if ($tipo_rol == 'asesor') {
				$sql = "SELECT *             
						FROM GT_EXPEDIENTE 
						WHERE estado_expediente = 'En proceso' AND idgrado_procedimiento=$idgrado_procedimiento
						AND id IN (SELECT UE.idexpediente
									FROM GT_USUARIO_EXPEDIENTE UE INNER JOIN GT_USUARIO U
									ON UE.idusuario = U.id
									WHERE UE.tipo = '$tipo_rol' 
									AND U.codi_usuario='$codi_usuario')
						ORDER BY fecha_inicio ASC";
			}
			else if ($tipo_rol == 'jurado') {
				$sql = "SELECT *             
						FROM GT_EXPEDIENTE 
						WHERE estado_expediente = 'En proceso' AND idgrado_procedimiento=$idgrado_procedimiento
						AND id IN (SELECT UE.idexpediente
									FROM GT_USUARIO_EXPEDIENTE UE INNER JOIN GT_USUARIO U
									ON UE.idusuario = U.id
									WHERE UE.tipo IN ('presidente', 'secretario', 'suplente') 
									AND U.codi_usuario='$codi_usuario')
						ORDER BY fecha_inicio ASC";
			}			
		}

		$result_query = mysqli_query($this->conn, $sql);
  
		$array_expediente = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_expediente, $row);
		}
  
		$result['array_expediente'] = $array_expediente;      
  
		return $result;
	 }   
	 public function getListByCodi($codi_usuario) {
  
		$result = array('error' => false);
  
		$sql="SELECT DISTINCT GT_EXPEDIENTE.*,actescu.nesc
			  FROM GT_MOVIMIENTO 
			  INNER JOIN GT_EXPEDIENTE ON GT_EXPEDIENTE.id = GT_MOVIMIENTO.idexpediente
			  INNER JOIN GT_USUARIO ON GT_USUARIO.id = GT_MOVIMIENTO.idusuario
			  INNER JOIN actescu ON GT_EXPEDIENTE.nues= actescu.nues
			  WHERE GT_EXPEDIENTE.estado_expediente='En proceso' 
			  AND GT_USUARIO.codi_usuario='$codi_usuario'";
	 
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_expediente = array();
  
		  while ($row = $result_query->fetch_assoc()) {            
  
			  $sql2 = "SELECT REPLACE(acdiden.apn,'/',' ') AS apell_nombres FROM acdiden 
					   INNER JOIN GT_GRADUANDO ON GT_GRADUANDO.cui = acdiden.cui
					   INNER JOIN GT_USUARIO ON GT_USUARIO.codi_usuario = GT_GRADUANDO.cui
					   INNER JOIN GT_USUARIO_EXPEDIENTE ON GT_USUARIO_EXPEDIENTE.idusuario = GT_USUARIO.id
					   INNER JOIN GT_EXPEDIENTE ON GT_EXPEDIENTE.id = GT_USUARIO_EXPEDIENTE.idexpediente
					   WHERE GT_EXPEDIENTE.id = ".$row['id'];
						  //Buscar si esta bien el row
			  $result_query2 = mysqli_query($this->conn, $sql2);
  
			  $row2 = $result_query2->fetch_assoc();
  
			 $row['apell_nombres'] = $row2['apell_nombres'];       
  
					 //$row['apell_nombres'] = $sql2;
			  array_push($array_expediente, $row);
						  
		  }
  
		  $result['array_expediente'] = $array_expediente;
  
		  return $result;
	 }
  
	 public function getMovByIdExp($idexpediente) {
  
		$result = array('error' => false);
  
		$sql =  "SELECT GT_MOVIMIENTO.* FROM GT_EXPEDIENTE
				 INNER JOIN GT_MOVIMIENTO ON GT_EXPEDIENTE.id = GT_MOVIMIENTO.idexpediente
				 INNER JOIN GT_USUARIO ON GT_USUARIO.id = GT_MOVIMIENTO.idusuario
				 WHERE GT_EXPEDIENTE.id = '$idexpediente'";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$row = $result_query->fetch_assoc();      
  
		$result['array_movimiento'] = $row;      
  
		return $result;
	 }
  
	 public function getExpediente() {
  
		$result = array('error' => false);
  
		$sql = "SELECT gt_e.*, ac_a.nesc " .             
			   "FROM GT_EXPEDIENTE AS gt_e " .
			   "INNER JOIN actescu AS ac_a ON gt_e.nues = ac_a.nues " .
			   "WHERE gt_e.id = $this->id";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$row = $result_query->fetch_assoc();      
  
		$result['expediente'] = $row;      
  
		return $result;
	 }   
}