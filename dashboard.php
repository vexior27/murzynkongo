<?php 
 define("host", "localhost");
 define("user", "root");
 define("pass","");

 $conn = mysqli_connect(host,user,pass);
 $baza = mysqli_select_db($conn, "firma_kurierska2023");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css?v=9">
    <title>Home</title>
</head>
<body>
    <div id="left-panel">
        <div id="user-profile">
            <div id="img-container">
                <img src="" alt="">
            </div>
            <div id="user-name">
                <p>
                <?php 
                   session_start();
                   $ul = $_SESSION['userLogin'];
                   echo $ul;
                ?>
                </p>
            </div>
            <button id="logout"><a href="mainpage.html">Wyloguj</a></button>
        </div>
        <div id="menu">
        <ul>
            <li class="active"><i class="fa-solid fa-house"></i>Strona główna</li>
            <li><i class="fa-solid fa-users"></i><a href="oddzialy.php">Dane oddziału</a></li>
            <li><i class="fa-solid fa-truck-fast"></i><a href="kurierzy.php">Kurierzy</a></li>
            <li><i class="fa-solid fa-user"></i><a href="nadawcy.php">Nadawcy</a></li>
            <li><i class="fa-regular fa-user"></i><a href="odbiorcy.php">Odbiorcy</a></li>
            <li><i class="fa-solid fa-box"></i><a href="przesylka.php">Przesyłka</a></li>
        </ul>
        </div>
    </div>
    <div id="nav">
        Strona główna
    </div>
    <div id="main">
        <div class="main-dashboard">
            <div class="dashboard-oddzial">
                <h1>Liczba oddziałów</h1>
                <?php 
                    $kwerenda = mysqli_prepare($conn,"SELECT COUNT(id_oddzialu) FROM oddzial_firmy");
                    mysqli_execute($kwerenda);
                    mysqli_stmt_bind_result($kwerenda,$l);
                    while(mysqli_stmt_fetch($kwerenda)){
                        echo "<p class='count'>$l</p>";
                    }
                ?>
            </div>
            <div class="dashboard-kurierzy">
                <h1>Aktywne zlecenia</h1>
                <?php 
                    $kwerenda = mysqli_prepare($conn,"SELECT COUNT(id_zlecenia) FROM zlecenie");
                    mysqli_execute($kwerenda);
                    mysqli_stmt_bind_result($kwerenda,$l);
                    while(mysqli_stmt_fetch($kwerenda)){
                        echo "<p class='count'>$l</p>";
                    }
                ?>
            </div>
            <div class="dashboard-mapa">
                Mapa polski 
                <img src="pl.svg" style="filter: grayscale(100%); width: 250px;" alt="">
            </div>
            <div class="dashboard-zlecenia">
                <p>Ostatni kurierzy</p>
                <?php 
                $kwerenda = mysqli_prepare($conn, "SELECT kurier.id_kr,
                kurier.imie_kr,
                kurier.nazwisko_kr,
                kurier.telefon_kr,
                kurier.godziny_od,
                kurier.godziny_do,
                kurier.id_oddzialu,oddzial_firmy.nazwa_oddzialu FROM kurier INNER JOIN oddzial_firmy ON oddzial_firmy.id_oddzialu = kurier.id_oddzialu ORDER BY kurier.id_kr DESC LIMIT 4 ");
                mysqli_execute($kwerenda);
                mysqli_stmt_bind_result($kwerenda,$id,$imie,$naz,$tel,$od,$do,$odz,$nazodz);

                while(mysqli_stmt_fetch($kwerenda)){
                    echo "
                    <div class='kurier-plate'>
                        <div>$imie $naz</div>
                        <div>$tel</div>
                        <div>$nazodz</div>
                    </div>
                    ";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>