<?
require_once "../modelo/Usuario.php";
require_once "../modelo/UsuarioExpediente.php";

$action = '';

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

switch ($action) {    

    case 'getIdUsuario': //obtener el idusuario       

        $usuario = new Usuario();
        $usuario->codi_usuario = $_GET['codi_usuario'];        

        $result = $usuario->getIdUsuario();
   
        echo json_encode($result);       
      
        break;  

    case 'getGradByIdExp': //obtener todos los graduandos de un solo expediente
      
        $idexpediente = $_GET['idexpediente'];        

        $usuario = new Usuario();

        $result = $usuario->getGradByIdExp($idexpediente);
   
        echo json_encode($result);       
      
        break;  
    
    case 'getDocentes': //obtener todos los posibles asesores o jurados de un expediente segun su escuela o nues
      
        $idexpediente = $_GET['idexpediente'];        

        $usuario = new Usuario();

        $result = $usuario->getDocentes($idexpediente);
   
        echo json_encode($result);       
      
        break;  

    case 'getExpJurados': //obtener los jurados registrados en la tabla usuario_expediente
      
        $idexpediente = $_GET['idexpediente'];        

        $usuario_expediente = new UsuarioExpediente();

        $result = $usuario_expediente->getExpJurados($idexpediente);

        echo json_encode($result);       
      
        break;          

    case 'getAsesor': //obtener el asesor asignado a un expediente 
      
        $idexpediente = $_GET['idexpediente'];        

        $usuario_expediente = new UsuarioExpediente();

        $result = $usuario_expediente->getAsesor($idexpediente);
   
        echo json_encode($result);       
      
        break; 

    case 'getNombreAsesor': //obtener el asesor para mostrar en jurado
      
        $idexpediente = $_GET['idexpediente'];        

        $usuario_expediente = new UsuarioExpediente();

        $result = $usuario_expediente->getNombreAsesor($idexpediente);
   
        echo json_encode($result);       
      
        break;  

    case 'storeAsesor': 
        $usuario_expediente = new UsuarioExpediente();
  
        $usuario_expediente->idexpediente = $_POST['idexpediente'];
        $usuario_expediente->idusuario = $_POST['iddocente'];
        $usuario_expediente->tipo = 'asesor';

        $result = $usuario_expediente->insertar_asesor();        

        echo json_encode($result);       

        break;

    case 'deleteAsesor':    
        $usuario_expediente = new UsuarioExpediente();
    
        $usuario_expediente->id = $_POST['id'];        

        $result = $usuario_expediente->deleteAsesor();        

        echo json_encode($result);

        break; 

    case 'storeJurado': 
        $usuario_expediente = new UsuarioExpediente();
  
        $usuario_expediente->idexpediente = $_POST['idexpediente'];
        $usuario_expediente->idusuario = $_POST['iddocente'];
        $usuario_expediente->tipo = $_POST['tipo'];

        $result = $usuario_expediente->insertar_jurado();        

        echo json_encode($result);       

        break;
    
    case 'deleteJurado': 
        $usuario_expediente = new UsuarioExpediente();
  
        $usuario_expediente->id = $_POST['id'];        

        $result = $usuario_expediente->eliminar_jurado();        

        echo json_encode($result);       

        break;
}
?>



