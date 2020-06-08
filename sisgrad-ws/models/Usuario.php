<?php

class Usuario {
	private $id;
	private $codi_usuario;
	private $tipo;

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

	function getCodiUsuario() {
		return $this->codi_usuario;
	}

	function setCodiUsuario($codi_usuario) {
		$this->codi_usuario = $codi_usuario;
	}	

	function getTipo() {
		return $this->tipo;
	}

	function setTipo($tipo) {
		$this->tipo = $tipo;
	} 
  
	public function getIdUsuario() {
		$result = array('error' => false);		

		$sql = "SELECT * 
				FROM GT_USUARIO
				WHERE codi_usuario = '$this->codi_usuario'";
		$result_query = mysqli_query($this->conn, $sql);		
  
		if ($result_query && mysqli_num_rows($result_query) > 0) {
			$row = $result_query->fetch_assoc();		   
			$result['usuario'] = $row;       
		}
		else {
			$result['error'] = true;
		   	$result['message'] = "No se pudo encontrar el usuario.";
		} 
		return $result;
	}

	public function getMenus($codi_menu_grup) {  
		$result = array('error' => false);

        $sql = "SELECT DISTINCT (AC_MS.codi_msub), AC_MS.nomb_msub AS nombre
                FROM SIAC_OPER_MENU AS AC_SOM
				INNER JOIN SIAC_MENU AS AC_M ON AC_M.codi_menu = AC_SOM.codi_menu
				INNER JOIN SIAC_MENU_SUBG AS AC_MS ON AC_MS.codi_msub = AC_M.codi_msub				                 
                WHERE AC_SOM.codi_oper = '$this->codi_usuario' 
				AND AC_MS.esta_msub = 'A' 
				AND AC_MS.codi_megr = $codi_menu_grup";

        $result_query = mysqli_query($this->conn, $sql);

        $array_menu = array();

        while ($row = $result_query->fetch_assoc()) {            
            $sql2 = "SELECT nomb_menu AS nombre, dire_menu AS componente
                     FROM SIAC_MENU  
                     WHERE codi_msub = ".$row['codi_msub'];
                        
			$result_query2 = mysqli_query($this->conn, $sql2);            
			
			$array_submenu = array();

            while ($row2 = $result_query2->fetch_assoc()) {                            
                array_push($array_submenu, $row2);
			}            

			$row['submenu'] = $array_submenu;                        			
			array_push($array_menu, $row);
        }

        $result['array_menu'] = $array_menu;        

        return $result;
	}      
  
	 //Obtener los asesores o jurados solo de la facultad a la que pertenece la socitud del expediente
	 public function getDocentes($idexpediente) {
  
		$result = array('error' => false);
  
		$sql = "SELECT gt_u.id, REPLACE(ac_doc.apn,'/',' ') AS apn, ac_doc.dic AS nro_documento " .
			   "FROM GT_USUARIO AS gt_u " .
			   "INNER JOIN SIAC_DOC AS ac_doc ON gt_u.codi_usuario = ac_doc.codper " .             
			   "INNER JOIN actdepa AS ac_d ON ac_doc.depend = ac_d.depa " .             
			   "WHERE ac_d.facu = (SELECT ac_e.facu " .
								  "FROM GT_EXPEDIENTE AS gt_e " .
								  "INNER JOIN actescu ac_e ON gt_e.nues = ac_e.nues " .
								  "WHERE gt_e.id = $idexpediente) " .
			   "AND ac_doc.esta_doc = 'A' " .             
			   "ORDER BY ac_doc.apn ASC";
  
		$result_query = mysqli_query($this->conn, $sql);

		if ($result_query) {
			$array_docente = array();
  
			while ($row = $result_query->fetch_assoc()) {         
			array_push($array_docente, $row);
			}
	
			$result['array_docente'] = $array_docente;
		}
		else {
			$result['error'] = true;
			$result['message'] = "No se pudo obtener los docentes.";    
		}	      
  
		return $result;
	}      
}