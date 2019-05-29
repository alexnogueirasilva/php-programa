<?php

include_once '/../../../core/conex.php';

class StatusDAO
{

    public static function listar()
    {

        $sql = " SELECT * FROM statusPedido ";

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public static function listarId($id)
    {

        $sql = "SELECT * FROM statusPedido WHERE codStatus = $id";

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

    public static function CadastroStatus($descricao)
    {
        $pdo = Database::connect();

        try {
            $stmt = $pdo->prepare("INSERT INTO statusPedido (nome) VALUES(:nome)");
            $stmt->bindparam(":nome", $descricao);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {

            echo $e->getMessage();
            return false;
        }
    }

    public static function editarStatus($edtId, $descricao)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try {
            $stmt = $pdo->prepare("UPDATE statusPedido SET nome=:descricao WHERE codStatus=:edtId ");
            $stmt->bindparam(":edtId", $edtId);
            $stmt->bindparam(":descricao", $descricao);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function deleteStatus($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM status WHERE codStatus=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();
		return true;
	}


}