<?php

$Name=$_POST['Name'];

$Email=$_POST['Email'];

$Mobile=$_POST['Mobile'];

$Message1=$_POST['Message'];


  $message = "<h3>Contact Us</h3>";

  $message .= "<table border='1' rules='all' style='font-size:13px;clor:#666;' cellpadding='5' cellspacing='5'>";

  $message .= "<tr><td>Name:</td><td>".$Name."</td></tr>";

  $message .= "<tr><td>Email Id:</td><td>".$Email."</td></tr>";

  $message .= "<tr><td>Mobile No:</td><td>".$Mobile."</td></tr>"; 

  $message .= "<tr><td>Business Query :</td><td>".$Message1."</td></tr></table>";


 $subject = "Contact us | ALHIN Website";



$to = "Resume@alhin.in"; //"juned456@gmail.com";

echo sendMail($to, $subject, $message);

function sendMail($email, $subject, $html){
	require("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	//$mail->IsSMTP();
$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "support@clearwatercraft.com";  // GMAIL username
$mail->Password   = "Support1987";            // GMAIL password

$mail->SetFrom('support@clearwatercraft.com', 'ALHIN GLOBAL');
	$mail->addAddress('juned456@gmail.com' , 'Juned sayyed');
	$mail->AddCC('haadi.shaikh@alhin.in', 'haadi shaikh');
	
  $mail->Subject = $subject;
	$mail->msgHTML($html);



	if (!$mail->send())	{
	    echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else
	{
		echo "Mail Sent.";
	}

}



?>