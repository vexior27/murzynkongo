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
            <button id="logout">Wyloguj</button>
        </div>
        <div id="menu">
        <ul>
            <li><i class="fa-solid fa-house"></i><a href="dashboard.php">Strona główna</a></li>
            <li><i class="fa-solid fa-users"></i><a href="oddzialy.php">Dane oddzialu</a></li>
            <li><i class="fa-solid fa-truck-fast"></i>Kurierzy</li>
            <li><i class="fa-solid fa-user"></i><a href="nadawcy.php">Nadawcy</a></li>
            <li class="active"><i class="fa-regular fa-user"></i><a href="odbiorcy.php">Odbiorcy</a></li>
            <li><i class="fa-solid fa-box"></i><a href="przesylka.php">Przesyłka</a></li>
        </ul>
        </div>
    </div>
    <div id="nav">
        Dodaj odbiorce
    </div>
    <div id="main">
        <div>
            <form action="odbiorcy.php" method="POST">
                <input type="text" name="imie" id="" placeholder="Imie" required><input type="text" name="naz" id="" placeholder="Nazwisko" required><br>
                <label>Dane osobowe</label><br><br>
                <input type="text" name="email" id="" required><br>
                <label>Email</label><br><br>
                <input type="text" name="tel" id="" required><br>
                <label>Telefon</label><br><br>
                <select name="typ" id="">
                    <option value="P">P</option>
                    <option value="F">F</option>
                </select><br>
                <label>Typ</label><br><br>
                <input type="text" name="ul" id="" placeholder="Ulica" style="width: 300px;" required><input type="text" name="nrd" id="" required placeholder="Nr domu" style="width: 100px;">
                <input type="text" name="nrl" id="" placeholder="Nr lokalu" style="width: 100px;"><br>
                <input type="text" name="miasto" id="" placeholder="Miasto" style="width: 250px;" required><input type="text" name="kodp" id="" placeholder="Kod pocztowy" required><br>
                <label>Adres zamieszkania</label><br>
                <input type="submit" value="Dodaj nadawce" class="add-btn" >
            </form>
        </div>
        <?php 
            $imie;$nazwisko;$email;$tel;$typ;$ulica;$nrdomu;$nrlokalu;$kodpocz;$miasto;
            if(isset($_POST['imie']) && isset($_POST['naz']) && isset($_POST['email']) && isset($_POST['tel']) && isset($_POST['typ']) && isset($_POST['ul']) && isset($_POST['nrd']) && isset($_POST['kodp']) && isset($_POST['miasto']) ){
                $imie = $_POST['imie'];
                $nazwisko = $_POST['naz'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
                $typ = $_POST['typ'];
                $ulica = $_POST['ul'];
                $nrdomu = $_POST['nrd'];
                $nrlokalu = $_POST['nrl'];
                $kodpocz = $_POST['kodp'];
                $miasto = $_POST['miasto'];
                $conn = mysqli_connect("localhost", "root", "");
                $baza = mysqli_select_db($conn,"firma_kurierska2023");
                $kwer = mysqli_prepare($conn, "INSERT INTO nadawca(imie_n,nazwisko_n,email_n,telefon_n,typ_n,ulica_n,nr_domu_n,nr_lokalu_n,kod_n,miasto_n) VALUES (?,?,?,?,?,?,?,?,?,?)");
                mysqli_stmt_bind_param($kwer, "ssssssssss", $imie, $nazwisko,$email,$tel,$typ,$ulica,$nrdomu,$nrlokalu,$kodpocz,$miasto);
                mysqli_stmt_execute($kwer);
                mysqli_close($conn);
            }
        ?>
        <div>

        </div>
    </div>
</body>
</html>