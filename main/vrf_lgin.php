<?php

session_start();         //A seção deve ser iniciada em todas as páginas
if (!isset($_SESSION['usuarioID'])) {                //Verifica se há seções
        session_destroy();                        //Destroi a seção por segurança
        header("Location: ../index.php");
        exit;        //Redireciona o visitante para login

}

$registro = $_SESSION['registro'];
$limite = $_SESSION['limite'];

if($registro){
 $segundos = time()- $registro;
}

if($segundos>$limite){
 session_destroy();
 header("Location: ../index.php");
} else{
 $_SESSION['registro'] = time();
}
$andre = date('Y-m-d-H:i:s');;
