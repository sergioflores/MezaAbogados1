<?php

session_start ();
ini_set ( 'default_charset', 'UTF-8' );
header ( 'Content-Type:text/html; charset=UTF-8' );
define ( 'TO_ROOT', '../' );

define ( 'TITULO', 'Expedientes' );

include (TO_ROOT . "includes/header.php");

if (isset ( $_SESSION ['id_abogado'] )) {
	
	include (TO_ROOT . "includes/conexion.php");
	include (TO_ROOT . "domain/DBHelper.php");
	include (TO_ROOT . "domain/Expedientes.php");
	include (TO_ROOT . "domain/Clientes.php");
	include (TO_ROOT . "domain/Abogados.php");
	include (TO_ROOT . "domain/AbogadoExpediente.php");
	include (TO_ROOT . "domain/Actor.php");
	include (TO_ROOT . "domain/Demandado.php");
	include (TO_ROOT . "domain/ActorExpediente.php");
	include (TO_ROOT . "domain/DemandadoExpediente.php");
	include (TO_ROOT . "domain/Juzgados.php");
	include (TO_ROOT . "domain/ExpedienteJuzgado.php");
	include (TO_ROOT . "domain/Tarea.php");
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$expediente = new Expedientes ();
	$expediente->id_expediente = $_GET ['id_expediente'];
	$expediente = $dbHelper->readFirst ( $expediente );
	
	$actoresExpedientes = new ActorExpediente ();
	$actoresExpedientes->id_expediente = $_GET ['id_expediente'];
	$actoresExpedientes->status = 1;
	$actoresExpedientes = $dbHelper->read ( $actoresExpedientes );
	
	$demandadosExpedientes = new DemandadoExpediente ();
	$demandadosExpedientes->id_expediente = $_GET ['id_expediente'];
	$demandadosExpedientes->status = 1;
	$demandadosExpedientes = $dbHelper->read ( $demandadosExpedientes );
	
	$clientes = new Clientes ();
	$clientes->status = 1;
	$clientes = $dbHelper->read ( $clientes );
	
	$actores = new Actor ();
	$actores = $dbHelper->read ( $actores );
	
	$demandados = new Demandado ();
	$demandados = $dbHelper->read ( $demandados );
	
	$abogados = new Abogados ();
	$abogados->status = 1;
	$abogados = $dbHelper->read ( $abogados );
	
	$abogadosExpediente = new AbogadoExpediente ();
	$abogadosExpediente->id_expediente = $_GET ['id_expediente'];
	;
	$abogadosExpediente->status = 1;
	$abogadosExpediente = $dbHelper->read ( $abogadosExpediente );
	
	$abogadoExpedienteArray = "";
	if (count ( $abogadosExpediente ) > 0)
		foreach ( $abogadosExpediente as $abogadoExpediente ) {
			$abogadoExpedienteArray [] = $abogadoExpediente->id_abogado;
		}
	
	$abogadoExpedienteArray [] = 0;
	
	$juzgados = new Juzgados ();
	$juzgados->status = 1;
	$juzgados = $dbHelper->read ( $juzgados );
	
	$tareas = new Tarea();
	$tareas->id_expediente = $_GET ['id_expediente'];
	$tareas->status = 1;
	$tareas = $dbHelper->read($tareas);
	
	?>
<script type="text/javascript">

$(document).ready(function() {


	var actoresArray = [
		           	<?php
	foreach ( $actores as $actor )
		echo '{"value" : "' . $actor->id_actor . '", "label" : "' . $actor->nombre . '"},'?>
		           ];

	var demandadossArray = [
			           	<?php
	foreach ( $demandados as $demandado )
		echo '{"value" : "' . $demandado->id_demandado . '", "label" : "' . $demandado->nombre . '"},'?>
			           ];

	var bandera = false;

	$("input#actor").autocomplete( {
		matchContains: true,
		minChars: 0,
		minLength: 0,
		close: function(event, ui) { bandera = false; },
		open: function(event, ui) { bandera = true; },
		select: function(event, ui) { 
			var selectedObj = ui.item;
			var html = '<div class="actorDemandado">' +
						selectedObj.label +
						' <img alt="Eliminar" src="../images/delete.jpg" height="15" onclick="deletee(this)" class="pointerArrow" />'+
						'<input type="hidden" name="id_actor[]" value="' + selectedObj.value + '">' +
						'</div>';
			$("#actoresSeccion").append(html);
			setTimeout ('borarActorDemandado()', 200); 
		},

		source: function(request, response) {
	        var rows = imAutocompleteJSONParse(actoresArray);
	        return response(rows);
	    }
		}
	
	  );

	$('#addActorButton').click(function() {
		  if(bandera == true){
			  $("input#actor").autocomplete("close");
		  }else{
		  	$("input#actor").autocomplete( "search", "" );
		  	bandera = true;
		  }
		});

	 $('#addActorButton').keypress(function(event) {
		  if ( event.which == 27 ) {
			  $("input#actor").autocomplete("close");
		  }
	  });



	 $("input#demandado").autocomplete( {
			matchContains: true,
			minChars: 0,
			minLength: 0,
			close: function(event, ui) { bandera = false; },
			open: function(event, ui) { bandera = true; },
			select: function(event, ui) { 
				var selectedObj = ui.item;
				var html = '<div class="actorDemandado">' +
							selectedObj.label +
							' <img alt="Eliminar" src="../images/delete.jpg" height="15" onclick="deletee(this)" class="pointerArrow" />'+
							'<input type="hidden" name="id_demandado[]" value="' + selectedObj.value + '">' +
							'</div>';
				$("#demandadosSeccion").append(html);
				setTimeout ('borarActorDemandado()', 200); 
			},
			source: function(request, response) {
		        var rows = imAutocompleteJSONParse(demandadossArray);
		        return response(rows);
		    }
		}
		
		  );

		$('#addDemandadoButton').click(function() {
			  if(bandera == true){
				  $("input#demandado").autocomplete("close");
			  }else{
			  	$("input#demandado").autocomplete( "search", "" );
			  	bandera = true;
			  }
			});

		 $('#addDemandadoButton').keypress(function(event) {
			  if ( event.which == 27 ) {
				  $("input#demandado").autocomplete("close");
			  }
		  });

		  $("#guardar").click(function(event){
			  $.blockUI({ message: '<h1> Guardando datos...</h1>' });
			  $("#exepdientesForm").submit();
			});

		  $("#addEtapa").click(function(event){
			  Messi.load('nuevaEtapa.php', {show : true, modal: true, unload : true, params : { id_expediente : <?php echo $_GET ['id_expediente'] ?>}	});
			});


		  $( "#tabs" ).tabs();

		  <?php 
		  $tab = 0;
		  	if($_GET['tab'] > 0 )
		  		$tab = $_GET['tab'];
		  ?>
		  $( "#tabs" ).tabs( "option", "active", <?php echo $tab?> );

		  $("#id_abogados").multiselect();

		  $( ".dateInput" ).datepicker();

});

function borarActorDemandado(){
	$("#actor").val('');
	$("#demandado").val('');
}
function deletee(element){
	$(element).parent().remove();
}

function imAutocompleteJSONParse(data) {
    var rows = [];
    var rowData = null;
    var dataLength = data.length;
    for (var i = 0; i < dataLength; i++) {
        rowData = data[i];
        rows[i] = {
            label: rowData.label,
            value: rowData.value
        };
    }
    return rows;
}
</script>
<div>
<h2>Expediente</h2>

<table style="width: 1000px" border="0" cellspacing="5" cellpadding="0">

	<tr>

		<td colspan="5" align="left" valign="bottom"></td>

		<td colspan="5" align="right"><a href="expedientes.php"><img
			src="<?php
	
	echo TO_ROOT?>images/volver.jpg" height="30" alt="Volver" border="0" title="Volver" /></a></td>

	</tr>
</table>

<div id="tabs" style="width: 1000px;">
<ul>
	<li><a href="#tabs-1">Datos Generales</a></li>
	<li><a href="#tabs-2">Etapas</a></li>
	<li><a href="#tabs-2">Adjuntos</a></li>
</ul>
<div id="tabs-1" align="left">
<form action="../actions/Expedientes.php" id="exepdientesForm" method="post">
<table cellspacing="5">
	<tr>
		<td>Cliente:</td>
		<td><select id="id_cliente" name="id_cliente" style="width: 190px;">
			<option>Seleccione...</option>
			<?php
	foreach ( $clientes as $cliente ) {
		if ($expediente->id_cliente == $cliente->id_cliente)
			$selectable = 'selected="selected"';
		echo '<option value="' . $cliente->id_cliente . '" ' . $selectable . '>' . $cliente->nombreEmpresa . '</option>';
		$selectable = '';
	}
	?>
			</select></td>
		<td>Tipo:</td>
		<td><select name="tipo" id="tipo">
			<option value="1" <?php
	if ($expediente->tipo == 1)
		echo 'selected="selected"'?>>Juicio</option>
			<option value="2" <?php
	if ($expediente->tipo == 2)
		echo 'selected="selected"'?>>Asesoría</option>
			<option value="3" <?php
	if ($expediente->tipo == 4)
		echo 'selected="selected"'?>>Otros</option>
		</select></td>
		<td>Acción:</td>
		<td><select name="accionE" style="width: 190px;" id="accionE">
			<option <?php
	if ($expediente->accion == 'INDEMNISACION POR DESPIDO')
		echo 'selected="selected"'?>>INDEMNISACION POR DESPIDO</option>
			<option <?php
	if ($expediente->accion == 'INDEMNISACION POR RESICION')
		echo 'selected="selected"'?>>INDEMNISACION POR RESICION</option>
			<option <?php
	if ($expediente->accion == 'INDEMNOSACION POR MUERTE')
		echo 'selected="selected"'?>>INDEMNOSACION POR MUERTE</option>
			<option <?php
	if ($expediente->accion == 'REINSTALACIÓN')
		echo 'selected="selected"'?>>REINSTALACIÓN</option>
			<option <?php
	if ($expediente->accion == 'OTRAS')
		echo 'selected="selected"'?>>OTRAS</option>
		</select></td>
		<td>No. Externo:</td>
		<td><input type="text" name="noExterno" value="<?php
	echo $expediente->noExterno?>"></td>
	</tr>
	<tr>
		<td valign="top">Comentarios:</td>
		<td colspan="7"><textarea name="comentarios" style="width: 760px; height: 45px;"><?php
	echo $expediente->comentarios?></textarea></td>
	</tr>
	<tr>
		<td>Abogados asginados:</td>
		<td><select name="id_abogados[]" multiple="multiple" id="id_abogados">
				<?php
	if (count ( $abogados ) > 0)
		foreach ( $abogados as $abogado ) {
			?>
					<option
				<?php
			if (in_array ( $abogado->id_abogado, $abogadoExpedienteArray ))
				echo 'selected="selected"'?>
				value="<?php
			echo $abogado->id_abogado?>"><?php
			echo $abogado->nombre?></option>
					<?php
		}
	?>
			</select></td>
	</tr>
	<tr>
		<td>Cliente:</td>
		<td valign="top" colspan="2"><input type="text" name="actor" id="actor" style="width: 190px"> <img
			src="../images/arrowsDown.png" id="addActorButton" height="20" class="pointerArrow" /></td>
		<td>Contrario:</td>
		<td colspan="2"><input type="text" name="demandado" id="demandado" style="width: 190px"><img
			src="../images/arrowsDown.png" id="addDemandadoButton" height="20" class="pointerArrow" /></td>
	</tr>
	<tr>
		<td id="actoresSeccion" colspan="2" valign="top" style="height: 80px;">
		<?php
	if (count ( $actoresExpedientes ) > 0)
		foreach ( $actoresExpedientes as $actorExpediente ) {
			$actor = new Actor ();
			$actor->id_actor = $actorExpediente->id_actor;
			$actor = $dbHelper->readFirst ( $actor );
			?>
			<div class="actorDemandado"><a href="#"><?php
			echo $actor->nombre?></a> <img alt="Eliminar" src="../images/delete.jpg" height="15"
			onclick="deletee(this)" class="pointerArrow" /> <input type="hidden" name="id_demandado[]"
			value="<?php
			echo $actor->id_actor?>"></div>
		<?php
		}
	?>
		
		</td>
		<td></td>
		<td id="demandadosSeccion" colspan="3" valign="top">
		<?php
	if (count ( $demandadosExpedientes ) > 0)
		foreach ( $demandadosExpedientes as $demandadoExpediente ) {
			$demandado = new Demandado ();
			$demandado->id_demandado = $demandadoExpediente->id_demandado;
			$demandado = $dbHelper->readFirst ( $demandado );
			?>
			<div class="actorDemandado"><a href="#"><?php
			echo $demandado->nombre?></a> <img alt="Eliminar" src="../images/delete.jpg" height="15"
			onclick="deletee(this)" class="pointerArrow" /> <input type="hidden" name="id_demandado[]"
			value="<?php
			echo $demandadoExpediente->id_demandado?>"></div>
		<?php
		}
	?>
		</td>
	</tr>
	<tr>
		<td colspan="8"><b>Juicio</b>
		<hr>
		</td>
	</tr>
	<tr>
		<td colspan="8">
		<table cellspacing="5">
			<tr>
				<td>Juzgado</td>
				<td><select name="jugzgado">
					<option>Seleccione...</option>
						<?php
	foreach ( $juzgados as $juzgado ) {
		echo '<option value="' . $juzgado->id_juzgado . '">' . $juzgado->nombre . '</option>';
	}
	?>
					</select></td>
				<td>Fecha Inicio Juicio</td>
				<td><input type="text" readonly="readonly" name="fechaInicioJuicio" class="dateInput" /></td>
				<td>No. Expediente Interno</td>
				<td><input type="text" readonly="readonly" value="00001" style="width: 70px;" /></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td colspan="8" align="center"><input type="button" id="guardar" value="Guardar"></td>
	</tr>
</table>
<input type="hidden" name="accion" value="editar_expediente" />
<input type="hidden" name="id_expediente" value="<?php echo $_GET ['id_expediente'] ?>" />

</form>
</div>
<div id="tabs-2" style="width: 1000px;">
<table width="100%" cellspacing="5">
	<tr>
		<td colspan="8"><b>Etapas y Actividades</b>
		<hr>
		</td>
	</tr>
	<tr>
		<td colspan="8"><br>
		<br>
		<table style="width: 100%; padding: 0; margin: 0;" cellspacing="0" cellpadding="0">
			<tr>
				<td style="height: 20px;" class="etapaTop etapaBotton"></td>
				<td class="etapaTop etapaBotton" style="background-image: url('../images/signEtapa.jpg');"></td>
				<td class="etapaTop etapaBotton"></td>
				<td class="etapaTop etapaBotton"></td>
				<td class="etapaTop etapaBotton"></td>
				<td class="etapaTop etapaBotton" style="border-right: 2px solid #CCC;"></td>
			</tr>
			<tr>
				<td class="etapaTop" style="height: 20px;" valign="bottom" align="center">Admisión de demanda</td>
				<td class="etapaTop" valign="bottom" align="center">Instrucción</td>
				<td class="etapaTop" valign="bottom" align="center">Laudo pendiente</td>
				<td class="etapaTop" valign="bottom" align="center">Laudo dictado</td>
				<td class="etapaTop" valign="bottom" align="center">Amparo directo</td>
				<td class="etapaTop" style="border-right: 2px solid #CCC;" valign="bottom" align="center">Ejecución</td>
			</tr>
		</table>
		<br />
		<br />
		<table style="width: 100%; padding: 0; margin: 0;" cellspacing="0" cellpadding="5">
			<tr>
			<td colspan="5" align="right">
				<a href="#" id="addEtapa"><img src="../images/add.png" border="0" /> Agregar Etapa</a>
			</td>
			</tr>
			<tr>
				<td><b>Etapa</b></td>
				<td><b>Titulo</b></td>
				<td><b>Fecha/Hora</b></td>
				<td><b>Responsable</b></td>
				<td><b>Lugar</b></td>
			</tr>
			<tr>
				<td colspan="5"><hr/></td>
			</tr>
			<?php 
			if(count($tareas) > 0)
			foreach($tareas as $tarea){
				
				$abogado2 = new Abogados();
				$abogado2->id_abogado = $tarea->id_abogado;
				$abogado2 = $dbHelper->readFirst($abogado2);
				
				?>
			<tr>
				<td><?php echo $tarea->etapa ?></td>
				<td><?php echo $tarea->titulo ?></td>
				<td><?php echo $tarea->fechaHoraInicio ?></td>
				<td><?php echo $abogado2->nombre?></td>
				<td><?php echo $tarea->direccion?></td>
			</tr>
				<?php 
			}
			?>
			
		</table>
		</td>
	</tr>
	<tr>

</table>
</div>
</div>
</div>

<?php
}
include (TO_ROOT . "includes/footer.php");
?>