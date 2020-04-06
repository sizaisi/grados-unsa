<?
require_once "../modelo/Ruta.php";
require_once "../modelo/GradoModalidad.php";
require_once "../modelo/GradoProcedimiento.php";

$action = '';

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

switch ($action) {   

  case 'read': 
      $ruta = new Ruta();

      $result = $ruta->getAllRutas();

      echo json_encode($result);      

      break;

  case 'getRutasByProc': // obtener rutas por cada procedimiento
      $ruta = new Ruta();
      $ruta->idgradproc_origen = $_GET['idgradproc_origen'];  

      $result = $ruta->getRutasByIdProcOrigen();

      echo json_encode($result);      

      break;

  case 'getListGradModalidad':      
      
      $grado_modalidad = new GradoModalidad();

      $result = $grado_modalidad->getActives();

      echo json_encode($result);

      break;
  
  case 'getListGradProcedimientos':      
      
      $grado_procedimiento = new GradoProcedimiento();      

      $grado_procedimiento->idgrado_modalidad = $_GET['idgrado_modalidad'];      

      $result = $grado_procedimiento->getListByIdGradoModalidad();

      echo json_encode($result);      
      break;

  case 'store':
      $ruta = new Ruta();

      $ruta->idgradproc_origen = $_POST['idgradproc_origen'];
      $ruta->idgradproc_destino = $_POST['idgradproc_destino'];
      $ruta->etiqueta = $_POST['etiqueta'];            

      $result = $ruta->insertar();

      echo json_encode($result);

      break;
   
   case 'update': 
      $ruta = new Ruta();

      $ruta->id = $_POST['id'];
      $ruta->idgradproc_origen = $_POST['idgradproc_origen'];
      $ruta->idgradproc_destino = $_POST['idgradproc_destino'];            
      $ruta->etiqueta = $_POST['etiqueta'];

      $result = $ruta->actualizar();

      echo json_encode($result);       

      break;   

   case 'activar': 
      $ruta = new Ruta();

      $ruta->id = $_POST['id'];

      $result = $ruta->activar();

      echo json_encode($result);      

      break;

   case 'desactivar': 
      $ruta = new Ruta();

      $ruta->id = $_POST['id'];

      $result = $ruta->desactivar();

      echo json_encode($result);      

      break;
}
?>



