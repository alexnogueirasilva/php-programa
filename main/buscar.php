
<?php
include_once '../core/crud.php';


$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

switch ($tipo) {

	case 'pesquisar':
	
	$valorPesquisar = $_POST['valorPesquisar'];
		$html = '';

		$dados1 = crud::dataview("SELECT * FROM instituicao 
		WHERE inst_nome LIKE'%".$valorPesquisar."%' ORDER BY inst_nome desc");
		$dados = $dados1->fetchAll(PDO::FETCH_ASSOC);
		// $dados = crud::listarInstituicao();

		if ($dados) {
			foreach($dados as $row) {

				$html .= "<tr>
								<td>" . $row['inst_id'] . "</td>
								<td>" . $row['inst_nome'] . "</td>
								<td>" . $row['inst_nomeFantasia'] . "</td>
								<td>" . $row['inst_dataCadastro'] . "</td>								
							</tr>";
			}
		} else {
			echo "<p class='text-danger'>Sem informacoes cadastradas</p>";
		}
		echo $html;
		break;
}
