<?php
include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';

//testando como enviar e-mail


$to = $_POST['email'];
$senha = $_POST['senha'];
$dica = $_POST['dica'];
$valida = md5("$to");


$subject = "Assunto Teste e-mail";
$message="<a href=valida_cadastro.php?v=$valida&$to> Teste de envio de mensagem </a>";
$headers = 'MIME-Version: 1.0'. "\r\n";
$headers .= 'content-type: text/html; charset=iso-8859-1'."\r\n";
$headers .= 'To: Carlos Andre <programadorfsaba@gmail.com>'."\r\n";
$headers .= 'From:< carlosandrefsaba@gmail.com>'."\r\n";
$headers .= 'CC:< programadorfsaba@gmail.com>'."\r\n";
$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>'."\r\n";

mail($to,$subject,$message,$headers);
?>

<?php
require_once "rodape.php";
include_once "modais.php";
?>