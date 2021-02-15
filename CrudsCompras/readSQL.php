<?php
if (!isset($_SESSION)) {
    session_start();
}

//Conexão 
require_once $_SERVER['DOCUMENT_ROOT'] . '/BancoDeDados/Conexao.php';
global $conexao;

//Chamando as informações do Banco do Dados
$sql = "SELECT * from Produtos";
$resultado= mysqli_query($conexao, $sql);

//Salvar as informações em um Array chamado arrayProdutos
$arrayProdutos = [];
if (mysqli_num_rows($resultado) != 0) {
    while ($row = mysqli_fetch_array($resultado)) {
        array_push($arrayProdutos, $row);
    }
}

//Pegando produtos esperando pagamento ou já pagos

//Chamando as informações do Banco do Dados
$sql = "SELECT id_produto from Compras";
$resultado= mysqli_query($conexao, $sql);

//Salvar as informações em um Array chamado arrayProdutos
$arrayProdutosComprados = [];
if (mysqli_num_rows($resultado) != 0) {
    while ($row = mysqli_fetch_array($resultado)) {
        array_push($arrayProdutosComprados, $row);
    }
}

//Fecha conexão
$conexao-> close();
?>

