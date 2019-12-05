<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (empty($_POST['submit'])) {
    echo "Form is not submitted!";
    exit;
}

if (empty($_POST["fname"]) || empty($_POST["lname"])) {
    echo "Please fill the form";
    exit;
}

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];

$to = "info@shellssgi.com";
$subject = "New Reservation Has Been Made!";

// $message = $fname+" "+$lname+"\n"
//     +$email+"\n"+$phone;

$message = "A new reservation has been made!
    \r\nName: $fname $lname
    \r\nEmail: $email
    \r\nPhone: $phone
    \r\nArrival Date: $startdate
    \r\nDeparture Date: $enddate";

// echo '<script>console.log("' . $message . '")</script>';
// echo $message;

//honey pot field
$honeypot = $_POST["firstname"];
//check if the honeypot field is filled out. If not, send a mail.
if (strlen($honeypot) > 0) {
    echo 'error';
} else {

    $servername = "";
    $username = "";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql= "INSERT INTO `reservation` (`first_name`, `last_name`, `email`, `start_date`, `end_date`) VALUES ('$fname', '$lname', '$email', '$startdate', '$enddate');";

        $conn->exec($sql);

    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $conn = null;

// In case any of our lines are larger than 70 characters, we should use wordwrap()
    // $message = wordwrap($message, 70, "\r\n");

    $headers = 'From: forms@codobit.com' . "\r\n" .
    'Reply-To: max.carter@codobit.com' . "\r\n" .
    'BCC: codobitdev@gmail.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Send
    mail($to, $subject, $message, $headers);

// Redirect to a thank you page
    header('Location: http://shellssgi.com/thank-you.html');
}
