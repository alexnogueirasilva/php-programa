<?php

include_once 'conex.php';

class crud
{


	//Aqui fazemos a verificação do login do usuário e do seu nível de acesso
	public static function pesquisaLoginUsr($nome, $senha)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pwd = sha1($senha);
		$sql = "SELECT u.id as idUsuario,u.nome,u.email,u.nivel,u.senha, u.status, u.id_dep, i.inst_id,u.fk_idInstituicao, i.inst_nome as nomeInstituicao FROM usuarios AS u INNER JOIN instituicao AS i on i.inst_codigo = u.fk_idInstituicao where email ='" . $nome . "' AND senha ='" . $pwd . "'";
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	//Nessa função, fazemos a montagem da tabela de dados.
	public static function dataview($query)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public static function mostraDemandas($usuarioSessao, $idInstituicao)
	{
		//SQL QUE VAI MOSTRAR A LISTA DE CHAMADOS DE CADA USUÁRIO UNINDO TRÊS TABELAS - (DEMANDAS, USUÁRIOS E DEPARTAMENTOS)

		$query = " SELECT d.id, d.mensagem, cli.nomecliente, d.titulo,d.fk_idInstituicao,d.id_usr_criador,d.id_usr_destino, u.id,d.prioridade, d.ordem_servico, d.data_criacao,d.data_fechamento, d.status,d.anexo, u.nome, dep.nome as nome_dep 
		FROM demanda AS d 
		INNER JOIN usuarios AS u ON d.id_usr_destino = u.id and  d.id_usr_criador =' " . $usuarioSessao . " ' 
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
		WHERE d.fk_idInstituicao = '" . $idInstituicao . "' 
		ORDER BY data_criacao ASC";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public static function mostraTodasDemandas($idInstituicao)
	{
		//SQL QUE VAI MOSTRAR A LISTA DE CHAMADOS DE CADA USUÁRIO UNINDO TRÊS TABELAS - (DEMANDAS, USUÁRIOS E DEPARTAMENTOS)
		$query = "SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.ordem_servico, d.data_criacao, d.status, d.anexo, u.nome, d.id_usr_criador, dep.nome AS nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_criador = u.id INNER JOIN departamentos AS dep ON d.id_dep = dep.id AND d.fk_idInstituicao = '" . $idInstituicao . "'  ORDER BY data_criacao ASC";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	//Esta é a função que atualiza o cadastro com os dados vindos da edição.	
	public static function atualizaStatusUsuario($id, $status)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE usuarios SET status=:status WHERE id=:id ");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":status", $status);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function atualizaStatus($codigoDemanda, $status)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE demanda SET status=:status WHERE id=:codigoDemanda ");
			$stmt->bindparam(":codigoDemanda", $codigoDemanda);
			$stmt->bindparam(":status", $status);

			$stmt->execute();

			$subject = "Cadastro de Ocorrencia"; // assunto
			$message = "Sua demanda esta em atendimento, para você visualisar " . "\r\n"; //mensagem
			$message .= "acesse com seu login " . "\r\n"; //mensagem
			$message .= "<a href=http://sistemaocorrencia.devnogueira.online/index.php> SO - Click aqui para fazer o login </a>"; //menssagem com link
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n"; //formato
			$headers .= 'From: <contato@sistemaocorrencia.com.br>' . "\r\n"; //email de envio
			$headers .= 'CC: <' . $emailLogado . '>' . "\r\n"; //email de copia
			$emailLogado =  $_POST['emaillogado']; //recuperando o e-mail do usuario logado
			//$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>'."\r\n";//email para resposta
			$to = $_POST['emailSolicitante']; // recuperando email do destinatario e envia notificacao da demanda

			mail($to, $subject, $message, $headers);

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function fechaDemanda($codigoDemanda, $status, $dataFechamento)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE demanda SET status=:status, data_fechamento=:data_fechamento WHERE id=:codigoDemanda ");
			$stmt->bindparam(":codigoDemanda", $codigoDemanda);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":data_fechamento", $dataFechamento);

			$stmt->execute();
			return true;

			$subject = "Cadastro de Ocorrencia"; // assunto
			$message = "Sua demanda foi fechada com sucesso, para você visualisar " . "\r\n"; //mensagem
			$message .= "acesse com seu login " . "\r\n"; //mensagem
			$message .= "<a href=http://sistemaocorrencia.devnogueira.online/index.php> SO - Click aqui para fazer o login </a>"; //menssagem com link
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n"; //formato
			$headers .= 'From: <contato@sistemaocorrencia.com.br>' . "\r\n"; //email de envio
			$headers .= 'CC: <' . $emailLogado . '>' . "\r\n"; //email de copia
			$emailLogado =  $_POST['emaillogado']; //recuperando o e-mail do usuario logado
			//$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>'."\r\n";//email para resposta
			$to = $_POST['emailSolicitante']; // recuperando email do destinatario e envia notificacao da demanda

