<?php


require('connection/conn.php');

session_start();

$accno =  $_SESSION["accno"];


$query = "Select * from accounts where accno = '" . $accno . "'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
}

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <!--CSS -->
    <link rel="stylesheet" href="./CSS/dashboard.css" />
    <link rel="stylesheet" href="./CSS/chatbot.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&family=Roboto&display=swap" rel="stylesheet">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</head>

<body>
    <!--Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img class="logo" src="../imges/logo.png" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav ms-auto">
                        <a class="nav-link active" aria-current="page">Dashboard</a>
                        <a class="nav-link" href="transaction.php">Transaction</a>
                        <a class="nav-link" href="statement.php">Statement</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Loan tools
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="ecal.php">E-cal</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="loanpred.php">Loan status predictor</a></li>
                            </ul>
                        </li>
                        <form class="d-flex" method="post">
                            <button class="btn btn-outline-secondary" name="logout">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <div class="row justify-content-around">
                <div class="col-lg-3 col-md-4 info">
                    <div class="box-detail">
                        <h4><i class="fa-solid fa-user"></i>User Account</h4>
                        <p>Name: <?php echo $row["fname"] . " " . $row["lname"] ?></p>
                        <p>Account no: <?php echo $row["accno"] ?></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 info">
                    <div class="box-detail">
                        <h4><i class="fa-solid fa-wallet"></i>Balance</h4>
                        <p class="money">₹ <?php echo $row["depo"] ?></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 info">
                    <div class="box-detail">
                        <h4><i class="fa-solid fa-money-bill-transfer"></i>Transacted</h4>
                        <p class="money">₹ <?php echo $row["trans"] ?></p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-around">
                <div class="col-lg-5 charst">
                    <canvas id="myChart1" height="300px"></canvas>
                </div>
                <div class="col-lg-5 charst">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
    </main>
    <!-- CHAT BAR BLOCK -->
    <div class="chat-bar-collapsible">
        <button id="chat-button" type="button" class="collapsible">Chat with us!
            <i id="chat-icon" style="color: #fff;" class="fa-regular fa-comments"></i>
        </button>

        <div class="content">
            <div class="full-chat-block">
                <!-- Message Container -->
                <div class="outer-container">
                    <div class="chat-container">
                        <!-- Messages -->
                        <div id="chatbox">
                            <h5 id="chat-timestamp"></h5>
                            <p id="botStarterMessage" class="botText"><span>Loading...</span></p>
                        </div>

                        <!-- User input box -->
                        <div class="chat-bar-input-block">
                            <div id="userInput">
                                <input id="textInput" class="input-box" type="text" name="msg" placeholder="Tap 'Enter' to send a message">
                                <p></p>
                            </div>

                            <div class="chat-bar-icons">
                                <i id="chat-icon" style="color: #333;" class="fa-solid fa-paper-plane" onclick="sendButton()"></i>
                            </div>
                        </div>

                        <div id="chat-bar-bottom">
                            <p></p>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var dar = [];
        const depo = [];
        const trans = [];
        <?php
        $graphQuery =  "Select * from graph where acc = '" . $accno . "'";
        $res = mysqli_query($conn, $graphQuery);
        $count = mysqli_num_rows($res);

        if ($count > 0) {

            while ($graph = mysqli_fetch_assoc($res)) {
        ?>
                dar.push((<?php echo  json_encode($graph["date"]); ?>));
                depo.push(<?php echo  $graph["depo"]; ?>);
                trans.push(<?php echo  $graph["trans"]; ?>)
        <?php
            }

            echo "
            const ctx = document.getElementById('myChart1').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dar,
                    datasets: [{
                        label: 'Savings',
                        data: depo,
                        backgroundColor: 'rgba(144,238,145,0.4)',
                        borderColor: 'rgb(0,255,0)',
                        tension: 0.1,
                        borderWidth: 1.5,
                        fill: true
                    }, {
                        label: 'Transaction',
                        data: trans,
                        backgroundColor: 'rgba(193, 100, 104,0.4)',
                        borderColor: 'rgb(250, 110, 110)',
                        borderWidth: 1.5,
                        tension: 0.1,
                        fill: true
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                    plugins: {
                        filler: {
                            propagate: false,
                        },
                        title: {
                            display: true,
                        }
                    },
                    interaction: {
                        intersect: false,
                    }
                }
            });
        ";
        } else {
            echo "
        const ctx = document.getElementById('myChart1').getContext('2d');
        ctx.font = '20px Arial';
        ctx.fillText('No information to display', 10,30);
        ";
        }

        ?>

        const ctx2 = document.getElementById('myChart2');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Savings', 'Transacted'],
                datasets: [{
                    label: 'Monthly Transaction',
                    data: [<?php echo $row['depo'] ?>, <?php echo $row['trans'] ?>],
                    backgroundColor: ["#00FF00", "#FF0000"],
                    borderWidth: 1
                }]
            }
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        var coll = document.getElementsByClassName("collapsible");

        for (let i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");

                var content = this.nextElementSibling;
                if (content.style.maxHeight) {
                    content.style.maxHeight = null;
                } else {
                    content.style.maxHeight = content.scrollHeight + "px";
                }
            });
        }


        function getTime() {
            let today = new Date();
            hours = today.getHours();
            minutes = today.getMinutes();

            if (hours < 10) {
                hours = "0" + hours;
            }

            if (minutes < 10) {
                minutes = "0" + minutes;
            }

            let time = hours + ":" + minutes;
            return time;
        }

        function firstBotMessage() {
            let firstMessage = "How's it going?"
            document.getElementById("botStarterMessage").innerHTML = '<p class="botText"><span>' + firstMessage + '</span></p>';

            let time = getTime();

            $("#chat-timestamp").append(time);
            document.getElementById("userInput").scrollIntoView(false);
        }

        firstBotMessage();

        function getHardResponse(userText) {
            var question = userText;
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
            let botResponse = myVariable;
            let botHtml = '<p class="botText"><span>' + botResponse + '</span></p>';
            $("#chatbox").append(botHtml);

            document.getElementById("chat-bar-bottom").scrollIntoView(true);
        }

        function getResponse() {
            let userText = $("#textInput").val();

            if (userText == "") {
                userText = "I love Code Palace!";
            }

            let userHtml = '<p class="userText"><span>' + userText + '</span></p>';

            $("#textInput").val("");
            $("#chatbox").append(userHtml);
            document.getElementById("chat-bar-bottom").scrollIntoView(true);

            setTimeout(() => {
                getHardResponse(userText);
            }, 1000)

        }

        // Handles sending text via button clicks
        function buttonSendText(sampleText) {
            let userHtml = '<p class="userText"><span>' + sampleText + '</span></p>';

            $("#textInput").val("");
            $("#chatbox").append(userHtml);
            document.getElementById("chat-bar-bottom").scrollIntoView(true);

            //Uncomment this if you want the bot to respond to this buttonSendText event
            // setTimeout(() => {
            //     getHardResponse(sampleText);
            // }, 1000)
        }

        function sendButton() {
            getResponse();
        }
        // Press enter to send a message
        $("#textInput").keypress(function(e) {
            if (e.which == 13) {
                getResponse();
            }
        });
    </script>

</body>

</html>