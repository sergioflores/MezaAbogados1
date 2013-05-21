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
	
	?>

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


</script>
		<?php
	if (isset ( $_GET ['mensaje'] )) {
		
		if ($_GET ['mensaje'] == 1) {
			
			echo '<div style="float: left;">' . $mensaje [$_GET ['mensaje']] . '</div>';
		
		}
	
	}
	?>
		<a href="agregarAbogado.php" class="link_titulo"><img alt="Abogado Cliente"
	echo TO_ROOT?>images/clientes.jpg" border="0"></a></td>
	<?php
	$class = "";
	if (isset ( $abogados ))
		
		foreach ( $abogados as $abogado ) {
			
			?>
	<tr class="abogado <?php
			echo $class?>">
			echo $abogado->nombre?></td>
			echo $abogado->correo?></td>
			echo number_format($abogado->costoHora,2);?></td>
			
			echo $abogado->id_abogado?>"
			echo $abogado->id_abogado?>)" /></td>
		
	
	<?php
			
			if ($class == "")
				
				$class = "gris";
			
			else
				
				$class = "";
		
		}
	?>
</table>

}

include (TO_ROOT . "includes/footer.php");

?>