			mail($to, $subject, $message, $headers);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//Essa é a função responsável pela criação das demandas
	public static function criaDemanda($dataAbertura, $departamento, $idLogado, $idInstituicao, $usuarioDestino, $titulo, $nomeSolicitante, $prioridade, $ordemServico, $mensagem, $status, $nomeAnexo)
	{
		if ($ordemServico == "") {
			$ordemServico = 0;
		}

		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO demanda(data_criacao, id_dep, id_usr_criador,id_instituicao, id_usr_destino, titulo, codCliente_dem, prioridade, ordem_servico, mensagem, status, anexo) 
												VALUES(:data_criacao, :id_dep, :id_usr_criador,:id_instituicao, :id_usr_destino, :titulo, :codCliente_dem, :prioridade, :ordem_servico, :mensagem, :status, :anexo)");
			$stmt->bindparam(":data_criacao", $dataAbertura);
			$stmt->bindparam(":id_dep", $departamento);
			$stmt->bindparam(":id_usr_criador", $idLogado);
			$stmt->bindparam(":id_instituicao", $idInstituicao);
			$stmt->bindparam(":id_usr_destino", $usuarioDestino);
			$stmt->bindparam(":titulo", $titulo);
			$stmt->bindparam(":codCliente_dem", $nomeSolicitante);
			$stmt->bindparam(":prioridade", $prioridade);
			$stmt->bindparam(":ordem_servico", $ordemServico);
			$stmt->bindparam(":mensagem", $mensagem);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":anexo", $nomeAnexo);

			$stmt->execute();
			//	$id = mysql_insert_id($pdo->$stmt);	

			$subject = "Cadastro de Ocorrencia"; // assunto
			$message = "Uma demanda cadastrada para você, " . "\r\n"; //mensagem
			$message .= "acesse com seu login para da tratamento " . "\r\n"; //mensagem
			$message .= "<a href=http://sistemaocorrencia.devnogueira.online/index.php> SO - Click aqui para fazer o login </a>"; //menssagem com link
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n"; //formato
			$headers .= 'From: <contato@sistemaocorrencia.com.br>' . "\r\n"; //email de envio
			$headers .= 'CC: <' . $emailLogado . '>' . "\r\n"; //email de copia
			$emailLogado =  $_POST['emaillogado']; //recuperando o e-mail do usuario logado
			//$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>'."\r\n";//email para resposta
			$to = $_POST['emailDestino']; // recuperando email do destinatario e envia notificacao da demanda

