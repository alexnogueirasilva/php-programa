
<?php
include_once '../core/crud.php';

$codUserDestino = $_POST['codUserDestino'];
	
		
		$emails = crud::dataview("SELECT email FROM usuarios WHERE id = ".$codUserDestino);
		$arrayEmails = $emails->fetchAll(PDO::FETCH_ASSOC);
		$html = "";
		
		
		
		$html .= $arrayEmails[0]['email'];
		

		
	
	echo $html;
?>