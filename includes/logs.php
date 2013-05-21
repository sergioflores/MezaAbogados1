<?php 
function error($numero,$texto){
$ddf = fopen(TO_ROOT . '/logs/error.log','a');
$direccion = $_SERVER['REQUEST_URI'];
fwrite($ddf,"[".date("r")."] $direccion Error $numero:$texto \n");
fclose($ddf);
echo "$texto";
}
set_error_handler('error');

?>