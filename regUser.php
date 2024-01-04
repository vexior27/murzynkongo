<?php 
    define('host','localhost');
    define('user','root');
    define('pass','');
    $conn = mysqli_connect(host,user,pass);
    $baza = mysqli_select_db($conn, 'firma_kurierska2023');
    // Wstepne czyszczenie danych
    // trim() - usuwa spacje z poczatku i konca stringu
        $user = mysqli_real_escape_string($conn, trim($_POST['userLogin']));
        $pass = mysqli_real_escape_string($conn, trim($_POST['userPass']));
    // Generowanie hasha dla hasła użytkownika:
        $pass = password_hash($pass, PASSWORD_DEFAULT);
    // Rejestracja usera w bazie:
        $kwerenda = mysqli_prepare($conn, "INSERT INTO users VALUES(null,?,?,CURRENT_DATE(),'D')");
        mysqli_stmt_bind_param($kwerenda, 'ss', $user, $pass);
        mysqli_stmt_execute($kwerenda);
    // Sprawdzenie czy dane zostały dodane do bazy:
    // mysqli_stmt_affected_rows() - Ile kolumn zostalo obietych w ostatnim zapytaniu
        if(mysqli_stmt_affected_rows($kwerenda) == 1){
            echo "Pomyślnie zarejestrowano dane użytkownika";
        }
        else {
            echo "Resovii nie rejestrujemy!";
        }
    mysqli_close($conn);

?>