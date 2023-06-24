<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
require('connection/conn.php');

session_start();

$accno =  $_SESSION["accno"];
$query = "Select * from accounts where accno = '" . $accno . "'";
$result = mysqli_query($conn, $query);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['deposit'])) {
    $amt = (int)test_input($_POST['amtDepo']);
    $row = mysqli_fetch_array($result);
    if ($amt <= 0 or empty($amt)) {
        echo '<script>alert("You need to enter money to deposit")</script>';
    } else {
        $newAmt = $amt + (int)$row['depo'];
        $depoQuery = "INSERT INTO history (facc,tacc,dtrans,stat,amount) VALUES ('" . $accno . "', '" . $accno . "', '" . date("Y-m-d") . "', 'Credited', '" . $amt . "')";
        $depoQuery2 = "UPDATE accounts SET depo = '" . $newAmt . "' WHERE accounts .accno = '" . $accno . "'";
        mysqli_query($conn, $depoQuery2);
        mysqli_query($conn, $depoQuery);
        echo '<script>alert("Amount deposited:' . $amt . ' ")</script>';
    }
}
if (isset($_POST['transact'])) {
    $amt = (int)test_input($_POST['amtTra']);
    $row = mysqli_fetch_array($result);
    $trans = (int)$row['depo'];
    if ($amt <= 0 or empty($amt)) {
        echo '<script>alert("You need to enter money to transact")</script>';
    } else {
        if ($amt > $trans) {
            echo '<script>alert("Insufficient funds")</script>';
        } else {
            $transacted = $amt + (int)$row['trans'];
            $newAmt = $trans - $amt;
            $transQuery = "INSERT INTO history (facc,tacc,dtrans,stat,amount) VALUES ('" . $accno . "', '" . $accno . "', '" . date("Y-m-d") . "', 'Debited', '" . $amt . "')";
            $transQuery2 = "UPDATE accounts SET depo = '" . $newAmt . "' WHERE accounts .accno = '" . $accno . "'";
            $transQuery3 = "UPDATE accounts SET trans = '" . $transacted . "' WHERE accounts .accno = '" . $accno . "'";
            mysqli_query($conn, $transQuery2);
            mysqli_query($conn, $transQuery3);
            mysqli_query($conn, $transQuery);
            echo '<script>alert("Amount transacted:' . $amt . ' ")</script>';
        }
    }
}
if (isset($_POST['transfer'])) {
    $tacc = test_input($_POST['tacc']); // Transfer account
    $amt = (int)test_input($_POST['amtTrans']); // Transfer amount
    $frow = mysqli_fetch_array($result); //From account whole

    if ($amt <= 0 or empty($amt) or empty($tacc)) {

        echo '<script>alert("You need to enter both Account number and amount fields correctly")</script>';
    } else {

        $tranQuery = "SELECT * FROM accounts where accno = '" . $tacc . "'";
        $trans = mysqli_query($conn, $tranQuery);
        $trow = mysqli_fetch_array($trans); // Transfer account whole
        $count = mysqli_num_rows($trans);
        if ($count > 0) {
            $tranAmt = $frow['depo']; // User
            $depoAmt = $trow['depo']; // Diff
            if ($amt > $tranAmt) {
                echo '<script>alert("Insufficient funds")</script>';
            } else {
                if ($tacc == $accno) {
                    echo '<script>alert("Use Internal fund transfer")</script>';
                } else {
                    $toDepoAmt = $amt + $depoAmt; // Diff
                    $transacted = $amt + (int)$frow['trans']; // User transact
                    $frDepoAmt = $tranAmt - $amt; // User depo

                    $fromQuery = "INSERT INTO history (facc,tacc,dtrans,stat,amount) VALUES ('" . $accno . "', '" . $tacc . "', '" . date("Y-m-d") . "', 'Transferred', '" . $amt . "')"; //User

                    $transQuery2 = "UPDATE accounts SET depo = '" . $toDepoAmt . "' WHERE accounts .accno = '" . $tacc . "'"; // Diff
                    $transQuery3 = "UPDATE accounts SET trans = '" . $transacted . "' WHERE accounts .accno = '" . $accno . "'"; // User
                    $transQuery4 = "UPDATE accounts SET depo = '" . $frDepoAmt . "' WHERE accounts .accno = '" . $accno . "'"; // User

                    mysqli_query($conn, $fromQuery);
                    mysqli_query($conn, $transQuery2);
                    mysqli_query($conn, $transQuery3);
                    mysqli_query($conn, $transQuery4);
                    echo '<script>alert("Amount transacted:' . $amt . ' ")</script>';
                }
            }
        } else {
            echo '<script>alert("Cannot transfer money! Invalid Account number: ' . $tacc . '")</script>';
        }
    }
}


// INSERT INTO `history` (`facc`, `tacc`, `dtrans`, `stat`, `amount`) VALUES ('', '', '', '', '')
// UPDATE `accounts` SET `depo` = '205' WHERE `accounts`.`accno` = 'SKYBNK00001';


if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
}


?>

<head>
    <meta charset="utf-8">
    <title></title>
    <!--CSS -->
    <link rel="stylesheet" href="../CSS/transaction.css" />
    <link rel="stylesheet" href="./CSS/chatbot.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&family=Roboto&display=swap" rel="stylesheet">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                        <a class="nav-link" aria-current="page" href="dashboard.php">Dashboard</a>
                        <a class="nav-link active" href="#">Transaction</a>
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
                                <li><a class="dropdown-item" href="active">Loan status predictor</a></li>
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
            <div class="row text-center">
                <h2>Internal Transfer</h2>
            </div>
            <div class="row justify-content-around">
                <div class="col-lg-4 col-md-4 depo">
                    <form action="transaction.php" method="post">
                        <label for="">Deposit:</label>
                        <input type="text" placeholder="Enter amount" name="amtDepo">
                        <div class="btn">
                            <input type="submit" class="login-btn" value="Deposit" name="deposit">
                        </div>
                    </form>
                </div>

                <div class="col-lg-4 col-md-4 depo">
                    <form action="transaction.php" method="post">
                        <label for="">Transact:</label>
                        <input type="text" placeholder="Enter amount" name="amtTra">
                        <div class="btn">
                            <input type="submit" class="login-btn" value="Transact" name="transact">
                        </div>
                    </form>
                </div>
            </div>

            <div class="row text-center">
                <h2>External Transfer</h2>
            </div>
            <div class="row justify-content-around">
                <div class="col-lg-6 col-md-6 depo">
                    <form action="transaction.php" method="post">
                        <label for="">Account no.:</label>
                        <input type="text" placeholder="Enter Account number" name="tacc"><br>
                        <label for="">Transact:</label>
                        <input type="text" placeholder="Enter Transaction amount" name="amtTrans">
                        <div class="btn">
                            <input type="submit" class="login-btn" value="Transfer" name="transfer">
                        </div>
                    </form>
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