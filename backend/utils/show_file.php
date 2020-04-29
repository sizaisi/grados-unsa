<?php
if (isset($_POST['file_id'])) {
	require_once '../config/db.php';
	$file_id = $_POST['file_id'];
	
	$conn = Database::conectar();
	$sql = "SELECT * from GT_ARCHIVO where id = $file_id";
	$result_query = mysqli_query($conn, $sql);
	$row = $result_query->fetch_assoc();      

	header('Content-type:'.$row['extension']);
	header('Content-Disposition:inline; filename='.$row['nombre'].'.pdf');

	echo base64_decode($row['data']);      	
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>