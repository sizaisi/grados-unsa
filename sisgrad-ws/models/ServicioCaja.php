<?php

class ServicioCaja {
	
	public function __construct() {
		$this->conexion = Database::conectar();
	}
	
	public function getPagosCajaProfesionalTesis($cui, $depe){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_PROCEDIMIENTO WHERE id = $this->id";
        $result_query = mysqli_query($this->conn, $sql);        

        $row = $result_query->fetch_assoc();      

        $result['procedimiento'] = $row;      

        return $result;
    }
}