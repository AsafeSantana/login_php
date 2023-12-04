<?php

// Verifica se houve uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?rota=login');
    exit;
}

// Obtém os dados do POST
$usuario = $_POST['text_usuario'] ?? null;
$senha = $_POST['text_senha'] ?? null;

// Verifica se os dados foram preenchidos
if (empty($usuario) || empty($senha)) {
    header('Location: index.php?rota=login');
    exit;
}

$db = new database();
$params = [
    ':usuario' => $usuario
];
$sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
$result = $db->query($sql, $params);

if ($result['status'] === 'error') {
    header('Location: index.php?rota=404');
    exit;
}

if (count($result['data']) === 0) {
    // Erro na sessão
    $_SESSION['error'] = 'Usuário ou Senha inválidos';
    header('Location: index.php?rota=login');
    exit;
}

// Verifica se o usuário existe
if (!password_verify($senha, $result['data'][0]->senha)) {
    // Erro na sessão
    $_SESSION['error'] = 'Usuário ou senha inválidos';
    header('Location: index.php?rota=login');
    exit;
}

// Define a sessão do usuário
$_SESSION['usuario'] = $result['data'][0];

// Redireciona para a página inicial
header('Location: index.php?rota=login');



