<?php
declare(strict_types=1);

/**
 * sendMail.php  (file is inside /phpmailer ; project root holds /vendor)
 * --------------------------------------------------------------
 * Expects POST: Name, Email, Mobile, Message
 * Reads SMTP credentials from .env (INI format) in project root.
 * Returns JSON { success: bool, message?: string }
 */

require_once __DIR__ . '/../vendor/autoload.php';   // ← one level up!
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

// --------------------------------------------------
// 1. Load & validate environment
// --------------------------------------------------
$envPath = dirname(__DIR__) . '/.env';
if (!is_readable($envPath)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => '.env missing']);
    exit;
}
$env = parse_ini_file($envPath, false, INI_SCANNER_TYPED);  // keeps ints int :contentReference[oaicite:0]{index=0}

foreach (['SMTP_HOST','SMTP_PORT','SMTP_USER','SMTP_PASS','TO_EMAIL'] as $key) {
    if (empty($env[$key])) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => "Env key $key missing"]);
        exit;
    }
}

// --------------------------------------------------
// 2. Sanitise & validate input
// --------------------------------------------------
$input = filter_input_array(INPUT_POST, [
    'Name'    => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
    'Email'   => FILTER_VALIDATE_EMAIL,
    'Mobile'  => FILTER_SANITIZE_NUMBER_INT,
    'Message' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
]);

if (!$input ||
    $input['Name']    === '' ||
    $input['Email']   === false ||
    !preg_match('/^\d{10}$/', $input['Mobile']) ||
    $input['Message'] === ''
) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => 'Validation failed']);
    exit;
}

['Name'=>$name, 'Email'=>$email, 'Mobile'=>$mobile, 'Message'=>$message] = $input;

// --------------------------------------------------
// 3. Build the HTML body
// --------------------------------------------------
$body = <<<HTML
  <h2>New Contact Enquiry</h2>
  <table cellpadding="6" cellspacing="0" border="1">
    <tr><th align="left">Name</th><td>{$name}</td></tr>
    <tr><th align="left">Email</th><td>{$email}</td></tr>
    <tr><th align="left">Mobile</th><td>{$mobile}</td></tr>
    <tr><th align="left">Message</th><td>{$message}</td></tr>
  </table>
  <p style="font-size:12px;color:#666">Sent from the ALHIN website contact form.</p>
HTML;

// --------------------------------------------------
// 4. Send with PHPMailer
// --------------------------------------------------
$mail = new PHPMailer(true);

try {
    // SMTP
    $mail->isSMTP();
    $mail->Host       = $env['SMTP_HOST'];
    $mail->Port       = (int)$env['SMTP_PORT'];
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // TLS :contentReference[oaicite:1]{index=1}
    $mail->Username   = $env['SMTP_USER'];
    $mail->Password   = $env['SMTP_PASS'];
    $mail->CharSet    = 'UTF-8';
    // $mail->SMTPDebug = PHPMailer::DEBUG_SERVER;      // uncomment for verbose logs

    // Recipients
    $mail->setFrom($env['SMTP_USER'], 'ALHIN GLOBAL Website');
    $mail->addAddress($env['TO_EMAIL']);
    $mail->addReplyTo($email, $name);
    if (!empty($env['CC_EMAIL'])) {
        $mail->addCC($env['CC_EMAIL']);
    }

    // Content
    $mail->isHTML(true);
    $mail->Subject = "Contact enquiry: {$name}";
    $mail->Body    = $body;

    $mail->send();
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    error_log('Mailer Error: '.$mail->ErrorInfo);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Mail sending failed']);
}