<?php
require_once 'crud.php';
require_once 'crudContato.php';

//isset()
$value = isset($_POST['tipo']) ? $_POST['tipo'] : '';

switch ($value) {
				
	case 'Salvar':
		$nomeCliente 		= $_POST['nomeCliente'];
		$codCliente 		= $_POST['codCliente'];
		$idInstituicao 		= $_POST['idInstituicao'];
		$dataCadastro 		= $_POST['dataAtual'];
		$dataAlteracao 		= $_POST['dataAtual'];
		$nomeContato		= $_POST['nomeContato'];		
		$telefoneContato 	= $_POST['telefoneContato'];
		$celularContato 	= $_POST['celularContato'];
		$emailContato 		= $_POST['emailContato'];	
		$codContato 		= $_POST['codContato'];
		$cargoSetor 		= $_POST['cargoSetor'];
		$acao 				= $_POST['acao'];	

			if ($acao == 1) {
					//cadastrar
				$codContato = crudContato::cadastrar($codCliente, $dataCadastro, $idInstituicao, $nomeContato,$telefoneContato,$celularContato,$emailContato,$cargoSetor  );
			} else if ($acao == 2) {
					//alterar						
				$codContato = crudContato::alterar($codContato,$codCliente, $dataCadastro, $idInstituicao, $nomeContato,$telefoneContato,$celularContato,$emailContato,$cargoSetor);
			} else if ($acao == 3) {
					//excluir						
				$codContato = crudContato::excluir($codContato, $idInstituicao);
			}

			if ($codContato == true) {
				echo $codContato;
			} else {
				echo 0;
			}		

	break;
	
	//controlepedido

	case 'pesquisar':
		$valorPesquisar = $_POST['valorPesquisar'];
		$html = '';
		$cdt = crud::pesquisar($valorPesquisar);

		if ($cdt == true) {
			if ($cdt->rowCount() > 0) {
				while ($row = $cdt->fetch(PDO::FETCH_ASSOC)) {
					$html .= "<tr>
									<td>" . $row['inst_id'] . "</td>
									<td>" . $row['inst_nome'] . "</td>
									<td>" . $row['inst_nomeFantasia'] . "</td>
									<td>" . crud::formataData($row['inst_dataCadastro']) . "</td>
									<td><a class='btn btn-info waves-effect waves-light' id='btnEditar' data-whatever='@getbootstrap' data-codigo=" . $row['inst_id'] . " data-codigoacesso=" . $row['inst_codigo'] . " data-nome=" . $row['inst_nome'] . " data-nomefantasia=" . $row['inst_nomeFantasia'] . ">Editar</a></td>
									<td><a class='btn btn-danger waves-effect waves-light' data-target='#modalExcluir'  id='btnExcluir' data-whatever='@getbootstrap' data-codigo=" . $row['inst_id'] . " data-codigoacesso=" . $row['inst_codigo'] . " data-nome=" . $row['inst_nome'] . " data-nomefantasia=" . $row['inst_nomeFantasia'] . ">Excluir</a></td>
									</tr>";
				}
			} else {
				echo "<p class='text-danger'>Sem informacoes cadastradas</p>";
			}
			echo $html;
		} else {
			echo 0;
		}
	break;

	case 'suporte':
		$nomeUsuario 	= $_POST['nomeUsuarioSuporte'];
		$mensagem = $_POST['mensagemPedidoSuporte'];
		$erro 	= 	$_POST['erro'];
		$email			 = $_POST['emailSuporte'];
		$data = crud::formataData($_POST['dataSuporte']);

		crud::enviarEmailSuporte($email, $mensagem, $nomeUsuario, $erro, $data);

	break;
}
