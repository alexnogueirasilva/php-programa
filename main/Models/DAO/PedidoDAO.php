<?php
include_once '../core/conex.php';
class PedidoDAO
{
	//Aqui fazemos a verificação do login do usuário e do seu nível de acesso
	public static function pesquisaLoginUsr($instituicao,$nome, $senha){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pwd = sha1($senha);
		$sql = "SELECT u.id as idUsuario,u.nome,u.email,u.nivel,u.senha, u.status, u.id_dep, i.id,u.id_instituicao, i.nome as nomeInstituicao FROM usuarios AS u INNER JOIN instituicao AS i on i.id = u.id_instituicao where id_instituicao ='" . $instituicao . "' AND email ='" . $nome . "' AND senha ='" . $pwd . "'";
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	//Nessa função, fazemos a montagem da tabela de dados.
	public static function dataview($query)	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public static function mostraDemandas($usuarioSessao)	{
		//SQL QUE VAI MOSTRAR A LISTA DE CHAMADOS DE CADA USUÁRIO UNINDO TRÊS TABELAS - (DEMANDAS, USUÁRIOS E DEPARTAMENTOS)

		$query = 'SELECT d.id, d.mensagem, cli.nomecliente, d.titulo,d.id_Instituicao as idInstituicao, d.prioridade, d.ordem_servico, d.data_criacao,d.data_fechamento, d.status,d.anexo, u.nome, dep.nome as nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_destino = u.id AND id_usr_criador = ' . $usuarioSessao . ' INNER JOIN departamentos AS dep ON u.id_dep = dep.id INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem ORDER BY data_criacao ASC';
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	public static function mostraTodasDemandas(){
		//SQL QUE VAI MOSTRAR A LISTA DE CHAMADOS DE CADA USUÁRIO UNINDO TRÊS TABELAS - (DEMANDAS, USUÁRIOS E DEPARTAMENTOS)
		$query = 'SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.ordem_servico, d.data_criacao, d.status, d.anexo, u.nome, d.id_usr_criador, dep.nome AS nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_criador = u.id INNER JOIN departamentos AS dep ON d.id_dep = dep.id ORDER BY data_criacao ASC';
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}

	//Esta é a função que atualiza o cadastro com os dados vindos da edição.	
	public static function atualizaStatusUsuario($id, $status){
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

	public static function atualizaCliente($id, $nome, $status,$tipoCliente)	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE cliente SET nomecliente=:nome, status=:status, tipoCliente=:tipoCliente WHERE codCliente=:id ");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":tipoCliente", $tipoCliente);
			$stmt->bindparam(":nome", $nome);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function atualizaStatusCliente($id, $status)	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE cliente SET status=:status WHERE codCliente=:id ");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":status", $status);
			$stmt->execute();
			return true;
			echo getMessage("Atualizado com sucesso;");
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function atualizaStatus($codigoDemanda, $status){
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

	public static function fechaDemanda($codigoDemanda, $status, $dataFechamento){
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
	public static function criaDemanda($dataAbertura, $departamento, $idLogado,$idInstituicao, $usuarioDestino, $titulo, $nomeSolicitante, $prioridade, $ordemServico, $mensagem, $status, $nomeAnexo){
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

	public static function criaUsr($nome, $email, $nivel, $dep, $status, $pass)
	{
		$pdo = Database::connect();
		$pwd = sha1($pass);
		try {
			$stmt = $pdo->prepare("INSERT INTO usuarios(nome, email, nivel, id_dep, status, senha) VALUES(:nome, :email, :nivel, :id_dep, :status, :senha)");
			$stmt->bindparam(":nome", $nome);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":nivel", $nivel);
			$stmt->bindparam(":id_dep", $dep);
			$stmt->bindparam(":status", $status);
			$stmt->bindparam(":senha", $pwd);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function criarCliente($nomeCliente)
	{

		$pdo = Database::connect();

		try {
			$stmt = $pdo->prepare("INSERT INTO cliente(nomeCliente) VALUES (:nomeCliente)");
			$stmt->bindparam(":nomeCliente", $nomeCliente);
			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function deleteCliente($idCliente)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("DELETE FROM cliente WHERE codCliente=:codCliente");
			$stmt->bindparam(":codCliente", $idCliente);
			$stmt->execute();
			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

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

	public static function criaUsuario($emailUser, $senhalUser, $dicalUser, $ativo, $valida){
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

	public static function ativarUsuario($ativo, $valida)
	{
		$pdo = Database::connect();
		try {
			$stmt = $pdo->prepare("UPDATE usuario SET ativo=:ativo WHERE valida=:valida");
			$stmt->bindparam(":ativo", $ativo);
			$stmt->bindparam(":valida", $valida);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function mostraUsuario($valor, $valor2)
	{
		$pdo = Database::connect();
		$sql = "SELECT * FROM usuario WHERE valida='" . $valor . "' AND email='" . $valor2 . "'";
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

	public static function VericaEmailUser($emailUser2)
	{
		$pdo = Database::connect();
		$sql = "SELECT email FROM usuario WHERE email='" . $emailUser2 . "'   ";
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
	public static function mostrarCliente()
	{
		$query = "SELECT * FROM cliente ORDER BY nomecliente ASC";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();

		return $stmt;
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
	public static function cadSla($descricao, $tempo, $uniTempo){
		$pdo = Database::connect();

		try {
			$stmt = $pdo->prepare("INSERT INTO tbl_sla (descricao, tempo, unitempo) VALUES(:descricao,:tempo,:unitempo)");
			$stmt->bindparam(":descricao", $descricao);
			$stmt->bindparam(":tempo", $tempo);
			$stmt->bindparam(":unitempo", $uniTempo);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {

			echo $e->getMessage();
			return false;
		}
	}

	public static function edtSla($id, $descricao, $tempo, $uniTempo)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$stmt = $pdo->prepare("UPDATE tbl_sla SET descricao=:descricao, tempo=:tempo, uniTempo=:uniTempo WHERE id=:id ");
			$stmt->bindparam(":id", $id);
			$stmt->bindparam(":descricao", $descricao);
			$stmt->bindparam(":tempo", $tempo);
			$stmt->bindparam(":uniTempo", $uniTempo);

			$stmt->execute();

			return true;
		} catch (PDOException $e) {
			echo $e->getMessage();
			return false;
		}
	}

	public static function excluiSla($id)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM tbl_sla WHERE id=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();
		return true;
	}

	public static function mostraSla()
	{
		$query = "SELECT * FROM tbl_sla";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
	}
	public static function formataData($data){
		$qtde = strlen($data);
		$data1 = new DateTime($data);
		if ( $qtde > 10) {
			$dataFormatada = $data1->format('d/m/Y h:i:s');  
		} else {
			$dataFormatada = $data1->format('d/m/Y');  
		}
				return $dataFormatada;
	}
//statuspedido
	public static function listarStatus()
    {

        $sql = " SELECT * FROM statusPedido ";

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public static function listarSatusId($id)
    {

        $sql = "SELECT * FROM statusPedido WHERE codStatus = $id";

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt;
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
		$stmt = $pdo->prepare("DELETE FROM statusPedido WHERE codStatus=:id");
		$stmt->bindparam(":id", $id);
		$stmt->execute();
		return true;
	}

//statuspedido

//controlepedido
public static function listarPedido(){
	$sql = "SELECT con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}

public static function listarPedidoMunicipio($idInstituicao){
	$sql = "SELECT con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao,con.fk_idInstituicao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
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

	$sql = "SELECT sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
	FROM controlePedido as con 
	inner join cliente as cli on cli.codCliente = con.codCliente 
	inner join statusPedido as sta on sta.codStatus = con.codStatus
	where sta.nome  not in  ('ATENDIDO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "'
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}

public static function listarPedidoNaoAteCancMunicipio($idInstituicao) {//nao atendidos/cancelado

	$sql = "SELECT sta.nome,con.codControle,con.dataAlteracao,con.dataFechamento,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
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
	where sta.nome in  ('NEGADO','CANCELADO') AND con.fk_idInstituicao = '" . $idInstituicao . "'
	ORDER BY con.dataCadastro desc";

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt;
}
public static function listarPedidoNaoAtendCancMunicipio($idInstituicao)
	{
		$sql = "SELECT con.fk_idInstituicao,con.codControle,con.dataFechamento,con.dataAlteracao,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente, sta.nome as nomeStatus 
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
	where sta.nome in  ('ATENDIDO') AND con.fk_idInstituicao = '" . $idInstituicao . "'
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
	 WHERE con.codCliente = $id AND con.fk_idInstituicao = '" . $idInstituicao . "'
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


//CADASTRO DE REPRESENTANTE

public static function criarRepresentante($nomeRepresentante){

	$pdo = Database::connect();

	try{
		$stmt = $pdo->prepare("INSERT INTO cadRepresentante(nomeRepresentante) VALUE (:nomeRepresentante)");
		$stmt->bindParam(":nomeRepresentante", $nomeRepresentante);
		$stmt->execute();

		return true;
	}catch(PDOException $e){
		echo $e->getMessage();
		return false;
	}

}

public static function deleteRepresentante($codRepresentante){

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	try{
		$stmt = $pdo->prepare("DELETE FROM codRepresentante = :codRepresentante");
		$stmt->bindParam(":codRepresentate", $codRepresentante);
		$stmt->execute();

		return true;
	}catch (PDOException $e){
			echo $e->getMessage();
			return false;
	}
}

public static function editarRepresentante($codRepresentante, $nomeRepresentante, $statusRepresentante){

	$pdo = Database::connect();
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try{

		$stmt = $pdo->prepare("UPDATE cadRepresentante SET nomeRepresentante=:nomeRepresentante, statusRepresentante = :statusRepresentante WHERE codRepresentante = :codRepresentante");
		$stmt->bindParam(":codRepresentante", $codRepresentante);
		$stmt->bindParam(":nomeRepresentante", $nomeRepresentante);
		$stmt->bindParam(':statusRepresentante', $statusRepresentante);
		$stmt->execute();

		return true;

	}catch(PDOException $e){
		echo $e->getMessage();
		
		return false;
	}


}
//CADASTRO DE REPRESENTANTE

}
