<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>HEllo</h1>
    <p> <?php 
    session_start();  
    define("dick",32);
    echo "This is printed using php <br>";
     $var = 34; $var2 = 35;
     echo $var + $var2;
     echo "<br>";
     echo dick;

     $language = array("Python","Mapping","Fan");

     $a = 0;
     while($a < count($language) ){
        echo "Array contents: $language[$a] <br>";
        $a++;
     }
     echo '<script>alert("Account created: '.$_SESSION['accno'].'")</script>';
    ?></p>
</body>
</html>