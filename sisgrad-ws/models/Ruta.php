<?php

class Ruta {
	private $id;
	private $nombre;
	private $idgradproc_origen;
    private $idgradproc_destino;
	private $etiqueta;
	
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

	function getNombre() {
		return $this->nombre;
	}

	function setNombre($nombre) {
		$this->nombre = $nombre;
	}	

	function getIdGradProcOrigen() {
		return $this->idgradproc_origen;
	}

	function setIdGradProcOrigen($idgradproc_origen) {
		$this->idgradproc_origen = $idgradproc_origen;
	}

	function getIdGradProcDestino() {
		return $this->idgradproc_destino;
	}

	function setIdGradProcDestino($idgradproc_destino) {
		$this->idgradproc_destino = $idgradproc_destino;
	}

	function getEtiqueta() {
		return $this->etiqueta;
	}

	function setEtiqueta($etiqueta) {
		$this->etiqueta = $etiqueta;
	}
	
	public function getAllRutas(){
		$result = array('error' => false);       
  
		$sql = "SELECT GT_R.id AS idruta, GT_GM.id AS idgrado_modalidad,
					   GT_GT.nombre AS nombre_gradotitulo, GT_MO.nombre AS nombre_modobtencion,
					   GT_P.nombre AS nombre_proc_origen, GT_R.idgradproc_origen, GT_R.idgradproc_destino,
					   GT_R.etiqueta, GT_R.condicion
				FROM GT_RUTA AS GT_R 
				LEFT JOIN GT_GRADO_PROCEDIMIENTO AS GT_GP ON GT_R.idgradproc_origen = GT_GP.id              
				LEFT JOIN GT_PROCEDIMIENTO AS GT_P ON GT_GP.idprocedimiento = GT_P.id 
				LEFT JOIN GT_GRADO_MODALIDAD AS GT_GM ON GT_GP.idgrado_modalidad = GT_GM.id 
				LEFT JOIN GT_GRADO_TITULO AS GT_GT ON GT_GM.idgrado_titulo = GT_GT.id 
				LEFT JOIN GT_MODALIDAD_OBTENCION AS GT_MO ON GT_GM.idmodalidad_obtencion = GT_MO.id
				ORDER BY GT_R.id ASC";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		$array_ruta = array();
  
		while ($row = $result_query->fetch_assoc()) {            
  
		   $sql2 = "SELECT GT_P.nombre AS nombre_proc_destino, GT_GM.id AS idgrado_modalidad,
						   GT_GT.nombre AS nombre_gradotitulo, GT_MO.nombre AS nombre_modobtencion
					FROM GT_RUTA AS GT_R 
					LEFT JOIN GT_GRADO_PROCEDIMIENTO AS GT_GP ON GT_R.idgradproc_destino = GT_GP.id 
					LEFT JOIN GT_PROCEDIMIENTO AS GT_P ON GT_GP.idprocedimiento = GT_P.id
					LEFT JOIN GT_GRADO_MODALIDAD AS GT_GM ON GT_GP.idgrado_modalidad = GT_GM.id 
					LEFT JOIN GT_GRADO_TITULO AS GT_GT ON GT_GM.idgrado_titulo = GT_GT.id 
					LEFT JOIN GT_MODALIDAD_OBTENCION AS GT_MO ON GT_GM.idmodalidad_obtencion = GT_MO.id
					WHERE GT_R.id = ".$row['idruta'];
					   
		   $result_query2 = mysqli_query($this->conn, $sql2);
  
		   $row2 = $result_query2->fetch_assoc();
  
		   $row['nombre_proc_destino'] = $row2['nombre_proc_destino'];                       
  
		   if ($row['idgradproc_origen'] == 0) {            
			  $row['idgrado_modalidad'] = $row2['idgrado_modalidad'];
			  $row['nombre_gradotitulo'] = $row2['nombre_gradotitulo'];
			  $row['nombre_modobtencion'] = $row2['nombre_modobtencion'];
			  $row['nombre_proc_origen'] = 'Inicio';
		   }
  
		   if ($row['idgradproc_destino'] == 0) {                        
			  $row['nombre_proc_destino'] = 'Fin';
		   }
		   
		   array_push($array_ruta, $row);                     
		}
  
		$result['array_ruta'] = $array_ruta;
  
		return $result;
	  }
  
	  function getRutasByIdProcOrigen() { //para devolver las rutas posibles dado un grado-procedimiento origen
		$result = array('error' => false);
  
		$sql = "SELECT GT_R.*, GT_P.nombre AS procedimiento_destino, GT_RA.nombre AS rol_area_destino
				FROM GT_RUTA GT_R LEFT JOIN GT_GRADO_PROCEDIMIENTO GT_GP
				ON GT_R.idgradproc_destino = GT_GP.id
				LEFT JOIN GT_PROCEDIMIENTO GT_P 
				ON GT_GP.idprocedimiento = GT_P.id
				LEFT JOIN GT_ROL_AREA GT_RA 
				ON GT_GP.idrol_area = GT_RA.id
				WHERE GT_R.idgradproc_origen = $this->idgradproc_origen AND GT_R.condicion = 1";
		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {			
			$array_ruta = array();
  
			while ($row = $result_query->fetch_assoc()) {
				array_push($array_ruta, $row);
			}
	
			$result['array_ruta'] = $array_ruta;  			
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener las rutas.";            
		}		  
		
		return $result;
	  }
  
	  
	  public function insertar(){
		$result = array('error' => false);
  
		$sql = "INSERT INTO GT_RUTA(idgradproc_origen, idgradproc_destino, etiqueta, condicion)
				 VALUES ($this->idgradproc_origen, $this->idgradproc_destino, '$this->etiqueta' , 1)";
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Ruta agregada correctamente.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudo agregar la ruta.";            
		}      
  
		return $result;
	  }
   
	  public function actualizar(){
		$result = array('error' => false);
  
		$sql = "UPDATE GT_RUTA SET idgradproc_origen = $this->idgradproc_origen, 
								   idgradproc_destino = $this->idgradproc_destino, 
								   etiqueta = '$this->etiqueta'
				 WHERE id = $this->id";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Ruta actualizada con éxito.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = $sql;
		}
  
		return $result;   
	  }
  
	  public function activar(){
		$result = array('error' => false);
  
		$sql = "UPDATE GT_RUTA SET condicion = '1' WHERE id = $this->id";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Ruta activada con éxito.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudo activar la ruta.";
		}
  
		return $result;
	  }
  
	  public function desactivar(){
		$result = array('error' => false);
  
		$sql = "UPDATE GT_RUTA SET condicion = '0' WHERE id = $this->id";
  
		$result_query = mysqli_query($this->conn, $sql);
  
		if ($result_query) {
		   $result['message'] = "Ruta desactivada con éxito.";
		}
		else {
		   $result['error'] = true;
		   $result['message'] = "No se pudo desactivar la ruta.";
		}
  
		return $result;
	  }
}