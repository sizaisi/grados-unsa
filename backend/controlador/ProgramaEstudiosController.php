<?
require_once "../modelo/ProgramaEstudios.php";

$action = '';

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

switch ($action) {
   case 'read': 
      $programa_estudios = new ProgramaEstudios();

      $result = $programa_estudios->getAllProgramaEstudios();   
      echo json_encode($result);        
      break;
   
   case 'store': 
      $programa_estudios = new ProgramaEstudios();

      $programa_estudios->nombre = $_POST['nombre'];
      $result = $programa_estudios->insertar();
      echo json_encode($result);       
      break;
   
   case 'update': 
      $programa_estudios = new ProgramaEstudios();

      $programa_estudios->id = $_POST['id'];
      $programa_estudios->nombre = $_POST['nombre'];

      $result = $programa_estudios->actualizar();
      echo json_encode($result);       
      break;

   case 'activar': 
      $programa_estudios = new ProgramaEstudios();

      $programa_estudios->id = $_POST['id'];      

      $result = $programa_estudios->activar();
      echo json_encode($result);       
      break;

   case 'desactivar': 
      $programa_estudios = new ProgramaEstudios();

      $programa_estudios->id = $_POST['id'];      

      $result = $programa_estudios->desactivar();
      echo json_encode($result);       
      break;
}
?>



