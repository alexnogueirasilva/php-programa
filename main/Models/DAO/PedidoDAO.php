<?php

include_once '/../../../core/conex.php';

class PedidoDAO
{

    public static function listar(){
        $sql = 'SELECT con.codControle,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, sta.nome as nomeStatus 
        FROM controlePedido as con 
        inner join cliente as cli on cli.codCliente = con.codCliente 
        inner join statusPedido as sta on sta.codStatus = con.codStatus
        ORDER BY con.dataCadastro desc';

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public static function listarId($id) {

        $sql = "SELECT SELECT con.codControle,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codControle, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, sta.staNome as nomeStatus 
        FROM controlePedido as con 
        inner join cliente as cli on cli.codCliente = con.codCliente 
        inner join status as sta on sta.idStatus = con.codStatus WHERE codControle = $id";

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt;
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

    public static function formataData($data)    {
        $qtde = strlen($data);
        $data1 = new DateTime($data);
        if ($qtde > 10) {
            $dataFormatada = $data1->format('d/m/Y h:i:s');
        } else {
            $dataFormatada = $data1->format('d/m/Y');
        }

        return $dataFormatada;
    }

    public static function CadastroPedido($numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao) {
        $pdo = Database::connect();

        try {
            $stmt = $pdo->prepare("INSERT INTO status (numeroPregao, numeroAf,valorPedido,codStatus,codCliente,anexo,observacao) 
            VALUES(:numeroPregao, :numeroAf, :valorPedido, :statusControle, :codCliente, :anexo, :observacao)");
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

    public static function editarPedido($codControle, $numeroPregao, $numeroAf, $valorPedido, $codStatus, $codCliente, $anexo, $observacao)
    {
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

    public static function deletePedido($codControle){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM controlepedido WHERE codControle=:codControle");
		$stmt->bindparam(":id", $codControle);
		$stmt->execute();
		return true;
	}
}

