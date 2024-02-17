<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link  href="style.css?v=5" rel="stylesheet" type="text/css">
    <title>Kurierzy</title>
</head>
<body>
<div id="left-panel">
        <div id="user-profile">
            <div id="img-container">
                <img src="" alt="">
            </div>
            <div id="user-name">
                <p><?php 
                   $ul = $_SESSION['userLogin'];
                   echo $ul;
                   session_abort();
                ?></p>
            </div>
            <button id="logout"><a href="mainpage.html">Wyloguj</a></button>
        </div>
        <div id="menu">
        <ul>
            <li><i class="fa-solid fa-house"></i><a href="dashboard.php">Strona główna</a></li>
            <li><i class="fa-solid fa-users"></i><a href="oddzialy.php">Dane oddzialu</a></li>
            <li><i class="fa-solid fa-truck-fast"></i><a href="kurierzy.php">Kurierzy</a></li>
            <li><i class="fa-solid fa-user"></i><a href="nadawcy.php">Nadawcy</a></li>
            <li><i class="fa-regular fa-user"></i><a href="odbiorcy.php">Odbiorcy</a></li>
            <li class="active"><i class="fa-solid fa-box"></i><a href="przesylka.php">Przesyłka</a></li>
        </ul>
        </div>
    </div>
    <div id="nav">
        Przesyłki
    </div>
    <div id="main">
    <a href="nadaj-przesylke.php" class='przesylka'>Nadaj przesylke</a>
    <a href="przesylka2.php" class='przesylka'>Sprawdz status przesylki</a>
    </div>
</body>
</html>