<?php

	$seccion = "Usuario bloqueado";
	$css = "auth";
	$mensaje = "";

	if(isset($_GET['token'])){
		$token = $_GET['token'];
		$usuario = new Usuarios();

		$tokenAction = $usuario->blocked($token); // bloquea y devuelve token_action

		if($tokenAction){
			$res = $usuario->consultar("SELECT email FROM usuarios_app_estacion WHERE token='".$token."' LIMIT 1");
			if(count($res)){
				$mailer = new Mailer();
				$mailer->blockedEmail($res[0]['email'], $tokenAction);
			}
			$mensaje = "Tu cuenta fue bloqueada, revisa tu correo.";
		} else {
			$mensaje = "El token no corresponde a un usuario.";
		}
	} else {
		$mensaje = "No se pudo bloquear el usuario";
	}


	$tpl = new Palta("blocked");

	$tpl->assign([
		'BLOCKED_MESSAGE' => $mensaje,
		'APP_SECTION'    => $seccion,
		'NAME_CSS'       => $css,
	]);

	$tpl->printToScreen();
?>