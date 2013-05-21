<?php
function ejecutar_query($query,$conexion){
	$ResQuery = mysql_query($query,$conexion) or die(mysql_error());
	return $ResQuery;
}
function obtener_filas($query)
{
	$ResQuery = mysql_fetch_assoc($query);
	return $ResQuery;
}
function obtener_num_filas($query,$conexion)
{
	$ResQuery = mysql_query($query,$conexion) or die(mysql_error());
	$filas  = mysql_result($ResQuery, 0, 0);
	return $filas;
}
?>