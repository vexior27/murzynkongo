 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja użytkownika</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #222;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    form {
        background-color: #333;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.1);
        width: 300px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #fff;
    }

    input {
        width: 100%;
        padding: 10px;
        margin-bottom: 16px;
        box-sizing: border-box;
        border: 1px solid #444;
        background-color: #555;
        color: #fff;
        border-radius: 4px;
    }

    input[type="submit"] {
        background-color: #4caf50;
        color: #fff;
        cursor: pointer;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    input[type="text"]:hover,
    input[type="password"]:hover {
        border-color: #5a5a5a;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color: #3498db;
        box-shadow: 0 0 10px rgba(52, 152, 219, 0.5);
    }

    </style>
</head>
<body>
    <?php 
        // Generowanie tokenu i przechowanie go w sesji
        session_start();
        if(!isset($_SESSION['log_token'])) {
            $_SESSION['log_token'] = bin2hex(random_bytes(32));
            //echo $_SESSION['log_token'];
        }
        
    ?>
    <form action="usrLogin_f.php" method="post">
        <label for="">Login</label><br><input type="text" name="userLogin" id=""><br>
        <label for="">Password</label><br><input type="password" name="userPass" id=""><br>
        <!-- Pole ukryte na token -->
        <input type="hidden" name="lToken" value="<?php echo $_SESSION['log_token']?>">
        <input type="submit" value="Zaloguj">
    </form>
</body>
</html>