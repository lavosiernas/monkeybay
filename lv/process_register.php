<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email inválido");
    }

    // Hash da senha
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Formato do registro: email:senha_hash
    $new_user = $email . ':' . $hashed_password . "\n";

    // Verifica se o email já existe
    $existing_users = file_get_contents('credentials.txt');
    if (strpos($existing_users, $email . ':') !== false) {
        die("Este email já está registrado");
    }

    // Adiciona novo usuário ao arquivo
    if (file_put_contents('credentials.txt', $new_user, FILE_APPEND)) {
        $_SESSION['message'] = "Registro realizado com sucesso!";
        header("Location: login.php");
    } else {
        die("Erro ao registrar usuário");
    }
}
?>