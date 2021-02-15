<?php

//Salvando informações do banco de dados
$host = "localhost";
$nomeDeUsuario = "root";
$senha = "";
$bdNome = "GNVendas";


$conexao = new mysqli($host, $nomeDeUsuario, $senha, $bdNome);

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['debug'])) {
    $_SESSION['debug'] = [];
}

// DEBUG
if ($conexao->connect_error) {
    array_push($_SESSION['debug'], "Falha na conexão com o banco de Dados: $conexao->connect_error");
} else {
    //array_push($_SESSION['debug'], 'Connection successful!');
}
?>