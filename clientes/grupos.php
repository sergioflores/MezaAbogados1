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
	include (TO_ROOT . "domain/Grupos.php");
	include (TO_ROOT . "domain/GruposRegiones.php");

	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$_SESSION['paginaClientes'] = $_GET ['pagina'];
	
	if (isset ( $_GET ['delete'] )) {
		unset ( $_SESSION ['nombreEmpresa'] );
	}
	
	$grupos = new Grupos();
	$grupos2 = $dbHelper->read ( $grupos );
	
	$regPorPagina = 15;
	
	$noRegistros = count ( $grupos2 );
	$noPaginas = ceil ( $noRegistros / $regPorPagina );
	$grupos = $dbHelper->pagination ( $grupos, $regPorPagina, $_GET ['pagina'] );
	
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
<h2>GRUPOS</h2>
<table border="0" cellspacing="1" cellpadding="0" align="center">
	<tr>
		<td colspan="2">
		<span style="color: red"><?php
	if ($_GET ['mensaje'] == 1)
		echo "* El grupo se ha eliminado con exito";
	?></span></td>
		<td colspan="3" align="right">
			<a href="agregarGrupo.php" class="link_titulo" title="Agregar Grupo">
				<img alt="Agregar Grupo" src="<?php echo TO_ROOT?>images/gruposAdd.png" border="0">
			</a>
			<a href="regiones.php" class="link_titulo" title="Ir a Regiones">
				<img alt="Ir a Regiones" src="<?php echo TO_ROOT?>images/regiones.png" border="0">
			</a>
			<a href="clientes.php" class="link_titulo" title="Ir a Clientes">
				<img alt="Ir a Clientes" src="<?php echo TO_ROOT?>images/volver.jpg" border="0">
			</a>
		</td>
	</tr>
	<tr style="background: #f1f1f1;">
		<td width="60" align="center" height="30"><b>No.</b></td>
		<td width="400" align="center"><b>Alias</b></td>
		<td width="80" align="center"><b>No. Integrantes</b></td>
		<td width="360" align="center"><b>Acciones</b></td>
	</tr>
	<?php
	$class = "";
	if (isset ( $grupos ))
		foreach ( $grupos as $grupo ) {

			$arrayClientes = null;
			
			$query = "select cl.id_cliente from Clientes cl, ClienteGrupo cg where cl.id_cliente = cg.id_cliente and cg.id_grupo = " . $grupo->id_grupo;
			$result = $dbHelper->executeQuery($query);
			while ($fila = mysql_fetch_array($result, MYSQL_NUM)) {
			    $arrayClientes [] = $fila[0];
			}
			
			$grupoRegiones = new GruposRegiones();
			$grupoRegiones->id_grupo = $grupo->id_grupo;
			$grupoRegiones->status = 1;
			$grupoRegiones = $dbHelper->read($grupoRegiones);
			
			if(count($grupoRegiones)>0)
			foreach($grupoRegiones as $grupoRegion){
				$query = "select cl.id_cliente from Clientes cl, ClienteRegion cr where cl.id_cliente = cr.id_cliente and cr.id_region = " . $grupoRegion->id_region;
				$result = $dbHelper->executeQuery($query);
				while ($fila = mysql_fetch_array($result, MYSQL_NUM)) {
				    $arrayClientes [] = $fila[0];
				}
			}
			if(count($arrayClientes)>0)
				$arrayClientes = array_unique($arrayClientes);
			
			
			
			?>
	<tr class="<?php
			echo $class?>">
		<td align="center" height="30"><?php
			echo $grupo->id_grupo?></td>
		<td><?php
			echo $grupo->alias ?>
		</td>
		<td align="center"><a href="clientes.php?id_grupo=<?php echo $grupo->id_grupo ?>"><?php echo count($arrayClientes) ?></a></td>
		<td align="center">
			<a href="editarGrupo.php?id_grupo=<?php echo $grupo->id_grupo ?>" title="Ver Grupo"><img src="../images/openFolder.png" border="0" /></a>
			<a href="regiones.php?id_grupo=<?php echo $grupo->id_grupo ?>" title="Ver Regiones"><img src="../images/regiones.png" border="0" height="23" /></a>
			<img src="../images/delete.jpg" border="0"
			onClick="javascript:confirmacion(<?php
				echo $grupo->id_cliente?>)" class="delete" /></td>
	</tr>
		
	
	<?php
			if ($class == "")
				$class = "gris";
			else
				$class = "";
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




