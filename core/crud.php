<?php
include_once 'conex.php';
class crud
{
	//Aqui fazemos a verificação do login do usuário e do seu nível de acesso
	public static function pesquisaLoginUsr($nome,$senha){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pwd = sha1($senha);
		$sql = "SELECT * FROM usuarios where email ='".$nome."' AND senha ='".$pwd."'";
		$q = $pdo->prepare($sql);
		$q->execute();
		$data = $q->fetch(PDO::FETCH_ASSOC);
		return $data;
	}

	//Nessa função, fazemos a montagem da tabela de dados.
	public static function dataview($query){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
		
	}

	public static function mostraDemandas($usuarioSessao){
		//SQL QUE VAI MOSTRAR A LISTA DE CHAMADOS DE CADA USUÁRIO UNINDO TRÊS TABELAS - (DEMANDAS, USUÁRIOS E DEPARTAMENTOS)
		
		$query = 'SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.ordem_servico, d.data_criacao, d.status,d.anexo, u.nome, dep.nome as nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_destino = u.id AND id_usr_criador = '.$usuarioSessao.' INNER JOIN departamentos AS dep ON u.id_dep = dep.id ORDER BY data_criacao ASC';
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
		
	}
	
	//Esta é a função que atualiza o cadastro com os dados vindos da edição.
	public static function atualizaStatus($codigoDemanda,$status){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try
		{
			$stmt=$pdo->prepare("UPDATE demanda SET status=:status WHERE id=:codigoDemanda ");
			$stmt->bindparam(":codigoDemanda",$codigoDemanda);
			$stmt->bindparam(":status",$status);
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}


	public static function atualizaStatusUsuario($id, $status){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try	{
			$stmt=$pdo->prepare("UPDATE usuarios SET status=:status WHERE id=:id ");
			$stmt->bindparam(":id",$id);
			$stmt->bindparam(":status",$status);
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public static function atualizaCliente($id, $nome, $status){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try	{
			$stmt=$pdo->prepare("UPDATE cliente SET nomecliente=:nome, status=:status WHERE codCliente=:id ");
			$stmt->bindparam(":id",$id);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":nome",$nome);
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{			
			echo $e->getMessage();	
			return false;
		}
	}

	public static function atualizaStatusCliente($id, $status){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try	{
			$stmt=$pdo->prepare("UPDATE cliente SET status=:status WHERE codCliente=:id ");
			$stmt->bindparam(":id",$id);
			$stmt->bindparam(":status",$status);
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{			
			echo $e->getMessage();	
			return false;
		}
	}

	public static function fechaDemanda($codigoDemanda, $status, $dataFechamento){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try
		{
			$stmt=$pdo->prepare("UPDATE demanda SET status=:status, data_fechamento=:data_fechamento WHERE id=:codigoDemanda ");
			$stmt->bindparam(":codigoDemanda",$codigoDemanda);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":data_fechamento",$dataFechamento);
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	//Essa é a função responsável pela criação das demandas
	public static function criaDemanda($dataAbertura, $idLogado, $titulo, $departamento, $usuarioDestino, $prioridade, $ordemServico, $mensagem, $status, $nomeAnexo){
		$pdo = Database::connect();

		try{
			$stmt=$pdo->prepare("INSERT INTO demanda(data_criacao, id_dep, id_usr_criador, id_usr_destino, titulo,prioridade, ordem_servico, mensagem, status, anexo) VALUES(:data_criacao, :id_dep, :id_usr_criador, :id_usr_destino, :titulo, :prioridade, :ordem_servico, :mensagem, :status, :anexo)");
			$stmt->bindparam(":data_criacao",$dataAbertura);
			$stmt->bindparam(":id_dep",$departamento);
			$stmt->bindparam(":id_usr_criador",$idLogado);
			$stmt->bindparam(":id_usr_destino",$usuarioDestino);
			$stmt->bindparam(":titulo",$titulo);
			$stmt->bindparam(":prioridade",$prioridade);			
			$stmt->bindparam(":ordem_servico",$ordemServico);			
			$stmt->bindparam(":mensagem",$mensagem);
			$stmt->bindparam(":status",$status);
			$stmt->bindparam(":anexo",$nomeAnexo);
			
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public static function addMensagem($idLogado, $dataHora, $codDemanda, $mensagem){
		$pdo = Database::connect();

		try{
			$stmt=$pdo->prepare("INSERT INTO hst_mensagens(cod_demanda, cod_usr_msg, mensagem, msg_data) VALUES(:cod_demanda, :cod_usr_msg, :mensagem, :datahora)");
			$stmt->bindparam(":cod_demanda", $codDemanda);
			$stmt->bindparam(":cod_usr_msg", $idLogado);
			$stmt->bindparam(":mensagem",$mensagem);						
			$stmt->bindparam(":datahora",$dataHora);						
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{
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
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

	public static function criaUsr($nome, $email, $nivel, $dep, $status, $pass){
		$pdo = Database::connect();
		$pwd = sha1($pass);
		
		
		try{
			$stmt=$pdo->prepare("INSERT INTO usuarios(nome, email, nivel, id_dep, status, senha) VALUES(:nome, :email, :nivel, :id_dep, :status, :senha)");
			$stmt->bindparam(":nome", $nome);
			$stmt->bindparam(":email", $email);
			$stmt->bindparam(":nivel", $nivel);
			$stmt->bindparam(":id_dep",$dep);			
			$stmt->bindparam(":status",$status);			
			$stmt->bindparam(":senha", $pwd);
			$stmt->execute();

			return true;
		}catch(PDOException $e){

			echo $e->getMessage();	
			return false;
		}
		
	}

	public static function criarCliente($nomeCliente){

		$pdo = Database::connect();

		try{
			$stmt=$pdo->prepare("INSERT INTO cliente(nomeCliente) VALUES (:nomeCliente)");
			$stmt->bindparam(":nomeCliente", $nomeCliente);
			//$stmt->bindparam(":status", $statusCliente);

			$stmt->execute();

			return true;
		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}

	}

	public static function deleteCliente($idCliente){

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ATT_EXCEPTION);

		$pdo = Database::connect();

		try{
			$stmt=$pdo->prepare("DELETE FROM cliente WHERE codCliente=:codCliente");
			$stmt->bindparam(":codCliente", $idCliente);
			$stmt->execute();

		}catch(PDOException $e){
			echo $e->getMessage();
			return false;
		}


	}

	public static function edtUsr($id, $nome, $email, $nivel, $dep, $status, $pass){

		$pdo = Database::connect();
		$pwd = sha1($pass);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try
		{
			$stmt=$pdo->prepare("UPDATE usuarios SET nome=:nome, email=:email, nivel=:nivel, id_dep=:id_dep, senha=:senha  WHERE id=:id ");
			$stmt->bindparam(":id",$id);
			$stmt->bindparam(":nome",$nome);
			$stmt->bindparam(":email",$email);
			$stmt->bindparam(":nivel",$nivel);
			$stmt->bindparam(":id_dep",$dep);			
			$stmt->bindparam(":senha",$pwd);			
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public static function deleteUser($id)
	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

	public static function criaDep($nomeDep){
		$pdo = Database::connect();
			
		try{
			$stmt=$pdo->prepare("INSERT INTO departamentos(nome) VALUES(:nomeDep)");
			$stmt->bindparam(":nomeDep", $nomeDep);
			
			$stmt->execute();

			return true;
		}catch(PDOException $e){

			echo $e->getMessage();	
			return false;
		}
		
	}

	public static function mostrarCliente(){

		$query = "SELECT * FROM cliente";

		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();

		return $stmt;
		
	}

	//Nessa função, fazemos a montagem da tabela de dados.
	public static function mostraDep()	{
		$query = "SELECT * FROM departamentos";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
		
	}

	public static function editDep($id, $nomeDep){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try
		{
			$stmt=$pdo->prepare("UPDATE departamentos SET nome=:nomeDep WHERE id=:id ");
			$stmt->bindparam(":id",$id);
			$stmt->bindparam(":nomeDep",$nomeDep);
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public static function deleteDep($id){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM departamentos WHERE id=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

 	//MANAGER SLA --------------------------------------------
	public static function cadSla($descricao,$tempo,$uniTempo){
		$pdo = Database::connect();
			
		try{
			$stmt=$pdo->prepare("INSERT INTO tbl_sla (descricao, tempo, unitempo) VALUES(:descricao,:tempo,:unitempo)");
			$stmt->bindparam(":descricao", $descricao);
			$stmt->bindparam(":tempo", $tempo);
			$stmt->bindparam(":unitempo", $uniTempo);
			
			$stmt->execute();

			return true;
		}catch(PDOException $e){

			echo $e->getMessage();	
			return false;
		}
		
	}


	public static function edtSla($id,$descricao,$tempo,$uniTempo){
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try	{
			$stmt=$pdo->prepare("UPDATE tbl_sla SET descricao=:descricao, tempo=:tempo, uniTempo=:uniTempo WHERE id=:id ");
			$stmt->bindparam(":id",$id);
			$stmt->bindparam(":descricao",$descricao);
			$stmt->bindparam(":tempo",$tempo);
			$stmt->bindparam(":uniTempo",$uniTempo);			
			
			$stmt->execute();
			
			return true;	
		}catch(PDOException $e)
		{
			echo $e->getMessage();	
			return false;
		}
	}

	public static function excluiSla($id)	{
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare("DELETE FROM tbl_sla WHERE id=:id");
		$stmt->bindparam(":id",$id);
		$stmt->execute();
		return true;
	}

	public static function mostraSla()	{
		$query = "SELECT * FROM tbl_sla";
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo->prepare($query);
		$stmt->execute();
		return $stmt;
		
	}


	
}
?>