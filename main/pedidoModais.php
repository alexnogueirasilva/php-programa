<?php
include_once 'vrf_lgin.php';
require_once 'cabecalho.php';

//DEFINIÇÃO DO NOME DO ANEXO
$nomeAnexo = date('Y-m-d-H:i');
$dataMsg = date('d/m/Y - H:i');
$novoNomeAnexo = md5($nomeAnexo);

$idLogado = $_SESSION['usuarioID'];
$logado         = $_SESSION['nomeUsuario'];
$emailLogado    = $_SESSION['emailUsuario'];
$instituicao    = $_SESSION['instituicaoUsuario'];
$nomeUsuario
?>
<!-- MODAL CADASTRAR PEDIDO -->
<div class="modal fade bs-example-modal-lg" id="modalCadastrarPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Cadastro de Pedido</h4>
            </div>
            <div class="modal-body">
                <form id="frmCadastroPedido" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="CadastroPedido" name="tipo" id="tipo">
                    <input type="hidden" value="<?php echo $nomeAnexo; ?>" name="dataAtual" id="dataAtual">
                    <input type="hidden" value="<?php echo $nomeUsuario; ?>" name="nomeUsuario" id="nomeUsuario">
                    <input type="hidden" value="Cadastro de Pedido" name="subject" id="subject">
                    <input type="hidden" value="<?php echo $idInstituicao; ?>" name="idInstituicao" id="idInstituicao">
                    <input type="hidden" value="<?php echo $dataAtual; ?>" name="dataCadastro" id="dataCadastro">
                    <div class="form-group">
                        <select class="form-control" name="nomeCliente" id="nomeCliente" required>
                            <option value="" selected disabled>Selecione o Cliente</option>
                            <?php
                            $selectCliente = crud::mostrarCliente($idInstituicao);
                            if ($selectCliente->rowCount() > 0) {
                                while ($row = $selectCliente->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php print($row['codCliente']); ?>">
                                        <?php print($row['nomeCliente']); ?>
                                    </option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>

                    <div class="form-inline">
                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="numeroAf" id="numeroAf" placeholder="Numero da AF" required>
                        </div>
                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="numeroPregao" id="numeroPregao" placeholder="Numero Licitação" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-inline">

                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="13" class="form-control" name="valorPedido" id="valorPedido" placeholder="Valor do Pedido">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="statusPedido" id="statusPedido" required>
                                <option value="" selected disabled>Selecione o Status</option>
                                <?php
                                $selectStatus = crud::listarStatus($idInstituicao);
                                if ($selectStatus->rowCount() > 0) {
                                    while ($row = $selectStatus->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <option value="<?php print($row['codStatus']); ?>">
                                            <?php print($row['nome']); ?>
                                        </option>
                                    <?php
                                }
                            }
                            ?>
                            </select>
                        </div>
                    </div>

                    <br>
                    <div class="form-group">
                        <label for="message-text" class="control-label">Observação:</label>
                        <textarea name="mensagem" class="form-control" rows="3" id="mensagem"></textarea>
                    </div>
                    <input type="file" name="file" id="file">
            </div>
            <div class="modal-footer">
                <div class="form-group">
                    <input type="text" size="50" class="form-control" name="email" id="email" placeholder="Informe e-mail separando por virgula ">
                </div>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="submit" id="salvaPedido" class="btn btn-primary">Enviar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL CRIA PEDIDO -->

<!-- MODAL ALTERAR PEDIDO-->
<div class="modal fade" id="modalPedidoAlterar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Alterar Status do Pedido</h4>
            </div>
            <div class="modal-body">
                <form id="frmAlterarPedido" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="AlterarPedido" name="tipo" id="tipo">
                    <input type="hidden" id="codigoControleAlterar" name="codigoControleAlterar">
                    <input type="hidden" id="subjectAlterar" name="subjectAlterar" value="Alteracao do Pedido">
                    <input type="hidden" id="dataFechamentoPedidoAlterar" name="dataFechamentoPedidoAlterar">
                    <input type="hidden" value="<?php echo $nomeUsuario; ?>" name="nomeUsuarioAlterar" id="nomeUsuarioAlterar">
                    <input type="hidden" value="<?php echo $dataAtual; ?>" name="dataAtual" id="dataAtual">
                    <input type="hidden" name="idInstituicaoAlterar" id="idInstituicaoAlterar">
                    <div class="form-group">
                        <select class="form-control" name="statusPedidoAlterar" id="statusPedidoAlterar" required>
                            <option value="" selected disabled>Selecione o Status</option>
                            <?php
                            $selectStatus = crud::listarStatus($idInstituicao);
                            if ($selectStatus->rowCount() > 0) {
                                while ($row = $selectStatus->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <option value="<?php print($row['codStatus']); ?>">
                                        <?php print($row['nome']); ?>
                                    </option>
                                <?php
                            }
                        }
                        ?>
                        </select>
                    </div>
                    
                    <input type="checkbox" name="email2" checked="checked" />

                    <?php            
            
            if(isset($_GET['email2'])){
                echo "Checado!";
            } else{
                echo "Não Checado";
            }
            ?>    

                    <div class="form-group">
                        <label for="message-text" class="control-label">Observação:</label>
                        <textarea name="mensagemPedidoAlterar" class="form-control" rows="3" id="mensagemPedidoAlterar"></textarea>
                        <br>
                        
                        <div class="form-group">
                            <input type="text" size="50" class="form-control" name="emailAlterar" id="emailAlterar" placeholder="Informe e-mail separando por virgula ">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Mensagem:</label>
                            <textarea name="mensagemEmailAlterar" class="form-control" rows="3" id="mensagemEmailAlterar"></textarea>
                        </div>                     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" id="alteraPedido" class="btn btn-primary">Enviar</button>                        
                    </div>                    
                </form>
                
            </div>
            
        </div>
    </div>
</div>

<!-- MODAL ALTERAR PEDIDO-->


<!-- MODAL EXCLUIR -->
<div class="modal fade" id="modalExluirPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="headermodal">Confirmação</h4>
            </div>
            <div class="modal-body">
                <form id="frmExcluirPedido">
                    <div class="row">
                        <input type="hidden" name="tipo" id="tipo" value="deletePedido">
                        <input type="hidden" name="ExcIdInstituicao" id="ExcIdInstituicao">
                        <input type="hidden" value="<?php echo $nomeUsuario; ?>" name="ExcnomeUsuario" id="ExcnomeUsuario">
                        <input type="hidden" name="Excsubject" id="Excsubject" value="Exclusao de Pedido">
                        <input type="hidden" name="excIdPedido" id="excIdPedido">
                        <div class="col-md-12">
                            <div id="contextoModal">
                                <h2>Você vai EXCLUIR pedido do Cliente: </h2>
                                <div class="form-group">
                                    <input type="text" size="50" class="form-control" disabled="disabled" name="ExcNomePedido" id="ExcNomePedido">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" size="50" class="form-control" name="emailExcluir" id="emailExcluir" placeholder="Informe e-mail separando por virgula ">
                    </div>
                    <div class="form-group">
                            <label for="message-text" class="control-label">Mensagem:</label>
                            <textarea name="excmensagemEmail" class="form-control" rows="3" id="excmensagemEmail"></textarea>
                        </div>                       
                    <div class="modal-footer">

                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnExcluirPedido" class="btn btn-primary">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODAL EXCLUIR -->

<!-- MODAL detalhe do Pedido-->
<div class="modal fade bs-example-modal-lg" id="modalDetPedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Detalhes do Pedido</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table id="" class="table table-striped">
                            <tr>
                                <td>Código</td>
                                <td><span id="codigoDetalhes"></span></td>
                            </tr>
                            <tr>
                                <td>Nome Cliente</td>
                                <td><span id="nomeClienteDetalhes"></span></td>
                            </tr>
                            <tr>
                                <td>Tipo</td>
                                <td><span id="tipoClienteDetalhes"></span></td>
                            </tr>
                            <tr>
                                <td>Licitacao</td>
                                <td><span id="licitacaoDetalhes"></span></td>
                            </tr>
                            <tr>
                                <td>Pedido</td>
                                <td><span id="pedidoDetalhes"></span></td>
                            </tr>
                            <tr>
                                <td>Valor</td>
                                <td><span id="valorDetathes"></span></td>
                            </tr>
                            <tr>
                                <td>Cadastrado em:</td>
                                <td><span id="dataCriacaoDetalhes"></span></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td id="statusDetalhes"></td>
                            </tr>
                            <tr>
                                <th>Decorridos</th>
                                <td id="tempoDetalhes"></td>
                            </tr>
                            <tr>
                                <td>Mensagem</td>
                                <td id="mensagemDetatalhes"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <h4><strong>Comentários:</strong></h4>
                        <table class="table table-striped">
                            <tbody id="comentariosPedido">


                            </tbody>
                        </table>
                    </div>

                    <div class="col-md-12">
                        <form id="frmAddMensagem">
                            <input type="hidden" value="<?php echo $idLogado; ?>" name="idLogado" id="idLogado">
                            <input type="hidden" value="<?php echo $dataMsg; ?>" name="datahora" id="datahora">
                            <input type="hidden" value="<?php echo $idInstituicao; ?>" name="idInstituicaoMensagem" id="idInstituicaoMensagem">
                            <div class="form-group">
                                <label for="message-text" class="control-label">Adicionar Comentário</label>
                                <textarea name="mensagemComentario" class="form-control" rows="2" id="mensagemComentario" required></textarea>
                            </div>
                            <button type="submit" id="addMensagem" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <td><a class="btn btn-primary waves-effect waves-light" type="button" id="btnPedidoAlterar2" data-toggle="modal" data-target="#modalPedidoAlterar" data-whatever="@getbootstrap" value="<?php echo $idControle; ?>" target="_blank" data-codigocontrolealterar="<?php print($row['codControle']); ?>">Alterar</a></td>
            </div>
        </div>
    </div>
</div>
<!-- MODAL detalhe do Pedido-->

<!-- MODAL anexo do Pedido-->
<div class="modal fade" id="modalPedidoSemAnexo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" id="headerModalAlerta">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="headermodal">Alerta</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="contextoModal">
                            <h2>Este pedido não possui anexo!</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>

            </div>
        </div>
    </div>
</div>
<!-- MODAL anexo do Pedido-->

<!-- MODAL SUPORTE-->
<div class="modal fade" id="modalSuportePedido" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Suporte</h4>
            </div>
            <div class="modal-body">
                <form id="frmSuportePedido" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="suporte" name="tipo" id="tipo">
                    <input type="hidden" name="erro" id="erro">
                    <input type="hidden" value="<?php echo $nomeUsuario; ?>" name="nomeUsuarioSuporte" id="nomeUsuarioSuporte">
                    <input type="hidden" value="<?php echo $dataAtual; ?>" name="dataSuporte" id="dataSuporte">
                    <div class="form-group">

                    </div>

                    <div class="form-group">
                        <label for="message-text" class="control-label">Observação:</label>
                        <textarea name="mensagemPedidoSuporte" class="form-control" rows="3" id="mensagemPedidoSuporte"></textarea>
                        <br>
                        <div class="form-group">
                            <input type="text" size="50" class="form-control" value="<?php echo $emailLogado; ?>" name="emailSuporte" id="emailSuporte" placeholder="Informe e-mail separando por virgula ">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" id="btnSuporte" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- MODAL SUPORTE-->


<!-- UPLOAD DE ARQUIVOS -->
<script src="js/jquery.form.js"></script>