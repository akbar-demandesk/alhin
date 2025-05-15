<?php

// Get data from POST request
$Name = $_POST['Name'];
$Email = $_POST['Email'];
$Mobile = $_POST['Mobile'];
$Message1 = $_POST['Message'];

// Prepare the HTML message for email
$message = "<h3>Contact Us</h3>";
$message .= "<table border='1' rules='all' style='font-size:13px; color:#666;' cellpadding='5' cellspacing='5'>";
$message .= "<tr><td>Name:</td><td>".$Name."</td></tr>";
$message .= "<tr><td>Email Id:</td><td>".$Email."</td></tr>";
$message .= "<tr><td>Mobile No:</td><td>".$Mobile."</td></tr>"; 
$message .= "<tr><td>Business Query :</td><td>".$Message1."</td></tr></table>";

$subject = "Contact us | ALHIN Website";
$to = "Resume@alhin.in"; // Change this to the appropriate recipient email

// Call the sendMail function to send the email
if (sendMail($to, $subject, $message)) {
    echo "Mail Sent.";
} else {
    echo "Mailer Error.";
}

// Save the data into MySQL database
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "Alhin"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // If connection fails, display error message
} else {
    echo "Database connected successfully!"; // If connection is successful, display success message
}

// Prepare SQL query to insert data into the database
$sql = "INSERT INTO form_submissions (name, email, mobile, message)
        VALUES ('$Name', '$Email', '$Mobile', '$Message1')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully into the database.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

// Function to send the email
function sendMail($email, $subject, $html) {
    require("phpmailer/class.phpmailer.php");
    $mail = new PHPMailer();
    
    // Set SMTP configuration
    $mail->SMTPDebug = 1; // Enable SMTP debugging for testing
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // Use SSL for SMTP
    $mail->Host = "smtp.gmail.com"; // SMTP server
    $mail->Port = 465; // SMTP port
    $mail->Username = "support@clearwatercraft.com"; // Gmail username (change to your local email if needed)
    $mail->Password = "Support1987"; // Gmail password (change to your local password if needed)

    $mail->SetFrom('support@clearwatercraft.com', 'ALHIN GLOBAL');
    $mail->addAddress('juned456@gmail.com', 'Juned Sayyed');
    $mail->AddCC('haadi.shaikh@alhin.in', 'Haadi Shaikh');
    
    $mail->Subject = $subject;
    $mail->msgHTML($html);
    
    if (!$mail->send()) {
        return false; // Return false if mail fails to send
    }
    return true; // Return true if mail sent successfully
}

?>
