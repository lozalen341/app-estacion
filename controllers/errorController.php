<?php 
	
	$seccion = "Error";
	$css = "error";

	/* IMPRIMO LA VISTA */
	$tpl = new Palta("error");

	$tpl->assign([
		"APP_SECTION" => $seccion,
		"NAME_CSS" => $css,
	]);

	$tpl->printToScreen();

?>