<?
require_once "../modelo/Procedimiento.php";

$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){  

   case 'read': 
      $procedimiento = new Procedimiento();

      $result = $procedimiento->getAllProcedimiento();

      echo json_encode($result);

      break;
   
   case 'store':
      $procedimiento = new Procedimiento();

      $procedimiento->nombre = $_POST['nombre'];
      $procedimiento->descripcion = $_POST['descripcion'];

      $result = $procedimiento->insertar();

      echo json_encode($result);

      break;
   
   case 'update': 
      $procedimiento = new Procedimiento();

      $procedimiento->id = $_POST['id'];
      $procedimiento->nombre = $_POST['nombre'];
      $procedimiento->descripcion = $_POST['descripcion'];

      $result = $procedimiento->actualizar();

      echo json_encode($result);

      break;

   case 'activar':
      $procedimiento = new Procedimiento();

      $procedimiento->id = $_POST['id'];

      $result = $procedimiento->activar();

      echo json_encode($result);

      break;

   case 'desactivar': 
      $procedimiento = new Procedimiento();

      $procedimiento->id = $_POST['id'];      

      $result = $procedimiento->desactivar();

      echo json_encode($result);       

      break;
}

?>