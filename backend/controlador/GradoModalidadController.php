<?
require_once "../modelo/GradoModalidad.php";
require_once "../modelo/GradoTitulo.php";
require_once "../modelo/ModalidadObtencion.php";

$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){

   case 'read_escritorio': 
      $codi_usuario = $_GET['codi_usuario'];

      $grado_modalidad = new GradoModalidad();

      $result = $grado_modalidad->getAllModalidadEscritorio($codi_usuario);

      echo json_encode($result);

      break;

   case 'readGradoTitulo':
      $grado_titulo = new GradoTitulo();

      $result = $grado_titulo->getActives();

      echo json_encode($result);

      break;

   case 'readModObtencion': 
      $modalidad_obtencion = new ModalidadObtencion();

      $result = $modalidad_obtencion->getActives();

      echo json_encode($result);

      break;

   case 'get': // obtener solo un objeto
      $idgrado_modalidad = $_GET['idgrado_modalidad'];

      $grado_modalidad = new GradoModalidad();
      $grado_modalidad->id = $idgrado_modalidad;

      $result = $grado_modalidad->getGradoModalidad();

      echo json_encode($result);

      break;

   case 'read':
      $grado_modalidad = new GradoModalidad();

      $result = $grado_modalidad->getAllGradoModalidad();

      echo json_encode($result);

      break;
   
   case 'store':
      $grado_modalidad = new GradoModalidad();

      $grado_modalidad->idgrado_titulo = $_POST['idgrado_titulo'];
      $grado_modalidad->idmodalidad_obtencion = $_POST['idmodalidad_obtencion'];

      $result = $grado_modalidad->insertar();

      echo json_encode($result);

      break;
   
   case 'update': 
      $grado_modalidad = new GradoModalidad();

      $grado_modalidad->id = $_POST['id'];
      $grado_modalidad->idgrado_titulo = $_POST['idgrado_titulo'];
      $grado_modalidad->idmodalidad_obtencion = $_POST['idmodalidad_obtencion'];
      
      $result = $grado_modalidad->actualizar();

      echo json_encode($result);

      break;

   case 'activar':
      $grado_modalidad = new GradoModalidad();

      $grado_modalidad->id = $_POST['id'];

      $result = $grado_modalidad->activar();

      echo json_encode($result);

      break;

   case 'desactivar': 
      $grado_modalidad = new GradoModalidad();

      $grado_modalidad->id = $_POST['id'];      

      $result = $grado_modalidad->desactivar();

      echo json_encode($result);       

      break;
}

?>