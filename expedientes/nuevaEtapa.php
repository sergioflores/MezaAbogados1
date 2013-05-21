<?php
define ( 'TO_ROOT', '../' );

include (TO_ROOT . "includes/conexion.php");
include (TO_ROOT . "domain/DBHelper.php");
include (TO_ROOT . "domain/Expedientes.php");
include (TO_ROOT . "domain/Clientes.php");
include (TO_ROOT . "domain/Abogados.php");
include (TO_ROOT . "domain/AbogadoExpediente.php");
include (TO_ROOT . "domain/Actor.php");
include (TO_ROOT . "domain/Demandado.php");
include (TO_ROOT . "domain/ActorExpediente.php");
include (TO_ROOT . "domain/DemandadoExpediente.php");
include (TO_ROOT . "domain/Juzgados.php");
include (TO_ROOT . "domain/ExpedienteJuzgado.php");

$dbHelper = new DBHelper ();
$dbHelper->setConection ( $conexion );

$abogados = new Abogados ();
$abogados->status = 1;
$abogados = $dbHelper->read ( $abogados );

$juzgados = new Juzgados ();
$juzgados->status = 1;
$juzgados = $dbHelper->read ( $juzgados );

?>

<script type="text/javascript">

$(document).ready(function() {

	$('.timePickers').timepicker({ 'timeFormat': 'H:i' });
	$( ".dateInput" ).datepicker({ dateFormat: "yy-mm-dd" });
	
});
</script>

<div style="width: 100%;" align="center">
<form action="../actions/Expedientes.php" method="post">
<table class="tableTarea" cellspacing="5">
	<tr>
		<td colspan="2" align="center">
		<h2>Agregar Tarea</h2>
		</td>
	</tr>
	<tr>
		<td>Tipo:</td>
		<td>
			<select name="tipo">
				<option>Seleccionar...</option>
				<option value="1">Actividad</option>
				<option value="2">Audiencia</option>
				<option value="3">Etapa</option>
			</select>
		</td>
	</tr>
	<tr>
		<td>Titulo:</td>
		<td><input name="titulo" /></td>
	</tr>
	<tr>
		<td>Juzgado:</td>
		<td><select name="id_juzgado">
			<option>Seleccione...</option>
						<?php
						foreach ( $juzgados as $juzgado ) {
							echo '<option value="' . $juzgado->id_juzgado . '">' . $juzgado->nombre . '</option>';
						}
						?>
					</select></td>
	</tr>
	<tr>
		<td>Dirección:</td>
		<td><input name="direccion" /></td>
	</tr>
	<tr>
		<td>Fecha:</td>
		<td><input name="fecha" class="dateInput" /></td>
	</tr>
	<tr>
		<td>Hora:</td>
		<td><input name="horaInicio" class="timePickers" style="width: 70px;"/> - <input name="horaFin" class="timePickers" style="width: 70px;"/></td>
	</tr>
	<tr>
		<td>Horas a invertir:</td>
		<td><input name="horasInvertir" /></td>
	</tr>
	<tr>
		<td>Personal Resposable:</td>
		<td><select name="id_abogado" id="id_abogado">
			<option>Seleccione...</option>
				<?php
				if (count ( $abogados ) > 0)
					foreach ( $abogados as $abogado ) {
						?>
					<option value="<?php
						echo $abogado->id_abogado?>"><?php
						echo $abogado->nombre?></option>
		<?php
					}
				?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top">Descripcion:</td>
		<td><textarea name="descripcion"></textarea></td>
	</tr>
	<tr>
		<td>Visible?</td>
		<td align="left"><input type="checkbox" name="visible" style="width: 13px;"/></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="Guardar"></td>
	</tr>
</table>
<input type="hidden" name="accion" value="guardar_tarea" />
<input type="hidden" name="id_expediente" value="<?php echo $_POST['id_expediente']?>" />
</form>
</div>