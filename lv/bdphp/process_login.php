<?php
session_start();
header('Content-Type: application/json');

// Função para validar email
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Função para ler usuários do arquivo
function getUsers()
{
    $usersFile = 'users.json';
    if (file_exists($usersFile)) {
        $jsonContent = file_get_contents($usersFile);
        return json_decode($jsonContent, true);
    }
    return ['users' => []];
}

// Função para salvar usuários no arquivo
function saveUsers($users)
{
    $usersFile = 'application\user.json';
    file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT));
}

// Função para registrar novo usuário
function registerUser($email, $password)
{
    $users = getUsers();

    // Verifica se o email já existe
    foreach ($users['users'] as $user) {
        if ($user['email'] === $email) {
            return false;
        }
    }

    // Cria novo usuário com senha hasheada
    $users['users'][] = [
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ];

    saveUsers($users);
    return true;
}

// Função para verificar login
function verifyLogin($email, $password)
{
    $users = getUsers();

    foreach ($users['users'] as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            return true;
        }
    }
    return false;
}

// Processa a requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $data['password'] ?? '';

    if (!validateEmail($email)) {
        echo json_encode(['success' => false, 'message' => 'Email inválido']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Senha deve ter pelo menos 6 caracteres']);
        exit;
    }

    // Verifica se é login ou registro
    if (isset($data['action']) && $data['action'] === 'register') {
        if (registerUser($email, $password)) {
            echo json_encode(['success' => true, 'message' => 'Usuário registrado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email já cadastrado']);
        }
    } else {
        if (verifyLogin($email, $password)) {
            $_SESSION['user_email'] = $email;
            echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
        }
    }
}
?>