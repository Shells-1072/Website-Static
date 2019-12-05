<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//check if form was sent
if ($_POST) {
    // $to = "nicmaxcarter@gmail.com";
    $to = "info@shellssgi.com";
    $email_bcc = "codobitdev@gmail.com";
    $subject = "Contact Form Submission";
    $name = $_POST["First-Name"] . " " . $_POST["Last-Name"];
    $email = $_POST["Email"];
    $phone = $_POST["Phone"];
    $message = $_POST["message"];

    $content = "Submission to shellssgi.com" . "\r\n" .
        "Name: " . $name . "\n" .
        "Email: " . $email . "\n" .
        "Phone: " . $phone . "\n\n" .
        "Message: " . $message . "\n";

    //honey pot field
    $honeypot = $_POST["firstname"];
    //check if the honeypot field is filled out. If not, send a mail.
    if (strlen($honeypot) > 0) {
        echo 'error';
    } else {

        $headers = 'From: ' . $name . '<' . $email . '>' . "\r\n" .
        'BCC: codobitdev@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        // Send
        mail($to, $subject, $content, $headers);

        // Redirect to a thank you page
        header('Location: ./contact-thank-you.html');

    }
}
