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

$query = "Select * from accounts order by accno desc";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);
$accno = "";

if (isset($_POST["submit"])) {
    $fname = test_input($_POST['fname']);
    $lname = test_input($_POST['lname']);
    $dob = test_input($_POST['dob']);
    $pnum = test_input($_POST['pnum']);
    $email = test_input($_POST['mail']);
    $city = test_input($_POST['city']);
    $pass = test_input($_POST['pass']);

    if (empty($row)) {
        $accno = "SKYBNK00001";
    } else {
        $lastid = $row["accno"];
        $start = str_replace("SKYBNK", "", $lastid);
        $id = str_pad($start + 1, 5, 0, STR_PAD_LEFT);
        $accno = "SKYBNK" . $id;
    }

    $sql = "INSERT INTO accounts (accno,fname,lname,dob,pnum,mail,city,pass,depo,trans) 
        VALUES ('" . $accno . "','" . $fname . "','" . $lname . "','" . $dob . "','" . $pnum . "','" . $email . "','" . $city . "','" . $pass . "',498,2)";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Congratulations! Account no: ' . $accno . '")</script>';
    }

    //Sending email
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'srbera17@gmail.com';
    $mail->Password   = 'hgbictgnarokecxi';
    $mail->SMTPSecure = "ssl";
    $mail->Port       = 465;

    $mail->setFrom('srbera17@gmail.com','Sky Bank');

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = "Congratulations on creating account with Sky Bank";

    $bodyContent = "<h2>Your account details</h2>Account no.: $accno <br> Password: $pass";

    $mail->Body = $bodyContent;

    $mail->send();
    // INSERT INTO `accounts` (`accno`, `fname`, `lname`, `dob`, `pnum`, `mail`, `city`, `pass`, `depo`, `trans`) VALUES ('', '', '', '', '', '', '', '', '', '')
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <!--CSS -->
    <link rel="stylesheet" href="./CSS/createAcc.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&family=Roboto&display=swap" rel="stylesheet">

</head>

<body>
    <div class="reg-form">

        <form action="" method="post">
            <h2>Create account</h2>
            <div class="details">

                <div class="fields">
                    <div class="input-fields">
                        <label>First Name</label>
                        <input type="text" placeholder="Enter First Name" class="fname" name="fname" pattern="[a-zA-Z]+" required>
                    </div>
                    <div class="input-fields">
                        <label>Last Name</label>
                        <input type="text" placeholder="Enter Last Name" class="lname" name="lname" pattern="[a-zA-Z]+" required>
                    </div>

                    <div class="input-fields">
                        <label>Date of birth</label>
                        <input type="date" placeholder="Enter your birthdate" name="dob" class="dob" required>
                    </div>


                    <div class="input-fields">
                        <label>Phone number</label>
                        <input type="tel" placeholder="Enter your number" class="num" name="pnum" maxlength="10" pattern="[0-9]{10}" required>
                    </div>

                    <div class="input-fields">
                        <label>Email</label>
                        <input type="email" placeholder="Enter your email" class="mail" name="mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                    </div>

                    <div class="input-fields">
                        <label>City</label>
                        <input type="text" placeholder="Enter your city" class="city" name="city" pattern="[A-za-z]+" required>
                    </div>

                    <div class="input-fields">
                        <label>Password</label>
                        <input type="password" placeholder="Enter password" maxlength="6" name="pass" class="pass" pattern="[0-9]{6}" required>
                    </div>


                    <input type="submit" value="Create Account" name="submit" class="acc-btn">



                </div>
                <div class="check">Already have an account?&nbsp;<a href="./login.php">login</a></div>

            </div>
        </form>

    </div>
</body>

</html>