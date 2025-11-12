<?php 

	$section = "error";


	/* IMPRIMO LA VISTA */
	$tpl = new Palta([
		"error",
		"APP_SECTION" => $section,

	]);

	$tpl->printToScreen();

 ?>