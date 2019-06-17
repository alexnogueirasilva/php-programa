<?php
 include_once '../core/crud.php';					//Seleciona banco de dados
  
  $nome=$_POST['user'];	//Pegando dados passados por AJAX
  $senha=$_POST['senha'];


  $vf = crud::pesquisaLoginUsr($nome, $senha);
  

	if ($vf == 0){
		echo 0;	//Se a consulta não retornar nada é porque as credenciais estão erradas
		
	}else{
		echo 1;	//Responde sucesso
		if(!isset($_SESSION)) 	//verifica se há sessão aberta		
		session_start();		//Inicia seção
				
		//Abrindo seções
		$_SESSION['usuarioID']=$vf['idUsuario'];
		$_SESSION['nomeUsuario']=$vf['nome'];
		$_SESSION['nivel']=$vf['nivel'];
		$_SESSION['emailUsuario']=$vf['email'];
		$_SESSION['instituicaoUsuario']=$vf['fk_idInstituicao'];
		$_SESSION['instituicaoNome']=$vf['nomeInstituicao'];

		date_default_timezone_set("Brazil/East");
		$tempolimite = 6000;
		$_SESSION['registro'] = time(); // armazena o momento em que autenticado ou atualiza a pagina//
 		$_SESSION['limite'] = $tempolimite;

		exit;	
	}