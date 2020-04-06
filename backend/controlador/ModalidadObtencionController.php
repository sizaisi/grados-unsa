<?
require_once "../modelo/ModalidadObtencion.php";

$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){
   case 'read': 
      $modalidad_obtencion = new ModalidadObtencion();

      $result = $modalidad_obtencion->getAllModalidadObtencion();

      echo json_encode($result);

      break;   

   case 'store':
      $modalidad_obtencion = new ModalidadObtencion();

      $modalidad_obtencion->nombre = $_POST['nombre'];

      $result = $modalidad_obtencion->insertar();

      echo json_encode($result);

      break;
   
   case 'update': 
      $modalidad_obtencion = new ModalidadObtencion();

      $modalidad_obtencion->id = $_POST['id'];
      $modalidad_obtencion->nombre = $_POST['nombre'];
      
      $result = $modalidad_obtencion->actualizar();

      echo json_encode($result);

      break;

   case 'activar':
      $modalidad_obtencion = new ModalidadObtencion();

      $modalidad_obtencion->id = $_POST['id'];

      $result = $modalidad_obtencion->activar();

      echo json_encode($result);

      break;

   case 'desactivar': 
      $modalidad_obtencion = new ModalidadObtencion();

      $modalidad_obtencion->id = $_POST['id'];      

      $result = $modalidad_obtencion->desactivar();

      echo json_encode($result);       

      break;
}

?>