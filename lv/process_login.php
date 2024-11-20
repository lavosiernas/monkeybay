<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Lê o arquivo de credenciais
    $credentials = file('credentials.txt', FILE_IGNORE_NEW_LINES);
    $authenticated = false;

    foreach ($credentials as $line) {
        list($stored_email, $stored_hash) = explode(':', $line);

        if ($email === $stored_email && password_verify($password, $stored_hash)) {
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        $_SESSION['user_email'] = $email;
        header("Location: index.php");
    } else {
        $_SESSION['error'] = "Email ou senha incorretos";
        header("Location: login.php");
    }
}
?>