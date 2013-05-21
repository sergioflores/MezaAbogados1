<?php
$numContacts = $_POST ['numContacts']?><table id="contactNewTable<?php
echo $numContacts?>" class="tableContacts">	<tr>		<td>Nombre:</td>		<td><input type="text" name="nombreCont[]" style="width: 190px;"></td>		<td>Correo:</td>		<td><input type="text" name="correoContacto[]" style="width: 190px;"></td>		<td>Tel.</td>		<td><input type="text" name="telefonoCont[]" style="width: 190px;"></td>		<td>Extension.</td>		<td colspan="4"><input type="text" name="extension[]"></td>		<td><img src="../images/delete.png" height="15"			onclick="javascript:deleteRowContact('<?php
			echo $numContacts?>');" class="delete" /></td>	</tr>	<tr>		<td>Cel.:</td>		<td><input type="text" name="celular[]" style="width: 190px;"></td>		<td>Puesto:</td>		<td><input type="text" name="puesto[]" style="width: 190px;"></td>		<td>Facebook:</td>		<td><input type="text" name="facebookCont[]" style="width: 190px;"></td>		<td>Twitter:</td>		<td><input type="text" name="twitterCont[]"></td>	</tr>
	<tr>

		<td>Fecha Cumpleaños:</td>

		<td><input type="text" name="fechaCumpleanos[]" style="width: 190px;"></td>
		<td>Comentarios:</td>

		<td colspan="3"><input type="text" name="comentariosCont[]" style="width: 455px;"></td>
		

	</tr></table>