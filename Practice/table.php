<?php

require('../connection/conn.php');

$accno = "SKYBNK00002";

$query = "SELECT * FROM history WHERE facc = '" . $accno . "' OR tacc = '" . $accno . "'";
$result = mysqli_query($conn, $query);

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
    <link rel="stylesheet" href="../CSS/statement.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&family=Roboto&display=swap" rel="stylesheet">

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

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
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                        <a class="nav-link" href="transaction.php">Transaction</a>
                        <a class="nav-link active" aria-current="page">Statement</a>
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
    <main class="table">
        <section class="table_header">
            <h2>Transaction History</h2>
        </section>
        <section class="table_body">
            <table>
                <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Amount(₹)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = mysqli_num_rows($result);

                    if ($count > 0) {
                        while ($record = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>".$record['facc']."</td>
                                    <td>".$record['tacc']."</td>
                                    <td>".$record['dtrans']."</td>
                                    <td>
                                        <p>".$record['stat']."</p>
                                    </td>
                                    <td>".$record['amount']."</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr>
                            <td>No records to display</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>


</body>

</html>