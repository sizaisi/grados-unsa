<?php
require_once 'Recurso.php';

class Persona extends Recurso {	
	private $tipo;
	private $iddocente;

	private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}

	function getIdDocente() {
		return $this->iddocente;
	}

	function setIdDocente($iddocente) {
		$this->iddocente = $iddocente;
    }

	function getTipo() {
		return $this->tipo;
	}

	function setTipo($tipo) {
		$this->tipo = $tipo;
    }
    
    public function getAsesor() {
		$result = array('error' => false);

		$sql = "SELECT GT_R.id, REPLACE(AC_D.apn, '/', ' ') AS apn, 
				AC_D.dic AS nro_documento, GT_P.tipo
				FROM GT_RECURSO AS GT_R
				INNER JOIN GT_PERSONA GT_P ON GT_P.idrecurso = GT_R.id
				INNER JOIN GT_USUARIO AS GT_U ON GT_U.id = GT_P.iddocente
				INNER JOIN SIAC_DOC AS AC_D ON AC_D.codper = GT_U.codi_usuario 
				WHERE GT_R.idexpediente = $this->idexpediente 
                AND GT_R.idgrado_proc = $this->idgrado_proc 
				AND GT_R.idusuario = $this->idusuario
				AND GT_P.tipo = 'asesor'				
				AND GT_R.idmovimiento IS NULL";	

		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {			
			if (mysqli_num_rows($result_query) > 0) {
				$row = $result_query->fetch_assoc();        
				$result['asesor'] = $row;
			}			
			else {
				$result['error'] = true;
				$result['message'] = "No se pudo encontrar el asesor.";            
			}			
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener el asesor.";            
		}		
  
		return $result;		
	}      
  
	public function insertar() {     
		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion	
		
		$sql = "INSERT INTO GT_RECURSO(idexpediente, idgrado_proc, idusuario, idmovimiento, idruta, estado) 
				VALUES ($this->idexpediente, $this->idgrado_proc, $this->idusuario, NULL, $this->idruta, 0)";      
		$result_query = mysqli_query($this->conn, $sql);     
		
		$idrecurso;
		
		if (!$result_query) {
		   	$result['error'] = true;                    
		}       
		else {
			$idrecurso = mysqli_insert_id($this->conn);
		}
		
		$sql = "INSERT INTO GT_PERSONA(idrecurso, iddocente, tipo) 
				VALUES ($idrecurso, $this->iddocente, '$this->tipo')";      
		$result_query = mysqli_query($this->conn, $sql);     		
  
		if (!$result_query) {
		   $result['error'] = true;                    
		} 
		
		if( $result['error'] == false) { //si no hay ningun error en querys
		   $this->conn->commit();          
		   $result['message'] = "Asesor registrado correctamente.";
		}
		else {
		   $this->conn->rollback(); // deshacer transaccion
		   $result['message'] = "No se pudo registrar el asesor.";
		}
  
		$this->conn->autocommit(TRUE); //finalizar transaccion
  
		return $result; 	
    }
    
    public function eliminar() {   		
		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion	
		
		$sql = "DELETE FROM GT_PERSONA where idrecurso = $this->id";      
		$result_query = mysqli_query($this->conn, $sql);     	
		
		if (!$result_query) {
		   	$result['error'] = true;                    
		}       	
		
		$sql = "DELETE FROM GT_RECURSO where id = $this->id AND idmovimiento IS NULL";
		$result_query = mysqli_query($this->conn, $sql);     		
  
		if (!$result_query) {
			$result['error'] = true;                	       
		} 	

		if (mysqli_affected_rows($this->conn) == 0) { //no debe eliminar si el recurso ya tiene movimiento
			$result['error'] = true;
		}
		
		if( $result['error'] == false) { //si no hay ningun error en querys
		   	$this->conn->commit();          
		   	$result['message'] = "Asesor eliminado correctamente.";
		}
		else {
		   	$this->conn->rollback(); // deshacer transaccion
		   	$result['message'] = "No se pudo eliminar el asesor.";
		}
  
		$this->conn->autocommit(TRUE); //finalizar transaccion
  
		return $result; 		
	}
}