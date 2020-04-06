<?
require_once "../modelo/GradoProcedimiento.php";
require_once "../modelo/GradoModalidad.php";
require_once "../modelo/Procedimiento.php";
require_once "../modelo/RolArea.php";

$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action){
   case 'read': 
      $grado_procedimiento = new GradoProcedimiento();

      $result = $grado_procedimiento->getAllGradoProcedimiento();

      echo json_encode($result);      

      break;

   case 'getGradoProcedimiento':
      $grado_procedimiento = new GradoProcedimiento();

      $grado_procedimiento->id = $_GET['idgrado_procedimiento'];

      $result = $grado_procedimiento->getGradoProcedimiento();

      echo json_encode($result);

      break; 
   
   case 'getListByIds': 

      $idgrado_modalidad = $_GET['idgrado_modalidad'];
      $codi_usuario = $_GET['codi_usuario'];
      
      $grado_procedimiento = new GradoProcedimiento();      

      $result = $grado_procedimiento->getListByIds($idgrado_modalidad, $codi_usuario);

      echo json_encode($result);      

      break;  

   case 'readGradoModalidad':
      $grado_modalidad = new GradoModalidad();

      $result = $grado_modalidad->getActives();

      echo json_encode($result);

      break;

   case 'readProcedimientos': 
      $procedimiento = new Procedimiento();

      $result = $procedimiento->getActives();

      echo json_encode($result);

      break;

   case 'readRolArea': 
      $rol_area = new RolArea();

      $result = $rol_area->getAllRolArea();

      echo json_encode($result);
      break;

   case 'store':
      $grado_procedimiento = new GradoProcedimiento();

      $grado_procedimiento->idgrado_modalidad = $_POST['idgrado_modalidad'];
      $grado_procedimiento->idprocedimiento = $_POST['idprocedimiento'];
      $grado_procedimiento->idrol = $_POST['idrol_area'];   
      $grado_procedimiento->tipo_rol = $_POST['tipo_rol'];      
      $grado_procedimiento->url = $_POST['url_formulario'];
      $grado_procedimiento->orden = $_POST['orden'];

      $result = $grado_procedimiento->insertar();

      echo json_encode($result);

      break;
   
   case 'update': 
      $grado_procedimiento = new GradoProcedimiento();

      $grado_procedimiento->id = $_POST['id'];
      $grado_procedimiento->idgrado_modalidad = $_POST['idgrado_modalidad'];
      $grado_procedimiento->idprocedimiento = $_POST['idprocedimiento'];            
      $grado_procedimiento->idrol = $_POST['idrol_area'];
      $grado_procedimiento->tipo_rol = $_POST['tipo_rol'];
      $grado_procedimiento->url = $_POST['url_formulario'];      
      $grado_procedimiento->orden = $_POST['orden'];

      $result = $grado_procedimiento->actualizar();

      echo json_encode($result);       

      break;   

   case 'activar': 
      $grado_procedimiento = new GradoProcedimiento();

      $grado_procedimiento->id = $_POST['id'];

      $result = $grado_procedimiento->activar();

      echo json_encode($result);      

      break;

   case 'desactivar': 
      $grado_procedimiento = new GradoProcedimiento();

      $grado_procedimiento->id = $_POST['id'];

      $result = $grado_procedimiento->desactivar();

      echo json_encode($result);      

      break;
}

?>