<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bank";


$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Connection to server failed! Please try again later ". mysqli_connect_error());
}

?>
