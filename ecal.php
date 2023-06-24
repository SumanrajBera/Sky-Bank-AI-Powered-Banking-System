<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
    <!--CSS -->
    <link rel="stylesheet" href="./CSS/navbar.css" />
    <link rel="stylesheet" href="./CSS/ecal.css">
    <link rel="stylesheet" href="./CSS/chatbot.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&family=Roboto&display=swap" rel="stylesheet">

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
                        <a class="nav-link" aria-current="page" href="dashboard.php">Dashboard</a>
                        <a class="nav-link" href="transaction.php">Transaction</a>
                        <a class="nav-link" href="statement.php">Statement</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle active" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Loan tools
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item active">E-cal</a></li>
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

    <!--Calculator-->
    <main>
        <div class="loan-calculator">
            <div class="top">
                <h2>Loan calculator</h2>
                <form action="#">
                    <div class="group">
                        <div class="title">Amount</div>
                        <input type="text" value="30000" class="loan-amount">
                    </div>

                    <div class="group">
                        <div class="title">Interest Rate</div>
                        <input type="text" value="8.5" class="interest-rate">
                    </div>

                    <div class="group">
                        <div class="title">Tenure (in months)</div>
                        <input type="text" value="240" class="tenure">
                    </div>
                </form>
            </div>


            <div class="result">
                <div class="left">
                    <div class="loan-emi">
                        <h3>Loan EMI</h3>
                        <div class="value">123</div>
                    </div>

                    <div class="total-interest">
                        <h3>Total Interest Payable</h3>
                        <div class="value">1234</div>
                    </div>

                    <div class="total-amount">
                        <h3>Total amount</h3>
                        <div class="value">12345</div>
                    </div>

                    <button class="cal-btn">Calculate</button>
                </div>

                <div class="right">
                    <canvas id="myChart" width="400" height="400"></canvas>
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

    <!--Scripts for chart and loan calculation-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.3.0/dist/chart.umd.min.js"></script>

    <script src="./JS/ecal.js"></script>

</body>

</html>