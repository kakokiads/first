<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// Validate email format
function isEmail($email) {
    return (preg_match("/^[-_.[:alnum:]]+@([a-z0-9-]+\.)+[a-z]{2,6}$/i", $email));
}

// Capture form data
$name     = $_POST['name'];
$subject  = $_POST['subject'];
$email    = $_POST['email'];
$comments = $_POST['comments'];

// Basic validation
if(trim($name) == '') {
    echo '<div class="error_message">You must enter your name.</div>';
    exit();
} else if(trim($email) == '') {
    echo '<div class="error_message">Please enter a valid email address.</div>';
    exit();
} else if(!isEmail($email)) {
    echo '<div class="error_message">You have entered an invalid e-mail address.</div>';
    exit();
} else if(trim($comments) == '') {
    echo '<div class="error_message">Please enter your message.</div>';
    exit();
}

// PHPMailer configuration
$mail = new PHPMailer(true);

try {
    // SMTP Settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kakokicreativeco@gmail.com';         // ✅ Your Gmail
    $mail->Password   = 'ywmpgffovqzbmsfu';      // ✅ Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Email content
    $mail->setFrom($email, $name);
    $mail->addAddress('kakokicreativeco@gmail.com');  // ✅ Receiver email

    $mail->Subject = $subject ?: 'New Contact Form Submission';
    $mail->Body    = "Name: $name\nEmail: $email\n\nMessage:\n$comments";

    $mail->send();

    echo "<fieldset><div id='success_page'>
    <h3>Email Sent Successfully.</h3>
    <p>Thank you <strong>$name</strong>, your message has been submitted.</p>
    </div></fieldset>";

} catch (Exception $e) {
    echo "<fieldset><div id='error_page'>
    <h3>Oops! Something went wrong.</h3>
    <p>Mailer Error: {$mail->ErrorInfo}</p>
    </div></fieldset>";
}
?>
