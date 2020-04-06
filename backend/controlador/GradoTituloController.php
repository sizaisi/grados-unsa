<?
require_once "../modelo/GradoTitulo.php";

$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){
   case 'read': 
      $grado_titulo = new GradoTitulo();

      $result = $grado_titulo->getAllGradoTitulo();

      echo json_encode($result);

      break;   

   case 'store':
      $grado_titulo = new GradoTitulo();

      $grado_titulo->nombre = $_POST['nombre'];
      $grado_titulo->codigo = $_POST['codigo'];
      $grado_titulo->idprereq = $_POST['idprereq'];
      $grado_titulo->descripcion = $_POST['descripcion'];

      $result = $grado_titulo->insertar();

      echo json_encode($result);

      break;
   
   case 'update': 
      $grado_titulo = new GradoTitulo();

      $grado_titulo->id = $_POST['id'];
      $grado_titulo->nombre = $_POST['nombre'];
      $grado_titulo->codigo = $_POST['codigo'];
      $grado_titulo->idprereq = $_POST['idprereq'];
      $grado_titulo->descripcion = $_POST['descripcion'];


      $result = $grado_titulo->actualizar();

      echo json_encode($result);       

      break;

   case 'activar': 
      $grado_titulo = new GradoTitulo();

      $grado_titulo->id = $_POST['id'];

      $result = $grado_titulo->activar();

      echo json_encode($result);       

      break;

   case 'desactivar': 
      $grado_titulo = new GradoTitulo();

      $grado_titulo->id = $_POST['id'];      

      $result = $grado_titulo->desactivar();

      echo json_encode($result);       

      break;
}

?>