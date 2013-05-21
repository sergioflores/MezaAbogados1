<?php

session_start ();

define ( 'TO_ROOT', '../' );

if ($_POST) {
	
	$conexion = null;
	
	include_once (TO_ROOT . 'domain/Abogados.php');
	
	include_once (TO_ROOT . "domain/DBHelper.php");
	
	include_once (TO_ROOT . "includes/conexion.php");
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$abogado = new Abogados ();
		
	$abogado->correo = $_POST ['correo'];
	
	$abogado->password = $_POST ['password'];
	
	$abogado->status = 1;
	
	$abogado = $readFirst = $dbHelper->readFirst ( $abogado );
	
	if (is_a ( $abogado, "Abogados" )) {
		
		$dbHelper = new DBHelper ();
		
		$dbHelper->setConection ( $conexion );
		
		$_SESSION ['id_abogado'] = $abogado->id_abogado;
		$_SESSION ['nombreAbogado'] = $abogado->nombre;
		
		header ( "location: " . TO_ROOT . "index.php" );
	
	} else {
		header ( "location: " . TO_ROOT . "index.php?error=1" );
	
	}

}

if ($_GET) {
	
	if (isset ( $_GET ['salir'] )) {
		
		unset ( $_SESSION ['id_abogado'] );
		
		header ( "location: " . TO_ROOT . "index.php" );
	
	}

}

?>