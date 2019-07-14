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

	public static function cadastrar($codCliente, $dataCadastro, $idInstituicao, $nomeContato,$telefoneContato,$celularContato,$emailContato,$cargoSetor,$codUsuario ){
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("INSERT INTO contato (nomeContato, telefoneContato,  celularContato,   emailContato,  fk_codCliente, dataCadastro, fk_idInstituicao,cargoSetor,fk_idUsuario) 
												VALUES(:nomeContato, :telefoneContato, :celularContato, :emailContato, :codCliente, :dataCadastro,:idInstituicao,:cargoSetor,:codUsuario)");
			$stmt->bindparam(":nomeContato", $nomeContato);
			$stmt->bindparam(":telefoneContato", $telefoneContato);
			$stmt->bindparam(":celularContato", $celularContato);
			$stmt->bindparam(":emailContato", $emailContato);
			$stmt->bindparam(":codCliente", $codCliente);
			$stmt->bindparam(":dataCadastro", $dataCadastro);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->bindparam(":cargoSetor", $cargoSetor);
			$stmt->bindparam(":codUsuario", $codUsuario);
			
			$stmt->execute();
			$id_cad = $pdo->lastInsertId();
		
			return $id_cad;
			//return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function excluir($codContato,$idInstituicao)	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("DELETE FROM contato WHERE codContato=:codContato AND fk_idInstituicao=:idInstituicao ");
			$stmt->bindparam(":codContato", $codContato);			
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->execute();
			return $codContato;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	public static function alterar($codContato,$codCliente, $dataAlteracao, $idInstituicao, $nomeContato,$telefoneContato,$celularContato,$emailContato,$cargoSetor,$codUsuario){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE contato SET nomeContato=:nomeContato, telefoneContato=:telefoneContato,celularContato=:celularContato,emailContato=:emailContato,fk_codCliente=:codCliente,dataAlteracao=:dataAlteracao, cargoSetor=:cargoSetor,fk_idUsuario=:codUsuario
		WHERE codContato=:codContato AND fk_idInstituicao=:idInstituicao ");
			$stmt->bindparam(":codContato", $codContato);
			$stmt->bindparam(":nomeContato", $nomeContato);
			$stmt->bindparam(":telefoneContato", $telefoneContato);
			$stmt->bindparam(":celularContato", $celularContato);
			$stmt->bindparam(":emailContato", $emailContato);
			$stmt->bindparam(":codCliente", $codCliente);
			$stmt->bindparam(":dataAlteracao", $dataAlteracao);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->bindparam(":cargoSetor",$cargoSetor);
			$stmt->bindparam(":codUsuario",$codUsuario);
			$stmt->execute();

			return $codContato;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	
	public static function listarContato($idInstituicao){
		$sql = "SELECT * FROM contato c INNER JOIN cliente cli on cli.codCliente = c.fk_codCliente INNER JOIN usuarios u on u.id= c.fk_idUsuario WHERE c.fk_idInstituicao = '" . $idInstituicao . "' ORDER BY nomeContato desc";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}
	public static function qtdeContato($idInstituicao){
		$sql = "SELECT COUNT(*) as total from contato where fk_idInstituicao = '".$idInstituicao."'";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arrayContatosTodos = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $arrayContatosTodos;
	}
	

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
