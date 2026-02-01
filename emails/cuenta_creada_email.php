<?php

require_once '../config/email_config.php';

use PHPMailer\PHPMailer\Exception;

try {
    $mail = getMailer();
    $emailUser = trim($_REQUEST['emailUser']);
    $mail->addAddress($emailUser, '');
    //Asunto                             
    $mail->Subject = 'Parking';
    $mail->Body .= "<section style='margin-top: 10px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>En <strong style='color:#ff6d0c;'>Parking</strong> le damos la bienvenida y estamos encantados de tenerte como nuestro cliente.</p>";
    $mail->Body .= "<p>Tu cuenta se ha creado exitosamente.</p>";
    $mail->Body .= "<p>Para acceder con tu cuenta a la plataforma, haga clic en el siguiente enlace:</p><br>";
    $mail->Body .= "<a href='https://parking.com/app/' style='background: #ff6d0c; font-size:15px; padding: 10px 20px; border-radius: 25px;text-decoration: unset; color:#fff;'>Acceder Ahora</a>";
    $mail->Body .= "</section>";

    $mail->Body .= "<section style='margin-top: 50px; margin-bottom: 70px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>Gracias de nuevo por elegir <strong style='color:#ff6d0c;'>Parking</strong>.</p>";
    $mail->Body .= "<p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>";
    $mail->Body .= '<p>¡Esperamos que tengas una experiencia increíble!</p>';
    $mail->Body .= "</section>";

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        header("location:../?successC=1");
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: " . $e->getMessage();
}
