<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <button id="click" onclick="clicked()">Click</button>
    <p id="para"></p>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        function clicked() {

            var question = "What's up?";
            var myVariable;
            $.ajax({
                'async': false,
                url: "ajax.php",
                type: "POST",
                data: {
                    txt1: question
                },
                success: function(data) {
                    myVariable = data;
                }
            });

            alert(myVariable);
        }
    </script>
</body>

</html>