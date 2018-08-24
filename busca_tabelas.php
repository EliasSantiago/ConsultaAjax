<?php 
include 'conexao.php';

$db = new Conexao();
$nomeBanco = $_POST['banco'];
$db->buscarTabelas($nomeBanco);

 ?>