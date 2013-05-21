<?php

session_start ();
define ( 'TO_ROOT', '../' );
define ( 'TITULO', 'Editar Cliente' );
include (TO_ROOT . "includes/header.php");
if (isset ( $_SESSION ['id_abogado'] )) {
	
	include_once (TO_ROOT . 'domain/Clientes.php');
	include_once (TO_ROOT . 'domain/Contactos.php');
	include_once (TO_ROOT . 'domain/DatosFiscales.php');
	include_once (TO_ROOT . 'includes/conexion.php');
	include_once (TO_ROOT . 'domain/DBHelper.php');
	include_once (TO_ROOT . 'domain/ClientesDatosFiscales.php');
	include_once (TO_ROOT . 'domain/ClientesDatosSociales.php');
	include_once (TO_ROOT . 'domain/DatosSociales.php');
	include_once (TO_ROOT . 'domain/ArchivosAdjuntos.php');
	include_once (TO_ROOT . 'domain/Grupos.php');
	include_once (TO_ROOT . 'domain/Regiones.php');
	include_once (TO_ROOT . 'domain/ClienteGrupo.php');
	include_once (TO_ROOT . 'domain/ClienteRegion.php');
	include_once (TO_ROOT . 'domain/GruposRegiones.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_cliente = $_GET ['id_cliente'];
	
	$cliente = new Clientes ();
	$cliente->id_cliente = $id_cliente;
	$cliente = $dbHelper->readFirst ( $cliente );
	
	$contacto = new Contactos ();
	$contacto->id_cliente = $cliente->id_cliente;
	$contactos = $dbHelper->read ( $contacto );
	
	$clientesDatosFiscales = new ClientesDatosFiscales ();
	$clientesDatosFiscales->id_cliente = $cliente->id_cliente;
	$clientesDatosFiscales = $dbHelper->readFirst ( $clientesDatosFiscales );
	
	//	$arrayDatosFiscales = "";
	//	foreach ( $clientesDatosFiscales as $clienteDatosFiscales ) {
	$datosFicales = new DatosFiscales ();
	$datosFicales->id_datosFiscales = $clientesDatosFiscales->id_datosFiscales;
	$datosFicales = $dbHelper->readFirst ( $datosFicales );
	//		$arrayDatosFiscales [] = $datosFicales;
	//	}
	

	$clientesDatosSociales = new ClientesDatosSociales();
	$clientesDatosSociales->id_cliente = $id_cliente;
	$clientesDatosSociales = $dbHelper->read($clientesDatosSociales);
	
	
	$datoSocialActivo = ""; 
	
	foreach($clientesDatosSociales as $clienteDatosSociales){
		$datoSocial = new DatosSociales();
		$datoSocial->id_datosSociales = $clienteDatosSociales->id_datosSociales;
		$datoSocial = $dbHelper->readFirst ( $datoSocial );
		
		if($clienteDatosSociales->status == 1){
			$datoSocialActivo = $datoSocial;
		}else{
			$arrayDatoSociales [] = $datoSocial;
		}
	}
	
	$archivosAdjuntos = new ArchivosAdjuntos();
	$archivosAdjuntos->id_cliente = $id_cliente;
	$archivosAdjuntos->status = 1;
	$archivosAdjuntos = $dbHelper->read($archivosAdjuntos, "tipo");
	
	$grupos = new Grupos();
	$grupos->status = 1;
	$grupos = $dbHelper->read($grupos);
	
	$clienteGrupo = new ClienteGrupo();
	$clienteGrupo->id_cliente = $id_cliente;
	$clienteGrupo = $dbHelper->readFirst($clienteGrupo);
	
	$clienteRegiones = new ClienteRegion();
	$clienteRegiones->id_cliente = $id_cliente;
	$clienteRegiones->status = 1;
	$clienteRegiones = $dbHelper->read($clienteRegiones);
	
	$clienteRegionesArray = "";
	if(count($clienteRegiones)>0)
	foreach ($clienteRegiones as $clienteRegion){
		$clienteRegionesArray [] = $clienteRegion->id_region;	
	}
	
	$clienteRegionesArray [] = 0;
	
	$gruposRegiones = new GruposRegiones();
	$gruposRegiones->id_grupo = $clienteGrupo->id_grupo;
	$gruposRegiones->status = 1;
	$gruposRegiones = $dbHelper->read($gruposRegiones);
	
	$regiones = null;
	foreach($gruposRegiones as $grupoRegion){
		$region = new Regiones();
		$region->status = 1;
		$region->id_region = $grupoRegion->id_region;
		$regiones [] = $dbHelper->readFirst($region);
	}
	
	$tipoDocumento[1] = "Documento Social";
	$tipoDocumento[2] = "Documento Contratación";
	$tipoDocumento[3] = "Aesoría";
	
	?>
<script type="text/javascript">
$(document).ready(function() {

	$("#id_grupo").change(function () {

		var id_grupo = $("#id_grupo option:selected").val();
		$.post("getRegiones.php", { id_grupo: id_grupo},
				function(data) {
					$('#id_region').empty().append(data);
			});
	});
	
	var options = {};

$('#addContact').click(function() {

	var numContacts = $('#numContacts').val();
	$.post("camposContacto.php", { numContacts: numContacts},
			function(data) {
				$('#contactsContent').append(data);
		});
	numContacts ++;
	$('#numContacts').val(numContacts);
	});


$("#guardarDatosGeneralesButton").click(function(){
	$.blockUI({ message: '<h1> Guardando datos...</h1>' });

	//Datos generales
	var nombreEmpresa = $("#nombreEmpresa").val();
	var paginaWeb = $("#paginaWeb").val();
	var tipo = $("#tipo").val();
	var sindicato = $("#sindicato").val();
	var facebook = $("#facebook").val();
	var twitter = $("#twitter").val();
	var quienRefiere = $("#quienRefiere").val();
	var comentarios = $("#comentarios").val();
	var id_grupo = $("#id_grupo").val();
	var id_region = $("#id_region").val();
	var datoEconomicoS = $("#datoEconomico").val();
	var igualaS = $("#iguala").val();

	//Datos Facturación
	var rfc = $("#rfc").val();
	var razon = $("#razon").val();
	var calle = $("#calle").val();
	var noe = $("#noe").val();
	var noi = $("#noi").val();
	var colonia_fac = $("#colonia_fac").val();
	var municipio_fac = $("#municipio_fac").val();
	var estado_fac = $("#estado_fac").val();
	var cp_fac = $("#cp_fac").val();

	var arrayNombreCont = $("input[name='nombreCont\\[\\]']")
    .map(function(){return $(this).val();}).get();
	var arrayCorreo = $("input[name='correoContacto\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayTelefono = $("input[name='telefonoCont\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayExtension = $("input[name='extension\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayCelular = $("input[name='celular\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayPuesto = $("input[name='puesto\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayFace = $("input[name='facebookCont\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayTwit = $("input[name='twitterCont\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayFechCump = $("input[name='fechaCumpleanos\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayComments = $("input[name='comentariosCont\\[\\]']")
    .map(function(){return $(this).val();}).get();

	var arrayId_contacto = $("input[name='id_contacto\\[\\]']")
    .map(function(){return $(this).val();}).get();

    var accion = "guardar_datos_generales";
    var id_cliente = $("#id_cliente").val();

	$.post("../actions/Clientes.php", { 
		 nombreEmpresa : nombreEmpresa
		,paginaWeb : paginaWeb
		,tipo : tipo
		,sindicato : sindicato
		,facebook : facebook
		,twitter : twitter
		,quienRefiere : quienRefiere
		,datoEconomico : datoEconomicoS
		,iguala : igualaS
		,comentarios : comentarios
		,id_region : id_region
		,id_grupo : id_grupo
		,rfc : rfc
		,razon : razon
		,calle : calle
		,noe : noe
		,noi : noi
		,colonia_fac : colonia_fac
		,municipio_fac : municipio_fac
		,estado_fac : estado_fac
		,cp_fac : cp_fac
		,accion : accion
		,id_cliente : id_cliente
		,arrayNombreCont : arrayNombreCont
		,arrayCorreo : arrayCorreo
		,arrayTelefono : arrayTelefono
		,arrayExtension : arrayExtension
		,arrayCelular : arrayCelular
		,arrayPuesto : arrayPuesto
		,arrayFace : arrayFace
		,arrayTwit : arrayTwit
		,arrayFechCump : arrayFechCump
		,arrayComments : arrayComments
		,arrayId_contacto : arrayId_contacto
		},
			function(data) {
				$.unblockUI();
				$('#resultadoGuardarDatosG').html(data);
		});
	
});

	$("#datosSocialesButton").click(function(){
		$.blockUI({ message: '<h1> Guardando datos...</h1>' });
		var fechaConstitucion = $("#fechaConstitucion").val();
		var noInstrumentoNotarial = $("#noInstrumentoNotarial").val();
		var nombreNotario = $("#nombreNotario").val();
		var adscripcion = $("#adscripcion").val();
		var nombreRepresentanteLegal = $("#nombreRepresentanteLegal").val();
		var fechaProtocolizacion = $("#fechaProtocolizacion").val();
		var id_cliente = $("#id_cliente").val();
		var accion = "guardar_datos_sociales";

		$.post("../actions/Clientes.php", { 
								 fechaConstitucion: 		fechaConstitucion
								,noInstrumentoNotarial : 	noInstrumentoNotarial
								,nombreNotario : 			nombreNotario
								,adscripcion : 				adscripcion
								,nombreRepresentanteLegal : nombreRepresentanteLegal
								,fechaProtocolizacion : 	fechaProtocolizacion
								,id_cliente				:	id_cliente
								,accion : accion
			},
				function(data) {
					$.unblockUI();
					$('#resultadoGuardarDatosS').html(data);
			});
		
	});

	$('#datoEconomico').change(function() {
		var valor = $('#datoEconomico').val();
		if(valor == 2){
			$("#iguala").css("visibility", "visible");
		}else{
			$("#iguala").css("visibility", "hidden");
		}
	});

	$( "#tabs" ).tabs();

	$( ".dateInput" ).datepicker();

	$("#id_region").multiselect();

	var datoEconomico = $('#datoEconomico').val();

	if(datoEconomico == 2){
		$("#iguala").css("visibility", "visible");
	}
	
	
});


function deleteRowContact(idContactTable){
	$('#contactNewTable' + idContactTable ).remove();		
}

function guardarAdjunto(){
	$.blockUI({ message: '<h1> Guardando documento...</h1>' });
	var descripcionArchivo = $("#descripcionArchivo").val();
	var fileName = $("#fileName").val();
	var id_cliente = $("#id_cliente").val();
	var tipoArchivo = $("#tipoArchivo").val();
	var accion = "guardar_adjunto";
	

	$.post("../actions/Clientes.php", { 
		descripcionArchivo: 		descripcionArchivo
		,fileName : 	fileName
		,id_cliente				:	id_cliente
		,tipoArchivo : tipoArchivo
		,accion : accion
},
function(data) {
	$('#resultadoGuardarDatosAd').html(data);
	$.post("getArchivosAdjuntos.php", { id_cliente: id_cliente},
		function(data) {
			$('#adjuntosContent').html(data);
	});

	$.unblockUI();
});
	
}

	function deleteContact(idContactoCliente){
		jConfirm('Desea eliminar a este contacto?', 'Confirmation Dialog', function(r) {
			if(r){
				window.location = "http://barbosahuerga.com.mx/scc/admin/actions/Clientes.php?accion=eliminar_contacto&id_contacto=" + idContactoCliente + "&id_cliente="+<?php
	echo $cliente->id_cliente;
	?>;
			}
		});
	}

	function eliminarArchivo(id_adjunto){
		new Messi(
				'En realidad desea eliminar este archivo?.', 
				{title: 'Archivos', 
					buttons: [{id: 0, label: 'Si', val: id_adjunto}, 
								{id: 1, label: 'No', val: 'N'}], 
								callback: function(val) { 
									if(val != 'N'){
										$.post("../actions/Clientes.php", { accion: 'eliminar_adjunto', id_archivoAdjunto : val},
												function(data) {
													$('#resultadoGuardarDatosAd').html(data);
											});
										
										var id_cliente = $("#id_cliente").val();
										$.post("getArchivosAdjuntos.php", { id_cliente: id_cliente},
												function(data) {
													$('#adjuntosContent').html(data);
											});
									}
									
									}});
	}

	function showAddSocialData(){
		new Messi('This is a message with Messi in modal view. Now you can\'t interact' + 
				'with other elements in the page until close this.', {title: 'Datos Sociales', modal: true});
	}

</script>
<div id="tabs">
<ul>
	<li><a href="#tabs-1">Datos Generales</a></li>
	<li><a href="#tabs-2">Datos Sociales</a></li>
	<li><a href="#tabs-3">Documentos</a></li>
</ul>
<div id="tabs-1">









<form id="item_form" action="../actions/Clientes.php" method="post" accept-charset="UTF-8">
<table width="1000" border="0" cellspacing="5" cellpadding="0" align="center">
	<tr>
		<td width="1000" align="center">
		<h2>Cliente</h2>
		<table width="995" border="0" cellspacing="5" cellpadding="0">

			<tr>

				<td colspan="5" align="left" valign="bottom"><strong>Cliente</strong></td>

				<td colspan="5" align="right"><a href="clientes.php"><img src="<?php
	
	echo TO_ROOT?>images/volver.jpg"
					height="30" alt="Volver" border="0" title="Volver" /></a></td>

			</tr>

			<tr>

				<td colspan="8" height="5">

				<hr />

				</td>

			</tr>

			<tr>

				<td>Nombre Empresa:</td>

				<td><input type="text" name="nombreEmpresa" style="width: 190px;" class="required"
					value="<?php
	echo $cliente->nombreEmpresa?>" id="nombreEmpresa" /></td>

				<td>Página Web:</td>

				<td><input type="text" name="paginaWeb" style="width: 190px;" value="<?php
	echo $cliente->paginaWeb?>"
					id="paginaWeb" /></td>

				<td>Tipo:</td>

				<td><select name="tipo" style="width: 145px;" id="tipo">
					<option>Física</option>
					<option>Moral</option>
				</select></td>

				<td>Sindicato:</td>

				<td><input type="text" name="sindicato" style="width: 120px;" value="<?php
	echo $cliente->sindicato?>"
					id="sindicato" /></td>

			</tr>

			<tr>

				<td>Facebook:</td>

				<td><input type="text" name="facebook" style="width: 190px;" value="<?php
	echo $cliente->facebook?>"
					id="facebook" /></td>

				<td>Twitter:</td>

				<td><input type="text" name="twitter" style="width: 190px;" value="<?php
	echo $cliente->twitter?>"
					id="twitter" /></td>

				<td>Referido por:</td>

				<td><input type="text" name="quienRefiere" style="width: 140px;"
					value="<?php
	echo $cliente->quienRefiere?>" id="quienRefiere" /></td>

			</tr>
			<tr>
				<td>Grupo:</td>
				<td>
				<select name="id_grupo" id="id_grupo" style="width: 200px;">
					<option>Seleccionar...</option>
					<?php foreach($grupos as $grupo){?>
					<option
					<?php if($grupo->id_grupo == $clienteGrupo->id_grupo) echo 'selected="selected"'?>
					 value="<?php echo $grupo->id_grupo ?>"><?php echo $grupo->alias?></option>
					<?php } ?>
				</select>
				</td>
				<td>Region:</td>
				<td>
					<select name="id_region" id="id_region" multiple="multiple" style="width: 200px;">
					<option disabled="disabled">Seleccionar...</option>
					
					<?php
					if(count($regiones) > 0) 
					foreach($regiones as $region){?>
					<option
					<?php if(in_array($region->id_region, $clienteRegionesArray)) echo 'selected="selected"'?>
					 value="<?php echo $region->id_region ?>"><?php echo $region->alias?></option>
					<?php } ?>
					</select>
				</td>
				<td>
					Dato económico:
				</td>
				<td colspan="3">
					<select name="datoEconomico" id="datoEconomico">
						<option value="1" <?php if($cliente->datoEconomico == 1) echo 'selected="selected"' ?> >Normal</option>
						<option value="2" <?php if($cliente->datoEconomico == 2) echo 'selected="selected"' ?>>Iguala</option>
					</select>
					<span id="spanIguala">$ <input type="text" name="iguala" value="<?php echo $cliente->iguala ?>" style="visibility: hidden;" id="iguala"></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">Comentarios</td>
			</tr>
			<tr>
				<td colspan="6"><textarea name="comentarios" style="width: 555px; height: 66px;" id="comentarios"><?php
	echo $cliente->comentarios?></textarea></td>
			</tr>
			
			<tr>

				<td colspan="5"><br />

				<b>Contactos</b></td>

				<td colspan="3" align="right"><img src="<?php
	
	echo TO_ROOT?>images/addContact.png" height="20"
					id="addContact" /> <input type="hidden" id="numContacts" value="1" /></td>

			</tr>
			<tr>
				<td colspan="8">
				<hr />
				</td>
			</tr>
			<tr>
				<td colspan="8" id="contactsContent">
				
				<?php
	
	if (isset ( $contactos ))
		foreach ( $contactos as $contacto ) {
			
			?>
				
				
				<input type="hidden" id="id_contacto" value="<?php
			echo $contacto->id_contacto?>" name="id_contacto[]" />
				<table id="contactTable<?php
			echo $contacto->id_contacto?>" class="tableContacts">
					<tr>

						<td>Nombre:</td>

						<td><input type="text" name="nombreCont[]" style="width: 190px;"
							value="<?php
			echo $contacto->nombre?>" /></td>

						<td>Correo:</td>

						<td><input type="text" name="correoContacto[]" style="width: 190px;"
							value="<?php
			echo $contacto->correo?>"></td>

						<td>Tel.</td>

						<td><input type="text" name="telefonoCont[]" style="width: 190px;"
							value="<?php
			echo $contacto->telefono?>"></td>

						<td>Extension.</td>

						<td colspan="4"><input type="text" name="extension[]" value="<?php
			echo $contacto->extension?>"></td>

						<td><img src="../images/delete.png" height="15"
							onclick="javascript:deleteContact('<?php
			echo $contactoCliente->id_contactos_cliente?>');"
							class="delete" /></td>

					</tr>

					<tr>

						<td>Cel.:</td>

						<td><input type="text" name="celular[]" style="width: 190px;"
							value="<?php
			echo $contacto->celular?>"></td>
						<td>Puesto:</td>

						<td><input type="text" name="puesto[]" style="width: 190px;" value="<?php
			echo $contacto->puesto?>"></td>

						<td>Facebook:</td>

						<td><input type="text" name="facebookCont[]" style="width: 190px;"
							value="<?php
			echo $contacto->facebook?>"></td>
						<td>Twitter:</td>

						<td><input type="text" name="twitterCont[]" value="<?php
			echo $contacto->twitter?>"></td>



					</tr>
					<tr>

						<td>Fecha Cumpleaños:</td>

						<td><input type="text" name="fechaCumpleanos[]" style="width: 190px;"
							value="<?php
			echo $contacto->fechaCumpleanos?>"></td>
						<td>Comentarios:</td>

						<td colspan="3"><input type="text" name="comentariosCont[]" style="width: 455px;"
							value="<?php
			echo $contacto->comentario?>"></td>
					</tr>
				</table>
				
				
				
				<?php
		}
	?>
				
				
				
				
				</td>
			</tr>
			<tr id="facturacion">

				<td colspan="5"><br />

				<b>Datos de Fiscales</b></td>

				<td colspan="3" align="right"><img src="<?php
	
	echo TO_ROOT?>images/facturacion.png" height="20" /></td>

			</tr>

			<tr>

				<td colspan="8">

				<hr />

				</td>
			
			
			<tr />

			<tr>

				<td colspan="8">

				<table id="datosFacturacion" class="tableContacts">

					<tr>

						<td width="52">RFC:</td>

						<td colspan="2"><input type="text" name="rfc" id="rfc" style="width: 225px;"
							value="<?php
	echo $datosFicales->RFC?>" /></td>

						<td colspan="2">Nombre/Razón Social:</td>

						<td colspan="3"><input type="text" name="razon" id="razon" style="width: 308px;"
							value="<?php
	echo $datosFicales->nombre?>" /></td>



					</tr>

					<tr>

						<td width="52">Calle:</td>

						<td width="177"><input type="text" name="calle" id="calle" style="width: 170px;"
							value="<?php
	echo $datosFicales->calle?>" /></td>

						<td width="58">No. Ext</td>

						<td width="95"><input type="text" name="noe" id="noe" style="width: 95px;"
							value="<?php
	echo $datosFicales->nroExterior?>" /></td>

						<td width="54">No. Int.</td>

						<td width="125"><input type="text" name="noi" id="noi" style="width: 120px;"
							value="<?php
	echo $datosFicales->nroInterior?>" /></td>

						<td width="63">Colonia:</td>

						<td width="114"><input type="text" name="colonia_fac" id="colonia_fac" style="width: 110px"
							value="<?php
	echo $datosFicales->colonia?>" /></td>

						<td width="63">Municipio:</td>

						<td width="100"><input type="text" name="municipio_fac" id="municipio_fac" style="width: 100px"
							value="<?php
	echo $datosFicales->municipio?>" /></td>

					</tr>

					<tr>

						<td>Estado:</td>

						<td><input type="text" name="estado_fac" id="estado_fac" style="width: 170px;"
							value="<?php
	echo $datosFicales->estado?>" /></td>

						<td>C.P.</td>

						<td><input type="text" name="cp_fac" id="cp_fac" style="width: 120px;"
							value="<?php
	echo $datosFicales->codigoPostal?>" /></td>

					</tr>

				</table>



				</td>

			</tr>

			<tr>

				<td colspan="10" align="center"><input type="button" value="Guardar" id="guardarDatosGeneralesButton" class="inputButton" /></td>

			</tr>
			<tr>

				<td colspan="10" align="center" style="color: red;" id="resultadoGuardarDatosG"></td>

			</tr>
		</table>
		</td>
	</tr>
</table>
<input type="hidden" name="accion" value="editar_cliente" /> <input type="hidden" name="id_cliente"
	value="<?php
	echo $cliente->id_cliente?>" id="id_cliente" /></form>


</div>
<div id="tabs-2">
<table cellspacing="5">
	<tr>
		<td>Fecha de Constitución:</td>
		<td><input type="text" name="fechaConstitucion" id="fechaConstitucion" class="dateInput"
			value="<?php
	echo $datoSocialActivo->fechaConstitucion?>" /></td>
		<td>No. Instrumento Notarial:</td>
		<td><input type="text" name="noInstrumentoNotarial" id="noInstrumentoNotarial" style="width: 250px;"
			value="<?php
	echo $datoSocialActivo->noInstrumentoNotarial?>" /></td>
		<td>Nombre Notario:</td>
		<td><input type="text" name="nombreNotario" id="nombreNotario"
			value="<?php
	echo $datoSocialActivo->nombreNotario?>" /></td>
	</tr>
	<tr>
		<td>Adscripción:</td>
		<td><input type="text" name="adscripcion" id="adscripcion"
			value="<?php
	echo $datoSocialActivo->adscripcion?>"></td>
		<td>Nombre representante legal:</td>
		<td><input type="text" name="nombreRepresentanteLegal" id="nombreRepresentanteLegal" style="width: 250px;"
			value="<?php
	echo $datoSocialActivo->nombreRepresentanteLegal?>" /></td>
		<td>Fecha Protocolización:</td>
		<td><input type="text" name="fechaProtocolizacion" id="fechaProtocolizacion" class="dateInput"
			value="<?php
	echo $datoSocialActivo->fechaProtocolizacion?>" /></td>
	</tr>
	<tr>
		<td colspan="6" align="center"><input type="button" " value="Guardar" id="datosSocialesButton" class="inputButton" /></td>
	</tr>
	<tr>
		<td colspan="6" id="resultadoGuardarDatosS" style="color: red"></td>
	</tr>
	<tr>
		<td colspan="6">Historial Datos Sociales<hr /></td>
	</tr>
	<tr>
		<td colspan="6">
			<table cellpadding="5">
				<tr>
					<td class="borderBottom"><b>Nombre Notario</b></td>
					<td class="borderBottom"><b>No. Instrumento</b></td>
					<td class="borderBottom"><b>Fecha Constitución</b></td>
					<td class="borderBottom"><b>Adscripción</b></td>
					<td class="borderBottom"><b>Nombre Representante</b></td>
					<td class="borderBottom"><b>Fecha Protocolización</b></td>
				</tr>
				
				<?php
					if(count($arrayDatoSociales) > 0)
					foreach ($arrayDatoSociales as $datoSocial){
				?>
				<tr>
					<td><?php echo $datoSocial->nombreNotario?></td>
					<td><?php echo $datoSocial->noInstrumentoNotarial?></td>
					<td><?php echo $datoSocial->fechaConstitucion?></td>
					<td><?php echo $datoSocial->adscripcion ?></td>
					<td><?php echo $datoSocial->nombreRepresentanteLegal ?></td>
					<td><?php echo $datoSocial->fechaProtocolizacion ?></td>
				</tr>		
				<?php 	
					} 
				?>
				
			</table>
		</td>
	</tr>
</table>
</div>

<div id="tabs-3">
<div style="width: 100%; text-align: left;">
	<div id="adjuntosContent">
	<table cellspacing="5">
		<tr>
			<td style="width: 200px;"><b>Descpción</b></td>
			<td><b>Fecha de creación</b></td>
			<td align="center"><b>Tipo</b></td>
			<td width="100px;"></td>
		</tr>
		<?php foreach($archivosAdjuntos as $archivoAdjuntos){?>
		<tr>
			<td><?php echo $archivoAdjuntos->descripcion?></td>
			<td align="center"><?php echo $archivoAdjuntos->fechaCreacion?></td>
			<td align="center"><?php echo $tipoDocumento[$archivoAdjuntos->tipo]?></td>
			<td align="center">
				<a href="../DragandDrop/upload/<?php echo $archivoAdjuntos->nombre ?>" target="_blank">
					<img src="../images/download.png" border="0"></a>
					<img src="../images/delete.jpg" border="0" onclick="eliminarArchivo(<?php echo $archivoAdjuntos->id_archivoAdjunto?>)" />
				</td>
				</td>
		</tr>
		<?php }?>
	</table>
	</div>

	<div id="resultadoGuardarDatosAd" style="color: red"></div>
	<hr />
</div>
<div class="container">
<div class="upload_form_cont">
<div id="dropArea">Drop Area</div>

<div class="info">
<div><input id="url" type="hidden" value="http://soliat.com/Meza/DragandDrop/upload.php" /></div>
<div id="result">
	Arrastre el archivo hacia la zona Drop Area para cargar su archivo.
</div>
<canvas width="500" height="20"></canvas></div>
</div>
</div>
</div>
</div>
<script src="../js/script.js"></script>
<?php
	include_once '../includes/footer.php';
} else {
	header ( "location: " . TO_ROOT . "index.php?error=3" );
	;
}
?>