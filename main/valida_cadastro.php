<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
?>

<?php

$ativo = 0;
$valor  = $_GET['v'];
$valor2  = $_GET['v2'];

if ($valor == "") {
    echo "<script>window.location ='cadastro.php';</script>";  
}

$cdt = crud::mostraUsuario($valor, $valor2);
$codigo = $cdt['valida'];
$email = $cdt['email'];

if ($valor == $codigo && $valor2 == $email ) {
    $ativo = 1;
    $valida = $valor;
    $cdt = crud::ativarUsuario($ativo, $valida);
    echo "Cadastro ativado com sucesso!";
    echo "<script>window.location ='logout.php';</script>"; 
} else {
    echo "Nao foi possivel ativar o cadastro - " + " <a href=cadastro.php> Click aqui para tentar novamente</a>";
}

?>

<?php
require_once "rodape.php";
include_once "modais.php";
?>