			mail($to, $subject, $message, $headers);

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function addMensagem($idLogado, $dataHora, $codDemanda, $mensagem, $idInstituicao)
	{
		$pdo = Database::connect();

		try {
			$stmt = $pdo->prepare("INSERT INTO hst_mensagens(cod_demanda, cod_usr_msg, mensagem, msg_data,fk_idInstituicao) VALUES(:cod_demanda, :cod_usr_msg, :mensagem, :datahora,:idInstituicao)");
			$stmt->bindparam(":cod_demanda", $codDemanda);
			$stmt->bindparam(":cod_usr_msg", $idLogado);
			$stmt->bindparam(":mensagem", $mensagem);
			$stmt->bindparam(":datahora", $dataHora);
			$stmt->bindparam(":idInstituicao", $idInstituicao);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//Essa é a função responsável por deletar a pessoa da lista.
	public static function deletaCad($id)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();
		return true;
	}

	public static function criaUsr($nome, $email, $nivel, $dep, $status, $pass, $idInstituicao, $dica, $valida)
	{
		$pdo = Database::connect();
		$pwd = sha1($pass);
		try {
			$stmt = $pdo->prepare("INSERT INTO usuarios(nome, email, nivel, id_dep, status, senha,fk_idInstituicao, dica,valida) VALUES(:nome, :email, :nivel, :id_dep, :status, :senha,:idInstituicao,:dica,:valida)");
			$stmt->bindparam(":nome", $nome);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":nivel", $nivel);
			$stmt->bindparam(":id_dep", $dep);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":senha", $pwd);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->bindparam(":dica", $dica);
			$stmt->bindparam(":valida", $valida);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function enviarEmail($email, $idInstituicao)
	{

		$to = $email;
		$valida = md5("$to");

		$subject = "Assunto Teste e-mail";
		$message = "<a href=valida_cadastro.php?v=$valida&$to&$idInstituicao> Teste de envio de mensagem </a>";
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'To: Carlos Andre <programadorfsaba@gmail.com>' . "\r\n";
		$headers .= 'From:< carlosandrefsaba@gmail.com>' . "\r\n";
		$headers .= 'CC:< programadorfsaba@gmail.com>' . "\r\n";
		$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>' . "\r\n";

		mail($to, $subject, $message, $headers);
	}
	// CLIENTE
	public static function atualizaCliente($id, $nome, $status, $tipoCliente, $nomeFantasia, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE cliente SET nomecliente=:nome, status=:status, tipoCliente=:tipoCliente, nomeFantasiaCliente=:nomeFantasia, fk_idInstituicao=:idInstituicao WHERE codCliente=:id ");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":tipoCliente", $tipoCliente);
			$stmt->bindparam(":nome", $nome);
			$stmt->bindparam(":nomeFantasia", $nomeFantasia);
			$stmt->bindparam(":idInstituicao", $idInstituicao);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function atualizaStatusCliente($id, $status, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE cliente SET status=:status WHERE codCliente=:id AND fk_idInstituicao=:idInstituicao");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->execute();
			return true;
			echo getMessage("Atualizado com sucesso;");
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public static function criarCliente($nomeCliente, $tipoCliente, $nomeFantasiaCliente, $idInstituicao)
	{
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO cliente(nomeCliente, tipoCliente, nomeFantasiaCliente, fk_idInstituicao) VALUES (:nomeCliente, :tipoCliente, :nomeFantasiaCliente,:idInstituicao)");
			$stmt->bindparam(":nomeCliente", $nomeCliente);
			$stmt->bindparam(":tipoCliente", $tipoCliente);
			$stmt->bindparam(":nomeFantasiaCliente", $nomeFantasiaCliente);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function deleteCliente($codCliente, $idInstituicao)
	{

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("DELETE FROM cliente WHERE codCliente=:codCliente AND fk_idInstituicao=:idInstituicao");
			$stmt->bindparam(":codCliente", $codCliente);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function mostrarCliente($idInstituicao)
	{
		$query = "SELECT * FROM cliente WHERE fk_idInstituicao='" . $idInstituicao . "' ORDER BY nomecliente ASC";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();

		return $stmt;
	}

	//CLIENTE
	public static function edtUsr($id, $nome, $email, $nivel, $dep, $status, $pass)
	{

		$pdo = Database::connect();
		$pwd = sha1($pass);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE usuarios SET nome=:nome, email=:email, nivel=:nivel, id_dep=:id_dep, senha=:senha  WHERE id=:id ");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":nome", $nome);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":nivel", $nivel);
			$stmt->bindparam(":id_dep", $dep);
			$stmt->bindparam(":senha", $pwd);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function deleteUser($id)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();
		return true;
	}

	public static function criaDep($nomeDep)
	{
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO departamentos(nome) VALUES(:nomeDep)");
			$stmt->bindparam(":nomeDep", $nomeDep);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function criaUsuario($emailUser, $senhalUser, $dicalUser, $ativo, $valida)
	{
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO usuario(email,senha,dica,ativo,valida) 
			VALUES (:emailUser, :senhalUser,:dicalUser,:ativo, :valida)");
			$stmt->bindparam(":emailUser", $emailUser);
			$stmt->bindparam(":senhalUser", $senhalUser);
			$stmt->bindparam(":dicalUser", $dicalUser);
			$stmt->bindparam(":ativo", $ativo);
			$stmt->bindparam(":valida", $valida);

			$stmt->execute();

			$to = $emailUser;

			$valida = md5("$to");

			$subject = "Cadastro no Sistema de Ocorrencias"; // assunto
			$message = "Validacao de cadastro " . "\r\n";
			$message .= "<a href=http://sistemaocorrencia.devnogueira.online/main/valida_cadastro.php?v=$valida&v2=$to> SO - Click aqui para validar seu cadastro </a>";
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n"; //formato
			$headers .= 'To: Carlos Andre <programadorfsaba@gmail.com>' . "\r\n"; //
			$headers .= 'From:< contato@sistemaocorrencia.com.br>' . "\r\n"; //email de envio
			$headers .= 'CC:< programadorfsaba@gmail.com>' . "\r\n"; // email de copia
			$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>' . "\r\n"; //email para resposta

			mail($to, $subject, $message, $headers);

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function ativarUsuario($ativo, $valida, $idInstituicao)
	{
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("UPDATE usuarios SET status=:ativo WHERE valida=:valida AND fk_idInstituicao=:idInstituicao");
			$stmt->bindparam(":ativo", $ativo);
			$stmt->bindparam(":valida", $valida);
			$stmt->bindparam(":idInstituicao", $idInstituicao);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function mostraUsuario($valor, $valor2, $valor3)
	{
		$pdo = Database::connect();
		$sql = "SELECT * FROM usuarios WHERE valida='" . $valor . "' AND email='" . $valor2 . "' AND fk_idInstituicao='" . $valor3 . "'";
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetch(PDO::FETCH_ASSOC);
			return $data;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function VericaEmailUser($email, $idInstituicao)
	{
		$pdo = Database::connect();
		$sql = "SELECT * FROM usuarios WHERE email='" . $email . "' AND fk_idInstituicao='" . $idInstituicao . "'";
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$q = $pdo->prepare($sql);
			$q->execute();
			$data = $q->fetch(PDO::FETCH_ASSOC);
			return $data;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//Nessa função, fazemos a montagem da tabela de dados.
	public static function mostraDep()
	{
		$query = "SELECT * FROM departamentos";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public static function editDep($id, $nomeDep)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE departamentos SET nome=:nomeDep WHERE id=:id ");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":nomeDep", $nomeDep);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function deleteDep($id)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM departamentos WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();
		return true;
	}

	//MANAGER SLA --------------------------------------------
	public static function cadSla($descricao, $tempo, $uniTempo, $idInstituicao)
	{
		$pdo = Database::connect();

		try {
			$stmt = $pdo->prepare("INSERT INTO tbl_sla (descricao, tempo, unitempo,fk_idInstituicao) VALUES(:descricao,:tempo,:unitempo,:idInstituicao)");
			$stmt->bindparam(":descricao", $descricao);
			$stmt->bindparam(":tempo", $tempo);
			$stmt->bindparam(":unitempo", $uniTempo);
			$stmt->bindparam(":idInstituicao", $idInstituicao);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function edtSla($id, $descricao, $tempo, $uniTempo, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE tbl_sla SET descricao=:descricao, tempo=:tempo, uniTempo=:uniTempo, fk_idInstituicao=:idInstituicao WHERE id=:id ");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":descricao", $descricao);
			$stmt->bindparam(":tempo", $tempo);
			$stmt->bindparam(":uniTempo", $uniTempo);
			$stmt->bindparam(":idInstituicao", $idInstituicao);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function excluiSla($id, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM tbl_sla WHERE id=:id AND fk_idInstituicao=:idInstituicao");
		$stmt->bindparam(":id", $id);
		$stmt->bindparam(":idInstituicao", $idInstituicao);
		$stmt->execute();
		return true;
	}

	public static function mostraSla($idInstituicao)
	{
		$query = "SELECT * FROM tbl_sla WHERE fk_idInstituicao = '" . $idInstituicao . "' ";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	// SLA
	public static function formataData($data)
	{
		$qtde = strlen($data);
		$data1 = new DateTime($data);
		if ($qtde > 10) {
			$dataFormatada = $data1->format('d/m/Y h:i:s');
		} else {
			$dataFormatada = $data1->format('d/m/Y');
		}
		return $dataFormatada;
	}
	//statuspedido
	public static function listarStatus($idInstituicao)
	{

		$sql = " SELECT * FROM statusPedido WHERE fk_idInstituicao = '" . $idInstituicao . "' order by nome ";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function listarSatusId($id, $idInstituicao)
	{

		$sql = "SELECT * FROM statusPedido WHERE codStatus = $id  AND fk_idInstituicao = '" . $idInstituicao . "'order by nome";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function CadastroStatus($descricao, $idInstituicao)
	{
		$pdo = Database::connect();

		try {
			$stmt = $pdo->prepare("INSERT INTO statusPedido (nome, fk_idInstituicao) VALUES(:nome,:fk_idInstituicao)");
			$stmt->bindparam(":nome", $descricao);
			$stmt->bindparam(":fk_idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function editarStatus($edtId, $descricao, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE statusPedido SET nome=:descricao, fk_idInstituicao=:idInstituicao WHERE codStatus=:edtId AND fk_idInstituicao = '" . $idInstituicao . "' ");
			$stmt->bindparam(":edtId", $edtId);
			$stmt->bindparam(":descricao", $descricao);
			$stmt->bindparam(":idInstituicao", $idInstituicao);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function deleteStatus($id, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM statusPedido WHERE codStatus=:id AND fk_idInstituicao =:idInstituicao");
		$stmt->bindparam(":id", $id);
		$stmt->bindparam(":idInstituicao", $idInstituicao);
		$stmt->execute();
		return true;
	}

	//statuspedido

	//controlepedido
	public static function totalPedidoPendetes($idInstituicao)
	{

		$sql = "SELECT count(con.codControle) as totalPedidosPendetes
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE cli.tipoCliente = 'E' AND con.codStatus = 4 AND con.fk_idInstituicao = '" . $idInstituicao . "'
	ORDER BY con.dataCadastro desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function totalPedidoCancelados($idInstituicao)
	{

		$sql = "SELECT count(con.codControle) as totalPedidoCancelados
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE cli.tipoCliente = 'E' AND con.codStatus = 4 AND con.fk_idInstituicao = '" . $idInstituicao . "'
	ORDER BY con.dataCadastro desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}
	public static function totalPedidoAtendidos($idInstituicao)
	{

		$sql = "SELECT count(con.codControle) as totalPedidoAtendidos
		FROM controlePedido as con 
		inner join cliente as cli on cli.codCliente = con.codCliente 
		inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE cli.tipoCliente = 'E' AND con.codStatus = 16 and con.fk_idInstituicao = '" . $idInstituicao . "'
		ORDER BY con.dataCadastro desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function listarPedidoCanceladosNegados($idInstituicao)
	{ // cancelado ou negado

		$sql = "SELECT sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao,con.fk_idInstituicao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
		FROM controlePedido as con 
		inner join cliente as cli on cli.codCliente = con.codCliente 
		inner join statusPedido as sta on sta.codStatus = con.codStatus
		where sta.nome in  ('NEGADO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "'
		ORDER BY con.dataCadastro desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function listarPedido($idInstituicao)
	{

		$sql = "SELECT con.fk_idInstituicao ,con.codControle,con.dataFechamento,con.dataAlteracao,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.codCliente, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
		FROM controlePedido as con 
		inner join cliente as cli on cli.codCliente = con.codCliente 
		inner join statusPedido as sta on sta.codStatus = con.codStatus
		WHERE con.fk_idInstituicao = '" . $idInstituicao . "'
		ORDER BY con.dataCadastro desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();

		return $stmt;
	}

	public static function listarPedidoNaoAtendCanc($idInstituicao)
	{
		$sql = "SELECT con.fk_idInstituicao,con.codControle,con.dataFechamento,con.dataAlteracao,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
		FROM controlePedido as con 
		inner join cliente as cli on cli.codCliente = con.codCliente 
		inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE sta.nome not in ('ATENDIDO','CANCELADO','NEGADO') AND con.fk_idInstituicao = '" . $idInstituicao . "'
		ORDER BY con.dataCadastro desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function listarPedidoId($id, $idInstituicao)
	{

		$sql = "SELECT con.fk_idInstituicao,con.codControle,con.dataFechamento,con.dataAlteracao,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
		FROM controlePedido as con 
		inner join cliente as cli on cli.codCliente = con.codCliente 
		inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE con.codControle = $id AND con.fk_idInstituicao = '" . $idInstituicao . "' ";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function listarPedidoTipo($idInstituicao)
	{

		$sql = "SELECT con.fk_idInstituicao,con.codControle,con.dataFechamento,con.dataAlteracao,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus, cli.tipoCliente
		FROM controlePedido as con 
		inner join cliente as cli on cli.codCliente = con.codCliente 
		inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE cli.tipoCliente = 'E' AND con.fk_idInstituicao = '" . $idInstituicao . "' ";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}


	public static function CadastroPedido($numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao, $dataCadastro, $idInstituicao)
	{
		$pdo = Database::connect();

		try {
			$stmt = $pdo->prepare("INSERT INTO controlePedido (numeroPregao, numeroAf,valorPedido,codStatus,codCliente,anexo,observacao, dataCadastro,fk_idInstituicao) 
													VALUES(:numeroPregao, :numeroAf, :valorPedido, :codStatus, :codCliente, :anexo, :observacao,:dataCadastro,:idInstituicao)");
			//numeroPregao,numeroAf,valorPedido,codStatus,codCliente,anexo, observacao
			$stmt->bindparam(":numeroPregao", $numeroPregao);
			$stmt->bindparam(":numeroAf", $numeroAf);
			$stmt->bindparam(":valorPedido", $valorPedido);
			$stmt->bindparam(":codStatus", $codStatus);
			$stmt->bindparam(":codCliente", $codCliente);
			$stmt->bindparam(":anexo", $anexo);
			$stmt->bindparam(":observacao", $observacao);
			$stmt->bindparam(":dataCadastro", $dataCadastro);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function editarPedido($codControle, $numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE controlepedido SET numeroPregao=:numeroPregao, numeroAf=:numeroAf,valorPedido=:valorPedido,codStatus=:codStatus,codCliente=:codCliente,anexo=:anexo,observacao=:observacao 
		WHERE codControle=:codControle AND fk_idInstituicao=:idInstituicao ");
			$stmt->bindparam(":codControle", $codControle);
			$stmt->bindparam(":numeroPregao", $numeroPregao);
			$stmt->bindparam(":numeroAf", $numeroAf);
			$stmt->bindparam(":valorPedido", $valorPedido);
			$stmt->bindparam(":codStatus", $codStatus);
			$stmt->bindparam(":codCliente", $codCliente);
			$stmt->bindparam(":anexo", $anexo);
			$stmt->bindparam(":observacao", $observacao);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public static function AlterarPedido($codControle, $statusPedido, $mensagemAlterar, $idInstituicao, $dataAlteracao, $dataFechamento)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE controlePedido SET codStatus=:statusPedido, observacao=:mensagemAlterar,dataAlteracao=:dataAlteracao, dataFechamento=:dataFechamento WHERE codControle=:codControle AND fk_idInstituicao=:idInstituicao ");
			$stmt->bindparam(":codControle", $codControle);
			$stmt->bindparam(":statusPedido", $statusPedido);
			$stmt->bindparam(":mensagemAlterar", $mensagemAlterar);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->bindparam(":dataAlteracao", $dataAlteracao);
			$stmt->bindparam(":dataFechamento", $dataFechamento);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public static function AlterarPedido2($codControle, $statusPedido, $mensagemAlterar, $nomeCliente, $numeroAf, $valorPedido, $numeroLicitacao, $anexoAlterar, $idInstituicao, $dataAlteracao)
	{

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE controlePedido SET codStatus=:statusPedido, observacao=:mensagemAlterar, 
		codCliente=:nomeCliente, numeroAf=:numeroAf, valorPedido=:valorPedido, numeroPregao=:numeroLicitacao, anexo=:anexoAlterar, dataAlteracao=:dataAlteracao WHERE codControle=:codControle AND fk_idInstituicao=:idInstituicao ");
			$stmt->bindparam(":codControle", $codControle);
			$stmt->bindparam(":statusPedido", $statusPedido);
			$stmt->bindparam(":mensagemAlterar", $mensagemAlterar);
			$stmt->bindparam(":nomeCliente", $nomeCliente);
			$stmt->bindparam(":numeroAf", $numeroAf);
			$stmt->bindparam(":valorPedido", $valorPedido);
			$stmt->bindparam(":numeroLicitacao", $numeroLicitacao);
			$stmt->bindparam(":anexoAlterar", $anexoAlterar);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->bindparam(":dataAlteracao", $dataAlteracao);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function deletePedido($id, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM controlePedido WHERE codControle=:codControle AND fk_idInstituicao =:idInstituicao ");
		$stmt->bindparam(":codControle", $id);
		$stmt->bindparam(":idInstituicao", $idInstituicao);
		$stmt->execute();
		return true;
	}
	//controlepedido

	//CADASTRO DE REPRESENTANTE
	public static function listarRepresentante($idInstituicao)
	{
		$sql = "SELECT * FROM cadRepresentante WHERE fk_idInstituicao = '" . $idInstituicao . "' ORDER BY nomeRepresentante desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}
	public static function listarRepresentanteId($id, $idInstituicao)
	{
		$sql = "SELECT * FROM cadRepresentante WHERE codRepresentante = $id AND con.fk_idInstituicao = '" . $idInstituicao . "' ORDER BY nomeRepresentante desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function criarRepresentante($nomeRepresentante, $idInstituicao)
	{
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO cadRepresentante(nomeRepresentante, fk_idInstituicao) VALUE (:nomeRepresentante,:idInstituicao)");
			$stmt->bindparam(":nomeRepresentante", $nomeRepresentante);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public static function deleteRepresentante($codRepresentante, $idInstituicao)
	{

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		try {
			$stmt = $pdo->prepare("DELETE FROM cadRepresentante WHERE codRepresentante =:codRepresentante AND fk_idInstituicao=:idInstituicao");
			$stmt->bindParam(":codRepresentante", $codRepresentante);
			$stmt->bindParam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function editarRepresentante($nomeRepresentante, $codRepresentante, $statusRepresentante, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE cadRepresentante SET nomeRepresentante=:nomeRepresentante, statusRepresentante=:statusRepresentante, fk_idInstituicao=:idInstituicao 
		WHERE codRepresentante=:codRepresentante");
			$stmt->bindParam(":codRepresentante", $codRepresentante);
			$stmt->bindParam(":nomeRepresentante", $nomeRepresentante);
			$stmt->bindParam(":statusRepresentante", $statusRepresentante);
			$stmt->bindParam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function ativaRepresentante($codRepresentante, $statusRepresentante, $idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE cadRepresentante SET statusRepresentante=:statusRepresentante, fk_idInstituicao=:idInstituicao 
		WHERE codRepresentante=:codRepresentante");
			$stmt->bindParam(":codRepresentante", $codRepresentante);
			$stmt->bindParam(":statusRepresentante", $statusRepresentante);
			$stmt->bindParam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	//CADASTRO DE REPRESENTANTE

	//CADASTRO DE INSTITUICAO
	public static function listarInstituicao()
	{
		$sql = "SELECT * FROM instituicao ORDER BY inst_nome desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}
	public static function listarInstituicaoId($idInstituicao)
	{
		$sql = "SELECT * FROM instituicao WHERE inst_codigo = '" . $idInstituicao . "' ORDER BY inst_nome desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function listarInstituicaoNome($valorPesquisar)
	{
		$sql = "SELECT * FROM instituicao 
		WHERE inst_nome LIKE'%" . $valorPesquisar . "%' ORDER BY inst_nome desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public static function cadastrarInstituicao($nomeInstituicao, $nomeFantasia, $codigoAcesso, $dataCadastro)
	{
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO instituicao(inst_nome,inst_nomeFantasia,inst_codigo,inst_dataCadastro) VALUE (:nomeInstituicao,:nomeFantasia,:codigoAcesso,:dataCadastro)");
			$stmt->bindparam(":nomeInstituicao", $nomeInstituicao);
			$stmt->bindparam(":nomeFantasia", $nomeFantasia);
			$stmt->bindparam(":codigoAcesso", $codigoAcesso);
			$stmt->bindparam(":dataCadastro", $dataCadastro);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public static function alterarInstituicao($idInstituicao, $nomeInstituicao, $nomeFantasia)
	{
		$pdo = Database::connect();
		try {
			//$stmt = $pdo->prepare("UPDATE cadRepresentante SET nomeRepresentante=:nomeRepresentante, statusRepresentante=:statusRepresentante, fk_idInstituicao=:idInstituicao WHERE codRepresentante=:codRepresentante");
			$stmt = $pdo->prepare("UPDATE  instituicao SET inst_nome=:nomeInstituicao,inst_nomeFantasia=:nomeFantasia WHERE inst_id=:idInstituicao");
			$stmt->bindparam(":nomeInstituicao", $nomeInstituicao);
			$stmt->bindparam(":nomeFantasia", $nomeFantasia);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			//$stmt->bindparam(":dataCadastro", $dataCadastro);			
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function excluirInstituicao($idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("DELETE FROM instituicao WHERE inst_id =:idInstituicao");
			$stmt->bindParam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	//CADASTRO DE INSTITUICAO

	//CADASTRO DE CONTATOS
	public static function listarContato($idInstituicao)
	{
		$sql = "SELECT * FROM contatoCliente WHERE fk_idInstituicao = '" . $idInstituicao . "' ORDER BY nome desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}
	public static function cadastrarContato($nomeInstituicao, $nomeFantasia, $codigoAcesso, $dataCadastro)
	{
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO instituicao(inst_nome,inst_nomeFantasia,inst_codigo,inst_dataCadastro) VALUE (:nomeInstituicao,:nomeFantasia,:codigoAcesso,:dataCadastro)");
			$stmt->bindparam(":nomeInstituicao", $nomeInstituicao);
			$stmt->bindparam(":nomeFantasia", $nomeFantasia);
			$stmt->bindparam(":codigoAcesso", $codigoAcesso);
			$stmt->bindparam(":dataCadastro", $dataCadastro);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public static function alterarContato($idInstituicao, $nomeInstituicao, $nomeFantasia)
	{
		$pdo = Database::connect();
		try {
			//$stmt = $pdo->prepare("UPDATE cadRepresentante SET nomeRepresentante=:nomeRepresentante, statusRepresentante=:statusRepresentante, fk_idInstituicao=:idInstituicao WHERE codRepresentante=:codRepresentante");
			$stmt = $pdo->prepare("UPDATE  instituicao SET inst_nome=:nomeInstituicao,inst_nomeFantasia=:nomeFantasia WHERE inst_id=:idInstituicao");
			$stmt->bindparam(":nomeInstituicao", $nomeInstituicao);
			$stmt->bindparam(":nomeFantasia", $nomeFantasia);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			//$stmt->bindparam(":dataCadastro", $dataCadastro);			
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public static function excluirContato($idInstituicao)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("DELETE FROM instituicao WHERE inst_id =:idInstituicao");
			$stmt->bindParam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	//CADASTRO DE INSTITUICAO

	public static function pesquisar($valorPesquisar)
	{
		$sql = "SELECT * FROM instituicao WHERE inst_nome LIKE'%" . $valorPesquisar . "%' ORDER BY inst_nome desc";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}
	public static function enviarEmailPedido($email, $subject, $nomeUsuario)
	{
		$to = $email;
		
				//$subject = "Informacoes de Pedido"; // assunto
				$message = "Usuario: " .$nomeUsuario. " efetuou movimentacao de pedido no sistema <br><br> " . "\r\n";
				$message .= "<a href=http://sistemaocorrencia.devnogueira.online> Click aqui para acessar o sistema</a> <br><br><br> " . "\r\n";
				$message .= "favor da tratamento" . "\r\n";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:< noreply@sistemadevnogueira.online>' . "\r\n"; //email de envio
				//$headers .= 'CC:< programadorfsaba@gmail.com>' . "\r\n"; //email com copia
			//	$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>' . "\r\n"; //email para resposta

				mail($to, $subject, $message, $headers);
	}
	public static function enviarEmailPedidoAnexo($email,$subject,$nomeUsuario,$anexoAlterar){
		$to = $email;
		$anexo = $anexoAlterar;
				//$subject = "Informacoes de Pedido"; // assunto
				$message = "Usuario: " .$nomeUsuario. " efetuou movimentacao de pedido no sistema <br><br> " . "\r\n";
				$message .= "<a href=http://sistemaocorrencia.devnogueira.online> Click aqui para acessar o sistema</a> <br><br><br> " . "\r\n";
				$message .= "<a href=http://sistemaocorrencia.devnogueira.online/".$anexo."> Click aqui visualisar o anexo</a> <br><br><br> " . "\r\n";
				$message .= "favor da tratamento" . "\r\n";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:< noreply@sistemadevnogueira.online>' . "\r\n"; //email de envio
				//$headers .= 'CC:< programadorfsaba@gmail.com>' . "\r\n"; //email com copia
			//	$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>' . "\r\n"; //email para resposta

				mail($to, $subject, $message, $headers);
	}
	public static function enviarEmailSuporte($email,$mensagem,$nomeUsuario,$erro,$data){
		

		//$subject = "Informacoes de Pedido"; // assunto
		$message = "Usuario: " . $nomeUsuario . " efetuou movimentacao de pedido no sistema <br><br> " . "\r\n";
		$message .= "<a href=http://sistemaocorrencia.devnogueira.online> Click aqui para acessar o sistema</a> <br><br><br> " . "\r\n";
		$message .= "favor da tratamento" . "\r\n";
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:< noreply@sistemadevnogueira.online>' . "\r\n"; //email de envio
		//$headers .= 'CC:< programadorfsaba@gmail.com>' . "\r\n"; //email com copia
		//	$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>' . "\r\n"; //email para resposta

		mail($to, $subject, $message, $headers);
	}
	public static function enviarEmailSuporte($email, $mensagem, $nomeUsuario, $erro, $data)
	{
		$to = 'suporte@sistemadevnogueira.online';

		$subject = "Erro no sistema"; // assunto
		$message = "Usuario: " . $nomeUsuario . " identificou o erro no sistema <br><br> " . "\r\n";
		$message .= "Mensagem do Usuario: " . $mensagem . "  <br><br> " . "\r\n";
		$message .= "erro ocorrido em: " . $data . "  <br><br> " . "\r\n";
		$message .= "<a href=http://sistemaocorrencia.devnogueira.online> Click aqui para acessar o sistema</a> <br><br> " . "\r\n";
		$message .= "error " . $erro . " <br><br>"  . "\r\n";
		$message .= "favor da tratamento" . "\r\n";
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:< noreply@sistemadevnogueira.online>' . "\r\n"; //email de envio			
		$headers .= 'CC:<' . $email . '>' . "\r\n"; //email com copia
		$headers .= 'Reply-To: <' . $to . '>' . "\r\n"; //email para resposta

		mail($to, $subject, $message, $headers);
	}
}
