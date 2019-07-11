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
		$acao 				= $_POST['acao'];	

			if ($acao == 1) {
					//cadastrar
				$cad = crudContato::cadastrar($codCliente, $dataCadastro, $idInstituicao, $nomeContato,$telefoneContato,$celularContato,$emailContato  );
			} else if ($acao == 2) {
					//alterar
						
				$cad = crudContato::alterar($codContato,$codCliente, $dataCadastro, $idInstituicao, $nomeContato,$telefoneContato,$celularContato,$emailContato);
			}

			if ($cad == true) {
				echo $cad;
			} else {
				echo 0;
			}		

	break;

	case 'editarPedido':
		$descricao  = $_POST['edtDescricao'];
		$edtId         = $_POST['edtId'];
		$cad = crud::editarPedido($codControle, $numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao, $idInstituicao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
	break;

	case 'AlterarPedido2':
		$codControle        = $_POST['codigoControleAlterar'];
		$email		        = $_POST['emailAlterar2'];
		$statusPedido		= $_POST['statusPedidoAlterar'];
		$mensagemAlterar    = $_POST['mensagemPedidoAlterar'];
		$nomeCliente  		= $_POST['idClientePedidoAlterar'];
		$numeroAf         	= $_POST['numeroAfPedidoAlterar'];
		$valorPedidoAtual   = $_POST['valorPedidoAlterar'];
		$valorPedido 		= str_replace(",", ".", $valorPedidoAtual);
		$idInstituicao 		= $_POST['idInstituicaoAlterar'];
		$numeroLicitacao    = $_POST['numeroLicitacaoPedidoAlterar'];
		$anexoAlterar       = $_POST['anexoAlterar'];
		$dataAbertura 		= $_POST['dataAtual2'];
		$dataAlteracao 		= $_POST['dataAtual2'];
		$subject			= $_POST['subjectAlterar2'];
		$nomeUsuario		= $_POST['nomeUsuarioAlterar2'];
		$Cliente 			= $_POST['ClienteAlterar2'];
		$Status 			= $_POST['statusAlterar2'];
		//ENTRA AQUI SE TIVER ANEXO
		if (!empty($_FILES["file"]["name"])) {

			$validextensions = array("jpeg", "jpg", "png", "PNG", "JPG", "JPEG", "pdf", "PDF", "docx");
			$temporary = explode(".", $_FILES["file"]["name"]);
			$file_extension = end($temporary);
			$anexoAlterar = md5($dataAbertura) . "." . $file_extension;

			if (in_array($file_extension, $validextensions)) {
				$sourcePath = $_FILES['file']['tmp_name'];
				$targetPath = "../anexos/" . md5($dataAbertura) . "." . $file_extension;
				move_uploaded_file($sourcePath, $targetPath); // Move arquivo				
				//SALVA NO BANCO
				$cad = crud::AlterarPedido2(
					$codControle,
					$statusPedido,
					$mensagemAlterar,
					$nomeCliente,
					$numeroAf,
					$valorPedido,
					$numeroLicitacao,
					$anexoAlterar,
					$idInstituicao,
					$dataAlteracao
				);
				$anexo = $anexoAlterar;
				if ($cad == true) {
					echo 1;
					if (!$email == '') {
						$dadosCadastro = "Codigo: " . $codControle . " <br>" . "Cliente: " . $Cliente . " <br>" . "Status: " . $Status . " <br>" . "Licitacao: " . $numeroLicitacao . " <br>" . "Autorizacao: " . $numeroAf
							. " <br>" . "Valor do Pedido R$: " . $valorPedidoAtual . " <br>" . "Observacao do pedido: " . $mensagemAlterar;
						crud::enviarEmailPedidoAnexo($email, $subject, $nomeUsuario, $anexo, $dadosCadastro);
					}
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}
		} else {
			//CASO NÃO TENHA ANEXO ENTRA AQUI
			$anexo = $anexoAlterar;
			$cad = crud::AlterarPedido2($codControle, $statusPedido, $mensagemAlterar, $nomeCliente, $numeroAf, $valorPedido, $numeroLicitacao, $anexoAlterar, $idInstituicao, $dataAlteracao);

			if ($cad == true) {
				echo 1;
				if (!$email == '') {
					$dadosCadastro = "Codigo: " . $codControle . " <br>" . "Cliente: " . $Cliente . " <br>" . "Status: " . $Status . " <br>" . "Licitacao: " . $numeroLicitacao . " <br>" . "Autorizacao: " . $numeroAf
						. " <br>" . "Valor do Pedido R$: " . $valorPedidoAtual . " <br>" . "Observacao do pedido: " . $mensagemAlterar;
					crud::enviarEmailPedidoAnexo($email, $subject, $nomeUsuario, $anexo, $dadosCadastro);
				}
			} else {
				echo 0;
			}
		}
	break;

	case 'AlterarPedido':
		$statusPedido		= $_POST['statusPedidoAlterar'];
		$codControle        = $_POST['codigoControleAlterar'];
		$mensagemAlterar    = $_POST['mensagemPedidoAlterar'];
		$idInstituicao 		= $_POST['idInstituicaoAlterar'];
		$email		 		= $_POST['emailAlterar'];
		$dataAlteracao 		= $_POST['dataAtual'];
		$dataFechamento 	= $_POST['dataFechamentoPedidoAlterar'];
		$subject 			= $_POST['subjectAlterar'];
		$nomeUsuario		= $_POST['nomeUsuarioAlterar'];
		$mensagemEmail		= $_POST['mensagemEmailAlterar'];
		$Cliente			= $_POST['ClienteAlterar'];
		$Status 			= $_POST['statusAlterar'];

		if ($statusPedido == "16" || $statusPedido == "7"  || $statusPedido == "2") {
			if ($dataFechamento == "") {
				$dataFechamento = $dataAlteracao;
			}
		} else {
			$dataFechamento = null;
		}
		$cad = crud::AlterarPedido($codControle, $statusPedido, $mensagemAlterar, $idInstituicao, $dataAlteracao, $dataFechamento);
		if ($cad == true) {
			echo 1;
			if (!$email == '') {
				$dadosCadastro = "Codigo: " . $codControle . " <br>" . "Cliente: " . $Cliente . " <br>" . "Status: " . $Status . " <br>" . "Observacao do pedido: " . $mensagemEmail;
				crud::enviarEmailPedido($email, $subject, $nomeUsuario, $mensagemEmail, $dadosCadastro);
			}
		} else {
			echo 0;
		}
	break;

	case 'deletePedido':
		$email      	= $_POST['emailExcluir'];
		$id      		= $_POST['excIdPedido'];
		$idInstituicao 	= $_POST['ExcIdInstituicao'];
		$nomeUsuario 	= $_POST['ExcnomeUsuario'];
		$subject 		= $_POST['Excsubject'];
		$mensagemEmail	= $_POST['excmensagemEmail'];
		$Cliente		= $_POST['ExcNomePedido'];

		$cad = crud::deletePedido($id, $idInstituicao);
		if ($cad == true) {
			echo 1;
			if (!$email == '') {
				$dadosCadastro = "Codigo: " . $id . " <br>" . "Cliente: " . $Cliente . " <br>" . "Observacao: " . $mensagemEmail;
				crud::enviarEmailPedidoAnexo($email, $subject, $nomeUsuario, $anexo, $dadosCadastro);
			}
		} else {
			echo 0;
		}
		break;

	case 'adicionaMensagemPedido':
		$idLogado 		= $_POST['idLogado'];
		$dataHora 		= $_POST['datahora'];
		$codDemanda		= $_POST['codPedido'];
		$mensagem 		= $_POST['mensagem'];
		$idInstituicao 	= $_POST['idInstituicao'];

		$cdt = crud::addMensagem($idLogado, $dataHora, $codDemanda, $mensagem, $idInstituicao);
		if ($cdt == true) {
			echo 1;
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
