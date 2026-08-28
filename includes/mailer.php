<?php

require_once __DIR__ . '/../class.phpmailer.php';
require_once __DIR__ . '/../class.smtp.php';

/**
 * Sends an HTML email through the bundled (legacy but functional) PHPMailer
 * using SMTP credentials from environment variables. Older versions of this
 * codebase had real Gmail credentials hard-coded in several files
 * (admin/manageuser.php, resetpass.php, user/forgetpassword.php) - those
 * must be rotated; nothing here falls back to them.
 *
 * Returns true on success. On failure (or when mail is not configured at
 * all) the reason is logged and false is returned - callers must not treat
 * a false return as a fatal error, since local/dev environments routinely
 * have no SMTP server available.
 */
function send_mail(string $toEmail, string $subject, string $htmlBody): bool
{
    $host = getenv('MAIL_HOST');
    $username = getenv('MAIL_USERNAME');
    $password = getenv('MAIL_PASSWORD');

    if (!$host || !$username || !$password) {
        error_log('send_mail: MAIL_HOST/MAIL_USERNAME/MAIL_PASSWORD are not configured; skipping send to ' . $toEmail);

        return false;
    }

    $fromAddress = getenv('MAIL_FROM_ADDRESS') ?: $username;
    $fromName = getenv('MAIL_FROM_NAME') ?: 'WanderTrail';
    $port = (int)(getenv('MAIL_PORT') ?: 587);
    $encryption = getenv('MAIL_ENCRYPTION') ?: 'tls';

    $mail = new PHPMailer();

    try {
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = $encryption;
        $mail->Host = $host;
        $mail->Port = $port;
        $mail->IsHTML(true);
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SetFrom($fromAddress, $fromName);
        $mail->Subject = $subject;
        $mail->Body = $htmlBody;
        $mail->AddAddress($toEmail);

        if (!$mail->Send()) {
            error_log('send_mail: PHPMailer failed for ' . $toEmail . ': ' . $mail->ErrorInfo);

            return false;
        }

        return true;
    } catch (\Throwable $e) {
        error_log('send_mail: exception sending to ' . $toEmail . ': ' . $e->getMessage());

        return false;
    }
}

/**
 * True for requests coming from the local WAMP machine itself. Used only to
 * decide whether it's safe to show a not-actually-emailed link on screen as
 * a development convenience when MAIL_* env vars are not configured.
 */
function is_local_request(): bool
{
    $remote = $_SERVER['REMOTE_ADDR'] ?? '';

    return in_array($remote, ['127.0.0.1', '::1'], true);
}
