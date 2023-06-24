<?php

require('connection/conn.php');

session_start();

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


if(isset($_POST["submit"])){
    $accno = test_input($_POST['accno']);
    $pass = test_input($_POST['pass']);

    $query = 'Select * from accounts where accno= "' .$accno.'" and pass= "'.$pass.'" ';
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if($count > 0){
        $_SESSION["accno"] = $accno;
        header("Location: dashboard.php");
    }else{
        echo '<script>alert("Invalid Account number or password")</script>';
    }
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <!--CSS -->
    <link rel="stylesheet" href="./CSS/login.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&family=Roboto+Slab&display=swap" rel="stylesheet">
</head>

<body>
    <div class="login-form">
        <form action="login.php" method="post">
            <h2>Welcome!</h2>

            <div class="group">
                <div class="title">Account number</div>
                <input type="text" placeholder="Enter account number" class="uname" name="accno">
            </div>

            <div class="group">
                <div class="title">Password</div>
                <input type="password" placeholder="Enter your password" maxlength="6" class="pass" name="pass">
            </div>

            <input type="submit" value="Login"  name="submit" class="login-btn">

            <div>Don't Have an account? &nbsp;<a href="./createAcc.php">Create account</a></div>
            <div><a href="./forgot.php">Forgot password?</a></div>

        </form>
    </div>
</body>

</html>