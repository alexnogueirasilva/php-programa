
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
								<td>".$row['inst_id']."</td>
								<td>".$row['inst_nome']."</td>
								<td>".$row['inst_nomeFantasia']."</td>
								<td>".crud::formataData($row['inst_dataCadastro'])."</td>
								<td><a class='btn btn-info waves-effect waves-light' id='btnEditar' data-whatever='@getbootstrap' data-codigo=".$row['inst_id']." data-codigoacesso=".$row['inst_codigo']." data-nome=".$row['inst_nome']." data-nomefantasia=".$row['inst_nomeFantasia'].">Editar</a></td>
								<td><a class='btn btn-danger waves-effect waves-light' data-target='#modalExcluir'  id='btnExcluir' data-whatever='@getbootstrap' data-codigo=".$row['inst_id']." data-codigoacesso=".$row['inst_codigo']." data-nome=".$row['inst_nome']." data-nomefantasia=".$row['inst_nomeFantasia'].">Exluir</a></td>
								</tr>";
			}
		} else {
			echo "<p class='text-danger'>Sem informacoes cadastradas</p>";
		}
		echo $html;
		break;
}
