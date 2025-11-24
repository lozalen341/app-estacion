<?php

    session_start();

	if(isset($_SESSION['user_email'])){
		header("Location: ?slug=panel");
		exit;
	}

    $seccion = "Verificar";
    $css = "auth";
    $mensaje = "";

    if(isset($_GET['email']) && isset($_GET['token'])) {

        $email = $_GET['email'];
        $token = $_GET['token'];

        $usuario = new Usuarios();

        $mensaje = $usuario->verifyEmail($email, $token);

    } else {
        $mensaje = "Faltan parámetros de verificación.";
    }

    $tpl = new Palta("verify");

    $tpl->assign([
        'VERIFY_MESSAGE' => $mensaje,
        'APP_SECTION'    => $seccion,
        'NAME_CSS'       => $css,
    ]);

    $tpl->printToScreen();
?>