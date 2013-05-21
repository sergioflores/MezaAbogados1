<?php

session_start ();
define ( 'TO_ROOT', '../' );
define ( 'TITULO', 'Editar Abogado' );
define ( 'CURRENT', '5' );
include (TO_ROOT . "includes/header.php");
if (isset ( $_SESSION ['id_abogado'] )) {
	
	include (TO_ROOT . "includes/conexion.php");
	include (TO_ROOT . "domain/DBHelper.php");
	include (TO_ROOT . "domain/Abogados.php");
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$abogado = new Abogados ();
	$abogado->id_abogado = $_GET ['id_abogado'];
	$abogado = $dbHelper->readFirst ( $abogado );
	
	?>

<form id="item_form" action="../actions/Abogados.php" method="post">
<table width="800" border="0" cellspacing="5" cellpadding="0" align="center">
	<tr>
		<td width="1000" align="center">
		<h2>Editar Abogado</h2>
		<table width="995" border="0" cellspacing="5" cellpadding="0">
			<tr>
				<td colspan="5" align="left" valign="bottom"><strong>Editar Abogado</strong></td>
				<td colspan="5" align="right"><a href="abogados.php"><img src="<?php
	echo TO_ROOT?>images/volver.jpg"
					height="30" alt="Volver" border="0" title="Volver" /></a></td>
			</tr>
			<tr>
				<td colspan="10" height="5">
				<hr />
				</td>
			</tr>
			<tr>
				<td>Nombre:</td>
				<td><input type="text" name="nombre" style="width: 190px;" class="required"
					value="<?php
	echo $abogado->nombre?>" /></td>
				<td>Email:</td>
				<td><input type="text" name="correo" style="width: 190px;" class="required"
					value="<?php
	echo $abogado->correo?>" /></td>
				<td>Teléfono:</td>
				<td><input type="text" name="telefono" class="required" style="width: 140px;"
					value="<?php
	echo $abogado->telefono?>" /></td>
				<td>Ext.</td>
				<td><input type="text" name="ext" style="width: 80px;" class="required"
					value="<?php
	echo $abogado->extension?>" /></td>
			</tr>
			<tr>
				<td>Cel:</td>
				<td><input type="text" name="celular" style="width: 190px;" class="required"
					value="<?php
	echo $abogado->celular?>" /></td>
				<td>Costo Hora:</td>
				<td><input type="text" name="costoHora" style="width: 190px;" value="<?php
	echo $abogado->costoHora?>"
					class="required" /></td>
				<td>Password:</td>
				<td><input type="password" name="password" style="width: 140px;" class="required"
					value="<?php
	echo $abogado->password?>" /></td>
			</tr>
			<tr>
				<td colspan="10" align="center">
				<p><input type="submit" value="Guardar" /></p>
				</td>
			</tr>
			<tr>
				<td colspan="10"><span style="color: red"><?php
	if ($_GET ['mensaje'] == 1)
		echo "* El Abogado se ha editado con exito";
	?></td>
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
<input type="hidden" name="id_abogado" value="<?php
	echo $_GET ['id_abogado']?>"> <input type="hidden"
	name="accion" value="editar_abogado"></form>

<?php
} else {
	header ( "location: " . TO_ROOT . "index.php?error=3" );
	;
}
?>