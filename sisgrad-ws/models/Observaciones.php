<?php
require_once 'Recurso.php';

class Observaciones extends Recurso {	
    private $descripcion;

	private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}	
	
    function getDescripcion() {
		return $this->descripcion;
	}

	function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
    }    
	
	public function getObservaciones() {
		$result = array('error' => false);
  
		$sql = "SELECT GT_R.id, GT_O.descripcion
				FROM gt_recurso AS GT_R
				INNER JOIN gt_observaciones GT_O ON GT_O.idrecurso = GT_R.id
				WHERE GT_R.idexpediente = $this->idexpediente 
                AND GT_R.idgrado_proc = $this->idgrado_proc 
				AND GT_R.idusuario = $this->idusuario
				AND GT_R.idmovimiento IS NULL";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_observaciones = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_observaciones, $row);
		}
  
		$result['array_observaciones'] = $array_observaciones;
  
		return $result;
	}      
  
	public function insertar() {     
		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion	
		
		$sql = "INSERT INTO gt_recurso(idexpediente, idgrado_proc, idusuario, idmovimiento, idruta) 
				VALUES ($this->idexpediente, $this->idgrado_proc, $this->idusuario, NULL, $this->idruta)";      
		$result_query = mysqli_query($this->conn, $sql);     
		
		$idrecurso;
		
		if (!$result_query) {
		   	$result['error'] = true;                    
		}       
		else {
			$idrecurso = mysqli_insert_id($this->conn);
		}
		
		$sql = "INSERT INTO gt_observaciones(idrecurso, descripcion) 
				VALUES ($idrecurso, '$this->descripcion')";      
		$result_query = mysqli_query($this->conn, $sql);     		
  
		if (!$result_query) {
		   $result['error'] = true;                    
		} 
		
		if( $result['error'] == false) { //si no hay ningun error en querys
		   $this->conn->commit();          
		   $result['message'] = "Observaciones registradas correctamente.";
		}
		else {
		   $this->conn->rollback(); // deshacer transaccion
		   $result['message'] = "No se pudo registrar las observaciones.";
		}
  
		$this->conn->autocommit(TRUE); //finalizar transaccion
  
		return $result; 	
    }
    
    public function actualizar() {  
		$result = array('error' => false);
  
		$sql = "UPDATE gt_observaciones SET descripcion = '$this->descripcion' WHERE idrecurso = $this->id";
		
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Observaciones actualizadas correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudieron actualizar las observaciones.";
		}      
  
		return $result;
	}
  
	public function eliminar() {   		
		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion	
		
		$sql = "DELETE FROM gt_observaciones where idrecurso = $this->id";      
		$result_query = mysqli_query($this->conn, $sql);     	
		
		if (!$result_query) {
		   	$result['error'] = true;                    
		}       	
		
		$sql = "DELETE FROM gt_recurso where id = $this->id AND idmovimiento IS NULL";
		$result_query = mysqli_query($this->conn, $sql);     		
  
		if (!$result_query) {
			$result['error'] = true;                	       
		} 	

		if (mysqli_affected_rows($this->conn) == 0) { //no debe eliminar si el recurso ya tiene movimiento
			$result['error'] = true;
		}
		
		if( $result['error'] == false) { //si no hay ningun error en querys
		   	$this->conn->commit();          
		   	$result['message'] = "Observaciones eliminadas correctamente.";
		}
		else {
		   	$this->conn->rollback(); // deshacer transaccion
		   	$result['message'] = "No se pudo eliminar las observaciones.";
		}
  
		$this->conn->autocommit(TRUE); //finalizar transaccion
  
		return $result; 		
	 }
}