<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link  href="style.css" rel="stylesheet" type="text/css">
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
            <li><i class="fa-solid fa-user"></i>Nadawcy</li>
            <li><i class="fa-regular fa-user"></i>Odbiorcy</li>
            <li class="active"><i class="fa-solid fa-box"></i>Przesyłka</li>
        </ul>
        </div>
    </div>
    <div id="nav">
        Sprawdź status przesyłki
    </div>
    <div id="main">
        <?php
        define("host", "localhost");
        define("user", "root");
        define("pass","");

        $conn = mysqli_connect(host,user,pass);
        $baza = mysqli_select_db($conn, "firma_kurierska2023");

        $trcking_nr;
        if(isset($_POST['trcking'])){
            $trcking_nr = $_POST['trcking'];
        }

        $kwerenda = mysqli_prepare($conn, "SELECT przesyłka.tracking_nr, przesyłka.metoda, concat(nadawca.imie_n,' ',nadawca.nazwisko_n) AS nadawca, concat(odbiorca.imie_o,' ',odbiorca.nazwisko_o) AS odbiorca, przesyłka.data_wysłania, przesyłka.data_odbioru, trasa.status, przesyłka.waga, przesyłka.status_platnosci, concat(kurier.imie_kr,' ', kurier.nazwisko_kr) AS kurier, kurier.telefon_kr FROM przesyłka INNER JOIN zlecenie ON zlecenie.id_zlecenia=przesyłka.id_zlecenia LEFT JOIN nadawca ON zlecenie.id_nadawcy=nadawca.id_nadawcy LEFT JOIN odbiorca ON odbiorca.id_odbiorcy = zlecenie.id_odbiorcy LEFT JOIN trasa ON trasa.id_przesylki = przesyłka.id_przesylki LEFT JOIN kurier ON kurier.id_kr = zlecenie.id_kr WHERE przesyłka.tracking_nr = ?");
        mysqli_stmt_bind_param($kwerenda, "s", $trcking_nr);
        mysqli_stmt_execute($kwerenda);
        mysqli_stmt_bind_result($kwerenda, $tr_nr, $prz_metoda, $nadawca, $odbiorca, $data_wys, $data_od,$prz_status,$waga,$platnosc,$kurier, $tel_kr);
        while(mysqli_stmt_fetch($kwerenda)){
        echo "<div class='package-panel'>
            <div class='about-package'>
                <h1>Tracking</h1>
                <ul>
                    <li>Numer przesyłki: $tr_nr</li>
                    <li>Metoda płatności: <span>$prz_metoda</span></li>
                    <li>Nadawca: <span>$nadawca</span></li>
                    <li>Odbiorca:<span> $odbiorca</span></li>
                    <li>Data wysłania:<span> $data_wys</span></li>
                    <li>Data odbioru: <span>$data_od</span></li>
                </ul>
            </div>
            <div class='status-package'>
                <h1>Status</h1>
                <p>$prz_status</p>";
                if($prz_status == "Transport wewnętrzny"){
                    echo "<div class='svg-container'>
                    <div class='svg active-status'>
                        <img src='package-delivery-icon.svg'>
                    </div>
                    <div class='svg'>
                        <img src='package-svgrepo-com.svg'>
                    </div>
                    <div class='svg'>
                        <img src='delivery-truck-svgrepo-com.svg'>
                        </div>
                    <div class='svg'>
                        <img src='delivery-hand-package-icon.svg'>
                    </div>
                </div>";
                }
                if($prz_status == "Wydano do doręczenia"){
                    echo "<div class='svg-container'>
                    <div class='svg'>
                        <img src='package-delivery-icon.svg'>
                    </div>
                    <div class='svg active-status'>
                        <img src='package-svgrepo-com.svg'>
                    </div>
                    <div class='svg'>
                        <img src='delivery-truck-svgrepo-com.svg'>
                        </div>
                    <div class='svg'>
                        <img src='delivery-hand-package-icon.svg'>
                    </div>
                </div>";
                }
                if($prz_status == "W trakcie doręczenia"){
                    echo "<div class='svg-container'>
                    <div class='svg'>
                        <img src='package-delivery-icon.svg'>
                    </div>
                    <div class='svg'>
                        <img src='package-svgrepo-com.svg'>
                    </div>
                    <div class='svg active-status'>
                        <img src='delivery-truck-svgrepo-com.svg'>
                        </div>
                    <div class='svg'>
                        <img src='delivery-hand-package-icon.svg'>
                    </div>
                </div>";
                }
                if($prz_status == "Dostarczono"){
                    echo "<div class='svg-container'>
                    <div class='svg'>
                        <img src='package-delivery-icon.svg'>
                    </div>
                    <div class='svg'>
                        <img src='package-svgrepo-com.svg'>
                    </div>
                    <div class='svg'>
                        <img src='delivery-truck-svgrepo-com.svg'>
                        </div>
                    <div class='svg active-status'>
                        <img src='delivery-hand-package-icon.svg'>
                    </div>
                </div>";
                }
            echo "</div>
            <div class='weight-package'>
                <h1>Waga</h1>
                <p>$waga<span>kg</span></p>
            </div>
            <div class='payment-status'>
                <h1>Status opłaty</h1>
                ";
                if($platnosc == 'N'){
                    echo "<p class='nieop'>Nieopłacone</p>";
                }
                if($platnosc == 'O'){
                    echo "<p class='op'>Opłacone</p>";
                }
                echo "
            </div>
            <div class='deliveryman-package'>
                <h1>Kurier</h1>
                <img src='user-profile-icon.svg'>
                <p>$kurier</p>
                <p><i class='fa-solid fa-phone'></i> $tel_kr</p>
            </div>
        </div>";
        }
        ?>
    </div>
</body>
</html>