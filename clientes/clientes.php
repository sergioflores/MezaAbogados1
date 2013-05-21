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
	include (TO_ROOT . "domain/Clientes.php");

	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	if ($_POST) {
		
		$_SESSION ['nombreEmpresa'] = trim ( $_POST ['nombreEmpresa'] );
	
	}
	
	$_SESSION['paginaClientes'] = $_GET ['pagina'];
	
	if (isset ( $_GET ['delete'] )) {
		unset ( $_SESSION ['nombreEmpresa'] );
	}
	
	$clientes = new Clientes ();
	$clientes->nombreEmpresa = $_SESSION ['nombreEmpresa'];
	$clientes2 = $dbHelper->read ( $clientes );
	
	$regPorPagina = 15;
	
	$from = "";
	$conditions = "";
	if(isset($_GET['id_grupo'])){
		$from .= " join ClienteGrupo cg ";
		$conditions = "AND cl.id_cliente = cg.id_cliente AND cg.id_grupo = " . $_GET['id_grupo'] ;
	}
	
	if(isset($_GET['id_region'])){
		$from .= " join ClienteRegion cr ";
		$conditions = "AND cl.id_cliente = cr.id_cliente AND cr.id_region = " . $_GET['id_region'] ;
	}
	
	$page = $_GET ['pagina'];
	if($page <= 0)
		$page = 1;
	$start = ($page - 1) * 15;
	$limit .= " LIMIT " . $start . ", " . 15;
	
	$query = "SELECT cl.id_cliente, cl.tipo, cl.nombreEmpresa, cl.paginaWeb, cl.sindicato, cl.facebook, cl.twitter, cl.comentarios, cl.quienRefiere, cl.datoEconomico, cl.iguala, cl.fechaCreacion, cl.status 
			FROM Clientes cl" . $from . " WHERE cl.status = 1 " . $conditions . $limit;
	
	$result = $dbHelper->executeQuery($query);
	$clientes = $dbHelper->toObject($result, new Clientes());
	
	?>
<script type="text/javascript">

function confirmacion(id_cliente){
		jConfirm('Desea eliminar este cliente?', 'Eliminar Cliente', function(r) {
			if(r){
				window.location = "http://barbosahuerga.com.mx/scc/admin/actions/Clientes.php?accion=eliminar_cliente&id_cliente=" + id_cliente;
			}
		});
	}


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
<h2>CLIENTES</h2>
<table width="900" border="0" cellspacing="1" cellpadding="0" align="center">
	<tr>
		<td colspan="2"><a id="buscar" href="#" title="Buscar"><img
			src="<?php
	echo TO_ROOT?>images/search3.png" height="25" border="0" /> Buscar</a> <a href="clientes.php?delete">Limpiar</a>
		<span style="color: red"><?php
	if ($_GET ['mensaje'] == 1)
		echo "* El cliente se ha eliminado con exito";
	?></span></td>
		<td colspan="3" align="right">
			<a href="AgregarCliente.php" class="link_titulo" title="Agregar Cliente">
				<img alt="Agregar Cliente" src="<?php echo TO_ROOT?>images/cliente.png" border="0">
			</a>
			<a href="grupos.php" class="link_titulo" title="Ir a Grupos">
				<img alt="Agregar Cliente" src="<?php echo TO_ROOT?>images/grupos.png" border="0">
			</a>
		</td>
	</tr>
	<tr style="background: #f1f1f1;">
		<td width="60" align="center" height="30"><b>No.</b></td>
		<td width="320" align="center"><b>Nombre</b></td>
		<td width="150" align="center"><b>Página Web</b></td>
		<td width="100" align="center"><b>No. Expedientes</b></td>
		<td width="365" align="center"><b>Acciones</b></td>
	</tr>
	<?php
	$class = "";
	if (isset ( $clientes ))
		foreach ( $clientes as $cliente ) {
			
			?>
	<tr class="<?php
			echo $class?>">
		<td align="center" height="30"><?php
			echo $cliente->id_cliente?></td>
		<td><?php
			echo $cliente->nombreEmpresa ?>
		</td>
		<td align="center"><?php echo $cliente->paginaWeb ?></td>
		<td align="center">1</td>
		<td align="center">
			<a href="editarCliente.php?id_cliente=<?php echo $cliente->id_cliente ?>" title="Ver Cliente"><img src="../images/openFolder.png" border="0" /></a>
			<img src="../images/delete.jpg" border="0"
			onClick="javascript:confirmacion(<?php
				echo $cliente->id_cliente?>)" class="delete" /></td>
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




