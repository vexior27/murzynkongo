<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="LogStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<body>
    <div class="panel-back">
        <div class="panel">
            <form action="log.php" class="Reg-form" method="POST">
                <h2>Login</h2>
                <input type="text" name="Uname" placeholder="Username">
                <input type="text" name="Upass" placeholder="Password">
                <button class="Subbut" type="submit"><p>Login</p></button>
            </form>
        </div>
    </div>

    <div class="ChangePanel">
        <a class="ChangeBut" href="http://localhost/murzynkongo-master/reg.php">
            <i class="fa-solid fa-arrow-right"></i>
            <p>Rejestracja</p>
        </a>
    </div>
</body>
</html>

<?php
define("HOST", "localhost");
define("PASS", "");
define("USER", "root");

if(isset($_POST['Uname']) && isset($_POST['Upass'])) {
    $log = $_POST['Uname'];
    $haslo = $_POST['Upass'];

    if (empty($log) || empty($haslo)) {
        echo "All fields are required.";
    } else {
        $conn = mysqli_connect(HOST, USER, PASS);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $baza = mysqli_select_db($conn, "firma_kurierska2023");

        if (!$baza) {
            die("Database selection failed: " . mysqli_error($conn));
        }

        $kwerenda = mysqli_prepare($conn, "SELECT * FROM users WHERE login = ?");
        mysqli_stmt_bind_param($kwerenda, "s", $log);
        mysqli_stmt_execute($kwerenda);
        mysqli_stmt_store_result($kwerenda);

        if(mysqli_stmt_num_rows($kwerenda) > 0) {
            $kwerenda = mysqli_prepare($conn, "SELECT haslo FROM users WHERE login = ?");
            mysqli_stmt_bind_param($kwerenda, "s", $log);
            mysqli_stmt_execute($kwerenda);
            mysqli_stmt_store_result($kwerenda);
            mysqli_stmt_bind_result($kwerenda, $stored_password);

            if (mysqli_stmt_fetch($kwerenda)) {
                if (password_verify($haslo, $stored_password)) {
                    echo "Login successful!";
                    header('location: dashboard.php');

                } else {
                    echo "Incorrect password.";
                }
            }
        } else {
            echo "User not found.";
        }

        mysqli_close($conn);
    }
}
?>
