<?php

class Movimiento {
	public $id;
	public $idexpediente;
	public $idusuario;
	public $idruta;   

	private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	function getId() {
		return $this->id;
	}

	function getIdExpediente() {
		return $this->idexpediente;
	}

	function getIdUsuario() {
		return $this->idusuario;
	}

	function getIdRuta() {
		return $this->idruta;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setIdExpediente($idexpediente) {
		$this->idexpediente = $idexpediente;
	}	

	function setIdUsuario($idusuario) {
		$this->idusuario = $idusuario;
	}	

	function setIdRuta($idruta) {
		$this->idruta = $idruta;
	}	

	//para devolver el movimiento actual de entrada a traves del idgrado-procedimiento destino
	function getLastMovimiento($idgradproc_destino) { 
		$result = array('error' => false);
  
		/*$sql = "SELECT GT_M.fecha, GT_R.etiqueta, GT_P.nombre AS procedimiento_origen, GT_GP.tipo_rol, GT_RA.nombre AS rol_area_origen
				FROM GT_MOVIMIENTO GT_M 
				INNER JOIN GT_RUTA GT_R ON GT_M.idruta = GT_R.id
				INNER JOIN GT_GRADO_PROCEDIMIENTO GT_GP ON GT_R.idgradproc_origen = GT_GP.id
				INNER JOIN GT_PROCEDIMIENTO GT_P ON GT_GP.idprocedimiento = GT_P.id
				LEFT JOIN GT_ROL_AREA GT_RA ON GT_GP.tipo_rol = '' AND GT_GP.idrol_area = GT_RA.id				
				WHERE GT_R.idgradproc_destino = $idgradproc_destino 
				AND GT_M.idexpediente = $this->idexpediente AND GT_R.condicion = 1
				ORDER BY GT_M.id desc limit 1";*/

		$sql = "SELECT t_movimiento.*, SIAC_OPER.nomb_oper AS administrativo, REPLACE(SIAC_DOC.apn, '/', ' ') AS docente, SIAC_DOC.dic AS nro_doc_docente
				FROM
				(
					SELECT GT_M.id, GT_M.idusuario, GT_M.fecha, GT_R.etiqueta, GT_P.nombre AS procedimiento_origen, GT_GP.tipo_rol, GT_RA.nombre AS rol_area_origen
					FROM GT_MOVIMIENTO GT_M 
					INNER JOIN GT_RUTA GT_R ON GT_M.idruta = GT_R.id
					INNER JOIN GT_GRADO_PROCEDIMIENTO GT_GP ON GT_R.idgradproc_origen = GT_GP.id
					INNER JOIN GT_PROCEDIMIENTO GT_P ON GT_GP.idprocedimiento = GT_P.id
					LEFT JOIN GT_ROL_AREA GT_RA ON GT_GP.tipo_rol = '' AND GT_GP.idrol_area = GT_RA.id				
					WHERE GT_R.idgradproc_destino = $idgradproc_destino 
					AND GT_M.idexpediente = $this->idexpediente AND GT_R.condicion = 1
				) t_movimiento
				INNER JOIN GT_USUARIO GT_U ON GT_U.id = t_movimiento.idusuario
				LEFT JOIN SIAC_OPER ON GT_U.tipo = 'Administrativo' AND SIAC_OPER.codi_oper = GT_U.codi_usuario
				LEFT JOIN SIAC_DOC ON GT_U.tipo = 'Docente' AND SIAC_DOC.codper = GT_U.codi_usuario
				ORDER BY t_movimiento.id desc limit 1";

		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {									  
			if ($row = $result_query->fetch_assoc()) {
				$result['movimiento'] = $row;  							
			}		
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener el ultimo movimiento de entrada del procedimiento.";            
		}		  
		
		return $result;
	  }
	
	// registrar movimiento y actualizar procedimiento del expediente con el idgradprod_destino
	public function mover($idgradproc_destino) {      
      
		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion
		
		//realizar movimiento con la ruta seleccionada
		$sql = "INSERT INTO GT_MOVIMIENTO(idexpediente, idusuario, idruta) 
				VALUES ($this->idexpediente, $this->idusuario, $this->idruta)";      
		$result_query = mysqli_query($this->conn, $sql);     
  
		if (!$result_query) {
		   $result['error'] = true;                    
		}     
  
		//actualizar expediente para conocer en que procedimiento se encuentra
		$sql = "UPDATE GT_EXPEDIENTE SET idgrado_procedimiento = $idgradproc_destino
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
	 public function deshacer($idgradproc_origen) {      
		
		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion
		
		//eliminar el ultimo movimiento realizado
		$sql = "DELETE FROM GT_MOVIMIENTO WHERE id = $this->id";      
		$result_query = mysqli_query($this->conn, $sql);     
  
		if (!$result_query) {
		   $result['error'] = true;                    
		}     
  
		//actualizar expediente para conocer en que procedimiento se encuentra
		$sql = "UPDATE GT_EXPEDIENTE SET idgrado_procedimiento = $idgradproc_origen
				WHERE id = $this->idexpediente";        
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