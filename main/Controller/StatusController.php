<?php

require_once '../Models/DAO/StatusDAO.php';
//isset()
$value = isset($_POST['tipo']) ? $_POST['tipo'] : '';

switch ($value) {
    case 'CadastroStatus':
        $descricao = $_POST['descricao'];		
		$cad = StatusDAO::CadastroStatus($descricao);
		if ($cad == true) {
			echo 1;
		}else{
			echo 0;
		}
    break;

    case 'editarStatus':
        
        $descricao  = $_POST['edtDescricao'];		
        $edtId         = $_POST['edtId'];		
		$cad = StatusDAO::editarStatus($edtId,$descricao);
		if ($cad == true) {
			echo 1;
		}else{
			echo 0;
		}
    break;
    case 'excluirStatus':
        $id         = $_POST['id'];		
		$cad = StatusDAO::deleteStatus($id);
		if ($cad == true) {
			echo 1;
		}else{
			echo 0;
		}
    break;
}
/*


class StatusController{



    public static function select() {
      //  $statusDAO = new StatusDAO();
       $edt =  StatusDAO::listar();

       if ($edt > 0) {
		echo $edt;
	    } else{
		return false;
	    }
    }

    //CadastroStatus
    public function CadastroStatu($descricao)  {

        $descricao = $_POST['descricao'];
		
        $cad = StatusDAO::CadastroStatus($descricao);
        
		if ($cad == true) {
			echo 1;
		}else{
			echo 0;
		}
    }

    public function salvar()
    {
        $Status = new Status();
        $Status->setStaNome($_POST['staNome']);
        
        Sessao::gravaFormulario($_POST);

    //    $produtoValidador = new ProdutoValidador();
      //  $resultadoValidacao = $produtoValidador->validar($Produto);

        /*if($resultadoValidacao->getErros()){
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/produto/cadastro');
        }

        $statusDAO = new StatusDAO();

        $statusDAO->salvar($Status);
      
        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();

        $this->redirect('/index');
      
    }
    
    public function edicao($params)
    {
        $id = $params[0];

        $produtoDAO = new ProdutoDAO();

        $produto = $produtoDAO->listar($id);

        if(!$produto){
            Sessao::gravaMensagem("Produto inexistente");
            $this->redirect('/produto');
        }

        self::setViewParam('produto',$produto);

        $this->render('/produto/editar');

        Sessao::limpaMensagem();

    }

    public function atualizar()
    {

        $Produto = new Produto();
        $Produto->setId($_POST['id']);
        $Produto->setNome($_POST['nome']);
        $Produto->setPreco($_POST['preco']);
        $Produto->setQuantidade($_POST['quantidade']);
        $Produto->setDescricao($_POST['descricao']);

        Sessao::gravaFormulario($_POST);

        $produtoValidador = new ProdutoValidador();
        $resultadoValidacao = $produtoValidador->validar($Produto);

        if($resultadoValidacao->getErros()){
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/produto/edicao/'.$_POST['id']);
        }

        $produtoDAO = new ProdutoDAO();

        $produtoDAO->atualizar($Produto);

        Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();

        $this->redirect('/produto');

    }
    
    public function exclusao($params)
    {
        $id = $params[0];

        $produtoDAO = new ProdutoDAO();

        $produto = $produtoDAO->listar($id);

        if(!$produto){
            Sessao::gravaMensagem("Produto inexistente");
            $this->redirect('/produto');
        }

        self::setViewParam('produto',$produto);

        $this->render('/produto/exclusao');

        Sessao::limpaMensagem();

    }

    public function excluir()
    {
        $Produto = new Produto();
        $Produto->setId($_POST['id']);

        $produtoDAO = new ProdutoDAO();

        if(!$produtoDAO->excluir($Produto)){
            Sessao::gravaMensagem("Produto inexistente");
            $this->redirect('/produto');
        }

        Sessao::gravaMensagem("Produto excluido com sucesso!");

        $this->redirect('/produto');

    }*/
