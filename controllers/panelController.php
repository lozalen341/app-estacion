<?php 
	$section = "Panel";
	
	/* IMPRIMO LA VISTA */
	$tpl = new Palta("panel");

	$tpl->assign([
		"APP_SECTION" => $section,
	]);

	$tpl->printToScreen();
 ?>