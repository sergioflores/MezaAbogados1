<?php

session_start ();
ini_set('default_charset', 'UTF-8');
header ( 'Content-Type:text/html; charset=UTF-8' );
define ( 'TO_ROOT', '../' );

define ( 'TITULO', 'Expedientes' );

include (TO_ROOT . "includes/header.php");

if (isset ( $_SESSION ['id_abogado'] )) {
	
	include (TO_ROOT . "includes/conexion.php");
	include (TO_ROOT . "domain/DBHelper.php");
	include (TO_ROOT . "domain/Expedientes.php");
	include (TO_ROOT . "domain/Clientes.php");
	include (TO_ROOT . "domain/DemandadoExpediente.php");
	include (TO_ROOT . "domain/Demandado.php");
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$expedientes = new Expedientes();
	$expedientes->status = 1;
	$expedientes = $dbHelper->read($expedientes);
	
	$tipoArray[1] = "Juicios";
	$tipoArray[2] = "Asesorias";
	$tipoArray[3] = "Otros";
	
	
	?>
<script type="text/javascript">

$(document).ready(function() {
	
});
</script>
<div style="padding-top: 30px; padding-bottom: 30px;" align="center">
<h2>EXPEDIENTES</h2>
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
			<a href="agregarExpediente.php" class="link_titulo" title="Agregar Expediente">
				<img alt="Agregar Expediente" src="<?php echo TO_ROOT?>images/expedientesAdd.png" border="0">
			</a>
		</td>
	</tr>
	<tr style="background: #f1f1f1;">
		<td align="center" height="30"><b>No. A. T.</b></td>
		<td align="center" height="30"><b>No.Int.</b></td>
		<td align="center"><b>Tipo</b></td>
		<td align="center"><b>Contrario</b></td>
		<td align="center"><b>Cliente</b></td>
		<td align="center"><b>Acciones</b></td>
	</tr>
	<?php
	$class = "";
	if (isset ( $expedientes ))
		foreach ( $expedientes as $expediente ) {
			
			$cliente = new Clientes();
			$cliente->id_cliente = $expediente->id_cliente;
			$cliente = $dbHelper->readFirst($cliente);
			
			$demandadoExpediente = new DemandadoExpediente();
			$demandadoExpediente->id_expediente = $expediente->id_expediente;
			$demandadoExpediente->status = 1;
			$demandadoExpediente = $dbHelper->readFirst($demandadoExpediente);
			
			$demandado = new Demandado();
			if($demandadoExpediente->id_demandado > 0){
				$demandado->id_demandado = $demandadoExpediente->id_demandado;
				$demandado = $dbHelper->readFirst($demandado);
			}
			
			?>
	<tr class="<?php
			echo $class?>">
		<td align="center" height="30"><?php
			echo $expediente->noExterno	?></td>
			<td align="center" height="30"><?php
			echo str_pad($expediente->id_expediente,5,"0", STR_PAD_LEFT);	?></td>
		<td align="center"><?php
			echo $tipoArray[$expediente->tipo] ?>
		</td>
		<td align="center"><?php echo $demandado->nombre ?></td>
		<td>
			<?php echo $cliente->nombreEmpresa ?>
		</td>
		<td align="center">
			<a href="verExpediente.php?id_expediente=<?php echo $expediente->id_expediente ?>" title="Ver Expediente"><img src="../images/openFolder.png" border="0" /></a>
			<img src="../images/delete.jpg" border="0"
			onClick="javascript:confirmacion(<?php
				echo $expediente->id_cliente?>)" class="delete" /></td>
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




