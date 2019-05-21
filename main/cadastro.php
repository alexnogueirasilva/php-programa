<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';

$queryDepart = "SELECT * FROM departamentos";

$queryUsuarios = "SELECT usr.id, usr.nome, usr.email, usr.nivel,usr.status,usr.id_dep, dep.nome as nome_dep FROM usuarios as usr INNER JOIN departamentos as dep ON usr.id_dep = dep.id ORDER BY status ASC";
?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12">
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <h1>Cadastra Usuário</h1>
    <h4>Insira os dados do novo usuário</h4>
    <form id="frmCadastro" action="e-mail.php">
        <div class="row">
        <div class="col-lg-12">
        <div class="form-inline">
            <div class="form-group">
                <div class="input-group">
                    <!--<input type="email" class="form-control" size="50" id="email" name="email" placeholder="E-mail" required > -->
                    <span class="input-group-addon"><span class="fa fa-envelope"></span>
                    <input type="email" class="form-control" size="70" name="email" id="email" placeholder="Digite seu E-mail:" required oninvalid="this.setCustomValidity('Digite um e-mail valido!')" oninput="this.setCustomValidity('')" >
                    <button id="btnVerificarEmail" title="Click para verificar se este e-mail esta diponivel" class="btn btn-success"><span class="fa fa-search"></span></span></button>
                    
                   
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <input type="password" name="senha" value="" class="form-control" size="30" maxlength="15" minlength="5" id="senha" placeholder="digite a senha" required>
                    <span class="input-group-addon"><span class="fa fa-key"></span></span>
                </div>
            </div>
        </div><br>
        <div class="form-inline">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><span class="fa fa-envelope"></span></span>
                    <input type="text" class="form-control" size="70" minlength="3" maxlength="50" name="dica" id="dica" placeholder="digite a dica" required>
                </div>
            </div>
        </div>
