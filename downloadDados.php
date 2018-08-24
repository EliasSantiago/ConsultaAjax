<?php 
include 'conexao.php';

$banco = $_POST['dbName'];
$tabela = $_POST['tabela'];
$campos = $_POST['campos'];

$var = new Conexao();
$var->download($banco, $tabela, $campos);

?>