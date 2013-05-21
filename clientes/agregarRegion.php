<?php

session_start ();
define ( 'TO_ROOT', '../' );
define ( 'TITULO', 'Agregar Region' );
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
	
	
	?>
<script type="text/javascript">
$(document).ready(function() {
	$("#regionButton").click(function(){
		$.blockUI({ message: '<h1> Guardando datos...</h1>' });
		$('#agregarRegionForm').submit();
		});
});
</script>
<form action="../actions/Clientes.php" method="post" id="agregarRegionForm">
<table cellspacing="5">
	<tr>
		<td colspan="6" align="center">
			<h2>Agregar Region</h2>
			<span style="float: right;"><a href="regiones.php"><img src="../images/volver.jpg" border="0" /></a></span>
		</td>
	</tr>
	<tr>
		<td colspan="6"><b>Datos Generales</b>
		<hr />
		</td>
	</tr>
	<tr>
		<td>Alias:</td>
		<td><input type="text" name="alias"></td>
		<td>Descripción:</td>
		<td colspan="3"><input type="text" name="descripcion" style="width: 250px"></td>
	</tr>
	<tr>
		<td>Grupo:</td>
		<td>
			<select name="id_grupo">
				<?php foreach($grupos as $grupo){?>
				<option value="<?php echo $grupo->id_grupo ?>"><?php echo $grupo->alias?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="6"><b>Datos Sociales</b>
		<hr />
		</td>
	</tr>
	<tr>
		<td>Fecha de Constitución:</td>
		<td><input type="text" name="fechaConstitucion" id="fechaConstitucion" class="dateInput"
			 /></td>
		<td>No. Instrumento Notarial:</td>
		<td><input type="text" name="noInstrumentoNotarial" id="noInstrumentoNotarial" style="width: 250px;"
			 /></td>
		<td>Nombre Notario:</td>
		<td><input type="text" name="nombreNotario" id="nombreNotario"
			 /></td>
	</tr>
	<tr>
		<td>Adscripción:</td>
		<td><input type="text" name="adscripcion" id="adscripcion"
			value="<?php
	echo $datoSocialActivo->adscripcion?>"></td>
		<td>Nombre representante legal:</td>
		<td><input type="text" name="nombreRepresentanteLegal" id="nombreRepresentanteLegal" style="width: 250px;"
			 /></td>
		<td>Fecha Protocolización:</td>
		<td><input type="text" name="fechaProtocolizacion" id="fechaProtocolizacion" class="dateInput"
			/></td>
	</tr>
	<tr>
		<td colspan="6" align="center">
		<input type="button" " value="Guardar" id="regionButton" class="inputButton" />
		<input type="hidden" name="accion" value="guardar_region" />
		</td>
	</tr>
</table>
</form>
<?php } ?>