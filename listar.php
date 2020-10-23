<?php

require 'conexion.php';
$conexion = conectarBD();

$query = "SELECT  a.num_legajo as legajo, 
				  a.apellido as apellidoAlumno, 
				  a.nombre as nombreAlumno, 
				  a.celular as celular,
				  l.nombre as nombreLocalidad, 
				  c.nombre as nombreCarrera, 
				  a.anio as anio
FROM alumno a 
	 INNER JOIN localidad l 
	 ON (a.localidad_fk = l.id) 
	 INNER JOIN carreraregional cr 
	 ON (a.carrera_regional_fk = cr.id) 
	 INNER JOIN carrera c 
	 ON (cr.carrera_fk = c.id)";

$resultado = pg_query($conexion, $query);

if( !$resultado ){
	die("Error");
}else{
	while( $data = pg_fetch_assoc($resultado) ){
		$arreglo["data"][] = array_map("utf8_encode", $data);
	}
	echo json_encode($arreglo);
}

pg_free_result($resultado);
pg_close($conexion);