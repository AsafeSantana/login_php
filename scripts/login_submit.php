<?php

// verifica se aconteceu um POST
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php?rota=login');
    exit;
}

//vai buscar os dados do POST
$usuario = $_POST[ 'text_usuario'] ?? null;
$senha = $_POST['text_senha'] ?? null;

//verifica se os dados estão preenchidos
if(empty(!$usuario) ||  empty(!$senha)){
    header('Location: index.php?rota=login' );
    exit;
}

$db = new database;
$params = [
    ':usuario' => $usuario
];
$sql = "SELECT *  FROM usuarios WHERE usuario = :usuario";
$result = $db->query($sql,$params);

if ($result['status'] === 'error'){
    header('Location: index.php?rota=404');
    exit;
}

if(count($result['data'])===0){
    //erro na sessao
    $_SESSION['error'] = 'Usuário ou Senha inválidos';
    header('Location: index.php?rota=login');
    exit;
}

//verifica se o usuario existe
if(!password_verify($senha,$result['data'][0]->senha)){
    
    //erro  na sessao
    $_SESSION['error'] = 'Usuário ou senha inválidos';

    header('Location: inde.php?rota=login');
    exit;
}

// define a sessão do usuário
$_SESSION['usuario'] = $result['data'][0]->usuario;