<br>
<br>
        <button type="submit" class="btn btn-info btn-lg btn-block" id="submit"><span class="fa fa-save"></span> Salvar</button>
        </div>
        </div>
    </form>

    <!-- LISTAGEM USUÁRIOS -->

    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <hr>

                <div class="col-sm-6">
                    <h3>Lista de Usuário</h3>
                </div>

                <table id="tbl-user" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Nível</th>
                            <th>status</th>
                            <th>Departamento</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                            <th>Desativar</th>
                            <th>Ativar</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $dados = crud::dataview($queryUsuarios);

                        if ($dados->rowCount() > 0) {
                            while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {

                                ?>
                                <tr>
                                    <td><?php print($row['id']); ?></td>
                                    <td><?php print($row['nome']); ?></td>
                                    <td><?php print($row['email']); ?></td>
                                    <td><?php print($row['nivel']); ?></td>
                                    <td><?php print($row['status']); ?></td>
                                    <td><?php print($row['nome_dep']); ?></td>
                                    <td><a class="btn btn-info waves-effect waves-light" id="btnEdita" data-toggle="modal" data-target="#modalEditaUsuario" data-whatever="@getbootstrap" data-codigo="<?php print($row['id']); ?>" data-nome="<?php print($row['nome']); ?>" data-email="<?php print($row['email']); ?>" data-nivel="<?php print($row['nivel']); ?>" data-dep="<?php print($row['id_dep']); ?>" data-statusatual="<?php print($row['status']); ?>">Editar</a></td>

                                    <td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalExluirUser" data-whatever="@getbootstrap" id="btnExcluiUser" data-codigo="<?php print($row['id']); ?>" data-nome="<?php print($row['nome']); ?>">Excluir</a></td>
                                    <td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalConfirmacaoDesativa" data-whatever="@getbootstrap" id="btnDesativa" data-codigo="<?php print($row['id']); ?>" data-statusatual="<?php print($row['status']); ?>" data-nome="<?php print($row['nome']); ?>">Desativar</a></td>

                                    <td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalConfirmacaoAtiva" data-whatever="@getbootstrap" id="btnAtiva" data-codigo="<?php print($row['id']); ?>" data-statusatual="<?php print($row['status']); ?>" data-nome="<?php print($row['nome']); ?>">Ativa</a></td>
                                </tr>
                            <?php
                        }
                    } else {
                        echo "<p class='text-danger'>Sem Ocorrencias abertas</p>";
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php

require_once "rodape.php";
?>
<script type="text/javascript">
    $(document).ready(function() {
       
        permissaoNivel();
        $('#frmCadastro').submit(function() {
            var tipo = "CadastroUsuario";
            var emailUser = $("#email").val();
            var senhalUser = $("#senha").val();
            var dicalUser = $("#dica").val();
            $.ajax({ //Função AJAX
                url: "../core/save.php", //Arquivo php
                type: "post", //Método de envio
                data: {
                    tipo: tipo,
                    emailUser: emailUser,
                    senhalUser: senhalUser,
                    dicalUser: dicalUser
                }, //Dados

                success: function(result) {
                    if (result == 1) {
                        swal({
                                title: "OK!",
                                text: "Cadastrado com Sucesso!",
                                type: "success",
                                confirmButtonText: "Fechar",
                                closeOnConfirm: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    window.location = "cadastro.php";
                                }
                            });
                    } else {
                        alert("Erro ao salvar " + result); //Informa o erro
                    }
                }
            });

            return false; //Evita que a página seja atualizada
        });

        $('#frmCadastro').submit(function() {
            var tipo = "VerificaEmail";
            var emailUser = $("#email").val();
            
            $.ajax({ //Função AJAX
                url: "../core/save.php", //Arquivo php
                type: "post", //Método de envio
                data: {
                    tipo: tipo,
                    emailUser: emailUser,                   
                }, //Dados

                success: function(result) {
                    if (result ==1 ) {
                       // alert (" REsultado cadastro02 " + result);
                        swal({
                                title: "OK!",
                                text: "Cadastrado com Sucesso!",
                                type: "success",
                                confirmButtonText: "Fechar",
                                closeOnConfirm: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    window.location = "cadastro.php";
                                }
                            });
                    } else {
                        alert("Erro ao salvar "); //Informa o erro
                    }
                }
            });

            return false; //Evita que a página seja atualizada
        });
/*
        $(document).on("click", "#btnEditar", function() {
            var id = $(this).data('codigo');
            var nome = $(this).data('nome');


            $('#idDep').val(id);
            $('#edtNomeDep').val(nome);

        });
*/
/*
        $('#frmEdtDep').submit(function() {
            var tipo = "EditDep";
            var id = $('#idDep').val();
            var nomeDep = $('#edtNomeDep').val();

            $.ajax({ //Função AJAX
                url: "../core/save.php", //Arquivo php
                type: "post", //Método de envio
                data: {
                    tipo: tipo,
                    id: id,
                    nomeDep: nomeDep
                }, //Dados
                success: function(result) {
                    //alert(result)
                    if (result == 1) {
                        swal({
                                title: "OK!",
                                text: "Dados Editados com Sucesso!",
                                type: "success",
                                confirmButtonText: "Fechar",
                                closeOnConfirm: false
                            },

                            function(isConfirm) {
                                if (isConfirm) {
                                    window.location = "cad_dep.php";
                                }
                            });

                    } else {
                        swal({
                                title: "Ops!",
                                text: "Algo deu errado!",
                                type: "error",
                                confirmButtonText: "Fechar",
                                closeOnConfirm: false
                            },

                            function(isConfirm) {
                                if (isConfirm) {
                                    window.location = "cad_dep.php";
                                }
                            });
                    }
                }
            });

            return false;
        });
*/
/*
        $(document).on("click", "#btnExcluir", function() {
            var id = $(this).data('codigo');
            var nome = $(this).data('nome');

            $('#idDep').val(id);
            $('#labelDep').html("Você vai excluir o departamento <strong>" + nome + "?</strong>");

        });

*/
/*
        $('#frmDeleteDep').submit(function() {
            var tipo = "deleteDep";
            var id = $('#idDep').val();


            $.ajax({ //Função AJAX
                url: "../core/save.php", //Arquivo php
                type: "post", //Método de envio
                data: {
                    tipo: tipo,
                    id: id
                }, //Dados
                success: function(result) {
                    //alert(result)
                    if (result == 1) {
                        swal({
                                title: "OK!",
                                text: "Departamento Excluído com Sucesso!",
                                type: "success",
                                confirmButtonText: "Fechar",
                                closeOnConfirm: false
                            },

                            function(isConfirm) {
                                if (isConfirm) {
                                    window.location = "cad_dep.php";
                                }
                            });

                    } else {
                        swal({
                                title: "Ops!",
                                text: "Algo deu errado!",
                                type: "error",
                                confirmButtonText: "Fechar",
                                closeOnConfirm: false
                            },

                            function(isConfirm) {
                                if (isConfirm) {
                                    window.location = "cad_dep.php";
                                }
                            });
                    }
                }
            });

            return false;
        });
*/

    });
</script>