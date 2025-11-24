<?php
	session_start();

	if(!isset($_SESSION['user_email'])){
		header("Location: ?slug=login");
		exit;
	}
	
	$section = "Detalles";
	$css = "detalle";
	
	/* IMPRIMO LA VISTA */
	$tpl = new Palta("detalle");

	$tpl->assign([
		"APP_SECTION" => $section,
		"NAME_CSS" => $css,
	]);

	$tpl->printToScreen();
	
?>