<?php 
define('host','localhost');
define('user','root');
define('pass','');
$conn = mysqli_connect(host,user,pass);
$baza = mysqli_select_db($conn, 'firma_kurierska2023');
// Sprawdzanie typu połączenie oraz tokenu
session_start();
if(($_SERVER['REQUEST_METHOD']==='POST') && hash_equals($_SESSION['log_token'], $_POST['lToken'])){
    // Wstepne czyszczenie danych
    // trim() - usuwa spacje z poczatku i konca stringu
        $user = mysqli_real_escape_string($conn, trim($_POST['userLogin']));
        $pass = mysqli_real_escape_string($conn, trim($_POST['userPass']));
    // Obsluga logowania
    if($_SERVER['REQUEST_METHOD']==='POST'){ // Blokowanie rzadania przez URL
        $kwerenda = mysqli_prepare($conn, "SELECT login, haslo FROM users WHERE login=?");
        mysqli_stmt_bind_param($kwerenda, 's', $user);
        mysqli_stmt_execute($kwerenda);
        // Obsluga SELECT
        mysqli_stmt_bind_result($kwerenda, $ul, $up);
        mysqli_stmt_fetch($kwerenda);
        if(mysqli_stmt_affected_rows($kwerenda) ==- 1) {
            // Sprawdzanie hasła
            if(password_verify($pass, $up)){
                echo "Login i hasło zgodne!";
                // Uruchomienie sesji uzytkownika
                session_start();
                $_SESSION['userLogin'] = $ul;
                // Usuniecie tokenu z sesji
                unset($_SESSION['log_token']);
                // przekierowywanie po pomyślnej autoryzacji
                header('location: dashboard.php');
            }else {
                echo "Niepoprawne dane logowania!";
            }
        }
    }
}else {
    echo "Błąd CSRF: niepoprawy token logowania";
}
    mysqli_close($conn);
?>