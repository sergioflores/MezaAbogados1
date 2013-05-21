<?php

session_start ();

define ( 'TO_ROOT', '../' );

define ( 'TITULO', 'Agregar Cliente' );

define ( 'CURRENT', '2' );

include (TO_ROOT . "includes/header.php");

if (isset ( $_SESSION ['id_abogado'] )) {
	
	include_once (TO_ROOT . 'includes/conexion.php');
	include_once (TO_ROOT . 'domain/DBHelper.php');
	include_once (TO_ROOT . 'domain/Grupos.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$grupos = new Grupos();
	$grupos->status = 1;
	$grupos = $dbHelper->read($grupos);
	
	?><script>
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

	$('#facturacion').click(function() {
		$( "#datosFacturacion" ).toggle( 'blind', options, 500 );
	});

	$("#item_form").validate({	});
	
});

	function deleteRowContact(idContactTable){
		$('#contactNewTable' + idContactTable ).remove();	}


</script>
<form id="item_form" action="../actions/Clientes.php" method="post">
<table width="1000" border="0" cellspacing="5" cellpadding="0" align="center">
	<tr>
		<td width="1000" align="center">
		<h2>Agregar Cliente</h2>
		<table width="995" border="0" cellspacing="5" cellpadding="0">
			<tr>
				<td colspan="5" align="left" valign="bottom"><strong>Agregar Cliente</strong></td>
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
				<td><input type="text" name="nombreEmpresa" style="width: 190px;" class="required" /></td>
				<td>Página Web:</td>
				<td><input type="text" name="paginaWeb" style="width: 190px;" /></td>
				<td>Tipo:</td>
				<td><select name="tipo" style="width: 145px;">
					<option>Física</option>
					<option>Moral</option>
				</select></td>
				<td>Sindicato:</td>
				<td><input type="text" name="sindicato" style="width: 120px;" /></td>
			</tr>
			<tr>
				<td>Facebook:</td>
				<td><input type="text" name="facebook" style="width: 190px;" /></td>
				<td>Twitter:</td>
				<td><input type="text" name="twitter" style="width: 190px;" /></td>
				<td>Referido por:</td>
				<td><input type="text" name="quienRefiere" style="width: 140px;" /></td>
			</tr>
			<tr>
				<td>Grupo:</td>
				<td>
				<select name="id_grupo" id="id_grupo">
					<option>Seleccionar...</option>
					<?php foreach($grupos as $grupo){
						echo '<option value="'.$grupo->id_grupo.'">'.$grupo->alias.'</option>';
					}
						?>
				</select>
				</td>
				<td>Region:</td>
				<td>
					<select name="id_region" id="id_region">
						<option>Seleccionar...</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">Comentarios</td>
			</tr>
			<tr>
				<td colspan="6"><textarea name="comentarios" style="width: 555px; height: 66px;"></textarea></td>
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
			
			
			<tr />
			<tr>
				<td colspan="8" id="contactsContent"></td>
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
						<td colspan="2"><input type="text" name="rfc" id="rfc" style="width: 225px;" /></td>
						<td colspan="2">Nombre/Razón Social:</td>
						<td colspan="3"><input type="text" name="razon" id="razon" style="width: 308px;" /></td>
					</tr>
					<tr>
						<td width="52">Calle:</td>
						<td width="177"><input type="text" name="calle" id="calle" style="width: 170px;" /></td>
						<td width="58">No. Ext</td>
						<td width="95"><input type="text" name="noe" id="noe" style="width: 95px;" /></td>
						<td width="54">No. Int.</td>
						<td width="125"><input type="text" name="noi" id="noi" style="width: 120px;" value="" /></td>
						<td width="63">Colonia:</td>
						<td width="114"><input type="text" name="colonia_fac" id="colonia_fac" style="width: 110px" /></td>
						<td width="63">Municipio:</td>
						<td width="100"><input type="text" name="municipio_fac" id="municipio_fac" style="width: 100px" /></td>
					</tr>
					<tr>
						<td>Estado:</td>
						<td><input type="text" name="estado_fac" id="estado_fac" style="width: 170px;" /></td>
						<td>País:</td>
						<td><input type="text" name="pais_fac" id="pais_fac" style="width: 95px;" /></td>
						<td>C.P.</td>
						<td><input type="text" name="cp_fac" id="cp_fac" style="width: 120px;" /></td>
					</tr>
				</table>
				</td>
			</tr>
			<tr>
				<td colspan="10" align="center">
				<p><input type="submit" value="Guardar" /></p>
				</td>
			</tr>
			<tr>
				<td colspan="10" align="left">
				<p>Los campos marcados con <span style="color: red">*</span> son requeridos.</p>
				</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
<input type="hidden" name="accion" value="agregar_cliente"></form><?php

} else {
	
	header ( "location: " . TO_ROOT . "index.php?error=3" );
	
	;

}

?>