<?php
    session_start();
    define("host", "localhost");
    define("pass", "");
    define("user", "root");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link  href="style.css?v=2" rel="stylesheet" type="text/css">
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
            <button id="logout">Wyloguj</button>
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
        Zlecenie
    </div>
    <div id="main">
      <form action="nadaj-przesylke.php" method="post">
            <select name="" id="">
            <?php 
                $conn = mysqli_connect(host,user,pass);
                $baza = mysqli_select_db($conn,"firma_kurierska2023");
                $kwerenda = mysqli_prepare($conn, "SELECT zlecenie.id_kr,zlecenie.id_nadawcy,zlecenie.id_odbiorcy, concat(odbiorca.imie_o,' ',odbiorca.nazwisko_o) AS odbr, concat(nadawca.imie_n,' ',nadawca.nazwisko_n) AS nad, concat(kurier.imie_kr,' ',kurier.nazwisko_kr) AS kur 
                FROM zlecenie INNER JOIN odbiorca ON zlecenie.id_odbiorcy = odbiorca.id_odbiorcy INNER JOIN nadawca ON nadawca.id_nadawcy = zlecenie.id_nadawcy INNER JOIN kurier ON kurier.id_kr = zlecenie.id_kr");
                mysqli_stmt_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda, $krid, $nadid, $odbid, $odb, $nad, $kr);
                while(mysqli_stmt_fetch($kwerenda)){
                    echo "
                    <option value='$nadid'>$nad</option>
                    ";
                }
            ?>
            </select>
            <label for="Data zlecenia:"></label><input type="date" name="data" id="">
        </form>
      <?php 
            $conn = mysqli_connect(host,user,pass);
            $baza = mysqli_select_db($conn,"firma_kurierska2023");
            //$kwerenda = mysqli_prepare($conn, "INSERT INTO zlecenie VALUES(?,?,?,?)");

        ?>         
    </div>
</body>
</html>