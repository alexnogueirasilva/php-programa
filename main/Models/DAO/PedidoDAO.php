<?php
include_once '../core/conex.php';
class PedidoDAO
{
	

	//Nessa função, fazemos a montagem da tabela de dados.
	public static function dataview($query)	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}


	public static function addMensagem($idLogado, $dataHora, $codDemanda, $mensagem){
		$pdo = Database::connect();

		try {
			$stmt = $pdo->prepare("INSERT INTO hst_mensagens(cod_demanda, cod_usr_msg, mensagem, msg_data) VALUES(:cod_demanda, :cod_usr_msg, :mensagem, :datahora)");
			$stmt->bindparam(":cod_demanda", $codDemanda);
			$stmt->bindparam(":cod_usr_msg", $idLogado);
			$stmt->bindparam(":mensagem", $mensagem);
			$stmt->bindparam(":datahora", $dataHora);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	

	public static function formataData($data){
		$qtde = strlen($data);
		$data1 = new DateTime($data);
		if ( $qtde > 10) {
			$dataFormatada = $data1->format('d/m/Y');  
		} else {
			$dataFormatada = $data1->format('d/m/Y');  
		}
				return $dataFormatada;
	}

//controlepedido
public static function listarPedido($idInstituicao){
	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario,cli.codCliente,con.fk_idInstituicao,con.codControle,CAST(con.dataAlteracao AS date) as dataAlteracao,con.dataFechamento,CAST(con.dataCadastro AS date) as dataCadastro ,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	where con.fk_idInstituicao = '" . $idInstituicao . "'  AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}

public static function listarPedidoMunicipio($idInstituicao){
	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario, cli.codCliente, con.codControle,CAST(con.dataAlteracao AS date) as dataAlteracao,con.dataFechamento,CAST(con.dataCadastro AS date) as dataCadastro,con.numeroPregao,con.fk_idInstituicao as intituicao_id, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	where con.fk_idInstituicao = '" . $idInstituicao . "'	AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoNaoAteCanc($idInstituicao) {//nao atendidos/cancelado

	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario,con.fk_idInstituicao ,sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	where sta.nome  not in  ('ATENDIDO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}

public static function listarPedidoNaoAteCancMunicipio($idInstituicao) {//nao atendidos/cancelado

	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario,con.fk_idInstituicao ,sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	where sta.nome  not in  ('ATENDIDO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoCanceladosNegados($idInstituicao) {// cancelado ou negado

	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario, sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao,con.fk_idInstituicao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	where sta.nome in  ('NEGADO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoNaoAtendCancMunicipio($idInstituicao)
	{
		$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario, con.fk_idInstituicao,con.codControle,CAST(con.dataFechamento AS Date) as dataFechamento,CAST(con.dataAlteracao AS Date) as dataAlteracao,CAST(con.dataCadastro AS Date) as dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente,cli.codCliente, cli.tipoCliente, sta.nome as nomeStatus 
		FROM controlePedido as con 
		inner join cliente as cli on cli.codCliente = con.codCliente 
		inner join statusPedido as sta on sta.codStatus = con.codStatus 
			inner join usuarios as u on u.id = con.fk_idUsuarioPed
		WHERE sta.nome not in ('ATENDIDO','CANCELADO','NEGADO') 
		AND con.fk_idInstituicao = '" . $idInstituicao . "'
		
		AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
		ORDER BY con.dataCadastro desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

public static function listarPedidoCanceladosNegadosMunicipio($idInstituicao) {// cancelado ou negado

	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario, sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao,con.fk_idInstituicao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
		inner join usuarios as u on u.id = con.fk_idUsuarioPed
	where sta.nome in  ('NEGADO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoAtendidos($idInstituicao) {// Atendidos

	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario, sta.nome,con.fk_idInstituicao,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente,sta.codStatus, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	where sta.nome in  ('ATENDIDO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoAtendidosMunicipio($idInstituicao) {// Atendidos

	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario, sta.nome,con.fk_idInstituicao,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente,sta.codStatus, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	where sta.nome in  ('ATENDIDO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}

public static function listarPedidoId($id) {	
	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario, con.codControle,con.fk_idInstituicao,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	 WHERE con.codCliente = $id AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	 	 ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoIdMunicipio($id) {	
	$sql = "SELECT con.fk_idUsuarioPed, con.garantia, u.nome as nomeUsuario, con.codControle,con.fk_idInstituicao,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	inner join usuarios as u on u.id = con.fk_idUsuarioPed
	 WHERE con.codCliente = $id AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	 	 ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}


public static function CadastroPedido($numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao, $dataCadastro, $idInstituicao,$idUsuario,$garantia)
	{
		$pdo = Database::connect();

		try {
			$stmt = $pdo->prepare("INSERT INTO controlePedido (numeroPregao, numeroAf,valorPedido,codStatus,codCliente,anexo,observacao, dataCadastro,fk_idInstituicao,fk_idUsuarioPed,garantia) 
													VALUES(:numeroPregao, :numeroAf, :valorPedido, :codStatus, :codCliente, :anexo, :observacao,:dataCadastro,:idInstituicao,:idUsuario,:garantia)");
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
			$stmt->bindparam(":idUsuario", $idUsuario);
			$stmt->bindparam(":garantia", $garantia);
			
			$stmt->execute();
			$id_cad = $pdo->lastInsertId();
		
			return	$id_cad;
			//return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

public static function editarPedido($codControle, $numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao, $idInstituicao,$garantia)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE controlepedido SET numeroPregao=:numeroPregao, numeroAf=:numeroAf,valorPedido=:valorPedido,codStatus=:codStatus,codCliente=:codCliente,anexo=:anexo,observacao=:observacao, garantia =:garantia 
		WHERE codControle=:codControle AND fk_idInstituicao=:idInstituicao ");
			$stmt->bindparam(":codControle", $codControle);
			$stmt->bindparam(":numeroPregao", $numeroPregao);
			$stmt->bindparam(":numeroAf", $numeroAf);
			$stmt->bindparam(":valorPedido", $valorPedido);
			$stmt->bindparam(":codStatus", $codStatus);
			$stmt->bindparam(":codCliente", $codCliente);
			$stmt->bindparam(":anexo", $anexo);
			$stmt->bindparam(":observacao", $observacao);
			$stmt->bindparam(":garantia", $garantia);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}
	
public static function AlterarPedido($codControle, $statusPedido, $mensagemAlterar, $idInstituicao, $dataAlteracao, $dataFechamento,$idUsuario,$garantia)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE controlePedido SET codStatus=:statusPedido, observacao=:mensagemAlterar,dataAlteracao=:dataAlteracao, dataFechamento=:dataFechamento, fk_idUsuarioPed=:idUsuario, garantia=:garantia WHERE codControle=:codControle AND fk_idInstituicao=:idInstituicao ");
			$stmt->bindparam(":codControle", $codControle);
			$stmt->bindparam(":statusPedido", $statusPedido);
			$stmt->bindparam(":mensagemAlterar", $mensagemAlterar);
			$stmt->bindparam(":idInstituicao", $idInstituicao);
			$stmt->bindparam(":dataAlteracao", $dataAlteracao);
			$stmt->bindparam(":dataFechamento", $dataFechamento);
			$stmt->bindparam(":idUsuario", $idUsuario);
			$stmt->bindparam(":garantia", $garantia);
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
		codCliente=:nomeCliente, numeroAf=:numeroAf, valorPedido=:valorPedido, numeroPregao=:numeroLicitacao, anexo=:anexoAlterar, dataAlteracao=:dataAlteracao,garantia=:garantia WHERE codControle=:codControle AND fk_idInstituicao=:idInstituicao ");
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
			$stmt->bindparam(":garantia", $garantia);

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
		$stmt = $pdo->prepare("DELETE FROM controlePedido WHERE codControle = :id AND fk_idInstituicao = :idInstituicao ");
		$stmt->bindparam(":id", $id);
		$stmt->bindparam(":idInstituicao", $idInstituicao);
		$stmt->execute();
		return true;
	}
	}
	//controlepedido
