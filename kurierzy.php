<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link  href="style.css?v=1" rel="stylesheet" type="text/css">
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
            <li class="active"><i class="fa-solid fa-truck-fast"></i>Kurierzy</li>
            <li><i class="fa-solid fa-user"></i>Nadawcy</li>
            <li><i class="fa-regular fa-user"></i>Odbiorcy</li>
            <li><i class="fa-solid fa-box"></i>Przesyłka</li>
        </ul>
        </div>
    </div>
    <div id="nav">
        Oddziały
    </div>
    <div id="main">
      <div id="add-department">
        <h1>Dodaj kuriera</h1>
         <form action="kurierzy.php" method="POST">
            <label for="">Imie kuriera </label><input type="text" name="imie"><br>
            <label for="">Nazwisko kuriera </label><input type="text" name="naz"><br>
            <label for="">Telefon kuriera </label><input type="text" name="tel"><br>
            <label for="">Godziny od </label><input type="text" name="godz_od"><br>
            <label for="">Godziny do </label><input type="text" name="godz_do"><br>
            <label for="">Oddział </label>
            <select name="id_oddzial" id="">
                <?php 
                    $conn = mysqli_connect("localhost", "root", "");
                    $baza = mysqli_select_db($conn, "firma_kurierska2023");
                    $kwerenda = mysqli_prepare($conn, "SELECT nazwa_oddzialu, id_oddzialu FROM oddzial_firmy");
                    mysqli_stmt_execute($kwerenda);
                    mysqli_stmt_bind_result($kwerenda, $nazwa, $id);
                    while(mysqli_stmt_fetch($kwerenda)){
                        echo "<option value='$id'>$nazwa</option>";
                    }
                    mysqli_close($conn);
                ?>
            </select><br>
            <input type="submit" value="Dodaj">
         </form>
      </div>
      <?php 
        $imie;$nazwisko;$telefon;$godziny_od;$godziny_do;$id_oddzialu;
        if(isset($_POST['imie']) && isset($_POST['naz']) && isset($_POST['tel']) && isset($_POST['godz_od']) && isset($_POST['godz_do']) && isset($_POST['id_oddzial'])){
        $imie = $_POST['imie'];
        $nazwisko = $_POST['naz'];
        $telefon = $_POST['tel'];
        $godziny_do = $_POST['godz_do'];
        $godziny_od = $_POST['godz_od'];
        $id_oddzialu = $_POST['id_oddzial'];
        if($imie == "" || $nazwisko == "" || $telefon == "" || $godziny_do == "" || $godziny_od == "" || $id_oddzialu == ""){
            echo "BRAK DANYCH";
        }
        else {
            $conn = mysqli_connect("localhost", "root", "");
            $baza = mysqli_select_db($conn, "firma_kurierska2023");
            $kwerenda = mysqli_prepare($conn, "INSERT INTO kurier(imie_kr,nazwisko_kr,telefon_kr,godziny_od,godziny_do,id_oddzialu) VALUES(?,?,?,?,?,?)");
            mysqli_stmt_bind_param($kwerenda, "sssssd", $imie, $nazwisko, $telefon, $godziny_od, $godziny_do, $id_oddzialu);
            mysqli_stmt_execute($kwerenda);  
            mysqli_close($conn); 
        }
        }

      ?>
      <div id="departments">
      <h1>Pokaż kurierów</h1>
      <p>Wybierz oddzial</p>
      <form action="kurierzy.php" method="POST">
        <select name="id_odz" id="">
        <?php 
                    $conn = mysqli_connect("localhost", "root", "");
                    $baza = mysqli_select_db($conn, "firma_kurierska2023");
                    $kwerenda = mysqli_prepare($conn, "SELECT nazwa_oddzialu, id_oddzialu FROM oddzial_firmy");
                    mysqli_stmt_execute($kwerenda);
                    mysqli_stmt_bind_result($kwerenda, $nazwa, $id);
                    while(mysqli_stmt_fetch($kwerenda)){
                        echo "<option value='$id'>$nazwa</option>";
                    }
                    mysqli_close($conn);
            ?>
        </select>
        <input type="submit" value="Pokaż">
    </form>
    <table>
            <thead>
                <th>Imie</th>
                <th>Nazwisko</th>
                <th>Telefon</th>
                <th>Godziny od</th>
                <th>Godziny do</th>
                <th>Oddział</th>
            </thead>
    <?php 
        $id;
        if(isset($_POST['id_odz'])){
            $id = $_POST['id_odz'];
        }
        $conn = mysqli_connect("localhost", "root", "");
        $baza = mysqli_select_db($conn, "firma_kurierska2023");
        $kwerenda = mysqli_prepare($conn, "SELECT kurier.imie_kr, kurier.nazwisko_kr, kurier.telefon_kr, kurier.godziny_od, kurier.godziny_do, oddzial_firmy.nazwa_oddzialu FROM kurier 
        INNER JOIN oddzial_firmy ON kurier.id_oddzialu=oddzial_firmy.id_oddzialu WHERE kurier.id_oddzialu=?");
        mysqli_stmt_bind_param($kwerenda, "d", $id);
        mysqli_stmt_execute($kwerenda);
        mysqli_stmt_bind_result($kwerenda, $imie, $naz, $tel, $godz_od, $godz_do, $nazwa);
        while(mysqli_stmt_fetch($kwerenda)){
            echo "
                <tr>
                    <td>$imie</td>
                    <td>$naz</td>
                    <td>$tel</td>
                    <td>$godz_od</td>
                    <td>$godz_do</td>
                    <td>$nazwa</td>
                    </tr>
                ";
        }
    ?>
    </table>
    </div>
</body>
</html>