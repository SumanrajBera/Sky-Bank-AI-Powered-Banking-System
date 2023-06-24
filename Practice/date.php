<?php

require('../connection/conn.php');

$graphQuery = "SELECT * FROM graph WHERE acc = 'SKYBNK00002'";
    $res = mysqli_query($conn, $graphQuery);
    $count = mysqli_num_rows($res);

    if ($count > 0) {

        while($graph = mysqli_fetch_assoc($res)){
            echo strval($graph["date"]);
        }
    }else{
        echo "Nothing";
    }

?>