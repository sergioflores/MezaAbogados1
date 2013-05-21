<?php

session_start ();
ini_set ( 'default_charset', 'UTF-8' );
header ( 'Content-Type:text/html; charset=UTF-8' );
define ( 'TO_ROOT', '../' );

if (isset ( $_SESSION ['id_abogado'] )) {
	
	if ($_POST ['accion'] == "guardar_expediente") {
		
		include_once (TO_ROOT . "includes/conexion.php");
		include_once (TO_ROOT . "domain/DBHelper.php");
		include_once (TO_ROOT . "domain/Expedientes.php");
		include_once (TO_ROOT . "domain/ActorExpediente.php");
		include_once (TO_ROOT . "domain/DemandadoExpediente.php");
		include_once (TO_ROOT . "domain/AbogadoExpediente.php");
		
		$dbHelper = new DBHelper ();
		
		$dbHelper->setConection ( $conexion );
		
		$expediente = new Expedientes ();
		$expediente->accion = $_POST ['accionE'];
		$expediente->comentarios = $_POST ['comentarios'];
		$expediente->id_cliente = $_POST ['id_cliente'];
		$expediente->status = 1;
		$expediente->noExterno = $_POST ['noExterno'];
		$expediente->tipo = $_POST ['tipo'];
		$expediente = $dbHelper->persist ( $expediente );
		
		if (count ( $_POST ['id_actor'] ) > 0) {
			$id_actores = array_unique ( $_POST ['id_actor'] );
			foreach ( $id_actores as $id_actor ) {
				$actorExpediente = new ActorExpediente ();
				$actorExpediente->id_actor = $id_actor;
				$actorExpediente->id_expediente = $expediente->id_expediente;
				$actorExpediente->status = 1;
				
				$dbHelper->persist ( $actorExpediente );
			}
		}
		
		if (count ( $_POST ['id_demandado'] ) > 0) {
			$id_demandados = array_unique ( $_POST ['id_demandado'] );
			
			foreach ( $id_demandados as $id_demandado ) {
				$demandadoExpediente = new DemandadoExpediente ();
				$demandadoExpediente->id_demandado = $id_demandado;
				$demandadoExpediente->id_expediente = $expediente->id_expediente;
				$demandadoExpediente->status = 1;
				
				$dbHelper->persist ( $demandadoExpediente );
			}
		}
		
		$id_abogados = $_POST ['id_abogados'];
		if (count ( $id_abogados ) > 0)
			foreach ( $id_abogados as $id_abogado ) {
				$expedienteAbogado = new AbogadoExpediente ();
				$expedienteAbogado->fechaCreacion = date ( "Y-m-d H:i:s" );
				$expedienteAbogado->id_abogado = $id_abogado;
				$expedienteAbogado->id_expediente = $expediente->id_expediente;
				$expedienteAbogado->status = 1;
				$dbHelper->persist ( $expedienteAbogado );
			}
		
		header ( "Location: ../expedientes/verExpediente.php?id_expediente=" . $expediente->id_expediente );
	
	}

}
?>