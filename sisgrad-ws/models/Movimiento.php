<?php

class Movimiento {
	private $id;
	private $idexpediente;
	private $idusuario;
	private $idruta;   
	private $idmov_anterior;   

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

	function getIdExpediente() {
		return $this->idexpediente;
	}

	function setIdExpediente($idexpediente) {
		$this->idexpediente = $idexpediente;
	}	

	function getIdUsuario() {
		return $this->idusuario;
	}

	function setIdUsuario($idusuario) {
		$this->idusuario = $idusuario;
	}

	function getIdRuta() {
		return $this->idruta;
	}

	function setIdRuta($idruta) {
		$this->idruta = $idruta;
	}
	
	function getIdMovAnteior() {
		return $this->idmov_anterior;
	}

	function setIdMovAnterior($idmov_anterior) {
		$this->idmov_anterior = $idmov_anterior;
	}

	//function aceptar_movimiento y function cancelar movimiento

	//para devolver el movimiento actual de entrada a traves del idgrado-procedimiento destino
	function getLastMovimiento($idgradproc_destino) {		
		$result = array('error' => false);

		//obtener el ultimo movimiento
        $sql = "SELECT GT_M.id, GT_U.id AS idusuario, GT_U.codi_usuario, GT_U.tipo AS tipo_usuario, GT_M.fecha, GT_R.etiqueta, GT_P.nombre AS procedimiento_origen, GT_GP.tipo_rol, GT_RA.nombre AS rol_area_origen
				FROM GT_MOVIMIENTO AS GT_M 
					INNER JOIN GT_USUARIO AS GT_U ON GT_U.id = GT_M.idusuario 
					INNER JOIN GT_RUTA AS GT_R ON GT_R.id = GT_M.idruta 
					INNER JOIN GT_GRADO_PROCEDIMIENTO AS GT_GP ON GT_GP.id = GT_R.idgradproc_origen 
					INNER JOIN GT_PROCEDIMIENTO AS GT_P ON GT_P.id = GT_GP.idprocedimiento 
					LEFT JOIN GT_ROL_AREA AS GT_RA ON GT_GP.tipo_rol = '' AND GT_RA.id = GT_GP.idrol_area 
				WHERE GT_R.idgradproc_destino = $idgradproc_destino 
					AND GT_M.idexpediente = $this->idexpediente 
					AND GT_R.condicion = 1
				ORDER BY GT_M.id desc limit 1";				
		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {									  
			if ($row = $result_query->fetch_assoc()) {
				//actualizar la columna aceptado = 1 del ultimo movimiento
				switch ($row['tipo_usuario']) {
					case 'Administrativo':
						$sql2 = "SELECT nomb_oper AS nombre_usuario  
								 FROM SIAC_OPER
								 WHERE codi_oper = '" . $row['codi_usuario'] . "'";
						break;
					
					case 'Docente':
						$sql2 = "SELECT REPLACE(apn, '/', ' ') AS nombre_usuario  
									FROM SIAC_DOC
									WHERE codper = '" . $row['codi_usuario'] . "'";
						break;

					case 'Estudiante': //si hay conexion con reniec obtendria datos de GT_GRADUANDO
						$sql2 = "SELECT REPLACE(apn, '/', ' ') AS nombre_usuario  									
									FROM acdiden 
									WHERE cui = '" . $row['codi_usuario'] . "'";
						break;
				}

				$result_query2 = mysqli_query($this->conn, $sql2);

				if ($result_query2) {									  
					$row2 = $result_query2->fetch_assoc();				
					$row['nombre_usuario'] = $row2['nombre_usuario'];   
					$result['movimiento'] = $row;  

					//actualizar a 1 el campo aceptado del ultimo movimiento del expediente
					//JEIKEN TEMPORAL ESTE UPDATE DEBE ESTAR EN UNA TRANSACCION Y QUIZAS EN UNA FUNCION APARTE
					$sql = "UPDATE GT_MOVIMIENTO SET aceptado = 1 WHERE id = " . $row['id'];        
					$result_query = mysqli_query($this->conn, $sql);

					if (!$result_query) {
						$result['error'] = true;                    
						$result['message'] = "No se pudo actualizar o aceptar el movimiento en el expediente destino.";
					}				
				}
				else {
					$result['error'] = true;
					$result['message'] = "No se pudo obtener el nombre de usuario.";            
				}											
			}	
			else {
				$result['error'] = true;
				$result['message'] = "No existe el movimiento que actualizó el procedimiento del expediente seleccionado.";
			}	
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener el ultimo movimiento de entrada del procedimiento.";            
		}       

        return $result;
	}

