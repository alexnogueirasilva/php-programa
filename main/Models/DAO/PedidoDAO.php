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
	$sql = "SELECT cli.codCliente,con.fk_idInstituicao,con.codControle,CAST(con.dataAlteracao AS date) as dataAlteracao,con.dataFechamento,CAST(con.dataCadastro AS date) as dataCadastro ,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	where con.fk_idInstituicao = '" . $idInstituicao . "'  AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}

public static function listarPedidoMunicipio($idInstituicao){
	$sql = "SELECT con.codControle,CAST(con.dataAlteracao AS date) as dataAlteracao,con.dataFechamento,CAST(con.dataCadastro AS date) as dataCadastro,con.numeroPregao,con.fk_idInstituicao as intituicao_id, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	where con.fk_idInstituicao = '" . $idInstituicao . "'	AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoNaoAteCanc($idInstituicao) {//nao atendidos/cancelado

	$sql = "SELECT con.fk_idInstituicao ,sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	where sta.nome  not in  ('ATENDIDO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}

public static function listarPedidoNaoAteCancMunicipio($idInstituicao) {//nao atendidos/cancelado

	$sql = "SELECT con.fk_idInstituicao ,sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	where sta.nome  not in  ('ATENDIDO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoCanceladosNegados($idInstituicao) {// cancelado ou negado

	$sql = "SELECT sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao,con.fk_idInstituicao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
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
		$sql = "SELECT con.fk_idInstituicao,con.codControle,CAST(con.dataFechamento AS Date) as dataFechamento,CAST(con.dataAlteracao AS Date) as dataAlteracao,CAST(con.dataCadastro AS Date) as dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
		FROM controlePedido as con 
		inner join cliente as cli on cli.codCliente = con.codCliente 
		inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE sta.nome not in ('ATENDIDO','CANCELADO','NEGADO') AND con.fk_idInstituicao = '" . $idInstituicao . "'  AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
		ORDER BY con.dataCadastro desc";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

public static function listarPedidoCanceladosNegadosMunicipio($idInstituicao) {// cancelado ou negado

	$sql = "SELECT sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao,con.fk_idInstituicao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	where sta.nome in  ('NEGADO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoAtendidos($idInstituicao) {// Atendidos

	$sql = "SELECT sta.nome,con.fk_idInstituicao,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente,sta.codStatus, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	where sta.nome in  ('ATENDIDO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoAtendidosMunicipio($idInstituicao) {// Atendidos

	$sql = "SELECT sta.nome,con.fk_idInstituicao,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente,sta.codStatus, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	where sta.nome in  ('ATENDIDO') AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}

public static function listarPedidoId($id) {	
	$sql = "SELECT con.codControle,con.fk_idInstituicao,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	 WHERE con.codCliente = $id AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente IN ('Estadual','Federal','Estadual')
	 	 ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoIdMunicipio($id) {	
	$sql = "SELECT con.codControle,con.fk_idInstituicao,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	 WHERE con.codCliente = $id AND con.fk_idInstituicao = '" . $idInstituicao . "' AND cli.tipoCliente NOT IN ('Estadual','Federal','Estadual')
	 	 ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}


public static function CadastroPedido($numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao) {
	$pdo = Database::connect();

	try {
		$stmt = $pdo->prepare("INSERT INTO controlePedido (numeroPregao, numeroAf,valorPedido,codStatus,codCliente,anexo,observacao) 
													VALUES(:numeroPregao, :numeroAf, :valorPedido, :codStatus, :codCliente, :anexo, :observacao)");
									   					   //numeroPregao,numeroAf,valorPedido,codStatus,codCliente,anexo, observacao
		$stmt->bindparam(":numeroPregao", $numeroPregao);
		$stmt->bindparam(":numeroAf", $numeroAf);
		$stmt->bindparam(":valorPedido", $valorPedido);
		$stmt->bindparam(":codStatus", $codStatus);
		$stmt->bindparam(":codCliente", $codCliente);
		$stmt->bindparam(":anexo", $anexo);
		$stmt->bindparam(":observacao", $observacao);
		$stmt->execute();

		return true;
	} catch (PDOException $e) {

		echo $e->getMessage();
		return false;
	}
}

public static function editarPedido($codControle, $numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao){
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try {
		$stmt = $pdo->prepare("UPDATE controlepedido SET numeroPregao=:numeroPregao, numeroAf=:numeroAf,valorPedido=:valorPedido,codStatus=:codStatus,codCliente=:codCliente,anexo=:anexo,observacao=:observacao WHERE codControle=:codControle ");
		$stmt->bindparam(":codControle", $codControle);
		$stmt->bindparam(":numeroPregao", $numeroPregao);
		$stmt->bindparam(":numeroAf", $numeroAf);
		$stmt->bindparam(":valorPedido", $valorPedido);
		$stmt->bindparam(":codStatus", $codStatus);
		$stmt->bindparam(":codCliente", $codCliente);
		$stmt->bindparam(":anexo", $anexo);
		$stmt->bindparam(":observacao", $observacao);

		$stmt->execute();

		return true;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}
public static function AlterarPedido($codControle, $statusPedido, $mensagemAlterar){
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try {
		$stmt = $pdo->prepare("UPDATE controlePedido SET codStatus=:statusPedido, observacao=:mensagemAlterar WHERE codControle=:codControle ");
		$stmt->bindparam(":codControle", $codControle);
		$stmt->bindparam(":statusPedido", $statusPedido);
		$stmt->bindparam(":mensagemAlterar", $mensagemAlterar);

		$stmt->execute();

		return true;
	} catch (PDOException $e) {
		echo $e->getMessage();
		return false;
	}
}

public static function deletePedido($codControle){
	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare("DELETE FROM controlepedido WHERE codControle=:codControle");
	$stmt->bindparam(":codControle", $codControle);
	$stmt->execute();
	return true;
}
//controlepedido

}
