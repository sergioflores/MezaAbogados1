<?php
define ( 'TO_ROOT', '../' );

	include (TO_ROOT . "includes/conexion.php");
	include (TO_ROOT . "domain/DBHelper.php");
	include (TO_ROOT . "domain/Regiones.php");
	include (TO_ROOT . "domain/GruposRegiones.php");

	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_grupo = $_POST['id_grupo'];
	
	$gruposRegiones = new GruposRegiones();
	$gruposRegiones->id_grupo = $id_grupo;
	$gruposRegiones->status = 1;
	$gruposRegiones = $dbHelper->read($gruposRegiones);
	
	echo "<option>Seleccionar...</option>";
	
	if(count($gruposRegiones))
	foreach ($gruposRegiones as $grupoRegiones){
		
		$region = new Regiones();
		$region->id_region = $grupoRegiones->id_region;
		$region = $dbHelper->readFirst($region);
		
		echo "<option value='$region->id_region'>$region->alias</option>";
		
	}

?>