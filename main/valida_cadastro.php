<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
?>

<?php

$ativo = 0;
$valor  = $_GET['v'];
$valor2  = $_GET['v2'];
$valor3  = $_GET['v3'];

if ($valor == "" || $valor2 == "" || $valor3 == "" ) {
    echo "<script>window.location ='index.php';</script>";  
}

$cdt = crud::mostraUsuario($valor, $valor2, $valor3);
$codigo = $cdt['valida'];
$email = $cdt['email'];
$idInstituicao = $cdt['fk_idInstituicao'];

if ($valor == $codigo && $valor2 == $email && $valor3 == $idInstituicao ) {
    $ativo = 1;
    $valida = $valor;
    $cdt = crud::ativarUsuario($ativo, $valida,$idInstituicao);
    echo "Cadastro ativado com sucesso!";
    echo "<script>window.location ='logout.php';</script>"; 
} else {
    echo "Nao foi possivel ativar o cadastro - " + " <a href=index.php> Click aqui para tentar novamente</a>";
}

?>

<?php
require_once "rodape.php";
include_once "modais.php";
?>