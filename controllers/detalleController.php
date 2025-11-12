<?php 
	$section = "Detalles";
	
	/* IMPRIMO LA VISTA */
	$tpl = new Palta("detalle");

	$tpl->assign([
		"APP_SECTION" => $section,
	]);

	$tpl->printToScreen();
	
 ?>