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

	case 'editaCliente':

		$id = $_POST['idcliente'];
		$nome = $_POST['edtnome'];
		$status = $_POST['edtstatus'];

		$edt = crud::atualizaCliente($id, $nome, $status);
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
				/*data_criacao, id_dep, id_usr_criador, id_usr_destino, titulo,	codCliente_dem,prioridade, ordem_servico, mensagem, status, anexo*/
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
				echo 1;
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



		$cdt = crud::addMensagem($idLogado, $dataHora, $codDemanda, $mensagem);
		if ($cdt == true) {
			$mudaStatus = crud::dataview("UPDATE demanda SET status='Em atendimento' WHERE id=" . $codDemanda);
			echo 1;
		} else {
			echo 0;
		}

		break;



	case 'cadUsuario':

		$nome = $_POST['nome'];
		$email = $_POST['email'];
		$nivel = $_POST['nivel'];
		$dep = $_POST['dep'];
		$pass = $_POST['pass'];
		$status = "Ativo";
		$cdt = crud::criaUsr($nome, $email, $nivel, $dep, $status, $pass);
		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;


	case 'criarCliente':

		$nomeCliente = $_POST['nomeCliente'];
		//$statusCliente = $_POST['statusCliente'];

		$cdt = crud::criarCliente($nomeCliente);
		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'excluirCliente':

		$idCliente = $_POST['codCliente'];

		$cdt = crud::deleteCliente($idCliente);

		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}

		break;

		//EDITA USUÁRIO
	case 'editaUsr':

		$id = $_POST['iduser'];
		$nome = $_POST['edtnome'];
		$email = $_POST['edtemail'];
		$nivel = $_POST['edtnivelUser'];
		$dep = $_POST['edtdepartamento'];
		$pass = $_POST['edtPass'];
		$status = "Ativo";

		$edt = crud::edtUsr($id, $nome, $email, $nivel, $dep, $status, $pass);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
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
		break;

	case 'VerificaEmail':
		//tipo emailUser senhalUser dicalUser
		$emailUser2 = $_POST['emailUser'];

		$ativo = 0;
		$valida = md5($emailUser2);

		$cdt = crud::VericaEmailUser($emailUser2);
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

		//ATUALIZA STATUS DO CLIENTE PARA DESATIVADO
	case 'desativaCliente':

		$id = $_POST['id'];
		$status = "D";

		$edt = crud::atualizaStatusCliente($id, $status);
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

		$edt = crud::atualizaStatusCliente($id, $status);
		if ($edt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;
		//ATUALIZA STATUS DO CLIENTE PARA ATIVADO

		// MANAGER SLA
	case 'cadSla':

		$descricao = $_POST['descricao'];
		$tempo = $_POST['tempo'];
		$uniTempo = $_POST['unidtempo'];

		$cad = crud::cadSla($descricao, $tempo, $uniTempo);
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

		$cad = crud::edtSla($id, $descricao, $tempo, $uniTempo);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'excluiSla':

		$id = $_POST['idSla'];

		$exc = crud::excluiSla($id);
		if ($exc == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

		//statuspedido
	case 'CadastroStatus':
		$descricao = $_POST['descricao'];
		$cad = crud::CadastroStatus($descricao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'editarStatus':

		$descricao  = $_POST['edtDescricao'];
		$edtId         = $_POST['edtId'];
		$cad = crud::editarStatus($edtId, $descricao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;
	case 'excluirStatus':
		$id         = $_POST['id'];
		$cad = crud::deleteStatus($id);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;
		//statuspedido

		//controlepedido
		case 'CadastroPedido':
		$dataAbertura = $_POST['dataAtual'];
		$numeroPregao = $_POST['numeroPregao'];
		//$idLogado = $_POST['idLogado'];
		$numeroAf = $_POST['numeroAf'];
		$valorPedido = $_POST['valorPedido'];
		$codStatus = $_POST['statusPedido'];
		$codCliente = $_POST['nomeCliente'];
		$observacao = $_POST['mensagem'];

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
					/*data_criacao, id_dep, id_usr_criador, id_usr_destino, titulo,	codCliente_dem,prioridade, ordem_servico, mensagem, status, anexo*/
					$cdt = crud::CadastroPedido($numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao);
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
				$anexo = "sem_anexo.php";
					$cdt = crud::CadastroPedido($numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao);
				if ($cdt == true) {
					echo 1;
				} else {
					echo 0;
				}
			}
		if ($cdt == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'editarPedido':

		$descricao  = $_POST['edtDescricao'];
		$edtId         = $_POST['edtId'];
		$cad = crud::editarPedido($codControle, $numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;

	case 'deletePedido':
		$id         = $_POST['id'];
		$cad = crud::deletePedido($id);
		if ($cad == true) {
			echo 1;
		} else {
			echo 0;
		}
		break;
		//controlepedido
}
