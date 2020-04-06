<?
require_once 'conexion.php';

class RolArea{
    public $id;
    public $nombre;

    private $conn;

    public function __construct() {
        $mysql = new ConexionMySql();
        $this->conn = $mysql->connect();      
    }

    public function getAllRolArea(){
        $result = array('error' => false);

        $sql = "select * from GT_ROL_AREA";
        $result_query = mysqli_query($this->conn, $sql);

        $array_rol_area = array();

        while ($row = $result_query->fetch_assoc()) {
            array_push($array_rol_area, $row);
        }

        $result['array_rol_area'] = $array_rol_area;

        return $result;
    }

    public function insertar(){
        $result = array('error' => false);

        $sql = "INSERT INTO GT_ROL_AREA(nombre, condicion) VALUES ('$this->nombre', 1)";
        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Rol-Area agregado correctamente.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo agregar el Rol-Area.";
        }      

        return $result;
    }
 
    public function actualizar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_ROL_AREA SET nombre = '$this->nombre' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Rol-Area actualizado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo actualizar el Rol-Area.";
        }

        return $result;   
    }

    
    public function activar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_ROL_AREA SET condicion = 'Activo' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Rol-Área activado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo activar el Rol-Área.";
        }

        return $result;
    }

    public function desactivar(){
        $result = array('error' => false);

        $sql = "UPDATE GT_ROL_AREA SET condicion = 'Inactivo' WHERE id = $this->id";

        $result_query = mysqli_query($this->conn, $sql);

        if ($result_query) {
            $result['message'] = "Rol-Área desactivado con éxito.";
        }
        else {
            $result['error'] = true;
            $result['message'] = "No se pudo desactivar el Rol-Área.";
        }

        return $result;
    }    
}


?>