<?php

session_start ();
define ( 'TO_ROOT', '../' );
define ( 'TITULO', 'Ver Grupo' );
include (TO_ROOT . "includes/header.php");
if (isset ( $_SESSION ['id_abogado'] )) {
	
	include_once (TO_ROOT . 'includes/conexion.php');
	include_once (TO_ROOT . 'domain/DBHelper.php');
	include_once (TO_ROOT . 'domain/Grupos.php');
	include_once (TO_ROOT . 'domain/GruposDatosSociales.php');
	include_once (TO_ROOT . 'domain/DatosSociales.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_grupo = $_GET['id_grupo'];
	
	$grupo = new Grupos();
	$grupo->id_grupo = $id_grupo;
	$grupo = $dbHelper->readFirst($grupo);
	
	$gruposDatosSociales = new GruposDatosSociales();
	$gruposDatosSociales->id_grupo = $id_grupo;
	$gruposDatosSociales->status = 1;
	$gruposDatosSociales = $dbHelper->readFirst($gruposDatosSociales);
	
	$datoSocial = new DatosSociales();
	$datoSocial->id_datosSociales = $gruposDatosSociales->id_datosSociales;
	$datoSocial = $dbHelper->readFirst($datoSocial);
	
	
	?>
<script type="text/javascript">
$(document).ready(function() {
	$("#grupoButton").click(function(){
		$.blockUI({ message: '<h1> Guardando datos...</h1>' });
		$('#agregarGrupoForm').submit();
		});
});
</script>
<form action="../actions/Clientes.php" method="post" id="agregarGrupoForm">
<table cellspacing="5">
	<tr>
		<td colspan="6" align="center"><h2>Ver Grupo</h2>
			<span style="float: right;"><a href="grupos.php"><img src="../images/volver.jpg" border="0" /></a></span>
		</td>
	</tr>
	<tr>
		<td colspan="6"><b>Datos Generales</b>
		<hr />
		</td>
	</tr>
	<tr>
		<td>Alias:</td>
		<td><input type="text" name="alias" value="<?php echo $grupo->alias ?>"></td>
		<td>Descripción:</td>
		<td colspan="3"><input type="text" name="descripcion" value="<?php echo $grupo->descripcion ?>" style="width: 250px"></td>
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
		<input type="button" " value="Guardar" id="grupoButton" class="inputButton" />
		<input type="hidden" name="accion" value="editar_grupo" />
		<input type="hidden" name="id_grupo" value="<?php echo $id_grupo ?>" />
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