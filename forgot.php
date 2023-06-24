<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require('connection/conn.php');


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["submit"])) {
    $accno = test_input($_POST['accno']);

    $query = "Select * from accounts where accno = '" . $accno . "'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
    $row = mysqli_fetch_array($result);

    if ($count > 0) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'srbera17@gmail.com';
        $mail->Password   = 'hgbictgnarokecxi';
        $mail->SMTPSecure = "ssl";
        $mail->Port       = 465;

        $mail->setFrom('srbera17@gmail.com', 'Sky Bank');

        $mail->addAddress($row["mail"]);

        $mail->isHTML(true);

        $mail->Subject = "Email sent for forgotten account details";

        $bodyContent = "<h2>Your account details</h2>Account no.:".$row["accno"]." <br> Password: ". $row["pass"];

        $mail->Body = $bodyContent;

        $mail->send();

        echo '<script>alert("Email sent please check your inbox!")</script>';
    } else {
        echo '<script>alert("There is no such account")</script>';
    }
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <!--CSS -->
    <link rel="stylesheet" href="./CSS/forgot.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto+Slab&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-form">
        <form action="forgot.php" method="post">
            <h2>Forgot your password</h2>
            <div class="group">
                <div class="title">Account number</div>
                <input type="text" placeholder="Enter account number" class="uname" name="accno">
            </div>

            <input type="submit" value="Send details through mail" name="submit" class="login-btn">
            <div>Don't Have an account? &nbsp;<a href="./createAcc.php">Create account</a></div>
            <div class="check">Already have an account?&nbsp;<a href="./login.php">login</a></div>

        </form>
    </div>
</body>

</html>