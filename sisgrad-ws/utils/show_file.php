<?php
if (isset($_POST['file_id'])) {
	require_once '../config/db.php';
	$file_id = $_POST['file_id'];
	
	$conn = Database::conectar();
	$sql = "SELECT * from GT_ARCHIVO where idrecurso = $file_id";
	$result_query = mysqli_query($conn, $sql);
	$row = $result_query->fetch_assoc();     
	
	switch ($row['mime']) {
		case 'application/pdf':
			$extension = '.pdf';
			break;
		case 'image/png':
			$extension = '.png';
			break;
		case 'image/jpeg':
			$extension = '.jpg';
			break;
	}	

	header('Content-type:'.$row['mime']);
	header('Content-Disposition:inline; filename='.$row['nombre_asignado'].$extension);

	echo base64_decode($row['data']);      	
}
else {
	echo "<h3>No tiene permiso de acceso para mostrar el archivo</h3>";
}
?>