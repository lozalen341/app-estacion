<?php

class Mailer {

    private function loadPHPMailer() {

        $cred=__DIR__.'/../librarys/phpMailer/credenciales.php';
        $baseMailerPath=__DIR__.'/../librarys/phpMailer/Mailer/src/';

        @include_once $cred;
        @include_once $baseMailerPath.'PHPMailer.php';
        @include_once $baseMailerPath.'SMTP.php';
        @include_once $baseMailerPath.'Exception.php';

        if(!class_exists('PHPMailer\PHPMailer\PHPMailer')){
            return false;
        }

        return new \PHPMailer\PHPMailer\PHPMailer();
    }


    private function getBaseURL() {

        return
            (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http')
            ."://"
            .($_SERVER['HTTP_HOST'] ?? 'localhost')
            .dirname($_SERVER['REQUEST_URI'] ?? '/');
    }


    public function verifyEmail($email, $token) {

        $mail=$this->loadPHPMailer();
        if(!$mail){ return false; }

        $link=$this->getBaseURL()."?slug=verify&email=".urlencode($email)."&token=".urlencode($token);

        $subject='Activa tu cuenta en ClimaLink';

        ob_start();
        include __DIR__.'/../views/mails/verifyEmail.tpl.php';
        $body=ob_get_clean();

        return $this->sendMail($mail, $email, $subject, $body);
    }


    public function loginNotiEmail($email, $token) {

        $mail=$this->loadPHPMailer();
        if(!$mail){ return false; }

        $userAgent=$_SERVER['HTTP_USER_AGENT'];
        $ip=$_SERVER['REMOTE_ADDR'];

        $SO=preg_match('/Windows|Linux|mac/i', $userAgent, $somatch) ? $somatch[0] : "SO desconocido";
        $browser=preg_match('/firefox|chrome|brave|edge|opera/i', $userAgent, $navmatch) ? $navmatch[0] : "Navegador desconocido";

        $info="$SO ($browser)";

        $link=$this->getBaseURL()."?slug=blocked&token=".urlencode($token);
        $subject='Se inicio sesion con tu usuario';

        ob_start();
        include __DIR__.'/../views/mails/loginNotify.tpl.php';
        $body=ob_get_clean();

        return $this->sendMail($mail, $email, $subject, $body);
    }

    public function blockedEmail($email, $tokenAction){
        $mail = $this->loadPHPMailer();
        if(!$mail){ return false; }

        $subject = 'Tu cuenta ha sido bloqueada';
        $link = $this->getBaseURL() . "?slug=reset&token_action=" . $tokenAction;

        ob_start();
        include __DIR__.'/../views/mails/blockedEmail.tpl.php';
        $body = ob_get_clean();

        return $this->sendMail($mail, $email, $subject, $body);
    }

    public function recoveryEmail($email){

        $mail=$this->loadPHPMailer();
        if(!$mail){ return false; }

        $db = new DBAbstract();
        $sql = "SELECT token_action FROM usuarios_app_estacion WHERE email='".$email."' LIMIT 1";
        $res = $db->consultar($sql);

        if(count($res) !== 1){
            return false;
        }
        $token = $res[0]['token_action'];

        $subject = 'Recuperar contraseña';
        $link=$this->getBaseURL()."?slug=reset&token_action=".$token;

        ob_start();
        include __DIR__.'/../views/mails/recoveryEmail.tpl.php';
        $body=ob_get_clean();

        return $this->sendMail($mail, $email, $subject, $body);

    }

    public function resetEmail($email){
        $mail = $this->loadPHPMailer();
        if(!$mail){ return false; }

        $userAgent=$_SERVER['HTTP_USER_AGENT'];
        $ip=$_SERVER['REMOTE_ADDR'];

        $SO=preg_match('/Windows|Linux|mac/i', $userAgent, $somatch) ? $somatch[0] : "SO desconocido";
        $browser=preg_match('/firefox|chrome|brave|edge|opera/i', $userAgent, $navmatch) ? $navmatch[0] : "Navegador desconocido";

        $info="$SO ($browser)";

        $db = new DBAbstract();
        $sql = "SELECT token FROM usuarios_app_estacion WHERE email='".$email."' LIMIT 1";
        $res = $db->consultar($sql);
        $token = $res[0]['token'];


        $link=$this->getBaseURL()."?slug=blocked&token=".urlencode($token);

        $subject = 'Se restablecio su contraseña';

        ob_start();
        include __DIR__.'/../views/mails/resetEmail.tpl.php';
        $body = ob_get_clean();

        return $this->sendMail($mail, $email, $subject, $body);
    }

    private function sendMail($mail, $email, $subject, $body) {

        try {

            $mail->isSMTP();
            $mail->SMTPDebug=0;

            $mail->Host=HOST;
            $mail->Port=PORT;
            $mail->SMTPAuth=SMTP_AUTH;
            $mail->SMTPSecure=SMTP_SECURE;

            $mail->Username=REMITENTE;
            $mail->Password=PASSWORD;

            $mail->setFrom(REMITENTE, NOMBRE);
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject=$subject;
            $mail->Body=$body;

            return $mail->send();

        } catch(Exception $e){
            return false;
        }
    }

}
