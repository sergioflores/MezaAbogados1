<?php

if ($_POST ['accion'] == "agregar_abogado") {
	
	include_once ('../domain/Abogados.php');
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$abogado = new Abogados ();
	
	//Datos generales de clientes
	$abogado->nombre = $_POST ['nombre'];
	$abogado->correo = $_POST ['correo'];
	$abogado->telefono = $_POST ['telefono'];
	$abogado->celular = $_POST ['celular'];
	$abogado->extension = $_POST ['ext'];
	$abogado->costoHora = $_POST ['costoHora'];
	$abogado->password = $_POST ['password'];
	$abogado->status = 1;
	
	$resulCliente = $dbHelper->persist ( $abogado );
	
	header ( "Location: ../abogados/abogados.php" );

}

if ($_POST ['accion'] == "editar_abogado") {
	
	include_once ('../domain/Abogados.php');
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$abogado = new Abogados ();
	
	//Datos generales de clientes
	$abogado->nombre = $_POST ['nombre'];
	$abogado->correo = $_POST ['correo'];
	$abogado->telefono = $_POST ['telefono'];
	$abogado->celular = $_POST ['celular'];
	$abogado->extension = $_POST ['ext'];
	$abogado->id_abogado = $_POST ['id_abogado'];
	$abogado->costoHora = $_POST ['costoHora'];
	$abogado->password = $_POST ['password'];
	$abogado->status = 1;
	
	$resulCliente = $dbHelper->update ( $abogado, $_POST ['id_abogado'] );
	
	header ( "Location: ../abogados/editarAbogado.php?mensaje=1&id_abogado=" . $_POST ['id_abogado'] );

}

if ($_POST ['accion'] == "eliminar_abogado") {
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/Casos.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_abogado = $_POST ['id_abogado'];
	$id_abogado_remplazo = $_POST ['abogado'];
	
	$mensaje = 1;
	
	if (empty ( $id_abogado ) || empty ( $id_abogado_remplazo )) {
		$mensaje = 2;
	} else {
		
		$query = "UPDATE Casos SET id_abogado = $id_abogado_remplazo WHERE id_abogado = $id_abogado";
		$dbHelper->executeQuery ( $query );
		
		$query = "UPDATE Abogados SET status = 0 WHERE id_abogado = " . $id_abogado;
		$dbHelper->executeQuery ( $query );
	}
	
	header ( "Location: ../abogados/abogados.php?mensaje=" . $mensaje );

}

?>
