<?php
	/*Conexión BD*/
	include("../conexion/class.conexion.php");
	$db = new MySQL();
	$consulta = $db->consulta("SELECT id_tipo_movimiento id, descripcion descripcion FROM tiv_tipos_movimientos WHERE estado = 'A' AND ajuste = 'S' ORDER BY 1 ASC;");
	
	$rows = array();
	/*Recorrido de Datos*/
	if($db->num_rows($consulta)>=0){
	  while($resultados = $db->fetch_array($consulta)){ 
	    $rows[] = array_map('utf8_encode',$resultados);
	 }
	}
	
	/*Retorno de Información*/
	echo json_encode($rows);
?>
