<?php 
    
    session_start();

	if(isset($_SESSION['user_email'])){
		header("Location: ?slug=panel");
		exit;
	}

    $seccion = "Registro";
    $css = "auth";

    $error_register = "";

    if(isset($_POST['btn_registrar'])){

        // Validación de contraseñas primero
        $pass = $_POST['txt_password'] ?? "";
        $pass2 = $_POST['txt_password-repete'] ?? "";

        if($pass !== $pass2){
            $error_register = "Las contraseñas no coinciden.";
        } else {

            // Instancio el modelo
            $usuario = new Usuarios();

            // Intento registrar
            $response = $usuario->register($_POST);

            if($response["errno"] == 201){
                header("Location: ?slug=login");
                exit;
            } else {
                $error_register = $response["error"];
            }
        }
    }

    /* IMPRIMO LA VISTA */
    $tpl = new Palta("register");

    $tpl->assign([
        "ERROR_REGISTER" => $error_register,
        "APP_SECTION" => $seccion,
        "NAME_CSS" => $css,
    ]);

    $tpl->printToScreen();
?>
