<?php

/**
 * Configuración centralizada de PHPMailer para envío de correos
 * 
 * Pasos para Gmail:
 * 1. Usa tu correo de Gmail
 * 2. Genera una "Clave de aplicación" en: https://myaccount.google.com/security
 *    (Activa la verificación en 2 pasos antes)
 * 3. Usa esa clave como contraseña (no tu contraseña normal)
 */

require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$GLOBALS['email_config'] = [
    // Servidor SMTP
    'host'       => 'smtp.gmail.com',
    'port'       => 587,
    'secure'     => 'tls',  // 'tls' o 'ssl' (ssl usa puerto 465)
    'auth'       => true,

    // Credenciales - Reemplaza con tus datos reales
    'username'   => 'tucorreo@gmail.com',
    'password'   => 'tuclavedeseguridad',  // Usa clave de aplicación para Gmail

    // Remitente por defecto
    'from_email' => 'programadorphp2017@gmail.com',
    'from_name'  => 'Parking',

    // Reply-To y CC opcionales
    'reply_to'   => 'info@alcvaletparking.com',
    'reply_name' => 'Information',
    'cc_copy'    => 'urian1213viera@gmail.com',

    // Charset
    'charset'    => 'UTF-8',
];

/**
 * Devuelve una instancia de PHPMailer ya configurada con SMTP
 * @return PHPMailer
 */
function getMailer()
{
    $cfg = $GLOBALS['email_config'];
    $mail = new PHPMailer(true);
    $mail->setLanguage('es');
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host       = $cfg['host'];
    $mail->SMTPAuth   = $cfg['auth'];
    $mail->Username   = $cfg['username'];
    $mail->Password   = $cfg['password'];
    $mail->SMTPSecure = $cfg['secure'];
    $mail->Port       = $cfg['port'];
    $mail->CharSet    = $cfg['charset'];
    $mail->setFrom($cfg['from_email'], $cfg['from_name']);
    $mail->addReplyTo($cfg['reply_to'], $cfg['reply_name']);
    if (!empty($cfg['cc_copy'])) {
        $mail->addCC($cfg['cc_copy']);
    }
    $mail->isHTML(true);
    return $mail;
}
