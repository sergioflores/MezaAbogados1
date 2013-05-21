<?php

session_start ();
define ( 'TO_ROOT', '../' );
define ( 'TITULO', 'Ver Region' );
include (TO_ROOT . "includes/header.php");
if (isset ( $_SESSION ['id_abogado'] )) {
	
	include_once (TO_ROOT . 'includes/conexion.php');
	include_once (TO_ROOT . 'domain/DBHelper.php');
	include_once (TO_ROOT . 'domain/Regiones.php');
	include_once (TO_ROOT . 'domain/RegionesDatosSociales.php');
	include_once (TO_ROOT . 'domain/DatosSociales.php');
	include_once (TO_ROOT . 'domain/GruposRegiones.php');
	include_once (TO_ROOT . 'domain/Grupos.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_region = $_GET['id_region'];
	
	$region = new Regiones();
	$region->id_region = $id_region;
	$region = $dbHelper->readFirst($region);
	
	$regionesDatosSociales = new RegionesDatosSociales();
	$regionesDatosSociales->id_region = $id_region;
	$regionesDatosSociales->status = 1;
	$regionesDatosSociales = $dbHelper->readFirst($regionesDatosSociales);
	
	$datoSocial = new DatosSociales();
	$datoSocial->id_datosSociales = $regionesDatosSociales->id_datosSociales;
	$datoSocial = $dbHelper->readFirst($datoSocial);
	
	$gruposRegiones = new GruposRegiones();
	$gruposRegiones->id_region = $id_region;
	$gruposRegiones->status = 1;
	$gruposRegiones = $dbHelper->readFirst($gruposRegiones);
	
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
		<td colspan="6" align="center"><h2>Ver Region</h2>
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
		<td><input type="text" name="alias" value="<?php echo $region->alias ?>"></td>
		<td>Descripción:</td>
		<td colspan="3"><input type="text" name="descripcion" value="<?php echo $region->descripcion ?>" style="width: 250px"></td>
	</tr>
	<tr>
		<td>Grupo:</td>
		<td>
			<select name="id_grupo" id="id_grupo">
				<?php foreach($grupos as $grupo){?>
				<option
				<?php if($grupo->id_grupo == $gruposRegiones->id_grupo) echo 'selected="selected"'?>
				 value="<?php echo $grupo->id_grupo ?>"><?php echo $grupo->alias?></option>
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
			value="<?php
	echo $datoSocial->fechaConstitucion?>" /></td>
		<td>No. Instrumento Notarial:</td>
		<td><input type="text" name="noInstrumentoNotarial" id="noInstrumentoNotarial" style="width: 250px;"
			value="<?php
	echo $datoSocial->noInstrumentoNotarial?>" /></td>
		<td>Nombre Notario:</td>
		<td><input type="text" name="nombreNotario" id="nombreNotario"
			value="<?php
	echo $datoSocial->nombreNotario?>" /></td>
	</tr>
	<tr>
		<td>Adscripción:</td>
		<td><input type="text" name="adscripcion" id="adscripcion"
			value="<?php
	echo $datoSocial->adscripcion?>"></td>
		<td>Nombre representante legal:</td>
		<td><input type="text" name="nombreRepresentanteLegal" id="nombreRepresentanteLegal" style="width: 250px;"
			value="<?php
	echo $datoSocial->nombreRepresentanteLegal?>" /></td>
		<td>Fecha Protocolización:</td>
		<td><input type="text" name="fechaProtocolizacion" id="fechaProtocolizacion" class="dateInput"
			value="<?php
	echo $datoSocial->fechaProtocolizacion?>" /></td>
	</tr>
	<tr>
		<td colspan="6" align="center">
		<input type="button" " value="Guardar" id="regionButton" class="inputButton" />
		<input type="hidden" name="accion" value="editar_region" />
		<input type="hidden" name="id_region" value="<?php echo $id_region ?>" />
		<input type="hidden" name="id_datosSociales" value="<?php echo $datoSocial->id_datosSociales ?>" />
		</td>
	</tr>
	<tr>
		<td colspan="6" style="color: red">
			<?php if($_GET['mensaje'] == 1) echo "Datos actualizados con éxito"?>
		</td>
	</tr>
</table>
</form>
<?php } ?>