	public function getExpedientesEnviados($idgradproc_origen) {
		$result = array('error' => false);  
		
		$sql = "SELECT t_movimiento.*, GT_MO.fecha AS fecha_ant, GT_RU.etiqueta
				FROM
					(SELECT GT_M.id, GT_M.idexpediente, GT_E.codigo, GT_M.fecha AS fecha_envio, GT_E.estado, 
						GROUP_CONCAT(REPLACE(AC_I.apn,'/',' ') SEPARATOR ' / ') AS graduando,
						AC_E.nesc AS escuela, GT_R.idgradproc_origen, GT_M.idmov_anterior
					FROM GT_MOVIMIENTO AS GT_M
						INNER JOIN GT_RUTA AS GT_R ON GT_R.id = GT_M.idruta 
						INNER JOIN GT_EXPEDIENTE AS GT_E ON GT_E.id = GT_M.idexpediente 
						INNER JOIN GT_GRADUANDO_EXPEDIENTE AS GT_GE ON GT_GE.idexpediente = GT_E.id 
						INNER JOIN GT_GRADUANDO AS GT_G ON GT_G.id = GT_GE.idgraduando 		
						INNER JOIN acdiden AS AC_I ON AC_I.cui = GT_G.cui			
						INNER JOIN actescu AS AC_E ON AC_E.nues = GT_E.nues											
					WHERE GT_R.idgradproc_origen = $idgradproc_origen  					
						AND GT_M.idusuario = $this->idusuario
						AND GT_M.aceptado = 0  
					GROUP BY GT_GE.idexpediente 
					ORDER BY GT_M.id ASC) AS t_movimiento 
				INNER JOIN GT_MOVIMIENTO AS GT_MO ON GT_MO.id = t_movimiento.idmov_anterior
				INNER JOIN GT_RUTA AS GT_RU ON GT_RU.id = GT_MO.idruta";		
		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {
			$array_exp_enviados = array();
  
			while ($row = $result_query->fetch_assoc()) {         
				array_push($array_exp_enviados, $row);
			}
	
			$result['array_exp_enviados'] = $array_exp_enviados;			
			$result['message'] = $sql;
		}       
		else {
			$result['error'] = true;                    
			$result['message'] = "No se pudo obtener los expedientes enviados.";
		}	
  
		return $result;		
	}
	
	// registrar movimiento y actualizar procedimiento del expediente con el idgradprod_destino
	public function mover($idgradproc_origen, $idgradproc_destino, $estado_expediente) {      
      
		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion
		
		//realizar movimiento con la ruta seleccionada
		$sql = "INSERT INTO GT_MOVIMIENTO(idexpediente, idusuario, fecha, idruta, idmov_anterior) 
				VALUES ($this->idexpediente, $this->idusuario, now(), $this->idruta, $this->idmov_anterior)";      
		$result_query = mysqli_query($this->conn, $sql);     
  
		$idmovimiento;
		
		if (!$result_query) {
		   	$result['error'] = true;                    
		}       
		else {
			$idmovimiento = mysqli_insert_id($this->conn);
		}

		//asignar el idmovimiento a los recursos agregados en el expediente
		$sql = "UPDATE GT_RECURSO SET idmovimiento = $idmovimiento
				WHERE idexpediente = $this->idexpediente
				AND idusuario = $this->idusuario
				AND idgrado_proc = $idgradproc_origen
				AND idmovimiento IS NULL";        
		$result_query = mysqli_query($this->conn, $sql);
  
		if (!$result_query) {
		   $result['error'] = true;                    
		}
  
		//actualizar expediente para conocer en que procedimiento se encuentra
		$sql = "UPDATE GT_EXPEDIENTE 
				SET idgrado_procedimiento = $idgradproc_destino,
					fecha = now(),
					estado = '$estado_expediente'  
				WHERE id = $this->idexpediente";        
		$result_query = mysqli_query($this->conn, $sql);
  
		if (!$result_query) {
		   $result['error'] = true;                    
		}
  
		//verificar y realizar transaccion
		if($result['error'] == false) { //si no hay ningun error en querys
		   $this->conn->commit();          
		   $result['message'] = "El expediente fue derivado satisfactoriamente.";
		}
		else {
		   $this->conn->rollback(); // deshacer transaccion
		   $result['message'] = "No se pudo derivar el expediente.";
		}
  
		$this->conn->autocommit(TRUE); //finalizar transaccion
  
		return $result;     
	 }      
  
	 // eliminar movimiento y actualizar procedimiento del expediente con el idgradprod_origen
	 public function deshacer($idgradproc_origen, $fecha_ant, $estado_expediente_ant) {      
		
		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion
		
		//eliminar el ultimo movimiento realizado
		$sql = "DELETE FROM GT_MOVIMIENTO WHERE id = $this->id";      
		$result_query = mysqli_query($this->conn, $sql);     
  
		if (!$result_query) {
		   $result['error'] = true;                    
		}     
  
		//actualizar expediente para conocer en que procedimiento se encuentra		
		$sql = "UPDATE GT_EXPEDIENTE 
				SET idgrado_procedimiento = $idgradproc_origen, 
					fecha = '$fecha_ant',
					estado = '$estado_expediente_ant' 
				WHERE id = $this->idexpediente";        
		$result_query = mysqli_query($this->conn, $sql);
  
		if (!$result_query) {
		   $result['error'] = true;                    
		}

		//actualizar a nulo el idmovimiento de los recursos que tienen el idmovimiento seleccionado
		$sql = "UPDATE GT_RECURSO SET idmovimiento = NULL
				WHERE idmovimiento = $this->id";        
		$result_query = mysqli_query($this->conn, $sql);
  
		if (!$result_query) {
		   $result['error'] = true;
		}
  
		//verificar y realizar transaccion
		if($result['error'] == false) { //si no hay ningun error en querys
		   $this->conn->commit();          
		   $result['message'] = "El movimiento fue eliminado satisfactoriamente.";
		}
		else {
		   $this->conn->rollback(); // deshacer transaccion
		   $result['message'] = "No se pudo eliminar el movimiento.";
		}
  
		$this->conn->autocommit(TRUE); //finalizar transaccion
  
		return $result;     
	 }      
	 
}