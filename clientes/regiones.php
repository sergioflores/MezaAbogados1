<?php

session_start ();
ini_set('default_charset', 'UTF-8');
header ( 'Content-Type:text/html; charset=UTF-8' );
define ( 'TO_ROOT', '../' );

define ( 'TITULO', 'Clientes' );

include (TO_ROOT . "includes/header.php");

if (isset ( $_SESSION ['id_abogado'] )) {
	
	include (TO_ROOT . "includes/conexion.php");
	include (TO_ROOT . "domain/DBHelper.php");
	include (TO_ROOT . "domain/Regiones.php");
	include (TO_ROOT . "domain/GruposRegiones.php");
	include (TO_ROOT . "domain/Grupos.php");
	include (TO_ROOT . "domain/ClienteRegion.php");
	

	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$id_grupo = $_GET['id_grupo'];
	
	$_SESSION['paginaClientes'] = $_GET ['pagina'];
	
	if (isset ( $_GET ['delete'] )) {
		unset ( $_SESSION ['nombreEmpresa'] );
	}
	
	$gruposRegiones = new GruposRegiones();
	$gruposRegiones->id_grupo = $id_grupo;
	$gruposRegiones->status = 1;
	$gruposRegiones = $dbHelper->read($gruposRegiones);
	
	if(count($gruposRegiones))
	foreach ($gruposRegiones as $grupoRegiones){
		
		$region = new Regiones();
		$region->id_region = $grupoRegiones->id_region;
		$regiones [] = $dbHelper->readFirst($region);
		
		$grupo = new Grupos();
		$grupo->id_grupo = $grupoRegiones->id_grupo;
		$grupo = $dbHelper->readFirst($grupo);
		$nombresGrupo[] = $grupo->alias;
		
	}
	
	?>
<script type="text/javascript">


$(document).ready(function() {
	$( "#buscar" ).click(
			function() {
			
			$(".lightbox-background").css("display","block");
			$(".lightbox").css("display","block");
			}
	);
	
	$( "#cerrar" ).click(
			function() {
			$(".lightbox-background").css("display","none");
			$(".lightbox").css("display","none");
			}
	);
});
</script>
<div style="padding-top: 30px; padding-bottom: 30px;" align="center">
<h2>Regiones</h2>
<table border="0" cellspacing="1" cellpadding="0" align="center">
	<tr>
		<td colspan="2">
		<span style="color: red"><?php
	if ($_GET ['mensaje'] == 1)
		echo "* La Region se ha eliminado con exito";
	?></span></td>
		<td colspan="3" align="right">
			<a href="agregarRegion.php?id_grupo=<?php echo $id_grupo ?>" class="link_titulo" title="Agregar Regiones">
				<img alt="Ir a Regiones" src="<?php echo TO_ROOT?>images/addRegion.png" border="0">
			</a>
			<a href="grupos.php?id_grupo=<?php echo $id_grupo?>" class="link_titulo" title="Ir a Grupos">
				<img alt="Ir a Grupos" src="<?php echo TO_ROOT?>images/volver.jpg" border="0">
			</a>
		</td>
	</tr>
	<tr style="background: #f1f1f1;">
		<td width="60" align="center" height="30"><b>No.</b></td>
		<td width="200" align="center"><b>Alias</b></td>
		<td width="200" align="center"><b>Grupo</b></td>
		<td width="80" align="center"><b>No. Integrantes</b></td>
		<td width="360" align="center"><b>Acciones</b></td>
	</tr>
	<?php
	$class = "";
	$i = 0;
	if (isset ( $regiones ))
		foreach ( $regiones as $region ) {
			
			$clientesRegiones = new ClienteRegion();
			$clientesRegiones->id_region = $region->id_region;
			$clientesRegiones->status = 1;
			$clientesRegiones = $dbHelper->read($clientesRegiones);
			
			?>
	<tr class="<?php
			echo $class?>">
		<td align="center" height="30"><?php
			echo $region->id_region?></td>
		<td><?php
			echo $region->alias ?>
		</td>
		<td>
			<?php echo $nombresGrupo[$i]?>
		</td>
		<td align="center"><a href="clientes.php?id_region=<?php echo $region->id_region ?>"><?php echo count($clientesRegiones) ?></a></td>
		<td align="center">
			<a href="editarRegion.php?id_region=<?php echo $region->id_region ?>" title="Ver Region"><img src="../images/openFolder.png" border="0" /></a>
			<img src="../images/delete.jpg" border="0"
			onClick="javascript:confirmacion(<?php
				echo $region->id_cliente?>)" class="delete" /></td>
	</tr>
		
	
	<?php
			if ($class == "")
				$class = "gris";
			else
				$class = "";
				
			$i++;
		}
	?>
		
		<tr>
		<td colspan="4" style="color: #0E2C46; padding-top: 10px;" align="left">Paginación: 
			<?php
	for($i = 1; $i <= $noPaginas; $i ++) {
		if ($_GET ['pagina'] == $i) {
			echo $i;
		} else {
			?>
				<a href="clientes.php?pagina=<?php
			echo $i?>" class="paginacion"><?php
			echo $i?></a>
			<?php
		}
	}
	?>
		</td>
	</tr>
</table>
<div class="lightbox-background"></div>

</div>
<?php
}
include (TO_ROOT . "includes/footer.php");
?>




