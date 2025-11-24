<?php

class Usuarios extends DBAbstract {

    public function login($form) {

        $this->email=$form['txt_email'];
        $this->password=$form['txt_password'];

        if(strlen($this->email)==0){
            return ["errno"=>404, "error"=>"Falta email"];
        }

        if(strlen($this->password)==0){
            return ["errno"=>404, "error"=>"Falta contraseña"];
        }

        $sql="SELECT * FROM usuarios_app_estacion WHERE email='".$this->email."' LIMIT 1";
        $response=$this->consultar($sql);

        if(count($response)==0){
            return ["errno"=>400, "error"=>"Usuario no registrado"];
        }

        $usuarioDB=$response[0];
        $hashAlmacenado=$usuarioDB["contraseña"];
        $accesoValido=false;

        // --- CONTRASEÑAS HASHEADAS ---
        if(password_verify($this->password, $hashAlmacenado)){
            $accesoValido=true;

            if(password_needs_rehash($hashAlmacenado, PASSWORD_DEFAULT)){
                $nuevoHash=password_hash($this->password, PASSWORD_DEFAULT);
                $update="UPDATE usuarios_app_estacion SET contraseña='".$nuevoHash."' WHERE email='".$this->email."' LIMIT 1";
                $this->ejecutar($update);
            }

        } else {

            // --- SOPORTE A CONTRASEÑAS SIN HASH ---
            $info=password_get_info($hashAlmacenado);

            if($info['algo']===0 && $hashAlmacenado===$this->password){
                $accesoValido=true;

                $nuevoHash=password_hash($this->password, PASSWORD_DEFAULT);
                $update="UPDATE usuarios_app_estacion SET contraseña='".$nuevoHash."' WHERE email='".$this->email."' LIMIT 1";
                $this->ejecutar($update);
            }
        }

        if(!$accesoValido){
            return ["errno"=>401, "error"=>"Contraseña incorrecta"];
        }

        // VALIDACIÓN de cuenta activa
        if((int)$usuarioDB["activo"]!==1){
            return ["errno"=>403, "error"=>"Debes verificar tu email para ingresar."];
        }

        // Enviar notificación
        $mailer=new Mailer();
        $token=$usuarioDB["token"];
        $mailEnviado=$mailer->loginNotiEmail($this->email, $token);

        if(!$mailEnviado){
            return ["errno"=>500, "error"=>"No se pudo enviar el email de notificación"];
        }

        return [
            "errno"=>202,
            "error"=>"Acceso válido",
            "id_usuario"=>$usuarioDB["id"]
        ];
    }


    public function register($form){

        $this->name=$form['txt_name'];
        $this->email=$form['txt_email'];
        $this->password=$form['txt_password'];

        if(strlen($this->name)==0){
            return ["errno"=>404, "error"=>"Falta nombre"];
        }

        if(strlen($this->email)==0){
            return ["errno"=>404, "error"=>"Falta email"];
        }

        if(strlen($this->password)==0){
            return ["errno"=>404, "error"=>"Falta contraseña"];
        }

        // Verificar email repetido
        $sql="SELECT * FROM usuarios_app_estacion WHERE email='".$this->email."'";
        $response=$this->consultar($sql);

        if(count($response)>0){
            return ["errno"=>400, "error"=>"El usuario ya existe"];
        }

        $hash=password_hash($this->password, PASSWORD_DEFAULT);
        $token=bin2hex(random_bytes(32));
        $ahora=date('Y-m-d H:i:s');

        // INSERT
        $insert="
            INSERT INTO usuarios_app_estacion 
            (token, email, nombres, contraseña, activo, bloqueado, recupero, token_action, add_date) 
            VALUES (
                '".$token."', '".$this->email."', '".$this->name."', '".$hash."', 
                0, 0, 0, '".$token."', '".$ahora."'
            )
        ";

        $ok=$this->ejecutar($insert);

        if(!$ok){
            return ["errno"=>500, "error"=>"Error interno al registrar usuario"];
        }

        // Enviar email de verificación
        $mailer=new Mailer();
        $mailEnviado=$mailer->verifyEmail($this->email, $token);

        if(!$mailEnviado){
            return ["errno"=>500, "error"=>"No se pudo enviar el email de verificación"];
        }

        return ["errno"=>201, "error"=>"OK"];
    }

    public function verifyEmail($email, $token){
        $sql = "
            SELECT *
            FROM usuarios_app_estacion
            WHERE email = '".$email."'
            AND token_action = '".$token."'
            LIMIT 1
        ";

        $res = $this->consultar($sql);

        if(count($res) === 1){
            $update = "
                UPDATE usuarios_app_estacion
                SET activo = 1,
                    active_date = '".date('Y-m-d H:i:s')."',
                    token_action = NULL
                WHERE email = '".$email."'
                LIMIT 1
            ";

            $this->ejecutar($update);

            return "Cuenta verificada correctamente. Ya podés iniciar sesión.";
        } else {
            return "Enlace inválido o token expirado.";
        }
    }

    public function blocked($token){
        $sql = "SELECT * FROM usuarios_app_estacion WHERE token = '".$token."' LIMIT 1";
        $res = $this->consultar($sql);

        if(count($res) !== 1){
            return "El token no corresponde a un usuario.";
        }

        $tokenAction = bin2hex(random_bytes(32));

        $update = "
            UPDATE usuarios_app_estacion
            SET activo = 0,
                bloqueado = 1,
                blocked_date = '".date('Y-m-d H:i:s')."',
                token_action = '".$tokenAction."'
            WHERE token = '".$token."'
            LIMIT 1
        ";

        $this->ejecutar($update);

        return $tokenAction;
    }



    public function recovery($email){
        $sql = "SELECT * FROM usuarios_app_estacion WHERE email = '".$email."' LIMIT 1";
        $res = $this->consultar($sql);

        if(count($res) !== 1){
            return "El email no corresponde a un usuario. Click <a href='?slug=register'> aqui </a> para registrarse.";
        }

        $token = bin2hex(random_bytes(32));

        $update = "
            UPDATE usuarios_app_estacion
            SET recupero = 1,
                recover_date = '".date('Y-m-d H:i:s')."',
                token_action = '".$token."'
            WHERE email = '".$email."'
            LIMIT 1
        ";

        $this->ejecutar($update);

        return "Por favor revise su mail para continuar con el cambio de contraseña";
    }


    public function reset($token, $pass){
        $sql = "SELECT * FROM usuarios_app_estacion WHERE token_action = '".$token."' LIMIT 1";
        $res = $this->consultar($sql);

        if (count($res) !== 1){
            return "El token es invalido o esta expirado.";
        }

        $email = $res[0]['email'];

        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $update = "
            UPDATE usuarios_app_estacion 
            SET contraseña = '".$hash."',
                token_action = NULL,
                bloqueado = 0,
                recupero = 0,
                activo = 1
            WHERE token_action = '".$token."' 
            LIMIT 1
        ";

        $ok = $this->ejecutar($update);

        $mailer=new Mailer();
        $mailer->resetEmail($email);

        if(!$ok){
            return ["No se pudo cambiar la contraseña"];
        }
    }
}
?>