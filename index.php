<?php

if (isset($_POST["login"])) {
    header("Location: login.php");
}

if (isset($_POST["crAcc"])) {
    header("Location: createAcc.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sky Bank</title>
    <link rel="icon" type="icon" href="../imges/logo.png">

    <!--CSS -->
    <link rel="stylesheet" href="./CSS/landing.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt&family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital@1&family=Poltawski+Nowy:ital,wght@1,600&display=swap" rel="stylesheet">

    <!--Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img class="logo" src="../imges/logo.png" alt="logo">
                </a>
                <div class="navbar-nav ms-auto">
                    <form class="d-flex" method="post">
                        <button class="btn btn-outline-light" name="login">Login</button>
                    </form>
                </div>
            </div>
            </div>
        </nav>
    </header>
    <main>
        <h1>The AI powered banking system</h1>
        <p>Sky Bank: Harnessing AI for Intelligent Banking Solutions - Redefining Convenience, Security, and Personalization</p>
        <form method="post">
            <button class="btn btn-secondary btn-lg" name="crAcc">Create your account</button>
        </form>
    </main>
</body>

</html>