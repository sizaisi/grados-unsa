<?
require_once "../modelo/RolArea.php";

$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){
   case 'read': 
      $rol_area = new RolArea();

      $result = $rol_area->getAllRolArea();

      echo json_encode($result);
      break;

   case 'store':
      $rol_area = new RolArea();

      $rol_area->nombre = $_POST['nombre'];

      $result = $rol_area->insertar();

      echo json_encode($result);
      break;
   
   case 'update': 
      $rol_area = new RolArea();

      $rol_area->id = $_POST['id'];
      $rol_area->nombre = $_POST['nombre'];
      
      $result = $rol_area->actualizar();

      echo json_encode($result);
      break;

   case 'activar': 
      $rol_area = new RolArea();

      $rol_area->id = $_POST['id'];      

      $result = $rol_area->activar();
      echo json_encode($result);       
      break;

   case 'desactivar': 
      $rol_area = new RolArea();

      $rol_area->id = $_POST['id'];      

      $result = $rol_area->desactivar();
      echo json_encode($result);       
      break;
}
?>