<?php
   
   /*include "../../include/conection.inc.php";
   include "../../include/codigos_menu.inc";
   $acceso=do_conection();
    if(!$cerrar)
       require "../../include/sesiones/acse_busc_sesi.php";*/

   header("Content-Type: text/json");        
   
   //$codi_oper = 'fips';   //facultad
   //$codi_oper = 'uifips';   //unid de investigacion
   $codi_oper = '4141_1'; //presidente de jurado
   //$codi_oper = '3739_1';  //asesor
   //$codi_oper = 'grad3';  //grados y titulos
   //$codi_oper = 'repo';  //repositorio institucional

   $result = array('error' => false);    

   if(isset($codi_oper) && $codi_oper != null) {                  
      $result['codi_oper']= $codi_oper;
   }
   else {
      $result['error']= true;      
   }

   echo json_encode($result);   
   
?>