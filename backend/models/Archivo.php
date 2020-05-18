<?php
require_once 'Recurso.php';

class Archivo extends Recurso {	
	private $nombre_asignado;
	private $nombre_archivo;
	private $mime;
	private $data;
	
	private $conn;
	
	public function __construct() {
		$this->conn = Database::conectar();
	}
	
	function getNombreAsignado() {
		return $this->nombre_asignado;
	}

	function setNombreAsignado($nombre_asignado) {
		$this->nombre_asignado = $nombre_asignado;
	}	

	function getNombreArchivo() {
		return $this->nombre_archivo;
	}

	function setNombreArchivo($nombre_archivo) {
		$this->nombre_archivo = $nombre_archivo;
	}	

	function getMime() {
		return $this->mime;
	}

	function setMime($mime) {
		$this->mime = $mime;
	}	

	function getData() {
		return $this->data;
	}

	function setData($data) {
		$this->data = $data;
	}

	public function getTodosArchivos() {

		$result = array('error' => false);		
  
		$sql = "SELECT GT_R.id, GT_A.nombre_asignado AS nombre, GT_A.mime, 
					   GT_P.nombre AS procedimiento, GT_RA.nombre AS area 
				FROM GT_RECURSO AS GT_R
				INNER JOIN GT_ARCHIVO GT_A ON GT_A.idrecurso = GT_R.id				
				INNER JOIN GT_GRADO_PROCEDIMIENTO GT_GP ON GT_GP.id = GT_R.idgrado_proc
				INNER JOIN GT_PROCEDIMIENTO GT_P ON GT_P.id = GT_GP.idprocedimiento
				INNER JOIN GT_USUARIO GT_U ON GT_U.id = GT_R.idusuario
				INNER JOIN GT_ROL_AREA GT_RA ON GT_RA.id = GT_U.idrol_area
				WHERE GT_R.idexpediente = $this->idexpediente ORDER BY id ASC";
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_archivo = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_archivo, $row);
		}
  
		$result['array_archivo'] = $array_archivo;      
  
		return $result;
	 }   

	 public function getArchivosProcOrigen() {

		$result = array('error' => false);
  
		$sql = "SELECT GT_RE.id, GT_A.nombre_asignado AS nombre, GT_A.mime, 
					   GT_P.nombre AS procedimiento, GT_RA.nombre AS area 
				FROM GT_RECURSO AS GT_RE
				INNER JOIN GT_ARCHIVO GT_A ON GT_A.idrecurso = GT_RE.id				
				INNER JOIN GT_GRADO_PROCEDIMIENTO GT_GP ON GT_GP.id = GT_RE.idgrado_proc 
				INNER JOIN GT_PROCEDIMIENTO GT_P ON GT_P.id = GT_GP.idprocedimiento 
				INNER JOIN GT_USUARIO GT_U ON GT_U.id  = GT_RE.idusuario
				INNER JOIN GT_ROL_AREA GT_RA ON GT_RA.id  = GT_U.idrol_area 
				WHERE GT_RE.idexpediente = $this->idexpediente 
				AND GT_RE.idgrado_proc = ( SELECT GT_R.idgradproc_origen 
											FROM GT_MOVIMIENTO GT_M 
											INNER JOIN GT_RUTA GT_R ON GT_M.idruta = GT_R.id 
											WHERE GT_R.idgradproc_destino = $this->idgrado_proc 
											AND GT_M.idexpediente = $this->idexpediente AND GT_R.condicion = 1 
											ORDER BY GT_M.id desc limit 1
								  		) 
				ORDER BY GT_RE.id ASC";				
		
		
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_archivo_ultimo = array();
  
		while ($row = $result_query->fetch_assoc()) {         
		   array_push($array_archivo_ultimo, $row);
		}
  
		$result['array_archivo_ultimo'] = $array_archivo_ultimo;      
  
		return $result;
	 }   
  
	 public function getArchivo() {
  
		$result = array('error' => false);

		$sql = "SELECT GT_R.id, GT_A.nombre_asignado AS nombre, GT_A.mime
				FROM GT_RECURSO AS GT_R
				INNER JOIN GT_ARCHIVO GT_A ON GT_A.idrecurso = GT_R.id
				WHERE GT_R.idexpediente = $this->idexpediente 
				AND GT_R.idgrado_proc = $this->idgrado_proc 
				AND GT_R.idusuario = $this->idusuario
				AND GT_R.idmovimiento IS NULL";		

		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
			$array_documento = array();
  
			while ($row = $result_query->fetch_assoc()) {         
				array_push($array_documento, $row);
			}
	
			$result['array_documento'] = $array_documento;
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener los documentos o archivos.";
		}		      
  
		return $result;
	 }
  
	 public function insertar() {

		$result = array('error' => false);   
		$this->conn->autocommit(FALSE); //iniciar transaccion	
		
		$sql = "INSERT INTO GT_RECURSO(idexpediente, idgrado_proc, idusuario, idmovimiento, idruta) 
				VALUES ($this->idexpediente, $this->idgrado_proc, $this->idusuario, NULL, $this->idruta)";      
		$result_query = mysqli_query($this->conn, $sql);     
		
		$idrecurso;
		
		if (!$result_query) {
		   	$result['error'] = true;                    
		}       
		else {
			$idrecurso = mysqli_insert_id($this->conn);
		}
  
		$sql = "INSERT INTO GT_ARCHIVO(idrecurso, nombre_asignado, nombre_archivo, mime, data) 
				VALUES ($idrecurso, '$this->nombre_asignado', '$this->nombre_archivo', '$this->mime', '$this->data')";		
		$result_query = mysqli_query($this->conn, $sql);

		if (!$result_query) {
			$result['error'] = $sql;                    
		} 

		if ( $result['error'] == false) { //si no hay ningun error en querys
			$this->conn->commit();          
			$result['message'] = "Archivo registrado correctamente.";
		 }
		else {
			$this->conn->rollback(); // deshacer transaccion
			$result['message'] = "No se pudo registrar el archivo.";
		}
   
		$this->conn->autocommit(TRUE); //finalizar transaccion           
  
		return $result;
	 }
  
	 public function eliminar(){

		$result = array('error' => false);                
		$this->conn->autocommit(FALSE); //iniciar transaccion	
		
		$sql = "DELETE FROM GT_ARCHIVO where idrecurso = $this->id";      
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
		   	$result['message'] = "Archivo eliminado correctamente.";
		}
		else {
		   	$this->conn->rollback(); // deshacer transaccion
		   	$result['message'] = "No se pudo eliminar el archivo.";
		}
  
		$this->conn->autocommit(TRUE); //finalizar transaccion
  
		return $result; 		
	 }
}