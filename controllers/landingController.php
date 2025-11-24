<?php 


	/* dentro de los controladores solo hay codigo php*/


	/* LIBRERIAS */
	/* CLASES */


	/* LÓGICA DE NEGOCIO */
	$section = "Pagina principal";
	$css = "landing";

	$usuarios = new Usuarios();

	//$cant_users = $usuarios->getCant();


	/* IMPRIMO LA VISTA */
	$tpl = new Palta("landing");

	$tpl->assign([
		"APP_SECTION" => $section,
		"NAME_CSS" => $css,

		//"CANT_USERS" => $cant_users
	]);

	$tpl->printToScreen();

	

?>