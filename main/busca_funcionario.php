<?php
include_once '../core/crud.php';

$codDepart = $_POST['codDepart'];

$usuarios = crud::dataview("SELECT * FROM usuarios WHERE id_dep = " . $codDepart . " AND status='Ativo' ORDER BY nome ASC");
$arrayUsuarios = $usuarios->fetchAll(PDO::FETCH_ASSOC);
$html = "";

?>

<option value="" selected disabled>Destinatário</option>
<?php

foreach ($arrayUsuarios as $usuario) {
	
		$html .= "<option value=" . $usuario['id'] . " >" . $usuario['nome'] . "</option>";
	}

echo $html;
?>