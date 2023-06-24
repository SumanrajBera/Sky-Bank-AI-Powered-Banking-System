<?php

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST["submit"])) {
    $name = test_input($_POST["fname"]) . " " . test_input($_POST["lname"]);

    $gender = (int)test_input($_POST["gender"]);
    $api = (int)test_input($_POST["ai"]);
    $ms = (int)test_input($_POST["married"]);
    $cai = (int)test_input($_POST["cai"]);
    $dep = (int)test_input($_POST["dep"]);
    $edu = (int)test_input($_POST["edu"]);
    $la = (int)test_input($_POST["la"]);
    $lt = (int)test_input($_POST["lt"]);
    $ch = (int)test_input($_POST["ch"]);
    $emp = (int)test_input($_POST["emp"]);
    $pa = (int)test_input($_POST["pa"]);


    $question = $gender . " " . $ms . " " . $dep . " " . $edu . " " . $emp . " " . $api . " " . $cai . " " . $la . " " . $lt . " " . $ch . " " . $pa;
    $command = escapeshellcmd('python -u "D:\Practice dev\PHP\loanpred.py" ' . $question);
    $output = shell_exec($command);
    if ($output) {
        echo '<script>alert("Congratulations! Account no:' . $output . ' ")</script>';
    }
}

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
    <link rel="stylesheet" href="./CSS/loanpred.css" />
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


    <style>

    </style>
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
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                        <a class="nav-link" href="transaction.php">Transaction</a>
                        <a class="nav-link" href="statement.php">Statement</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Loan tools
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="ecal.php">E-cal</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item active">Loan status predictor</a></li>
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
        <div class="reg-form">

            <form action="loanpred.php" method="post">
                <h2>Loan Status Predictor</h2>
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
                            <label>Gender</label>
                            <select name="gender" id="gender" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background: rgba(255, 255, 255, 0.4);backdrop-filter: blur(5px);box-shadow: 0 12px 50px -11px rgb(169, 169, 169);border-radius: 8px; padding: 10px;" required>
                                <option value="" class="dropdown-item">--- Choose a option ---</option>
                                <option value="1" class="dropdown-item">Male</option>
                                <option value="0" class="dropdown-item">Female</option>
                            </select>
                        </div>

                        <div class="input-fields">
                            <label>Applicant Income</label>
                            <input type="text" placeholder="Enter Applicant Income" class="ai" name="ai" pattern="[0-9]+" required>
                        </div>

                        <div class="input-fields">
                            <label>Marital status</label>
                            <select name="married" id="married" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background: rgba(255, 255, 255, 0.4);backdrop-filter: blur(5px);box-shadow: 0 12px 50px -11px rgb(169, 169, 169);border-radius: 8px; padding: 10px;" required>
                                <option value="" class="dropdown-item">--- Choose a option ---</option>
                                <option value="1" class="dropdown-item">Married</option>
                                <option value="0" class="dropdown-item">Single</option>
                            </select>
                        </div>

                        <div class="input-fields">
                            <label>Coapplicant Income</label>
                            <input type="text" placeholder="Enter Coapplicant Income" class="cai" name="cai" pattern="[0-9]+" required>
                        </div>

                        <div class="input-fields">
                            <label>Dependents</label>
                            <select name="dep" id="dep" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background: rgba(255, 255, 255, 0.4);backdrop-filter: blur(5px);box-shadow: 0 12px 50px -11px rgb(169, 169, 169);border-radius: 8px; padding: 10px;">
                                <option value="" class="dropdown-item">--- Choose a option ---</option>
                                <option value="1" class="dropdown-item">One</option>
                                <option value="2" class="dropdown-item">Two</option>
                                <option value="3" class="dropdown-item">Three</option>
                                <option value="4" class="dropdown-item">More than 3</option>
                            </select>
                        </div>

                        <div class="input-fields">
                            <label>Education</label>
                            <select name="edu" id="edu" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background: rgba(255, 255, 255, 0.4);backdrop-filter: blur(5px);box-shadow: 0 12px 50px -11px rgb(169, 169, 169);border-radius: 8px; padding: 10px;">
                                <option value="" class="dropdown-item">--- Choose a option ---</option>
                                <option value="1" class="dropdown-item">Graduate</option>
                                <option value="0" class="dropdown-item">Not Graduate</option>
                            </select>
                        </div>

                        <div class="input-fields">
                            <label>Loan Amount</label>
                            <input type="text" placeholder="Enter Loan Amount" class="la" name="la" pattern="[0-9]+" required>
                        </div>

                        <div class="input-fields">
                            <label>Loan term</label>
                            <input type="text" placeholder="Enter months" class="lt" name="lt" pattern="[0-9]+" required>
                        </div>

                        <div class="input-fields">
                            <label>Credit History</label>
                            <select name="ch" id="ch" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background: rgba(255, 255, 255, 0.4);backdrop-filter: blur(5px);box-shadow: 0 12px 50px -11px rgb(169, 169, 169);border-radius: 8px; padding: 10px;">
                                <option value="" class="dropdown-item">--- Choose a option ---</option>
                                <option value="0" class="dropdown-item">No</option>
                                <option value="1" class="dropdown-item">Yes</option>
                            </select>
                        </div>

                        <div class="input-fields">
                            <label>Employment</label>
                            <select name="emp" id="emp" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background: rgba(255, 255, 255, 0.4);backdrop-filter: blur(5px);box-shadow: 0 12px 50px -11px rgb(169, 169, 169);border-radius: 8px; padding: 10px;">
                                <option value="" class="dropdown-item">--- Choose a option ---</option>
                                <option value="1" class="dropdown-item">Self-employeed</option>
                                <option value="0" class="dropdown-item">Not Self-employeed</option>
                            </select>
                        </div>

                        <div class="input-fields">
                            <label>Property Area</label>
                            <select name="pa" id="pa" class="btn dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false" style=" background: rgba(255, 255, 255, 0.4);backdrop-filter: blur(5px);box-shadow: 0 12px 50px -11px rgb(169, 169, 169);border-radius: 8px; padding: 10px;">
                                <option value="" class="dropdown-item">--- Choose a option ---</option>
                                <option value="0" class="dropdown-item">Rural</option>
                                <option value="1" class="dropdown-item">Urban</option>
                                <option value="2" class="dropdown-item">Semi-Urban</option>
                            </select>
                        </div>


                        <input type="submit" value="Predict Loan Approval" name="submit" class="acc-btn" onclick="onPred()">
                    </div>
                </div>


                <?php
                if (isset($output)) {
                    if (strlen($output) == 9) {
                        echo '<div class="alert alert-success alert-dismissible text-center" role="alert">';
                        echo $name."'s loan status: ".$output;
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                    }else{
                        echo '<div class="alert alert-danger alert-dismissible text-center" role="alert">';
                        echo $name."'s loan status: ".$output;
                        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                        echo '</div>';
                    }
                }
                ?>
            </form>
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