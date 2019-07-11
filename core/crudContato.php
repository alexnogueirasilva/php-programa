<?php

include_once 'conex.php';

class crudContato
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


	public static function cadastrar($codCliente, $dataCadastro, $idInstituicao, $nomeContato,$telefoneContato,$celularContato,$emailContato ){
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO contato (nomeContato, telefoneContato,  celularContato,   emailContato,  fk_codCliente, dataCadastro, fk_idInstituicao) 
												VALUES(:nomeContato, :telefoneContato, :celularContato, :emailContato, :codCliente, :dataCadastro,:idInstituicao)");
			$stmt->bindparam(":nomeContato", $nomeContato);
			$stmt->bindparam(":telefoneContato", $telefoneContato);
			$stmt->bindparam(":celularContato", $celularContato);
			$stmt->bindparam(":emailContato", $emailContato);
			$stmt->bindparam(":codCliente", $codCliente);
			$stmt->bindparam(":dataCadastro", $dataCadastro);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			
			$stmt->execute();
			$id_cad = $pdo->lastInsertId();
		
			return $id_cad;
			//return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function alterar($codContato,$codCliente, $dataAlteracao, $idInstituicao, $nomeContato,$telefoneContato,$celularContato,$emailContato)	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE contato SET nomeContato=:nomeContato, telefoneContato=:telefoneContato,celularContato=:celularContato,emailContato=:emailContato,fk_codCliente=:codCliente,dataAlteracao=:dataAlteracao 
		WHERE codContato=:codContato AND fk_idInstituicao=:idInstituicao ");
			$stmt->bindparam(":codContato", $codContato);
			$stmt->bindparam(":nomeContato", $nomeContato);
			$stmt->bindparam(":telefoneContato", $telefoneContato);
			$stmt->bindparam(":celularContato", $celularContato);
			$stmt->bindparam(":emailContato", $emailContato);
			$stmt->bindparam(":codCliente", $codCliente);
			$stmt->bindparam(":dataAlteracao", $dataAlteracao);
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
	public static function listarContato($idInstituicao)
	{
		$sql = "SELECT * FROM contato WHERE fk_idInstituicao = '" . $idInstituicao . "' ORDER BY nomeContato desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
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
	public static function enviarEmailPedido($email, $subject, $nomeUsuario,$mensagemEmail,$dadosCadastro)	{
		$to = $email;
		if($mensagemEmail == ''){
			$mensagemEmail = "sem informacoes!";
		}
		
				//$subject = "Informacoes de Pedido"; // assunto
				$message = "Ola, <br><br> " .$nomeUsuario. " efetuou movimentacao de pedido no sistema <br><br> " . "\r\n";
				$message .= "<a href=http://sistemaocorrencia.devnogueira.online> Click aqui para acessar o sistema</a> <br><br> " . "\r\n";
				$message .= "Mensagem do Usuario: " . $mensagemEmail. " <br><br>" . "\r\n";
				$message .= "Dados do cadastro: <br>" . $dadosCadastro. " <br><br>" . "\r\n";
				$message .= "Favor da tratamento" . "\r\n";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:< noreply@sistemadevnogueira.online>' . "\r\n"; //email de envio
				//$headers .= 'CC:< programadorfsaba@gmail.com>' . "\r\n"; //email com copia
				//$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>' . "\r\n"; //email para resposta

				mail($to, $subject, $message, $headers);
	}
	
	public static function enviarEmailPedidoAnexo($email,$subject,$nomeUsuario,$anexo,$dadosCadastro){
		$to = $email;
		
				//$subject = "Informacoes de Pedido"; // assunto
				$message = "Ola, <br><br> " .$nomeUsuario. " efetuou movimentacao de pedido no sistema <br><br> " . "\r\n";
				$message .= "<a href=http://sistemaocorrencia.devnogueira.online> Click aqui para acessar o sistema</a> <br><br> " . "\r\n";
				$message .= "<a href=http://sistemaocorrencia.devnogueira.online/anexos/".$anexo."> Click aqui para visualisar o anexo</a> <br><br> " . "\r\n";
				$message .= "Dados do cadastro: <br>" . $dadosCadastro. " <br><br>" . "\r\n";
				$message .= "favor da tratamento" . "\r\n";
				$headers = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'content-type: text/html; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:< noreply@sistemadevnogueira.online>' . "\r\n"; //email de envio
				//$headers .= 'CC:< programadorfsaba@gmail.com>' . "\r\n"; //email com copia
			//	$headers .= 'Reply-To: < carlosandrefsaba@gmail.com>' . "\r\n"; //email para resposta

				mail($to, $subject, $message, $headers);
	}
	
	public static function enviarEmailSuporte($email, $mensagem, $nomeUsuario, $erro, $data){
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
