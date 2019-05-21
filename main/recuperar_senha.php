<?php

include_once '../core/crud.php';
?>

<?php

$ativo = 0;
$valor  = $_GET['v'];
$valor2  = $_GET['v2'];

if ($codInstituicao == "" && $email =="" && $senha == "") {
    echo "<script>window.location ='logout.php';</script>";  
}

$cdt = crud::mostraUsuario($codInstituicao, $email, $senha);
$codigo = $cdt['valida'];
$email = $cdt['email'];

if ($valor == $codigo && $valor2 == $email ) {
    $ativo = 1;
    $valida = $valor;
    $cdt = crud::ativarUsuario($ativo, $valida);
    echo "Cadastro ativado com sucesso!";
   // echo "<script>window.location ='logout.php';</script>"; 
} else {
    echo "Nao foi possivel ativar o cadastro - " + " <a href=cadastro.php> Click aqui para tentar novamente</a>";
}

?>

<?php

include_once "modais.php";
?>