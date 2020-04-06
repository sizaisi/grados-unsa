<?
require_once "../modelo/Archivo.php";

$action = '';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

switch ($action) {
    case 'readAll':    
        $archivo = new Archivo();        

        $archivo->idexpediente = $_GET['idexpediente'];

        $result = $archivo->getTodosArchivos();

        echo json_encode($result);

        break;    

    case 'getDocumento':    
        $archivo = new Archivo();        

        $archivo->idgrado_proc = $_GET['idgrado_proc'];
        $archivo->idusuario = $_GET['idusuario'];
        $archivo->idexpediente = $_GET['idexpediente'];

        $result = $archivo->getDocumento();

        echo json_encode($result);       

        break;   
        
    case 'storeDocumento':    
        $archivo = new Archivo();        

        $archivo->nombre = $_POST['nombre'];
        $archivo->data = base64_encode(file_get_contents($_FILES['data']['tmp_name']));
        $archivo->extension = $_FILES['data']['type'];
        $archivo->idgrado_proc = $_POST['idgrado_proc'];
        $archivo->idusuario = $_POST['idusuario'];
        $archivo->idexpediente = $_POST['idexpediente'];       

        $result = $archivo->storeDocumento();

        echo json_encode($result);

        break;   
    
    case 'deleteDocumento':    
        $archivo = new Archivo();        

        $archivo->id = $_POST['id'];        

        $result = $archivo->deleteDocumento();

        echo json_encode($result);

        break;   
}

?>