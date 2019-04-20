
<?php
include_once '../core/crud.php';

		$clientes = crud::dataview("SELECT nomecliente FROM clientes ORDER BY nomecliente ASC");
		$arrayclientes = $clientes->fetchAll(PDO::FETCH_ASSOC);
		$html = "";
		?>
			 <option value="" selected disabled>Clientes</option>
		<?php
		
		foreach ($arrayclientes as $cliente){
			$html .= "<option value=".$cliente['id']." >".$cliente['nomecliente']."</option>";
		}

	echo $html;
?>