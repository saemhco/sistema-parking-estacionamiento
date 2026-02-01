<?php

require_once '../config/email_config.php';

use PHPMailer\PHPMailer\Exception;

try {
    $mail = getMailer();
    $emailUser = trim($_REQUEST['emailUser']);
    $IdReserva = trim($_REQUEST['IdReserva']);
    $mail->addAddress($emailUser, '');
    //Asunto                             
    $mail->Subject = 'Parking';
    $mail->Body .= "<section style='margin-top: 10px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>En <strong style='color:#ff6d0c;'> Parking</strong> le damos la bienvenida y estamos encantados de tenerte como nuestro cliente.</p>";
    $mail->Body .= "<p>Para acceder a tu reserva y obtener más detalles, puedes descargarla haciendo clic en el siguiente enlace:</p><br><br>";
    $mail->Body .= "</section>";

    $mail->Body .= "<section style='margin-top: 50px; margin-bottom: 70px; font-size: 18px; line-height: 7px;'>";
    $mail->Body .= "<p>Gracias de nuevo por elegir <strong style='color:#ff6d0c;'>Parking</strong>.</p>";
    $mail->Body .= "<p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos.</p>";
    $mail->AltBody = '<p>¡Esperamos que tengas una experiencia increíble!</p>';
    $mail->Body .= "</section>";

    if (!$mail->send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
        header("location:../dashboard/?successR=1");
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: " . $e->getMessage();
}
