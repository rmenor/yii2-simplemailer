<?php

namespace rmenor\simplemailer;

use PHPMailer\PHPMailer\PHPMailer;
use yii\base\Component;

/**
 * Example use:
 * Yii::$app->simplemailer->sendMail($email, $subject, $body);
 */

class Mailer extends Component
{

    public $host;
    public $username;
    public $password;
    public $port = 587;
    public $encryption = PHPMailer::ENCRYPTION_STARTTLS;
    public $fromEmail;
    public $fromName;

    public function sendMail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = $this->host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->username;
            $mail->Password   = $this->password;
            $mail->SMTPSecure = $this->encryption;
            $mail->Port       = $this->port;

            // Destinatarios
            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($to);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Enviar el correo
            $response = $mail->send();

            if ($response) {
                return [
                    'success' => true,
                    'message' => 'El mensaje fue enviado'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'El mensaje no pudo ser enviado. Error: ' . $mail->ErrorInfo
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'El mensaje no pudo ser enviado. Error: ' . $mail->ErrorInfo
            ];
        }
    }
}
