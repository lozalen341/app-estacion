<?php

    $seccion = "Notificación de inicio de sesión";
    $css = "auth";
    $mensaje = "";

    if(isset($_GET['email']) && isset($_GET['token'])) {

        $email = $_GET['email'];
        $token = $_GET['token'];

        $mailer = new Mailer();
        $ok = $mailer->loginNotiEmail($email, $token);

        $mensaje = $ok 
            ? "Notificación enviada correctamente." 
            : "Error al enviar la notificación.";

    } else {
        $mensaje = "Faltan parámetros.";
    }

    $tpl = new Palta("loginNotify");

    $tpl->assign([
        'LOGIN_NOTIFY_MESSAGE' => $mensaje,
        'APP_SECTION'          => $seccion,
        'NAME_CSS'             => $css,
    ]);

    $tpl->printToScreen();
?>