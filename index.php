<? require 'vendor/autoload.php'; ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.ico">
     <title>SO - Sistema de Ocorrência</title>
    <!-- Bootstrap CSS -->
    <link href="assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="main/css/style.css" rel="stylesheet" type="text/css" />   
</head>



<body>
    <section id="wrapper" class="login-register">
        <div class="login-box">
            <div class="white-box">
                <form class="form-horizontal m-t-20" method="" action="" id="login">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Login</h3>                           
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="codigo da registro" id="instituicao">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" required="" placeholder="E-mail" id="user">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" id="senha" placeholder="Senha">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-md-5 col-xs-12">
                            <div class="checkbox checkbox-primary">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> Lembrar sempre </label>
                            </div>
                        </div>                       
                    </div>
                        <label class="rec-senha">esqueceu a senha ?<br><a  href="/index.php">clique aqui.</a></label>                                                
                       <!-- <button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalCriaDemanda" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-plus"></i></span>esqueceu a senha</button> -->
                     <div class="alert alert-danger" id="errolog">Usuario ou senha incorreto</div>
                    <div class="form-group text-center m-t-40">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" >Entrar</button>
                        </div>                      
                    </div>                    
                </form>                
            </div>
            <footer class="footer text-center">
                <div class="social">
                    <img src="assets/images/SO.png">
                </div>
                2019 © SO - Sistema de Ocorrência.
            </footer>
        </div>
    </section>
    <!-- jQuery -->
    <script src="assets/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- MODAL RECUPERAR SENHA --><!--
<div class="modal fade bs-example-modal-lg" id="modalCriaDemanda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Recuperação de Senha</h4>
            </div>
            <div class="modal-body">
                <form id="frmRecuperarSenha" action="/main/recuperar_senha.php" tipo="recuperarSenha" method="post" enctype="multipart/form-data" >                    
                    <div class="form-inline">                       
                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="instituicao" id="instituicao" placeholder="Codigo de acesso" >
                        </div>     
                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="email" id="email" placeholder="Digite seu email" >
                        </div>                                                                          
                    </div>  
                    <br> 
                    <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="instituicao" id="instituicao" placeholder="Codigo de acesso" >
                        </div>                                                          
                    <br>                                                                               
            </div>
                    <div class="modal-footer">
                        <button type="submit" id="RecuperarSenha" class="btn btn-primary" >Enviar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
        </div>
    </div>
</div>
-->
<script type="text/javascript">    
    $(document).ready(function(){
        //alert('Você não tem acesso ao sistema!');
        $('#errolog').hide(); //Esconde o elemento com id errolog
        $('#login').submit(function(){  //Ao submeter formulário
      
        var user=$('#user').val();  //Pega valor do campo email
        var instituicao=$('#instituicao').val();  //Pega valor do campo insituicao
        var senha=$('#senha').val();    //Pega valor do campo senha
        /*alert(user);
        alert(senha);
        die();*/

        $.ajax({            //Função AJAX
            url:"main/login.php",            //Arquivo php
            type:"post",                //Método de envio
            data: "instituicao="+instituicao+"&user="+user+"&senha="+senha, //Dados
            success: function (result){         //Sucesso no AJAX
                    //alert(result)                 
                if(result==1){  
                    $("#errolog").fadeOut();                    
                            location.href='main/Home.php'   //Redireciona                          
                        }else{
                            
                            $('#errolog').fadeIn();     //Informa o erro
                        }
                        $('#myModal').on('hidden.bs.modal', function () {
                            $('#user').val('');
                            $('#senha').val('');
                            $('#instituicao').val('');
                            $("#errolog").fadeOut();
                        })
                    }
                })
        return false;   //Evita que a página seja atualizada
    })
    })
</script>

</body>

<!-- teste de commit Carlos Andre-->

</html>
