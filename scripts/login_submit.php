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