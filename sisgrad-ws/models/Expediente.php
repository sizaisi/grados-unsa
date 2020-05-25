<?php

class Expediente {
	private $id;
	private $url_repo;

	private $conn;

	function getId() {
		return $this->id;
	}

	function setId($id) {
		$this->id = $id;
	}

	function getUrlRepo() {
		return $this->url_repo;
	}

	function setUrlRepo($url_repo) {
		$this->url_repo = $url_repo;
	}

	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	public function getList($idgrado_procedimiento, $codi_usuario, $tipo_usuario, $tipo_rol) {
		$result = array('error' => false);
  
		if ($tipo_usuario == 'Administrativo') {
			$sql = "SELECT GT_E.id, GT_E.codigo, GT_E.fecha AS fecha_recepcion, GT_E.estado, 
						   GROUP_CONCAT(REPLACE(AC_I.apn,'/',' ') SEPARATOR ' / ') AS graduando,
						   AC_E.nesc AS escuela
					FROM GT_EXPEDIENTE AS GT_E
						INNER JOIN GT_GRADUANDO_EXPEDIENTE AS GT_GE ON GT_GE.idexpediente = GT_E.id 
						INNER JOIN GT_GRADUANDO AS GT_G ON GT_G.id = GT_GE.idgraduando 		
						INNER JOIN acdiden AS AC_I ON AC_I.cui = GT_G.cui			
						INNER JOIN actescu AS AC_E ON AC_E.nues = GT_E.nues						
						INNER JOIN SIAC_OPER_DEPE AC_OP ON AC_OP.codi_depe = GT_E.nues
					WHERE GT_E.idgrado_procedimiento = $idgrado_procedimiento					
						AND AC_OP.codi_oper = '$codi_usuario'
					GROUP BY GT_GE.idexpediente 
					ORDER BY GT_E.id ASC";
		}
		else if ($tipo_usuario == 'Docente') {			

			if ($tipo_rol == 'asesor') {
				$sql = "SELECT GT_E.id, GT_E.codigo, GT_E.fecha AS fecha_recepcion, GT_E.estado, 
							   GROUP_CONCAT(REPLACE(AC_I.apn,'/',' ') SEPARATOR ' / ') AS graduando,
							   AC_E.nesc AS escuela
						FROM GT_EXPEDIENTE AS GT_E
							INNER JOIN GT_GRADUANDO_EXPEDIENTE AS GT_GE ON GT_GE.idexpediente = GT_E.id 
							INNER JOIN GT_GRADUANDO AS GT_G ON GT_G.id = GT_GE.idgraduando 		
							INNER JOIN acdiden AS AC_I ON AC_I.cui = GT_G.cui			
							INNER JOIN actescu AS AC_E ON AC_E.nues = GT_E.nues						
						WHERE GT_E.idgrado_procedimiento = $idgrado_procedimiento
							AND GT_E.id IN (SELECT R.idexpediente
											FROM GT_RECURSO AS R
												INNER JOIN GT_PERSONA AS P ON P.idrecurso = R.id
												INNER JOIN GT_USUARIO AS U ON U.id = P.iddocente
											WHERE P.tipo = 'asesor'
												AND P.estado = 1  
												AND U.codi_usuario='$codi_usuario')
						GROUP BY GT_GE.idexpediente
						ORDER BY GT_E.id ASC";
			}
			else if ($tipo_rol == 'jurado') {
				$sql = "SELECT GT_E.id, GT_E.codigo, GT_E.fecha AS fecha_recepcion, GT_E.estado, 
							   GROUP_CONCAT(REPLACE(AC_I.apn,'/',' ') SEPARATOR ' / ') AS graduando,
							   AC_E.nesc AS escuela
						FROM GT_EXPEDIENTE AS GT_E
							INNER JOIN GT_GRADUANDO_EXPEDIENTE AS GT_GE ON GT_GE.idexpediente = GT_E.id 
							INNER JOIN GT_GRADUANDO AS GT_G ON GT_G.id = GT_GE.idgraduando 		
							INNER JOIN acdiden AS AC_I ON AC_I.cui = GT_G.cui			
							INNER JOIN actescu AS AC_E ON AC_E.nues = GT_E.nues						 
						WHERE GT_E.idgrado_procedimiento = $idgrado_procedimiento
						AND GT_E.id IN (SELECT R.idexpediente
										FROM GT_RECURSO AS R
										INNER JOIN GT_PERSONA AS P ON P.idrecurso = R.id
										INNER JOIN GT_USUARIO AS U	ON U.id = P.iddocente									
										WHERE P.tipo IN ('presidente', 'secretario', 'suplente') 
										AND P.estado = 1 
										AND U.codi_usuario='$codi_usuario')
						GROUP BY GT_GE.idexpediente
						ORDER BY GT_E.id ASC";
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
			  WHERE GT_USUARIO.codi_usuario='$codi_usuario'";
	 
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

	 public function getURL() {
  
		$result = array('error' => false);
  
		$sql = "SELECT url_repo FROM GT_EXPEDIENTE WHERE id = $this->id";

		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {			
			if (mysqli_num_rows($result_query) > 0) {
				$row = $result_query->fetch_assoc();        
				$result['url_repo'] = $row['url_repo'];
			}			
			else {
				$result['error'] = true;
				$result['message'] = "No se pudo encontrar la url de repositorio.";            
			}			
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener el url de repositorio.";            
		}		
  
		return $result;
	 }   
  
	 public function getExpediente() {
  
		$result = array('error' => false);
  
		$sql = "SELECT GT_E.*, AC_E.nesc AS escuela, AC_F.nfac AS facultad
			    FROM GT_EXPEDIENTE AS GT_E
			    INNER JOIN actescu AS AC_E ON GT_E.nues = AC_E.nues
				INNER JOIN actfacu AS AC_F ON AC_F.facu = AC_E.facu
			    WHERE GT_E.id = $this->id";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$row = $result_query->fetch_assoc();      
  
		$result['expediente'] = $row;      
  
		return $result;
	 }  
	 
	 public function actualizar_url(){
        $result = array('error' => false);

        $sql = "UPDATE GT_EXPEDIENTE SET url_repo = '$this->url_repo' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "URL actualizado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el URL.";
        }

        return $result;   
    }
}