<?php
    
    session_start();

	if(isset($_SESSION['user_email'])){
		header("Location: ?slug=panel");
		exit;
	}

    $seccion = "Olvide mi contraseña";
    $css = "auth";
    
    $info_message = "";
    $error_message = "";
    $success_message = "";
    
    if(isset($_POST['btn_ingresar'])){
        $email = $_POST['email'];

        $usuario = new Usuarios();
        $mensaje = $usuario->recovery($email);

        if ($mensaje !== "El email no corresponde a un usuario. Click <a href='?slug=register'> aqui </a> para registrarse.") {
            $mailer = new Mailer();
            $errMail = $mailer->recoveryEmail($email);

            if ($errMail) {
                $success_message = "Se ha enviado un enlace de recuperación a tu correo electrónico. Revisá tu bandeja de entrada.";
            } else {
                $error_message = "No se pudo enviar el mail.";
            }
        } else {
            $error_message = $mensaje;
        }
    } else {
        $info_message = "Ingresá tu dirección de email y te enviaremos un enlace para restablecer tu contraseña.";
    }

	$tpl = new Palta("recovery");

	$tpl->assign([
        "INFO_RECOVERY" => $info_message,
        "ERROR_RECOVERY" => $error_message,
        "SUCCESS_RECOVERY" => $success_message,
		"APP_SECTION" => $seccion,
		"NAME_CSS" => $css,
	]);

	$tpl->printToScreen();

?>