<?php
require_once 'crud.php';

//isset()
$value = isset($_POST['tipo']) ? $_POST['tipo'] : '';

switch ($value) {
	case 'editausr':
		$id = $_POST['id'];
		$nome = $_POST['nome'];


		$edt = crud::atualizaUsr($id, $nome);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'criaDemanda':

		$dataAbertura = $_POST['dataAtual'];
		$idLogado = $_POST['idLogado'];
		$idInstituicao = $_POST['idInstituicao'];
		$titulo = $_POST['titulo'];
		$nomeSolicitante = $_POST['nomeSolicitante'];
		$departamento = $_POST['departamento'];
		$usuarioDestino = $_POST['usuarioDestino'];
		$prioridade = $_POST['prioridade'];
		$ordemServico = $_POST['ordemServico'];
		if ($ordemServico == '') {
			$ordemServico = '';
		}

		$mensagem = $_POST['mensagem'];
		$status = "Aberto";
		//FUNÇÃO TRIM ELIMINA OS ESPAÇOS DA STRING
		$emailDestino = $_POST['emailDestino'];
		$email = trim($emailDestino);

		//ENTRA AQUI SE TIVER ANEXO
		if (!empty($_FILES["file"]["name"])) {
			$validextensions = array("jpeg", "jpg", "png", "PNG", "JPG", "JPEG", "pdf", "PDF", "docx");
			$temporary = explode(".", $_FILES["file"]["name"]);
			$file_extension = end($temporary);
			$nomeAnexo = md5($dataAbertura) . "." . $file_extension;

			if (in_array($file_extension, $validextensions)) {

				$sourcePath = $_FILES['file']['tmp_name'];
				$targetPath = "../anexos/" . md5($dataAbertura) . "." . $file_extension;
				move_uploaded_file($sourcePath, $targetPath); // Move arquivo				
				//SALVA NO BANCO 				
				$cdt = crud::criaDemanda($dataAbertura, $departamento, $idLogado, $idInstituicao, $usuarioDestino, $titulo, $nomeSolicitante, $prioridade, $ordemServico, $mensagem, $status, $nomeAnexo);
				if ($cdt == true) {
					echo 1;
					//enviaEmail();
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}

			//CASO NÃO TENHA ANEXO ENTRA AQUI	
		} else {
			$nomeAnexo = "sem_anexo.php";
			$cdt = crud::criaDemanda($dataAbertura, $departamento, $idLogado, $idInstituicao, $usuarioDestino, $titulo, $nomeSolicitante, $prioridade, $ordemServico, $mensagem, $status, $nomeAnexo);
			if ($cdt == true) {
				echo 1;
			} else {
				echo 0;
			}
		}
		break;


	case 'atualizaStatus':

		$codigoDemanda = $_POST['codigoDemanda'];
		$status = $_POST['status'];

		$edt = crud::atualizaStatus($codigoDemanda, $status);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'fechaDemanda':

		$codigoDemanda = $_POST['codigoDemanda'];
		$status = $_POST['status'];
		$dataFechamento = $_POST['dataFechamento'];

		$edt = crud::fechaDemanda($codigoDemanda, $status, $dataFechamento);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'deletacad':
		$id = $_POST['id'];
		$del = crud::deletaCad($id);
		if ($del == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'adicionaMensagem':

		$idLogado = $_POST['idLogado'];
		$dataHora = $_POST['datahora'];
		$codDemanda = $_POST['codDemanda'];
		$mensagem = $_POST['mensagem'];
		$idInstituicao = $_POST['idInstituicaoMensagem'];

		$cdt = crud::addMensagem($idLogado, $dataHora, $codDemanda, $mensagem, $idInstituicao);
		if ($cdt == true) {
			$mudaStatus = crud::dataview("UPDATE demanda SET status='Em atendimento' WHERE id=" . $codDemanda . "'  AND '" . $idInstituicao);
			echo 1;
		} else {
			echo 0;
		}

		break;

		//Cliente
	case 'editaCliente':

		$id = $_POST['idcliente'];
		$nome = $_POST['edtnome'];
		$nomeFantasia = $_POST['edtnomefantasia'];
		$status = $_POST['edtstatus'];
		$tipoCliente = $_POST['edttipo'];
		$idInstituicao = $_POST['edtidInstituicao'];

		$edt = crud::atualizaCliente($id, $nome, $status, $tipoCliente, $nomeFantasia, $idInstituicao);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;

	case 'criarCliente':

		$nomeCliente = $_POST['cdtnomeCliente'];
		$nomeFantasiaCliente = $_POST['cdtnomeFantasiaCliente'];
		$tipoCliente = $_POST['cdtTipoCliente'];
		$idInstituicao = $_POST['idInstituicao'];

		/*	$nomeCliente = $_POST['nomeCliente'];
		$nomeFantasiaCliente = $_POST['nomeFantasiaCliente'];
		$tipoCliente = $_POST['tipoCliente'];
		$idInstituicao = $_POST['idInstituicao'];
*/
		$cdt = crud::criarCliente($nomeCliente, $tipoCliente, $nomeFantasiaCliente, $idInstituicao);
		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'excluirCliente':

		$codCliente = $_POST['codCliente'];
		$idInstituicao = $_POST['idInstituicao'];

		$cdt = crud::deleteCliente($codCliente, $idInstituicao);

		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;
		//ATUALIZA STATUS DO CLIENTE PARA DESATIVADO
	case 'desativaCliente':

		$id = $_POST['id'];
		$status = "D";
		$idInstituicao = $_POST['idInstituicao'];

		$edt = crud::atualizaStatusCliente($id, $status, $idInstituicao);
		if ($edt == true) {
			echo 1;
		} else {

			echo 0;
		}
		break;

		//ATUALIZA STATUS DO CLIENTE PARA DESATIVADO/ ATIVADO
	case 'ativaCliente':

		$id = $_POST['id'];
		$status = "A";
		$idInstituicao = $_POST['idInstituicao'];
		$edt = crud::atualizaStatusCliente($id, $status, $idInstituicao);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;
		//ATUALIZA STATUS DO CLIENTE PARA ATIVADO
		//cliente

	case 'cadUsuario':

		$nome = $_POST['nome'];
		$dica = $_POST['dica'];
		$email = $_POST['email'];
		$nivel = $_POST['nivel'];
		$dep = $_POST['dep'];
		$pass = $_POST['pass'];
		$idInstituicao = $_POST['idInstituicao'];
		$valida = md5($email);
		$status = "Desativado";
		$cdt = crud::VericaEmailUser($email, $idInstituicao);
		if ($cdt == false) {
			$cdt = crud::criaUsr($nome, $email, $nivel, $dep, $status, $pass, $idInstituicao, $dica, $valida);
			if ($cdt == true) {
				echo 1;

				$to = $email;
				$valida = md5("$to");

				$subject = "Cadastro no Sistema"; // assunto
				$message = "Validacao de cadastro " . "\r\n";
				$message .= "<a href=http://sistemaocorrencia.devnogueira.online/main/valida_cadastro.php?v=$valida&v2=$to&v3=$idInstituicao> Click aqui para validar seu cadastro </a>";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'To: Carlos Andre <programadorfsaba@gmail.com>' . "\r\n";
				$headers .= 'From:< contato@sistemaocorrencia.com.br>' . "\r\n"; //email de envio
				$headers .= 'CC:< programadorfsaba@gmail.com>' . "\r\n"; //email com copia
				$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>' . "\r\n"; //email para resposta

				mail($to, $subject, $message, $headers);
			} else {
				echo 0;
			}
		} else {
			echo 2;
		}

		break;

	case 'excluiUsuario':
		$id = $_POST['idUser'];


		$del = crud::deleteUser($id);
		if ($del == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

		//EDITA USUÁRIO
	case 'editaUsr':
		$id = $_POST['iduser'];
		$nome = $_POST['edtnome'];
		$dica = $_POST['edtdica'];
		$idInstituicao = $_POST['edtidInstituicao'];
		$email = $_POST['edtemail'];
		$nivel = $_POST['edtnivelUser'];
		$dep = $_POST['edtdepartamento'];
		$pass = $_POST['edtPass'];
		$status = "Ativo";

		$edt = crud::edtUsr($id, $nome, $email, $nivel, $dep, $status, $pass, $idInstituicao, $dica);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;

	case 'cadDep':
		$nomeDep = $_POST['nomeDep'];

		$cdt = crud::criaDep($nomeDep);
		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'CadastroUsuario':
		//tipo emailUser senhalUser dicalUser
		$emailUser = $_POST['emailUser'];
		$idInstituicao = $_POST['idInstituicao'];
		$cdt = crud::VericaEmailUser($emailUser, $idInstituicao);
		if ($cdt == false) {
			$senhalUser = $_POST['senhalUser'];
			$dicalUser = $_POST['dicalUser'];
			$ativo = 0;
			$valida = md5($emailUser);

			$cdt = crud::criaUsuario($emailUser, $senhalUser, $dicalUser, $ativo, $valida);
			if ($cdt == true) {
				echo 1;
			} else {
				echo 0;
			}
		} else {
			echo 2;
		}

		break;

	case 'VerificaEmail':
		//tipo emailUser senhalUser dicalUser
		$emailUser2 = $_POST['emailUser'];
		$idInstituicao = $_POST['idInstituicao'];

		$ativo = 0;
		$valida = md5($emailUser2);

		$cdt = crud::VericaEmailUser($emailUser2, $idInstituicao);
		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'VerificaEmail2':
		//tipo emailUser senhalUser dicalUser
		$emailUser2 = $_POST['emailUser'];
		$idInstituicao = $_POST['idInstituicao'];

		$cdt = crud::VericaEmailUser($emailUser2, $idInstituicao);
		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'EditDep':
		$id = $_POST['id'];
		$nomeDep = $_POST['nomeDep'];

		$edt = crud::editDep($id, $nomeDep);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;


	case 'deleteDep':
		$id = $_POST['id'];


		$del = crud::deleteDep($id);
		if ($del == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;


		//ATUALIZA STATUS DO USUÁRIO PARA DESATIVADO
	case 'desativaUsuario':
		$id = $_POST['id'];
		$status = "Desativado";

		$edt = crud::atualizaStatusUsuario($id, $status);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

		//ATUALIZA STATUS DO USUÁRIO PARA DESATIVADO
	case 'ativaUsuario':
		$id = $_POST['id'];
		$status = "Ativo";

		$edt = crud::atualizaStatusUsuario($id, $status);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;



		// MANAGER SLA
	case 'cadSla':
		$descricao = $_POST['descricao'];
		$tempo = $_POST['tempo'];
		$uniTempo = $_POST['unidtempo'];
		$idInstituicao = $_POST['idInstituicao'];

		$cad = crud::cadSla($descricao, $tempo, $uniTempo, $idInstituicao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

		// MANAGER SLA
	case 'edtSla':
		$descricao = $_POST['edtDescricao'];
		$tempo = $_POST['edtTempo'];
		$uniTempo = $_POST['edtUnidtempo'];
		$id = $_POST['edtId'];
		$idInstituicao = $_POST['edtIdInstituicao'];

		$cad = crud::edtSla($id, $descricao, $tempo, $uniTempo, $idInstituicao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'excluiSla':
		$id = $_POST['idSla'];
		$idInstituicao = $_POST['excIdInstituicao'];

		$exc = crud::excluiSla($id, $idInstituicao);
		if ($exc == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

		//statuspedido
	case 'CadastroStatus':
		$descricao = $_POST['descricao'];
		$idInstituicao = $_POST['idInstituicao'];
		$cad = crud::CadastroStatus($descricao, $idInstituicao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'editarStatus':
		$descricao  = $_POST['edtDescricao'];
		$edtId         = $_POST['edtId'];
		$idInstituicao         = $_POST['edtIdInstituicao'];
		$cad = crud::editarStatus($edtId, $descricao, $idInstituicao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;
	case 'excluirStatus':
		$id         = $_POST['id'];
		$idInstituicao         = $_POST['idInstituicao'];
		$cad = crud::deleteStatus($id, $idInstituicao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;
		//statuspedido

		//controlepedido
	case 'CadastroPedido':
		$dataCadastro = $_POST['dataCadastro'];
		$dataAbertura = $_POST['dataAtual'];
		$numeroPregao = $_POST['numeroPregao'];
		$idInstituicao = $_POST['idInstituicao'];
		$numeroAf = $_POST['numeroAf'];
		$valorPedidoAtual = $_POST['valorPedido'];
		$valorPedido 		= str_replace(",", ".", $valorPedidoAtual);
		$codStatus = $_POST['statusPedido'];
		$codCliente = $_POST['nomeCliente'];
		$observacao = $_POST['mensagem'];
		$email = $_POST['email'];
		$subject = $_POST['subject'];
		$nomeUsuario = $_POST['nomeUsuario'];

		//ENTRA AQUI SE TIVER ANEXO
		if (!empty($_FILES["file"]["name"])) {
			$validextensions = array("jpeg", "jpg", "png", "PNG", "JPG", "JPEG", "pdf", "PDF", "docx");
			$temporary = explode(".", $_FILES["file"]["name"]);
			$file_extension = end($temporary);
			$anexo = md5($dataAbertura) . "." . $file_extension;

			if (in_array($file_extension, $validextensions)) {
				$sourcePath = $_FILES['file']['tmp_name'];
				$targetPath = "../anexos/" . md5($dataAbertura) . "." . $file_extension;
				move_uploaded_file($sourcePath, $targetPath); // Move arquivo				
				//SALVA NO BANCO
				$cdt = crud::CadastroPedido($numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao, $dataCadastro, $idInstituicao);
				if ($cdt == true) {
					echo $cdt;
					if (!$email == '') {
						$dadosCadastro = "Codigo: ".$cdt." <br>"."Licitacao: ".$numeroPregao." <br>"."Autorizacao: ".$numeroAf 
					." <br>"."Autorizacao: ".$numeroAf." <br>"."Valor do Pedido R$: ".$valorPedidoAtual;
						crud::enviarEmailPedidoAnexo($email, $subject, $nomeUsuario, $anexo,$dadosCadastro);
					}
				} else {
					echo 0;
				}
			} else {
				echo 0;
			}
			//CASO NÃO TENHA ANEXO ENTRA AQUI	
		} else {
			$anexo = "sem_anexo.php";
			$cdt = crud::CadastroPedido($numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao, $dataCadastro, $idInstituicao);
			if ($cdt == true) {
				echo $cdt;
				if (!$email == '') {
					$dadosCadastro = "Codigo: ".$cdt." <br>"."Licitacao: ".$numeroPregao." <br>"."Autorizacao: ".$numeroAf 
					." <br>"."Autorizacao: ".$numeroAf." <br>"."Valor do Pedido R$: ".$valorPedidoAtual;
					crud::enviarEmailPedidoAnexo($email, $subject, $nomeUsuario, $anexo,$dadosCadastro);
				}
			} else {
				echo 0;
			}
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
						//crud::enviarEmailPedido($email,$subject,$nomeUsuario);
						$dadosCadastro = "Codigo: ".$codControle." <br>"."Licitacao: ".$numeroLicitacao." <br>"."Autorizacao: ".$numeroAf
						." <br>"."Valor do Pedido R$: ".$valorPedidoAtual;
						crud::enviarEmailPedidoAnexo($email, $subject, $nomeUsuario, $anexo,$dadosCadastro);
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
			$cad = crud::AlterarPedido2($codControle, $statusPedido, $mensagemAlterar, $nomeCliente,	$numeroAf, $valorPedido, $numeroLicitacao, $anexoAlterar, $idInstituicao, $dataAlteracao);

			if ($cad == true) {
				echo 1;
				if (!$email == '') {
					$dadosCadastro = "Codigo: ".$codControle." <br>"."Licitacao: ".$numeroLicitacao." <br>"."Autorizacao: ".$numeroAf
						." <br>"."Valor do Pedido R$: ".$valorPedidoAtual;
						crud::enviarEmailPedidoAnexo($email, $subject, $nomeUsuario, $anexo,$dadosCadastro);
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
			if(!$email ==''){
				crud::enviarEmailPedido($email,$subject,$nomeUsuario,$mensagemEmail);
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
		

		$cad = crud::deletePedido($id, $idInstituicao);
		if ($cad == true) {
			echo 1;
			if(!$email ==''){
				crud::enviarEmailPedido($email,$subject,$nomeUsuario,$mensagemEmail);
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

		//REPRESENTANTE

	case 'cadRepresentante':
		$nomeRepresentante = $_POST['nomeRepresentante'];
		$idInstituicao = $_POST['idInstituicao'];
		$cad = crud::criarRepresentante($nomeRepresentante, $idInstituicao);

		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'editarRepresentante':
		$nomeRepresentante = $_POST['edtnome'];
		$codRepresentante = $_POST['idRepresentante'];
		$statusRepresentante =  $_POST['edtstatus'];
		$idInstituicao = $_POST['editaridInstituicao'];
		$cad = crud::editarRepresentante($nomeRepresentante, $codRepresentante, $statusRepresentante, $idInstituicao);

		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;

	case 'ativaRepresentante':
		$codRepresentante = $_POST['idRepresentante'];
		$statusRepresentante =  'A';
		$idInstituicao = $_POST['idInstituicao'];
		$cad = crud::ativaRepresentante($codRepresentante, $statusRepresentante, $idInstituicao);

		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;
	case 'desativaRepresentante':
		$codRepresentante = $_POST['idRepresentante'];
		$statusRepresentante =  'D';
		$idInstituicao = $_POST['idInstituicao'];
		$cad = crud::ativaRepresentante($codRepresentante, $statusRepresentante, $idInstituicao);

		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;

	case 'excluirRepresentante':
		$codRepresentante = $_POST['idRepresentante'];
		$idInstituicao = $_POST['idInstituicao'];
		$cad = crud::deleteRepresentante($codRepresentante, $idInstituicao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;

	case 'excluirInstituicao':
		$idInstituicao = $_POST['idInstituicao'];
		$cad = crud::excluirInstituicao($idInstituicao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;
	case 'listarInstituicao':

		//	$idInstituicao = $_POST['idInstituicao'];
		$cad = crud::listarInstituicao();
		if ($cad == true) {
			echo $cad;
		} else {
			echo 0;
		}

		break;
	case 'cadastrarInstituicao':
		$idInstituicao = $_POST['idInstituicao'];
		$nomeInstituicao = $_POST['nomeInstituicao'];
		$nomeFantasia = $_POST['nomeFantasia'];
		$codigoAcesso = $_POST['codigoAcesso'];
		$dataCadastro = $_POST['dataAtual'];
		$acao = $_POST['acao'];

		if ($acao == 1) {
			$cad = crud::cadastrarInstituicao($nomeInstituicao, $nomeFantasia, $codigoAcesso, $dataCadastro);
		} else if ($acao == 2) {
			$cad = crud::alterarInstituicao($idInstituicao, $nomeInstituicao, $nomeFantasia);
		}
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

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
