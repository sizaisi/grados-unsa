<?
require_once "../modelo/Expediente.php";

$action = '';

if (isset($_GET['action'])) {
  $action = $_GET['action'];
}

switch ($action) {
    case 'getListByIds':
      
        $idgrado_procedimiento = $_GET['idgrado_procedimiento'];
        $codi_usuario = $_GET['codi_usuario'];

        $expediente = new Expediente();

        $result = $expediente->getListByIds($idgrado_procedimiento, $codi_usuario);
   
        echo json_encode($result);       
      
        break;  

    case 'getListByCodi':
      
        $codi_usuario = $_GET['codi_usuario'];
  
        $expediente = new Expediente();
  
        $result = $expediente->getListByCodi($codi_usuario);
     
        echo json_encode($result);       
        
        break; 

    case 'getMovByIdExp':
      
        $idexpediente = $_GET['idexpediente']; 
      
        $expediente = new Expediente();
      
        $result = $expediente->getMovByIdExp($idexpediente);
         
        echo json_encode($result);       
           
        break; 
    

    case 'getExpById':
      
        $idexpediente = $_GET['idexpediente'];        

        $expediente = new Expediente();

        $result = $expediente->getExpById($idexpediente);
   
        echo json_encode($result);       
      
        break;  
  
}
?>



