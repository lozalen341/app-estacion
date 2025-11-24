<?php
    
    session_start();

	if(isset($_SESSION['user_email'])){
		header("Location: ?slug=panel");
		exit;
	}

    $seccion = "Cambiar contraseña";
    $css = "auth";
    $mensaje = "";

    if (isset($_GET['token_action'])) {

        $token = $_GET['token_action'];

        if (!isset($_POST['password']) || !isset($_POST['confirm_password'])) {
            
        } else {

            $pass  = $_POST['password'];
            $pass2 = $_POST['confirm_password'];

            if ($pass !== $pass2 || strlen($pass) < 1) {
                $mensaje = "Las contraseñas no coinciden.";
            } else {
                $usuario = new Usuarios();
                $mensaje = $usuario->reset($token, $pass);
            }
        }

    } else {
        $mensaje="El token es invalido o esta expirado.";
    }

    /* IMPRIMO LA VISTA */
    $tpl = new Palta("reset");

    $tpl->assign([
        "RESET_MESSAGE" => $mensaje,
        "TOKEN_ACTION" => $_GET['token_action'] ?? "",
        "APP_SECTION" => $seccion,
        "NAME_CSS" => $css,
    ]);


    $tpl->printToScreen();
?>