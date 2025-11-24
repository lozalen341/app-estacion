<?php
	// session_start();

	// if(!isset($_SESSION['user_email'])){
	//     header("Location: ?slug=login");
	//     exit;
	// }
	$section = "Panel";
	$css = "panel";
	
	/* IMPRIMO LA VISTA */
	$tpl = new Palta("panel");

	$tpl->assign([
		"APP_SECTION" => $section,
		"NAME_CSS" => $css,
	]);

	$tpl->printToScreen();
 ?>