<?php

// set error reporting level
if (version_compare(phpversion(), '5.3.0', '>=') == 1)
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
else
  error_reporting(E_ALL & ~E_NOTICE);

function bytesToSize1024($bytes, $precision = 2) {
    $unit = array('B','KB','MB');
    return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), $precision).' '.$unit[$i];
}

if (isset($_FILES['myfile'])) {
    $sFileName = $_FILES['myfile']['name'];
    $sFileType = $_FILES['myfile']['type'];
    $sFileSize = bytesToSize1024($_FILES['myfile']['size'], 1);
    
    move_uploaded_file($_FILES["myfile"]["tmp_name"],
      "upload/" . $_FILES["myfile"]["name"]);
    

    echo <<<EOF
    	<table cellspacing="5">
    		<tr>
    			<td colspan="2">Su archivo {$sFileName} fue exitosamente recibido.</td>
    		</tr>
    		<tr>
    			<td style="width:90px">Descripción:</td>
    			<td>
    				<input name="fileName" id="fileName" value="{$sFileName}" type="hidden" />
    				<input name="descripcionArchivo" id="descripcionArchivo" />
    			</td>
    			<tr>
    			<td>Tipo:</td>
    			<td>
    				<select name="tipo" id="tipoArchivo">
    					<option value="1">Documento Social</option>
    					<option value="2">Documento Contratación</option>
    					<option value="3">Asesoría</option>
    				</select>
    			</td>
    		</tr>
    		<tr>
    			<td colspan="2"><input type="button" value="Guardar Archivo" class="inputButton" id="guardarArchivoButton" onclick="guardarAdjunto()"/></td>
    		</tr>
    	</table>
EOF;
} else {
    echo '<div class="f">An error occurred</div>';
}