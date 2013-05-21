<?php
define ( 'TO_ROOT', '../' );

	include_once (TO_ROOT . 'includes/conexion.php');
	include_once (TO_ROOT . 'domain/DBHelper.php');
	include_once (TO_ROOT . 'domain/ArchivosAdjuntos.php');
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$archivosAdjuntos = new ArchivosAdjuntos();
	$archivosAdjuntos->id_cliente = $_POST['id_cliente'];
	$archivosAdjuntos->status = 1;
	$archivosAdjuntos = $dbHelper->read($archivosAdjuntos, "tipo");
	
	$tipoDocumento[1] = "Documento Social";
	$tipoDocumento[2] = "Documento Contratación";
	$tipoDocumento[3] = "Aesoría";
	
?>

<table cellspacing="5">
		<tr>
			<td style="width: 200px;"><b>Descpción</b></td>
			<td><b>Fecha de creación</b></td>
			<td align="center"><b>Tipo</b></td>
			<td width="100px;"></td>
		</tr>
		<?php foreach($archivosAdjuntos as $archivoAdjuntos){?>
		<tr id="adjuntosContent">
			<td><?php echo $archivoAdjuntos->descripcion?></td>
			<td align="center"><?php echo $archivoAdjuntos->fechaCreacion?></td>
			<td align="center"><?php echo $tipoDocumento[$archivoAdjuntos->tipo]?></td>
			<td align="center"><a href="../DragandDrop/upload/<?php echo $archivoAdjuntos->nombre ?>" target="_blank"><img src="../images/download.png" border="0"></a>
			<img src="../images/delete.jpg" border="0" onclick="eliminarArchivo(<?php echo $archivoAdjuntos->id_archivoAdjunto?>)" /></td>
		</tr>
		<?php }?>
	</table>