<?php

ini_set ( 'default_charset', 'UTF-8' );

if ($_POST ['accion'] == "agregar_caso") {
	
	include_once ('../domain/Clientes.php');
	
	include_once ('../domain/Casos.php');
	
	include_once ('../domain/Etapas.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$caso = new Casos ();
	
	//Datos generales de clientes	

	$caso->id_cliente = $_POST ['id_cliente'];
	
	$caso->id_abogado = $_POST ['id_abogado'];
	
	$caso->actor = $_POST ['actor'];
	
	$caso->demandante = $_POST ['demandado'];
	
	$caso->titulo = $_POST ['titulo'];
	
	$caso->fecha_creacion = date ( 'Y-m-d G:i:s' );
	
	$caso->fecha_comienzo = $_POST ['fecha'];
	
	$caso->tipo = $_POST ['tipo'];
	
	$caso->noExpediente = $_POST ['noExp'];
	
	$caso->noExpedienteInt = $_POST ['noExpedienteInt'];
	
	$caso->juzgado = $_POST ['juzgado'];
	
	$caso->monto = $_POST ['monto'];
	
	$caso->prestacionesRec = $_POST ['prestaciones_recl'];
	
	$caso->notas = $_POST ['notas'];
	
	$caso->ciudad = $_POST ['ciudad'];
	
	$caso->pais = $_POST ['pais'];
	
	$caso->estado = $_POST ['estado'];
	
	$caso->status = 1;
	
	$resultCaso = $dbHelper->persist ( $caso );
	
	$etapa = new Etapas ();
	
	$etapa->id_caso = $resultCaso->id_casos;
	
	$etapa->nombre = $_POST ['etapa'];
	
	$etapa->fecha_etapa = $_POST ['fecha_etapa'];
	
	$etapa->fecha_publicacion = date ( 'Y-m-d G:i:s' );
	
	$etapa->comentario = "Etapa inicial";
	
	$etapa->active = 1;
	
	$dbHelper->persist ( $etapa );
	
	header ( "Location: ../casos/casos.php" );

}

if ($_POST ['accion'] == "editar_caso") {
	
	include_once ('../domain/Clientes.php');
	include_once ('../domain/Casos.php');
	include_once ('../domain/Etapas.php');
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$caso = new Casos ();
	$caso->id_casos = $_POST ['id_casos'];
	$caso = $caso;
	
	$caso->id_abogado = $_POST ['id_abogado'];
	$caso->id_cliente = $_POST ['id_cliente'];
	$caso->actor = $_POST ['actor'];
	$caso->demandante = $_POST ['demandado'];
	$caso->titulo = $_POST ['titulo'];
	$caso->fecha_comienzo = $_POST ['fecha'];
	$caso->tipo = $_POST ['tipo'];
	$caso->noExpediente = $_POST ['noExp'];
	$caso->noExpedienteInt = $_POST ['noExpedienteInt'];
	$caso->juzgado = $_POST ['juzgado'];
	$caso->monto = $_POST ['monto'];
	$caso->prestacionesRec = $_POST ['prestaciones_recl'];
	$caso->notas = $_POST ['notas'];
	$caso->ciudad = $_POST ['ciudad'];
	$caso->pais = $_POST ['pais'];
	$caso->estado = $_POST ['estado'];
	$caso->id_casos = $_POST ['id_casos'];
	$caso->status = 1;
	
	$resultCaso = $dbHelper->update ( $caso, $caso->id_casos );
	
	header ( "Location: ../casos/editarCaso.php?mensaje=1&id_casos=" . $caso->id_casos );

}

if ($_GET ['accion'] == "eliminar_caso") {
	
	include_once ('../domain/Casos.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$query = "UPDATE Casos SET status = '0' WHERE id_casos =" . trim ( $_GET ['id_casos'] );
	
	$resultCaso = $dbHelper->executeQuery ( $query );
	
	header ( "Location: ../casos/casos.php?mensaje=1" );

}

if ($_GET ['accion'] == "archivar") {
	
	include_once ('../domain/Casos.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$query = "UPDATE Casos SET status = '2' WHERE id_casos =" . trim ( $_GET ['id_caso'] );
	
	$resultCaso = $dbHelper->executeQuery ( $query );
	
	header ( "Location: ../casos/casos.php?mensaje=2" );

}

if ($_GET ['accion'] == "restablecer") {
	
	include_once ('../domain/Casos.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$query = "UPDATE Casos SET status = '1' WHERE id_casos =" . trim ( $_GET ['id_caso'] );
	
	$resultCaso = $dbHelper->executeQuery ( $query );
	
	header ( "Location: ../casos/casos_archivados.php?mensaje=3" );

}

if ($_POST ['accion'] == "add_etapa") {
	
	include_once ('../domain/Etapas.php');
	
	include_once ('../domain/Casos.php');
	
	include_once ('../domain/Clientes.php');
	
	include_once ('../domain/ContactosCliente.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	include_once ('../includes/funciones.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$caso = new Casos ();
	$caso->id_casos = $_POST ['id_casos'];
	$caso = $dbHelper->readFirst ( $caso );
	
	$abogado = new Abogados ();
	$abogado->id_abogado = $caso->id_abogado;
	$abogado = $dbHelper->readFirst ( $abogado );
	
	$cliente = new Clientes ();
	
	$cliente->id_cliente = $caso->id_cliente;
	
	$cliente = $dbHelper->readFirst ( $cliente );
	
	$contacto = new ContactosCliente ();
	
	$contacto->id_cliente = $caso->id_cliente;
	
	$contacto = $dbHelper->read ( $contacto );
	
	//Datos generales de clientes		

	$etapa = new Etapas ();
	
	$etapa->id_caso = $_POST ['id_casos'];
	
	$etapa->nombre = $_POST ['etapa'];
	
	$etapa->fecha_etapa = $_POST ['fecha'];
	
	$etapa->fecha_publicacion = date ( 'Y-m-d G:i:s' );
	
	$etapa->comentario = trim ( $_POST ['comentario'] );
	
	$etapa->active = 1;
	
	$etapa->tipo = 1;
	
	$visible = $_POST ['visible'];
	
	if ($visible == 1) {
		
		$etapa->visible = 1;
	
	} else {
		
		$etapa->visible = 0;
	
	}
	
	$dbHelper->persist ( $etapa );
	
	//Envío de correo	

	if ($cliente->email == 1 && $visible == 1) {
		
		require_once ('../includes/class.phpmailer.php');
		
		$listaDeDirecciones = array ();
		
		if (count ( $contacto ) < 5) {
			foreach ( $contacto as $contactoCliente ) {
				
				if (! empty ( $contactoCliente->correo_electronico )) {
					
					$direccion ['nombre'] = $contactoCliente->nombre;
					
					$direccion ['correo'] = $contactoCliente->correo_electronico;
					
					$listaDeDirecciones [] = $direccion;
				
				}
			
			}
			
			$mensaje = '
	<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
body {
	font-family: Arial;
}
</style>
</head>
<body>
<div style="width: 100%">
<div
	style="width: 100%; height: 50px; background-color: #051a2d; padding-top: 20px; padding-left: 10px;">
<span style="color: #FFF;">Barbosa & Huerga</span></div>
<div
	style="background-color: #d4d5da; width: 100%; height: 20px; padding-left: 10px;"></div>
<div style="font-size: 12px; color: gray;">
<p>Ha habido un avance en su caso.</p>
Tipo de Avance: Etapa<br>
Cliente: ' . $cliente->nombre . '<br>
Actor: ' . $caso->actor . '<br>
Demandado: ' . $caso->demandante . '<br>
Tipo: ' . $caso->tipo . '<br>
Abogado asignado: ' . $abogado->nombre . '<br>
Fecha de la opereción:' . trim ( $_POST ['fecha'] ) . '<br>
<p><strong>Descripción:</strong><hr />
<strong> ' . trim ( $_POST ['etapa'] ) . '</strong><br>
' . trim ( $_POST ['comentario'] ) . '
</p></div></div></body></html>';
			
			Utils::enviarEmail ( "Notificación Nueva Etapa - Barbosa & Huerga", $mensaje, $listaDeDirecciones );
		
		}
	}
	
	header ( "Location: ../casos/procesarEtapas.php?id_casos=" . $_POST ['id_casos'] );

}

if ($_POST ['accion'] == "add_comment") {
	
	include_once ('../domain/Etapas.php');
	
	include_once ('../domain/Casos.php');
	
	include_once ('../domain/ContactosCliente.php');
	
	include_once ('../domain/Clientes.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	include_once ('../includes/funciones.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$caso = new Casos ();
	$caso->id_casos = $_POST ['id_casos'];
	$caso = $dbHelper->readFirst ( $caso );
	
	$abogado = new Abogados ();
	$abogado->id_abogado = $caso->id_abogado;
	$abogado = $dbHelper->readFirst ( $abogado );
	
	$cliente = new Clientes ();
	
	$cliente->id_cliente = $caso->id_cliente;
	
	$cliente = $dbHelper->readFirst ( $cliente );
	
	$contacto = new ContactosCliente ();
	
	$contacto->id_cliente = $caso->id_cliente;
	
	$contacto = $dbHelper->read ( $contacto );
	
	//Datos generales de clientes		

	$etapa = new Etapas ();
	
	$etapa->id_caso = $_POST ['id_casos'];
	
	$etapa->fecha_etapa = $_POST ['fecha'];
	
	$etapa->fecha_publicacion = date ( 'Y-m-d G:i:s' );
	
	$etapa->comentario = $_POST ['comentario'];
	
	$etapa->active = 1;
	
	$etapa->tipo = 2;
	
	$visible = $_POST ['visible'];
	
	if ($visible == 1) {
		
		$etapa->visible = 1;
	
	} else {
		
		$etapa->visible = 0;
	
	}
	
	$dbHelper->persist ( $etapa );
	
	//Envío de correo	

	if ($cliente->email == 1 && $visible == 1) {
		
		require_once ('../includes/class.phpmailer.php');
		
		$listaDeDirecciones = array ();
		if (count ( $contacto ) < 5) {
			foreach ( $contacto as $contactoCliente ) {
				
				if (! empty ( $contactoCliente->correo_electronico )) {
					
					$direccion ['nombre'] = $contactoCliente->nombre;
					
					$direccion ['correo'] = $contactoCliente->correo_electronico;
					
					$listaDeDirecciones [] = $direccion;
				
				}
			
			}
			
			$mensaje = '

	

	<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<style type="text/css">

body {

	font-family: Arial;

}

</style>

</head>

<body>

<div style="width: 100%">

<div

	style="width: 100%; height: 50px; background-color: #051a2d; padding-top: 20px; padding-left: 10px;">

<span style="color: #FFF;">Barbosa & Huerga</span></div>

<div

	style="background-color: #d4d5da; width: 100%; height: 20px; padding-left: 10px;"></div>

<div style="font-size: 12px; color: gray;">

<p>Ha habido un avance en su caso.</p>

Tipo de Avance: Informativo<br>

Cliente: ' . $cliente->nombre . '<br>

Actor: ' . $caso->actor . '<br>

Demandado: ' . $caso->demandante . '<br>

Tipo: ' . $caso->tipo . '<br>

Abogado asignado: ' . $abogado->nombre . '<br>

Fecha de la opereción:' . $_POST ['fecha'] . '<br>



<p><strong>Descripción:</strong><hr />

' . $_POST ['comentario'] . '

</p>

</div>

</div>

</body>

</html>

	';
			
			Utils::enviarEmail ( "Notificación - Barbosa & Huerga", $mensaje, $listaDeDirecciones );
		
		}
	}
	header ( "Location: ../casos/procesarEtapas.php?id_casos=" . $_POST ['id_casos'] );

}

if ($_POST ['accion'] == "editar_etapa") {
	
	include_once ('../domain/Clientes.php');
	
	include_once ('../domain/Casos.php');
	
	include_once ('../domain/Etapas.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$caso = new Casos ();
	
	//Datos generales de clientes		

	$etapa = new Etapas ();
	
	$etapa->id_etapa = $_POST ['id_etapa'];
	
	$etapa->id_caso = $_POST ['id_casos'];
	
	$etapa->nombre = trim ( $_POST ['etapa'] );
	
	$etapa->fecha_etapa = $_POST ['fecha'];
	
	$etapa->comentario = trim ( $_POST ['comentario'] );
	
	$etapa->active = 1;
	
	$textoEtapa = trim ( $_POST ['etapa'] );
	
	$visible = $_POST ['visible'];
	
	if (empty ( $textoEtapa )) {
		
		$etapa->tipo = 2;
	
	} else {
		
		$etapa->tipo = 1;
	
	}
	
	if ($visible == 1) {
		
		$etapa->visible = 1;
	
	} else {
		
		$etapa->visible = 0;
	
	}
	
	$dbHelper->update ( $etapa, $_POST ['id_etapa'] );
	
	header ( "Location: ../casos/procesarEtapas.php?id_casos=" . $_POST ['id_casos'] );

}

if ($_POST ['accion'] == "guardar_costo") {
	
	include_once ('../domain/Costos.php');
	
	include_once ('../domain/Gastos.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	if ($_POST ['gastoCosto'] == 1) {
		
		$costo = new Costos ();
		
		$costo->id_caso = $_POST ['id_caso'];
		
		$costo->tipo = $_POST ['tipo'];
		
		$costo->valor = str_replace ( ",", "", $_POST ['valor'] );
		
		$costo->concepto = trim ( $_POST ['concepto'] );
		
		$dbHelper->persist ( $costo );
	
	} else {
		
		$gasto = new Gastos ();
		
		$gasto->id_caso = $_POST ['id_caso'];
		
		$gasto->tipo = $_POST ['tipo'];
		
		$gasto->valor = str_replace ( ",", "", $_POST ['valor'] );
		
		$gasto->concepto = trim ( $_POST ['concepto'] );
		
		$dbHelper->persist ( $gasto );
	
	}
	
	header ( "Location: ../casos/procesarEtapas.php?costos=costos&id_casos=" . $_POST ['id_caso'] );

}

if ($_GET ['accion'] == "eliminar_gastocosto") {
	
	include_once ('../domain/Casos.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	if (! empty ( $_GET ['id_costo'] )) {
		
		$query = "DELETE FROM Costos WHERE id_costo = " . $_GET ['id_costo'];
	
	} else {
		
		$query = "DELETE FROM Gastos WHERE id_gasto = " . $_GET ['id_gasto'];
	
	}
	
	$resultCaso = $dbHelper->executeQuery ( $query );
	
	header ( "Location: ../casos/procesarEtapas.php?costos=costos&id_casos=" . $_GET ['id_casos'] );

}

if ($_GET ['accion'] == "eliminar_etapa") {
	
	include_once ('../domain/Etapas.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	if (! empty ( $_GET ['id_etapa'] )) {
		
		$etapa = new Etapas ();
		
		$etapa->id_etapa = $_GET ['id_etapa'];
		
		$etapa = $dbHelper->readFirst ( $etapa );
		
		$etapa->status = 0;
		
		$dbHelper->update ( $etapa, $etapa->id_etapa );
	
	}
	
	header ( "Location: ../casos/procesarEtapas.php?id_casos=" . $_GET ['id_casos'] );

}

?>