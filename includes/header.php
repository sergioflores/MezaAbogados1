<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es"
	dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="<?php
echo TO_ROOT?>css/style.css"
	type="text/css" />
<link rel="stylesheet" href="<?php
echo TO_ROOT?>css/inputs.css"
	type="text/css" />
<link href="<?php
echo TO_ROOT?>css/uploadFiles.css" rel="stylesheet"
	type="text/css" />
<link href="<?php
echo TO_ROOT?>css/messi.css" rel="stylesheet"
	type="text/css" />
<link href="<?php
echo TO_ROOT?>css/jquery.timepicker.css" rel="stylesheet"
	type="text/css" />
<link href="<?php
echo TO_ROOT?>css/jquery.multiselect.css"
	rel="stylesheet" type="text/css" />
<!--[if lt IE 9]>          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>        <![endif]-->
<!-- Librerias para Jquery -->
<link rel="stylesheet"
	href="<?php
	echo TO_ROOT?>js/themes/base/jquery.ui.all.css">
<script src="<?php
echo TO_ROOT?>js/jquery-1.9.1.min.js"></script>
<script src="<?php
echo TO_ROOT?>js/jquery-ui-1.10.3.custom.js"></script>
<script src="<?php
echo TO_ROOT?>js/ui/jquery.ui.core.js"></script>
<script src="<?php
echo TO_ROOT?>js/jquery.blockUI.js"></script>
<script src="<?php
echo TO_ROOT?>js/messi.min.js"></script>
<script src="<?php
echo TO_ROOT?>js/jquery.multiselect.js"></script>
<script src="<?php
echo TO_ROOT?>js/jquery.timepicker.js"></script>
<title><?php
echo TITULO?> - Meza Abogados</title>
</head>
<body>
<div id="content" align="center">
<div id="header">
<table class="tableHeader">
	<tr>
		<td align="left">
		<h2>Meza Abogados</h2>
		</td>
		<td class="userData" align="right">					<?php
		if ($_SESSION ['id_abogado']) {
			echo $_SESSION ['nombreAbogado']?><br />
		<a
			href="<?php
			echo TO_ROOT?>abogados/editarAbogado.php?id_abogado=<?php
			echo $_SESSION ['id_abogado']?>">Mis
		datos</a><br />
		<a href="<?php
			echo TO_ROOT?>Logueo/Logueo.php?salir">Salir</a>					<?php
		}
		?>											</td>
	</tr>
	<tr>
		<td colspan="2">
		<hr />
		</td>
	</tr>
	<tr>
		<td colspan="2">		<?php
		if ($_SESSION ['id_abogado'])
			include_once (TO_ROOT . "includes/menu.php");		?>		</td>
	</tr>
</table>
</div>