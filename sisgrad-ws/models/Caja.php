<?php

require_once 'config/dbcaja.php';

class Caja {
        
    private $conn;
	
	public function __construct() {
		$this->conn = CajaDatabase::conectar();
	}
    	
	public function getPagosProfesionalTesis($cui, $nues, $espe){
        $result = array('error' => false);        

        $sql = "SELECT RC.RECA_ID AS idrecibo, RC.RECA_FDIG AS fecha_pago, 
                       CONCAT(RC.RECA_SERIE, '-', RC.RECA_CORRELATIVO) AS nro_recibo, 
                       RD.REDE_COSTO AS monto, RD.REDE_CONC_ID AS idconcepto, C.CONC_DESC AS concepto
                FROM CJCO_RECI_CABE AS RC 
                    INNER JOIN CJCO_RECI_DETA AS RD ON RC.RECA_ID = RD.RECA_ID                 
                    INNER JOIN CJMM_CONCEPTO AS C ON RD.REDE_CONC_ID = C.CONC_ID
                WHERE RD.REDE_CONC_ID IN (13, 27, 961)
                    AND RC.RECA_CODI_USUA = '$cui' 
                    AND RC.RECA_DEPE_USUA = '$nues'"; //falta filtrar por fecha y cabecera estado detalle estado

        $result_query = mysqli_query($this->conn, $sql);

        $array_pagos = array();

        while ($row = $result_query->fetch_assoc()) {                          
            array_push($array_pagos, $row);
        }

        $result['array_pagos'] = $array_pagos;      

        return $result;
    }
}