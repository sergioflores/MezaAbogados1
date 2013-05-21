<?php

session_start ();

define ( 'TO_ROOT', '../' );

define ( 'TITULO', 'Abogados' );

include (TO_ROOT . "includes/header.php");

if (isset ( $_SESSION ['id_abogado'] )) {
	
	include (TO_ROOT . "includes/conexion.php");
	
	include (TO_ROOT . "domain/DBHelper.php");
	
	include (TO_ROOT . "domain/Abogados.php");
	
	$dbHelper = new DBHelper ();
	
	$dbHelper->setConection ( $conexion );
	
	$abogados = $dbHelper->read ( new Abogados () );
	
	$mensaje [1] = "El Abogado se ha eliminado con éxito";
	
	$mensaje [2] = "Ha ocurrido un error, vuelva a intentarlo";
	
	?><script type="text/javascript">

function eliminarAbogado(id_abogado){

	$("#id_abogado").val(id_abogado);
	$(".lightbox-background").fadeIn("slow");
	$(".lightbox").fadeIn("slow");
}


$(document).ready(function() {

	$("#cerrar").click(function(){
		$(".lightbox-background").fadeOut("slow");
		$(".lightbox").fadeOut("slow");
	});
	
});


</script><div style="padding-top: 30px; padding-bottom: 30px;" align="center"><h2 style="margin: 0">ABOGADOS</h2><table width="900" border="0" cellspacing="1" cellpadding="0" align="center">	<tr>		<td colspan="5" align="right">
		<?php
	if (isset ( $_GET ['mensaje'] )) {
		
		if ($_GET ['mensaje'] == 1) {
			
			echo '<div style="float: left;">' . $mensaje [$_GET ['mensaje']] . '</div>';
		
		}
	
	}
	?>
		<a href="agregarAbogado.php" class="link_titulo"><img alt="Abogado Cliente"			src="<?php
	echo TO_ROOT?>images/clientes.jpg" border="0"></a></td>	</tr>	<tr style="background: #f1f1f1;">		<td width="260" align="center" height="30"><b>Nombre </b></td>		<td width="210" align="center"><b>Correo</b></td>		<td width="100" align="center"><b>Costo Hora</b></td>		<td width="365" align="center"><b>Acciones</b></td>	</tr>
	<?php
	$class = "";
	if (isset ( $abogados ))
		
		foreach ( $abogados as $abogado ) {
			
			?>
	<tr class="abogado <?php
			echo $class?>">		<td height="30"><?php
			echo $abogado->nombre?></td>		<td><?php
			echo $abogado->correo?></td>		<td>$<?php
			echo number_format($abogado->costoHora,2);?></td>		<td align="center"><a href="editarAbogado.php?id_abogado=<?php
			
			echo $abogado->id_abogado?>"			title="Editar Caso"><img src="../images/edit.jpg" border="0" /></a> <img src="../images/delete.jpg"			border="0" class="delete" onclick="eliminarAbogado(<?php
			echo $abogado->id_abogado?>)" /></td>	</tr>
		
	
	<?php
			
			if ($class == "")
				
				$class = "gris";
			
			else
				
				$class = "";
		
		}
	?>
</table><div class="lightbox-background"></div></div><?php

}

include (TO_ROOT . "includes/footer.php");

?>




