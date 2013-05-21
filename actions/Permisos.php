<?php

if ($_POST ['accion'] == "guardar_permisos") {
	
	define ( 'TO_ROOT', '../' );
	
	include (TO_ROOT . "includes/conexion.php");
	include (TO_ROOT . "domain/DBHelper.php");
	include (TO_ROOT . "domain/Permisos.php");
	include (TO_ROOT . "domain/Abogados.php");
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_abogados = $_POST ['id_abogado'];
	
	$i = 0;
	foreach ( $id_abogados as $id_abogado ) {
		
		$permisos = new Permisos ();
		$permisos->id_abogado = $id_abogado;
		$permisos = $dbHelper->readFirst($permisos);

		$permisos->verClientes = ($_POST['verClientes' . $i ] == 1 ? 1: 0);
		$permisos->eliminarClientes = ($_POST['eliminarClientes' . $i]  == 1 ? 1: 0); 
		$permisos->editarCasos = ($_POST['editarCasos' . $i ]  == 1 ? 1: 0);
		$permisos->eliminarCasos = ($_POST['eliminarCasos' . $i ]  == 1 ? 1: 0);
		$permisos->editarEtapas = ($_POST['editarEtapas' . $i ]  == 1 ? 1: 0);
		$permisos->eliminarEtapas = ($_POST['eliminarEtapas' . $i ]  == 1 ? 1: 0);
		$permisos->verHonorarios = ($_POST['verHonorarios' . $i ]  == 1 ? 1: 0);
		$permisos->verGastos = ($_POST['verGastos' . $i ]  == 1 ? 1: 0);
		$permisos->verReportes = ($_POST['verReportes' . $i ] == 1 ? 1: 0);
		$permisos->verAbogados = ($_POST['verAbogados' . $i ] == 1 ? 1: 0);
		$permisos->eliminarAbogados = ($_POST['eliminarAbogados' . $i ] == 1 ? 1: 0);
		
		$dbHelper->update($permisos, $id_abogado);
		
		$i ++;
	}
	
	header("Location: ../permisos/permisos.php");

}