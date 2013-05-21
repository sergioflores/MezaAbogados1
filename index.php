<?php

session_start ();

define ( 'TO_ROOT', '' );
define ( 'TITULO', 'Inicio' );

include_once ("includes/header.php");

?>
<div id="main">
<?php 

if ($_SESSION ['id_abogado']) {
	
	?>
	<!-- Contenido usuario logueado -->
	<center><h1>Bienvenido</h1></center>
	<?php 
	
	
} else {
	
	?>
<script>
$(document).ready(function(){

	$("#submitLogin").click(function() {
		$.blockUI({ message: '<h1> Un momento por favor...</h1>' });
		  $("#formLogin").submit();
		});
	
});
</script>

<form action="Logueo/Logueo.php" method="post" id="formLogin">
<table align="center" cellspacing="10">
	<tr>
		<td colspan="2" align="center">
		<h3>Ingrese sus credenciales</h3>
		</td>
	</tr>
	<tr>
		<td>Correo:</td>
		<td><input name="correo" /></td>
	</tr>
	<tr>
		<td>Password:</td>
		<td><input name="password" type="password" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><a href="#" class='button' style="width: 30%" id="submitLogin">Ingresar</a></td>
	</tr>
	<tr>
		<td colspan="2" class="errosMsg">
				<?php
	if ($_GET ['error'] == 1)
		echo "Correo y/o password incorrectos"?>

					</td>
	</tr>
</table>
</form>

<?php
}
?>
</div>
<?php 
include_once ("includes/footer.php");
?>