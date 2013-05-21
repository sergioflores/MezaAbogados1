<?php

session_start ();
define ( 'TO_ROOT', '../' );
define ( 'TITULO', 'Agregar Abogado' );
define ( 'CURRENT', '5' );
include (TO_ROOT . "includes/header.php");
if (isset ( $_SESSION ['id_abogado'] )) {
	
	?>

<form id="item_form" action="../actions/Abogados.php" method="post">
<table width="800" border="0" cellspacing="5" cellpadding="0" align="center">
	<tr>
		<td width="1000" align="center">
		<h2>Agregar Abogado</h2>
		<table width="995" border="0" cellspacing="5" cellpadding="0">
			<tr>
				<td colspan="5" align="left" valign="bottom"><strong>Agregar Abogado</strong></td>
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
				<td><input type="text" name="nombre" style="width: 190px;" class="required" /></td>
				<td>Correo:</td>
				<td><input type="text" name="correo" style="width: 190px;" class="required" /></td>
				<td>Teléfono:</td>
				<td><input type="text" name="telefono" class="required" style="width: 140px;" /></td>
				<td>Ext.</td>
				<td><input type="text" name="ext" style="width: 80px;" class="required" /></td>
			</tr>
			<tr>
				<td>Cel:</td>
				<td><input type="text" name="celular" style="width: 190px;" class="required" /></td>
				<td>Costo Hora:</td>
				<td><input type="text" name="costoHora" style="width: 190px;" class="required" /></td>
				<td>Password:</td>
				<td><input type="text" name="password" style="width: 140px;" class="required" value="" /></td>
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
<input type="hidden" name="accion" value="agregar_abogado"></form>

<!-- 
<table>
<tr>
				<td>Nombre:</td>
				<td><input type="text" name="nombreCont[]" style="width: 190px;"></td>
				<td>Direccion:</td>
				<td><input type="text" name="direccionCont[]" style="width: 190px;"></td>
				<td>Municipio:</td>
				<td><input type="text" name="municipioCont[]"></td>
				<td>Estado:</td>
				<td colspan="3"><input type="text" name="estadoCont[]" style="width: 170px;"></td>
			</tr>
<tr>
				<td>Email:</td>
				<td><input type="text" name="emailCont[]" style="width: 190px;"></td>
				<td>Tel.</td>
				<td><input type="text" name="telefonoCont[]" style="width: 190px;"></td>
				<td>Cel.</td>
				<td><input type="text" name="celularCont[]"></td>
			</tr>
</table>
 -->

<?php
} else {
	header ( "location: " . TO_ROOT . "index.php?error=3" );
	;
}
?>