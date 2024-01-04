<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <title>Home</title>
</head>
<body>
    <div id="left-panel">
        <div id="user-profile">
            <div id="img-container">
                <img src="" alt="">
            </div>
            <div id="user-name">
                <p><?php 
                   session_start();
                   $ul = $_SESSION['userLogin'];
                   echo $ul;
                ?></p>
            </div>
            <button id="logout">Wyloguj</button>
        </div>
        <div id="menu">
        <ul>
            <li class="active"><i class="fa-solid fa-house"></i>Strona główna</li>
            <li><i class="fa-solid fa-users"></i><a href="oddzialy.php">Dane oddziału</a></li>
            <li><i class="fa-solid fa-truck-fast"></i>Kurierzy</li>
            <li><i class="fa-solid fa-user"></i>Nadawcy</li>
            <li><i class="fa-regular fa-user"></i>Odbiorcy</li>
            <li><i class="fa-solid fa-box"></i>Przesyłka</li>
        </ul>
        </div>
    </div>
    <div id="nav">
        Strona główna
    </div>
</body>
</html>