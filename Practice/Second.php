<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "testing";


$conn = mysqli_connect($servername, $username, $password, $dbname);

session_start();

if (isset($_POST["submit"])) {
    // $query = "Select Id from accounts order by Id desc";
    // $_SESSION['variable_name'] = variable_value;

    $query = "Select * from accounts";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result);
    $accno = "";
    $lastid = "";

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $pnum = $_POST['pnum'];

    if (empty($row)) {
        $accno = "SKYBNK00001";
        $_SESSION['accno'] = $accno;
        header("Location: First.php");
    } else {
        $lastid = $row["Id"];
        $start = str_replace("SKYBNK", "", $lastid);
        $id = str_pad($start + 1, 5, 0, STR_PAD_LEFT);
        $accno = "SKYBNK" . $id;
        $_SESSION['accno'] = $accno;
        $sql = "INSERT INTO accounts (Id,Fname,Lname,Pnum) VALUES ('" . $accno . "','" . $fname . "','" . $lname . "','" . $pnum . "')";
    }


    if(isset($var)){
        echo "isset";
    }else{
        echo "not set";
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script type="text/javascript">
        function jsFunction(a) {
            alert('Account created for ' + a);
        }
    </script>
</head>

<body>
    <form action="Second.php" method="post">
        <label for="">First name: </label>
        <input type="text" name="fname" id="fname"> <br>
        <label for="">Last name: </label>
        <input type="text" name="lname" id="lname"> <br>
        <label for="">Phone number</label>
        <input type="text" name="pnum" id="pnum"> <br>
        <button id="submit" name="submit">Send</button>
    </form>

    <a href="#"name="link"><?php $var = "hello"?>CLICK</a><br>
    Number of click&nbsp;0
</body>

</html>
<!-- INSERT INTO `accounts` (`Id`, `Fname`, `Lname`, `Pnum`) VALUES ('SBA0000001', 'Sumanraj', 'Bera', '8879919058') -->