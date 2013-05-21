<?php

if ($_POST ['accion'] == "agregar_cliente") {
	
	include_once ('../domain/Clientes.php');
	include_once ('../domain/Contactos.php');
	include_once ('../domain/DatosFiscales.php');
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/ClientesDatosFiscales.php');
	include_once ('../domain/DatosSociales.php');
	include_once ('../domain/ClientesDatosSociales.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	$cliente = new Clientes ();
	
	//Datos generales de clientes
	$cliente->nombreEmpresa = $_POST ['nombreEmpresa'];
	$cliente->paginaWeb = $_POST ['paginaWeb'];
	$cliente->tipo = $_POST ['tipo'];
	$cliente->sindicato = $_POST ['sindicato'];
	$cliente->facebook = $_POST ['facebook'];
	$cliente->twitter = $_POST ['twitter'];
	$cliente->quienRefiere = $_POST ['quienRefiere'];
	$cliente->comentarios = $_POST ['comentarios'];
	$cliente->status = 1;
	
	$resulCliente = $dbHelper->persist ( $cliente );
	
	$datosFiscales = new DatosFiscales ();
	
	$datosFiscales->RFC = $_POST ['rfc'];
	$datosFiscales->nombre = $_POST ['razon'];
	$datosFiscales->calle = $_POST ['calle'];
	$datosFiscales->nroExterior = $_POST ['noe'];
	$datosFiscales->nroInterior = $_POST ['noi'];
	$datosFiscales->colonia = $_POST ['colonia_fac'];
	$datosFiscales->municipio = $_POST ['municipio_fac'];
	$datosFiscales->estado = $_POST ['estado_fac'];
	$datosFiscales->codigoPostal = $_POST ['cp_fac'];
	$datosFiscales->correoFacturacion = "correo@correo.com";
	
	$datosFiscales = $dbHelper->persist ( $datosFiscales );
	
	$clientesDatosFiscales = new ClientesDatosFiscales ();
	$clientesDatosFiscales->id_cliente = $resulCliente->id_cliente;
	$clientesDatosFiscales->id_datosFiscales = $datosFiscales->id_datosFiscales;
	$clientesDatosFiscales->status = 1;
	$dbHelper->persist ( $clientesDatosFiscales );
	
	$arrayNombre = $_POST ['nombreCont'];
	$arrayCorreoContacto = $_POST ['correoContacto'];
	$arrayTelefonoCont = $_POST ['telefonoCont'];
	$arrayExtension = $_POST ['extension'];
	$arrayCelular = $_POST ['celular'];
	$arrayPuesto = $_POST ['puesto'];
	$arrayFacebook = $_POST ['facebookCont'];
	$arrayTwitter = $_POST ['twitterCont'];
	$arrayCumpleanos = $_POST ['fechaCumpleanos'];
	$arrayComentarios = $_POST ['comentariosCont'];
	
	$i = 0;
	
	if (count ( $arrayNombre ) > 0)
		
		foreach ( $arrayNombre as $nombre ) {
			
			$contacto = new Contactos ();
			
			$contacto->nombre = $nombre;
			$contacto->correo = $arrayCorreoContacto [$i];
			$contacto->telefono = $arrayTelefonoCont [$i];
			$contacto->extension = $arrayExtension [$i];
			$contacto->celular = $arrayCelular [$i];
			$contacto->puesto = $arrayPuesto [$i];
			$contacto->facebook = $arrayFacebook [$i];
			$contacto->twitter = $arrayTwitter [$i];
			$contacto->fechaCumpleanos = $arrayCumpleanos [$i];
			$contacto->comentario = $arrayComentarios [$i];
			$contacto->id_cliente = $resulCliente->id_cliente;
			
			$dbHelper->persist ( $contacto );
			
			$i ++;
		
		}
	
	$datoSocial = new DatosSociales ();
	$datoSocial->status = 1;
	$datoSocial = $dbHelper->persist($datoSocial);
	
	$clientesDatosSociales = new ClientesDatosSociales();
	$clientesDatosSociales->id_cliente = $resulCliente->id_cliente;
	$clientesDatosSociales->id_datosSociales = $datoSocial->id_datosSociales;
	$dbHelper->persist ( $clientesDatosSociales );
	
	$clienteGrupo = new ClienteGrupo();
	$clienteGrupo->id_cliente = $resulCliente->id_cliente;;
	$clienteGrupo->id_grupo = $_POST['id_grupo'];
	$clienteGrupo->status = 1;
	$dbHelper->persist($clienteGrupo);
	
	$clienteRegion = new ClienteRegion();
	$clienteRegion->id_cliente = $resulCliente->id_cliente;
	$clienteRegion->id_region = $_POST['id_region'];
	$clienteRegion->status = 1;
	$dbHelper->persist($clienteRegion);
	
	$id_Regiones = $_POST['id_region'];

	foreach ($id_Regiones as $id_Region){
		$clienteRegion = new ClienteRegion();
		$clienteRegion->id_cliente = $resulCliente->id_cliente;
		$clienteRegion->id_region = $id_Region;
		$clienteRegion->status = 1;
		$dbHelper->persist($clienteRegion);
	}
	
	header ( "Location: ../clientes/clientes.php" );

}

if ($_POST ['accion'] == "editar_cliente") {
	
	include_once ('../domain/Clientes.php');
	
	include_once ('../domain/ContactosCliente.php');
	
	include_once ('../domain/DatosFacturacion.php');
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$cliente = new Clientes ();
	
	//Datos generales de clientes
	

	$cliente->nombre = $_POST ['nombre'];
	
	$cliente->razon_social = $_POST ['razon_social'];
	
	$cliente->direccion = $_POST ['direccion'];
	
	$cliente->numero = $_POST ['numero'];
	
	$cliente->numero_int = $_POST ['numero_int'];
	
	$cliente->colonia = $_POST ['colonia'];
	
	$cliente->municipio = $_POST ['municipio'];
	
	$cliente->estado = $_POST ['estado'];
	
	$cliente->pais = $_POST ['pais'];
	
	$cliente->cp = $_POST ['cp'];
	
	$cliente->telefono = $_POST ['telefono'];
	
	$cliente->celular = $_POST ['celular'];
	
	$cliente->user = $_POST ['user'];
	
	$cliente->password = $_POST ['password'];
	
	$cliente->id_cliente = $_POST ['id_cliente'];
	
	if ($_POST ['sendEmail'] == 1) {
		
		$cliente->email = $_POST ['sendEmail'];
	
	} else {
		
		$cliente->email = 0;
	
	}
	
	$dbHelper->update ( $cliente, $cliente->id_cliente );
	
	// Datos de Facturacion
	

	$datosFacturacion = new DatosFacturacion ();
	
	$datosFacturacion->rfc = $_POST ['rfc'];
	
	$datosFacturacion->nombre = $_POST ['razon'];
	
	$datosFacturacion->direccion = $_POST ['calle'];
	
	$datosFacturacion->numero = $_POST ['noe'];
	
	$datosFacturacion->numero_int = $_POST ['noi'];
	
	$datosFacturacion->colonia = $_POST ['colonia_fac'];
	
	$datosFacturacion->municipio = $_POST ['municipio_fac'];
	
	$datosFacturacion->estado = $_POST ['estado_fac'];
	
	$datosFacturacion->pais = $_POST ['pais_fac'];
	
	$datosFacturacion->cp = $_POST ['cp_fac'];
	
	$datosFacturacion->id_datos_facturacion = $_POST ['id_datos_facturacion'];
	
	$dbHelper->update ( $datosFacturacion, $_POST ['id_datos_facturacion'] );
	
	$arrayNombre = $_POST ['nombreCont'];
	
	$arrayDireccion = $_POST ['direccionCont'];
	
	$arrayMunicipio = $_POST ['municipioCont'];
	
	$arrayFacebook = $_POST ['estadoCont'];
	
	$arrayTwitter = $_POST ['emailCont'];
	
	$arrayCumpleanos = $_POST ['telefonoCont'];
	
	$arrayComentarios = $_POST ['celularCont'];
	
	$arrayIdContacto = $_POST ['id_contacto_cliente'];
	
	$i = 0;
	
	if (count ( $arrayNombre ) > 0)
		
		foreach ( $arrayNombre as $nombre ) {
			
			$contacto = new ContactosCliente ();
			
			$contacto->nombre = $nombre;
			
			$contacto->direccion = $arrayDireccion [$i];
			
			$contacto->municipio = $arrayMunicipio [$i];
			
			$contacto->correo_electronico = $arrayTwitter [$i];
			
			$contacto->telefono = $arrayCumpleanos [$i];
			
			$contacto->celular = $arrayComentarios [$i];
			
			$contacto->id_cliente = $cliente->id_cliente;
			
			if ($arrayIdContacto [$i] > 0) {
				
				$contacto->id_contactos_cliente = $arrayIdContacto [$i];
				
				$dbHelper->update ( $contacto, $arrayIdContacto [$i] );
			
			} else {
				
				$dbHelper->persist ( $contacto );
			
			}
			
			$i ++;
		
		}
	
	header ( "Location: ../clientes/editarCliente.php?mensaje=1&id_cliente=" . $cliente->id_cliente );

}

if ($_GET ['accion'] == "eliminar_cliente") {
	
	include_once ('../includes/conexion.php');
	
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	$query = "UPDATE Clientes SET status = 0 WHERE id_cliente = " . $_GET ['id_cliente'];
	$dbHelper->executeQuery ( $query );
	
	header ( "Location: ../clientes/clientes.php?mensaje=1" );

}

if ($_GET ['accion'] == "eliminar_contacto") {
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$query = "UPDATE ContactosCliente SET status = 0 WHERE id_contactos_cliente = " . $_GET ['id_contacto'];
	$dbHelper->executeQuery ( $query );
	
	header ( "Location: ../clientes/editarCliente.php?id_cliente=" . $_GET ['id_cliente'] );
}

if ($_POST ['accion'] == "guardar_datos_sociales") {
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/DatosSociales.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$datoSocial = new DatosSociales ();
	$datoSocial->id_cliente = $_POST ['id_cliente'];
	$datoSocial = $dbHelper->readFirst ( $datoSocial );
	
	$datoSocial->fechaConstitucion = $_POST ['fechaConstitucion'];
	$datoSocial->noInstrumentoNotarial = $_POST ['noInstrumentoNotarial'];
	$datoSocial->nombreNotario = $_POST ['nombreNotario'];
	$datoSocial->adscripcion = $_POST ['adscripcion'];
	$datoSocial->nombreRepresentanteLegal = $_POST ['nombreRepresentanteLegal'];
	$datoSocial->fechaProtocolizacion = $_POST ['fechaProtocolizacion'];
	$datoSocial->status = 1;
	
	$dbHelper->update ( $datoSocial, $datoSocial->id_clientesMorales );
	
	echo "Los datos se han guardado con éxito";

}

if ($_POST ['accion'] == "guardar_datos_generales") {
	
	include_once ('../domain/Clientes.php');
	include_once ('../domain/Contactos.php');
	include_once ('../domain/DatosFiscales.php');
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/ClientesDatosFiscales.php');
	include_once ('../domain/DatosSociales.php');
	include_once ('../domain/ClienteGrupo.php');
	include_once ('../domain/ClienteRegion.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_cliente = $_POST ['id_cliente'];
	
	$cliente = new Clientes ();
	$cliente->id_cliente = $id_cliente;
	$cliente = $dbHelper->readFirst ( $cliente );
	
	//Datos generales de clientes
	$cliente->nombreEmpresa = $_POST ['nombreEmpresa'];
	$cliente->paginaWeb = $_POST ['paginaWeb'];
	$cliente->tipo = $_POST ['tipo'];
	$cliente->sindicato = $_POST ['sindicato'];
	$cliente->facebook = $_POST ['facebook'];
	$cliente->twitter = $_POST ['twitter'];
	$cliente->quienRefiere = $_POST ['quienRefiere'];
	$cliente->datoEconomico = $_POST['datoEconomico'];
	$cliente->iguala = $_POST['iguala'];
	$cliente->comentarios = $_POST ['comentarios'];
	$cliente->status = 1;
	
	$dbHelper->update ( $cliente, $cliente->id_cliente );
	
	$clientesDatosFiscales = new ClientesDatosFiscales ();
	$clientesDatosFiscales->id_cliente = $cliente->id_cliente;
	$clientesDatosFiscales->tipo = 1;
	$clientesDatosFiscales->status = 1;
	$clientesDatosFiscales = $dbHelper->readFirst ( $clientesDatosFiscales );
	
	$datosFiscales = new DatosFiscales ();
	$datosFiscales->RFC = $_POST ['rfc'];
	$datosFiscales->nombre = $_POST ['razon'];
	$datosFiscales->calle = $_POST ['calle'];
	$datosFiscales->nroExterior = $_POST ['noe'];
	$datosFiscales->nroInterior = $_POST ['noi'];
	$datosFiscales->colonia = $_POST ['colonia_fac'];
	$datosFiscales->municipio = $_POST ['municipio_fac'];
	$datosFiscales->estado = $_POST ['estado_fac'];
	$datosFiscales->codigoPostal = $_POST ['cp_fac'];
	$datosFiscales->correoFacturacion = "correo@correo.com";
	$datosFiscales->id_datosFiscales = $clientesDatosFiscales->id_datosFiscales;
	
	$dbHelper->update ( $datosFiscales, $datosFiscales->id_datosFiscales );
	
	$arrayNombreCont = $_POST['arrayNombreCont'];
	$arrayCorreo = $_POST['arrayCorreo'];
	$arrayTelefono = $_POST['arrayTelefono'];
	$arrayExtension = $_POST['arrayExtension'];
	$arrayCelular = $_POST['arrayCelular'];
	$arrayPuesto = $_POST['arrayPuesto'];
	$arrayFace = $_POST['arrayFace'];
	$arrayTwit = $_POST['arrayTwit'];
	$arrayFechCump = $_POST['arrayFechCump'];
	$arrayComments = $_POST['arrayComments'];
	$arrayIdContacto = $_POST['arrayId_contacto'];
	
	$i = 0;
	
	if (count ( $arrayNombreCont ) > 0)
		
		foreach ( $arrayNombreCont as $nombre ) {
			
			$contacto = new Contactos ();
			
			$contacto->nombre = $nombre;
			$contacto->correo = $arrayCorreo [$i];
			$contacto->telefono = $arrayTelefono [$i];
			$contacto->extension = $arrayExtension [$i];
			$contacto->celular = $arrayCelular [$i];
			$contacto->puesto = $arrayPuesto [$i];
			$contacto->facebook = $arrayFace[$i];
			$contacto->twitter = $arrayTwit[$i];
			$contacto->fechaCumpleanos = $arrayFechCump[$i];
			$contacto->comentario = $arrayComments[$i];
			$contacto->id_cliente = $_POST ['id_cliente'];
			
			if ($arrayIdContacto [$i] > 0) {
				
				$dbHelper->update ( $contacto, $arrayIdContacto [$i] );
			
			} else {
				$dbHelper->persist ( $contacto );
			
			}
			
			$i ++;
		
		}
		
	$clienteGrupo = new ClienteGrupo();
	$clienteGrupo->id_cliente = $id_cliente;
	$clienteGrupo = $dbHelper->readFirst($clienteGrupo);
	$clienteGrupo->id_grupo = $_POST['id_grupo'];
	$dbHelper->update($clienteGrupo, $clienteGrupo->id_clienteGrupo);

	$id_Regiones = $_POST['id_region'];
	
	$query = "UPDATE ClienteRegion SET status = 0 WHERE id_cliente = " . $_POST ['id_cliente'];
	$dbHelper->executeQuery($query);

	foreach ($id_Regiones as $id_Region){
		$clienteRegion = new ClienteRegion();
		$clienteRegion->id_cliente = $id_cliente;
		$clienteRegion->id_region = $id_Region;
		$clienteRegion2 = $dbHelper->readFirst($clienteRegion);
		if($clienteRegion2->id_clienteRegion == ""){
			$clienteRegion->status = 1;
			$dbHelper->persist($clienteRegion);
		}
		else{
			$clienteRegion2->status = 1;
			$dbHelper->update($clienteRegion2, $clienteRegion2->id_clienteRegion);
		}
	}
	
	echo "Los datos se han guardado con éxito";
}

if ($_POST ['accion'] == "guardar_adjunto") {
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/ArchivosAdjuntos.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$archivoAdjunto = new ArchivosAdjuntos ();
	$archivoAdjunto->id_cliente = $_POST ['id_cliente'];
	$archivoAdjunto->nombre = utf8_decode($_POST ['fileName']);
	$archivoAdjunto->descripcion = utf8_decode($_POST ['descripcionArchivo']);
	$archivoAdjunto->tipo = $_POST['tipoArchivo'];
	$archivoAdjunto->fechaCreacion = date("Y-m-d H:i:s");
	$archivoAdjunto->status = 1;
	
	$dbHelper->persist ( $archivoAdjunto );
	
	echo "El documento se guardó con éxito";
}

if ($_POST ['accion'] == "guardar_grupo") {
	
	define ( 'TO_ROOT', '../' );
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/DatosSociales.php');
	include_once (TO_ROOT . 'domain/GruposDatosSociales.php');
	include_once (TO_ROOT . 'domain/Grupos.php');
	include_once (TO_ROOT . 'domain/DatosSociales.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$grupo = new Grupos();
	$grupo->alias = $_POST['alias'];
	$grupo->descripcion = $_POST['descripcion'];
	$grupo->fechaCreacion = date("Y-m-d H:i:s");
	$grupo->status = 1;
	$grupo = $dbHelper->persist($grupo);
	
	$datoSocial = new DatosSociales ();
	$datoSocial->fechaConstitucion = $_POST ['fechaConstitucion'];
	$datoSocial->noInstrumentoNotarial = $_POST ['noInstrumentoNotarial'];
	$datoSocial->nombreNotario = $_POST ['nombreNotario'];
	$datoSocial->noNotario = $_POST['noNotario'];
	$datoSocial->adscripcion = $_POST ['adscripcion'];
	$datoSocial->nombreRepresentanteLegal = $_POST ['nombreRepresentanteLegal'];
	$datoSocial->fechaProtocolizacion = $_POST ['fechaProtocolizacion'];
	$datoSocial = $dbHelper->persist($datoSocial);
	
	$grupoDatosSociales = new GruposDatosSociales();
	$grupoDatosSociales->id_datosSociales = $datoSocial->id_datosSociales;
	$grupoDatosSociales->id_grupo = $grupo->id_grupo;
	$grupoDatosSociales->status = 1;
	$dbHelper->persist($grupoDatosSociales);
	
	header("Location: ../clientes/editarGrupo.php?id_grupo=" . $grupo->id_grupo);
}

if ($_POST ['accion'] == "editar_grupo") {
	
	define ( 'TO_ROOT', '../' );
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/DatosSociales.php');
	include_once (TO_ROOT . 'domain/GruposDatosSociales.php');
	include_once (TO_ROOT . 'domain/Grupos.php');
	include_once (TO_ROOT . 'domain/DatosSociales.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$grupo = new Grupos();
	$grupo->alias = $_POST['alias'];
	$grupo->descripcion = $_POST['descripcion'];
	$grupo->fechaCreacion = date("Y-m-d H:i:s");
	$grupo->status = 1;
	$grupo->id_grupo = $_POST['id_grupo'];
	$grupo = $dbHelper->update($grupo, $_POST['id_grupo']);
	
	$datoSocial = new DatosSociales ();
	$datoSocial->fechaConstitucion = $_POST ['fechaConstitucion'];
	$datoSocial->noInstrumentoNotarial = $_POST ['noInstrumentoNotarial'];
	$datoSocial->nombreNotario = $_POST ['nombreNotario'];
	$datoSocial->noNotario = $_POST['noNotario'];
	$datoSocial->adscripcion = $_POST ['adscripcion'];
	$datoSocial->nombreRepresentanteLegal = $_POST ['nombreRepresentanteLegal'];
	$datoSocial->fechaProtocolizacion = $_POST ['fechaProtocolizacion'];
	$datoSocial->id_datosSociales = $_POST['id_datosSociales'];
	$datoSocial = $dbHelper->update($datoSocial, $_POST['id_datosSociales']);
	
	
	header("Location: ../clientes/editarGrupo.php?id_grupo=" . $_POST['id_grupo'] . "&mensaje=1");
}

if ($_POST ['accion'] == "guardar_region") {
	
	define ( 'TO_ROOT', '../' );
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/DatosSociales.php');
	include_once (TO_ROOT . 'domain/RegionesDatosSociales.php');
	include_once (TO_ROOT . 'domain/Regiones.php');
	include_once (TO_ROOT . 'domain/DatosSociales.php');
	include_once (TO_ROOT . 'domain/GruposRegiones.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_grupo = $_POST['id_grupo'];
	
	$region = new Regiones();
	$region->alias = $_POST['alias'];
	$region->descripcion = $_POST['descripcion'];
	$region->fechaCreacion = date("Y-m-d H:i:s");
	$region->status = 1;
	$region = $dbHelper->persist($region);
	
	$datoSocial = new DatosSociales ();
	$datoSocial->fechaConstitucion = $_POST ['fechaConstitucion'];
	$datoSocial->noInstrumentoNotarial = $_POST ['noInstrumentoNotarial'];
	$datoSocial->nombreNotario = $_POST ['nombreNotario'];
	$datoSocial->noNotario = $_POST['noNotario'];
	$datoSocial->adscripcion = $_POST ['adscripcion'];
	$datoSocial->nombreRepresentanteLegal = $_POST ['nombreRepresentanteLegal'];
	$datoSocial->fechaProtocolizacion = $_POST ['fechaProtocolizacion'];
	$datoSocial = $dbHelper->persist($datoSocial);
	
	$regionDatosSociales = new RegionesDatosSociales();
	$regionDatosSociales->id_datosSociales = $datoSocial->id_datosSociales;
	$regionDatosSociales->id_region = $region->id_region;
	$regionDatosSociales->status = 1;
	$dbHelper->persist($regionDatosSociales);
	
	$gruposRegiones = new GruposRegiones();
	$gruposRegiones->id_grupo = $id_grupo;
	$gruposRegiones->id_region = $region->id_region;
	$gruposRegiones->status = 1;
	$dbHelper->persist($gruposRegiones);
	
	header("Location: ../clientes/editarRegion.php?id_region=" . $region->id_region);
}

if ($_POST ['accion'] == "editar_region") {
	
	define ( 'TO_ROOT', '../' );
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	include_once ('../domain/DatosSociales.php');
	include_once (TO_ROOT . 'domain/GruposDatosSociales.php');
	include_once (TO_ROOT . 'domain/Grupos.php');
	include_once (TO_ROOT . 'domain/DatosSociales.php');
	include_once (TO_ROOT . 'domain/Regiones.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$region = new Regiones();
	$region->alias = $_POST['alias'];
	$region->descripcion = $_POST['descripcion'];
	$region->fechaCreacion = date("Y-m-d H:i:s");
	$region->status = 1;
	$region->id_region = $_POST['id_region'];
	$region = $dbHelper->update($region, $_POST['id_region']);
	
	$datoSocial = new DatosSociales ();
	$datoSocial->fechaConstitucion = $_POST ['fechaConstitucion'];
	$datoSocial->noInstrumentoNotarial = $_POST ['noInstrumentoNotarial'];
	$datoSocial->nombreNotario = $_POST ['nombreNotario'];
	$datoSocial->noNotario = $_POST['noNotario'];
	$datoSocial->adscripcion = $_POST ['adscripcion'];
	$datoSocial->nombreRepresentanteLegal = $_POST ['nombreRepresentanteLegal'];
	$datoSocial->fechaProtocolizacion = $_POST ['fechaProtocolizacion'];
	$datoSocial->id_datosSociales = $_POST['id_datosSociales'];
	$datoSocial = $dbHelper->update($datoSocial, $_POST['id_datosSociales']);
	
	header("Location: ../clientes/editarRegion.php?id_region=" . $_POST['id_region'] . "&mensaje=1");
}

if ($_POST ['accion'] == "eliminar_adjunto") {
	
	include_once ('../includes/conexion.php');
	include_once ('../domain/DBHelper.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$query = "UPDATE ArchivosAdjuntos SET status = 0 WHERE id_archivoAdjunto = " . $_POST['id_archivoAdjunto'];
	$dbHelper->executeQuery($query);
	
	echo "Se ha eliminado con éxito";
	
	
}

?>