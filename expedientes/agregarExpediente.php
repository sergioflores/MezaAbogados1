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
	include (TO_ROOT . "domain/Actor.php");
	include (TO_ROOT . "domain/Demandado.php");
	include (TO_ROOT . "domain/Abogados.php");
	
	$dbHelper = new DBHelper ();
	$dbHelper->setConection ( $conexion );
	
	$clientes = new Clientes ();
	$clientes->status = 1;
	$clientes = $dbHelper->read ( $clientes );
	
	$actores = new Actor();
	$actores = $dbHelper->read($actores);
	
	$demandados = new Demandado();
	$demandados = $dbHelper->read($demandados);
	
	$abogados = new Abogados();
	$abogados->status = 1;
	$abogados = $dbHelper->read($abogados);
	
	?>
<script type="text/javascript">

$(document).ready(function() {


	var actoresArray = [
		           	<?php foreach($actores as $actor) echo '{"value" : "' . $actor->id_actor .'", "label" : "' . $actor->nombre .'"},'?>
		           ];

	var demandadossArray = [
			           	<?php foreach($demandados as $demandado) echo '{"value" : "' . $demandado->id_demandado .'", "label" : "' . $demandado->nombre .'"},'?>
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

		  $("#id_abogados").multiselect();

	
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
<div style="width: 900px;" align="center">
<h2>Agregar Expediente</h2>
<form action="../actions/Expedientes.php" id="exepdientesForm" method="post">
<table cellspacing="5">
	<tr>
		<td>Cliente:</td>
		<td><select id="id_cliente" name="id_cliente" style="width: 190px;">
			<option>Seleccione...</option>
			<?php
	foreach ( $clientes as $cliente ) {
		echo '<option value="' . $cliente->id_cliente . '">' . $cliente->nombreEmpresa . '</option>';
	}
	?>
			</select></td>
		<td>Tipo:</td>
		<td><select name="tipo">
			<option value="1">Juicio</option>
			<option value="2">Asesoría</option>
			<option value="3">Otros</option>
		</select></td>
		<td>Acción:</td>
		<td><select name="accionE" style="width: 190px;">
			<option>INDEMNISACION POR DESPIDO</option>
			<option>INDEMNISACION POR RESICION</option>
			<option>INDEMNOSACION POR MUERTE</option>
			<option>REINSTALACIÓN</option>
			<option>OTRAS</option>
		</select></td>
		<td>No. Externo:</td>
		<td><input type="text" name="noExterno"></td>
	</tr>
	<tr>
		<td>Abogados asginados:</td>
		<td>
			<select name="id_abogados[]" multiple="multiple" id="id_abogados">
				<?php
					if(count($abogados) > 0) 
					foreach($abogados as $abogado){?>
					<option
					 value="<?php echo $abogado->id_abogado ?>"><?php echo $abogado->nombre ?></option>
					<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top">Comentarios:</td>
		<td colspan="7"><textarea name="comentarios" style="width: 760px; height: 45px;"></textarea></td>
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
		<td id="actoresSeccion" colspan="2" valign="top" style="height: 110px;">
		</td>
		<td>
		</td>
		<td id="demandadosSeccion" colspan="3" valign="top"></td>
	</tr>
	<tr>
		<td colspan="6" align="center"><input type="button" id="guardar" value="Guardar"></td>
	</tr>
</table>
<input type="hidden" name="accion" value="guardar_expediente" />
</form>
</div>

<?php
}
include (TO_ROOT . "includes/footer.php");
?>