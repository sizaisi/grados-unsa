<?php
   
   /*include "../../include/conection.inc.php";
   include "../../include/codigos_menu.inc";
   $acceso=do_conection();
    if(!$cerrar)
       require "../../include/sesiones/acse_busc_sesi.php";*/

   header("Content-Type: text/json");        
   
   $codi_oper = 'fips';

   $result = array('error' => false);    

   if(isset($codi_oper) && $codi_oper != null) {                  
      $result['codi_oper']= $codi_oper;
   }
   else {
      $result['error']= true;      
   }

   echo json_encode($result);   
   
?>