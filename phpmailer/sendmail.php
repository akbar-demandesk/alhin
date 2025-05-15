<?php
// Load environment variables
$env = parse_ini_file('.env');

// Get form data from POST
$Name     = $_POST['Name'] ?? '';
$Email    = $_POST['Email'] ?? '';
$Mobile   = $_POST['Mobile'] ?? '';
$Message1 = $_POST['Message'] ?? '';

// Prepare the email HTML content
$htmlBody = "<h3>Contact Us</h3>";
$htmlBody .= "<table border='1' rules='all' style='font-size:13px; color:#666;' cellpadding='5' cellspacing='5'>";
$htmlBody .= "<tr><td>Name:</td><td>$Name</td></tr>";
$htmlBody .= "<tr><td>Email:</td><td>$Email</td></tr>";
$htmlBody .= "<tr><td>Mobile:</td><td>$Mobile</td></tr>";
$htmlBody .= "<tr><td>Business Query:</td><td>$Message1</td></tr></table>";

$subject = "Contact us | ALHIN Website";

// Include PHPMailer (older version you're using)
require 'phpmailer/class.phpmailer.php';
require 'phpmailer/class.smtp.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $env['SMTP_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $env['SMTP_USER'];
    $mail->Password   = $env['SMTP_PASS'];
    $mail->SMTPSecure = 'tls'; // use 'ssl' if you're on port 465
    $mail->Port       = $env['SMTP_PORT'];

    $mail->setFrom($env['SMTP_USER'], 'ALHIN GLOBAL');
    $mail->addAddress($env['TO_EMAIL']);
    $mail->AddCC('haadi.shaikh@alhin.in', 'Haadi Shaikh');

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $htmlBody;

    if ($mail->send()) {
        echo "Mail sent successfully.";
    } else {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Exception while sending mail: " . $mail->ErrorInfo;
}
?>
