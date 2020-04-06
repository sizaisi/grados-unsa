<?
require_once 'conexion.php';

class ModalidadObtencion{
    public $id;
    public $nombre;

    private $conn;

    public function __construct() {
        $mysql = new ConexionMySql();
        $this->conn = $mysql->connect();      
    }

    public function getAllModalidadObtencion(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_MODALIDAD_OBTENCION";
        $result_query = mysqli_query($this->conn, $sql);

        $array_modalidad_obtencion = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_modalidad_obtencion, $row);
        }

        $result['array_modalidad_obtencion'] = $array_modalidad_obtencion;

        return $result;
    }

    public function getActives(){
        $result = array('error' => false);

        $sql = "SELECT * FROM GT_MODALIDAD_OBTENCION where condicion = 1";
        $result_query = mysqli_query($this->conn, $sql);

        $array_modalidad_obtencion = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_modalidad_obtencion, $row);
        }

        $result['array_modalidad_obtencion'] = $array_modalidad_obtencion;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_MODALIDAD_OBTENCION(nombre, condicion, fing) VALUES ('$this->nombre', 1, null)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Modalidad de obtencion agregada correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar modalidad de obtencion.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_MODALIDAD_OBTENCION SET nombre = '$this->nombre' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Modalidad de obtencion actualizada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar la modalidad de obtencion.";
        }

        return $result;   
    }

    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_MODALIDAD_OBTENCION SET condicion = '1' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Modalidad de obtencion activada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar la modalidad de obtencion.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_MODALIDAD_OBTENCION SET condicion = '0' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Modalidad de obtencion activada con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar la modalidad de obtencion.";
        }

        return $result;
    }
}

?>