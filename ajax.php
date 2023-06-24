<?php

$question = $_POST['txt1'];
$command = escapeshellcmd('python -u "d:\Practice dev\PHP\chatbot.py" '.$question);
$output = shell_exec($command);
echo $output;

