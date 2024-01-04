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
   <title>Oddziały</title>
</head>
<style>



</style>
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
            <li class="active"><i class="fa-solid fa-users"></i>Dane oddziału</li>
            <li><i class="fa-solid fa-truck-fast"></i><a href="kurierzy.php">Kurierzy</a></li>
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
        <h1>Dodaj nowy oddział</h1>
         <form action="oddzialy.php" method="POST">
            <label for="">Nazwa oddziału </label><input type="text" name="odz_name"><br>
            <label for="">Ulica oddziału </label><input type="text" name="odz_ulica"><br>
            <label for="">Numer domu oddziału </label><input type="text" name="odz_nr_domu"><br>
            <label for="">Numer lokalu oddziału </label><input type="text" name="odz_nr_lok"><br>
            <label for="">Kod pocztowy </label><input type="text" name="odz_kod_pocz"><br>
            <label for="">Miasto </label><input type="text" name="odz_miasto"><br>
            <label for="">Telefon </label><input type="text" name="odz_tel"><br>
            <label for="">Email </label><input type="text" name="odz_email"><br>
            <input type="submit" value="Dodaj">
         </form>
      </div>
      <?php 
      define("host", "localhost");
      define("pass", "");
      define("user", "root");
      $nazwa;
      $ulica;
      $nr_domu;
      $nr_lokalu;
      $kod;
      $miasto;
      $tel;
      $email;
      if(isset($_POST['odz_name']) && isset($_POST['odz_ulica']) && isset($_POST['odz_nr_domu']) && isset($_POST['odz_nr_lok']) && isset($_POST['odz_kod_pocz']) && isset($_POST['odz_miasto']) && isset($_POST['odz_tel']) && isset($_POST['odz_email'])){
        $nazwa = $_POST['odz_name'];
        $ulica = $_POST['odz_ulica'];
        $nr_domu = $_POST['odz_nr_domu'];
        $nr_lokalu = $_POST['odz_nr_lok'];
        $kod = $_POST['odz_kod_pocz'];
        $miasto = $_POST['odz_miasto'];
        $tel  = $_POST['odz_tel'];
        $email = $_POST['odz_email'];
        $conn = mysqli_connect(host,user,pass);
        $baza = mysqli_select_db($conn,"firma_kurierska2023");
        $kwerenda = mysqli_prepare($conn, "INSERT INTO oddzial_firmy(nazwa_oddzialu,ulica_oddzialu, nr_domu_oddzialu,nr_lokalu_oddzialu, kod_oddzialu, miasto_oddzialu, tel_oddzialu, email_oddzialu) 
        VALUES(?,?,?,?,?,?,?,?)");
        mysqli_stmt_bind_param($kwerenda, "sssdssss",$nazwa,$ulica,$nr_domu,$nr_lokalu,$kod,$miasto,$tel,$email);
        mysqli_stmt_execute($kwerenda);
        mysqli_close($conn);
        }
      ?>
      
      <div id="departments">
        <h1>Wszystkie oddziały</h1>
        <table>
            <thead>
                <th>ID</th>
                <th>Nazwa oddziału</th>
                <th>Ulica oddziału</th>
                <th>Numer domu</th>
                <th>Numer lokalu</th>
                <th>Kod pocztowy</th>
                <th>Miasto</th>
                <th>Telefon</th>
                <th>Email</th>
            </thead>
         <?php 
            $conn = mysqli_connect(host,user,pass);
            $baza = mysqli_select_db($conn,"firma_kurierska2023");
            $kwerenda = mysqli_prepare($conn, "SELECT id_oddzialu, nazwa_oddzialu,ulica_oddzialu, nr_domu_oddzialu,nr_lokalu_oddzialu, kod_oddzialu, miasto_oddzialu, tel_oddzialu, email_oddzialu FROM oddzial_firmy");
            mysqli_stmt_execute($kwerenda);
            mysqli_stmt_bind_result($kwerenda,$id,$nazwa,$ulica,$nr_domu,$nr_lokalu,$kod,$miasto,$tel,$email);
            while(mysqli_stmt_fetch($kwerenda)){
                echo "
                <tr>
                    <td>$id</td>
                    <td>$nazwa</td>
                    <td>$ulica</td>
                    <td>$nr_domu</td>
                    <td>$nr_lokalu</td>
                    <td>$kod</td>
                    <td>$miasto</td>
                    <td>$tel</td>
                    <td>$email</td>
                    </tr>
                ";
            }
            mysqli_close($conn);
         ?>
         </table>
      </div>
   </div>
</body>
</html>