<?php

session_start();

define("HOST", "localhost");
define("PASS", "");
define("USER", "root");

if(isset($_POST['userLogin']) && isset($_POST['Upass']) && isset($_POST['UpassR'])) {
    $log = $_POST['userLogin'];
    $haslo = $_POST['Upass'];
    $haslo_repeat = $_POST['UpassR'];

    // Check if any field is empty
    if (empty($log) || empty($haslo) || empty($haslo_repeat)) {
        echo "All fields are required.";
    } else {
        // Check if passwords match
        if ($haslo === $haslo_repeat) {
            // Create connection
            $conn = mysqli_connect(HOST, USER, PASS);

            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Select database
            $baza = mysqli_select_db($conn, "firma_kurierska2023");

            // Check if database selection was successful
            if (!$baza) {
                die("Database selection failed: " . mysqli_error($conn));
            }

            // Check if the username already exists
            $check_query = mysqli_prepare($conn, "SELECT * FROM users WHERE login = ?");
            mysqli_stmt_bind_param($check_query, "s", $log);
            mysqli_stmt_execute($check_query);
            mysqli_stmt_store_result($check_query);

            if(mysqli_stmt_num_rows($check_query) > 0) {
                echo "Username already exists. Choose a different username.";
            } else {
                // Hash the password
                $hashed_password = password_hash($haslo, PASSWORD_DEFAULT);

                // Prepare and execute the query
                $kwerenda = mysqli_prepare($conn, "INSERT INTO users(login, haslo, data_rejestracji, status) VALUES (?, ?, NOW(), 'D')");
                mysqli_stmt_bind_param($kwerenda, "ss", $log, $hashed_password);
                mysqli_stmt_execute($kwerenda);

                // Check if the query was successful
                if(mysqli_affected_rows($conn) > 0) {
                    echo "User registered successfully!";
                    header('location: log.php');
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }

            // Close the connection
            mysqli_close($conn);
        } else {
            echo "Passwords do not match!";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="RegStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
</head>
<style>
     body {
      background-image: url("bg2.png");
   }
</style>
<body>
    <div class="panel-back">
            <div class="panel">
                <form action="reg.php" class="Reg-form" method="POST">
                    <h2>Registration</h2>
                    <input name="userLogin" type="text" placeholder="Username">
                    <input name="Upass" type="text" placeholder="Password">
                    <input name="UpassR" type="text" placeholder="Reapet Password">
                    <button class="Subbut" type="submit"><p>Register</p></button>
                </form>
            </div>
    </div>

    <div class="ChangePanel">
        <a class="ChangeBut" href="log.php">
            <i class="fa-solid fa-arrow-right"></i>
            <p>Logowanie</p>
        </a>
    </div>
    
    
</body>
</html>
