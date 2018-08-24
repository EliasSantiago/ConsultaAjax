<?php 
include 'conexao.php';

$tabela = $_POST['tabela'];
$banco  = $_POST['dbname']; 
$var = new Conexao();
$var->buscarCampos($banco, $tabela);


 ?>