<?php

//use main\Controller\PedidoController;

include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';
include_once 'Models/DAO/StatusDAO.php';
include_once './Models/DAO/PedidoDAO.php';

date_default_timezone_set('America/Bahia');

//DEFINIÇÃO DO NOME DO ANEXO
$nomeAnexo = date('Y-m-d-H:i');
$dataMsg = date('d/m/Y - H:i');
$novoNomeAnexo = md5($nomeAnexo);

$idLogado       = $_SESSION['usuarioID'];
$logado         = $_SESSION['nomeUsuario'];
$emailLogado    = $_SESSION['emailUsuario'];
$instituicao    = $_SESSION['instituicaoUsuario'];

?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12">

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="container">
        <div id="andre"></div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalCadastrarPedido" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-plus"></i></span>Cadastrar Pedido</button>
            <button class="btn btn-success waves-effect waves-light" type="button" onclick="window.location.href = 'homePedido.php'" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-home"></i></span>Home</button>
        </div>
        <form id="frmIndex" method="post">
            <div class="row">
                <div class="col-sm-12">
                    <div id="dado"></div>
                    <div class="white-box">
                        <div class="col-sm-6">
                            <h3>Pedidos Cancelados</h3>
                        </div>
                        <table id="tabela" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Licitação</th>
                                    <th>Pedido</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                    <th>Cancelado</th>
                                    <th>Status</th>
                                    <th>Decorridos</th>
                                    <th>Anexo</th>
                                    <th>Alterar</th>
                                    <th>Detalhes</th>
                                </tr>
                            <tfoot>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Licitação</th>
                                    <th>Pedido</th>
                                    <th>Valor</th>
                                    <th>Data</th>
                                    <th>Cancelado</th>
                                    <th>Status</th>
                                    <th>Decorridos</th>
                                    <th>Anexo</th>
                                    <th>Alterar</th>
                                    <th>Detalhes</th>
                                </tr>
                            </tfoot>
                            </thead>
                            <tbody>
                                <?php
                                $dados = PedidoDAO::listarPedidoCanceladosNegados($idInstituicao);
                                $totalPedido = 0;
                                $teste = 0;
                                if ($dados->rowCount() > 0) {
                                    while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
                                        $valorPedido = $row['valorPedido'];

                                        $totalPedido  += $valorPedido;
                                        $teste = $teste + 1;

                                        $dataCriada = $row['dataCadastro'];
                                        $codStatus = $row['codStatus'];

                                        $dataAtual = date('Y-m-d H:i:s');

                                        $datatime1 = new DateTime($row['dataCadastro']);
                                        $datatime2 = new DateTime($dataAtual);

                                        if ($codStatus == "16" || $codStatus == "7" || $codStatus == "2") {
                                            $datatime2 =  new DateTime($row['dataFechamento']);
                                        }

                                        $data1  = $datatime1->format('Y-m-d H:i');
                                        $data2  = $datatime2->format('Y-m-d H:i');

                                        $criada = strtotime($data1);
                                        $atual = strtotime($data2);

                                        $intervalo = ($atual - $criada) / 60;

                                        $horas = (int)($intervalo / 60);
                                        $minutos = $intervalo % 60;
                                        ?>
                                        <tr>
                                            <td style="text-transform: uppercase;">
                                                <?php print($row['nomeCliente']); ?></td>
                                            <td><?php print($row['tipoCliente']); ?></td>
                                            <td><?php print($row['numeroPregao']); ?></td>
                                            <td><?php print($row['numeroAf']); ?></td>
                                            <td> R$<?php print(number_format($row['valorPedido'], 2, ',', '.')); ?></td>
                                            <td><?php print(crud::formataData($row['dataCadastro'])); ?></td>
                                            <td><?php print(crud::formataData($row['dataFechamento'])); ?></td>
                                            <td id="statusControle"><?php print($row['nomeStatus']); ?></td>
                                            <td><?php print($horas .   'hs ' . 'e ' .  $minutos . 'm'); ?></td>

                                            <td><a class="btn btn-primary waves-effect waves-light" id="btnAnexo" target="_blank" href="../anexos/<?php print($row['anexo']); ?>">Anexo</a></td>
                                            <td><a class="btn btn-primary waves-effect waves-light" type="button" id="btnPedidoAlterar" data-toggle="modal" data-target="#modalPedidoAlterar" data-whatever="@getbootstrap" target="_blank" data-statusalterar="<?php print($row['codStatus']); ?>" data-mensagemalterar="<?php print($row['observacao']); ?>" data-codigocontrolealterar="<?php print($row['codControle']); ?>" data-dataalteracao="<?php print($row['dataAlteracao']); ?>" data-datafechamento="<?php print($row['dataFechamento']); ?>">Alterar</a></td>
                                            
                                            <td><a class="btn btn-success waves-effect waves-light" type="button" id="btnPedidoDetalhes" data-toggle="modal" data-target="#modalDetPedido" data-whatever="@getbootstrap" 
                                            data-codigocontroledet="<?php print($row['codControle']); ?>" data-nomeclientedet="<?php print($row['nomeCliente']); ?>" 
                                            data-tipoclientedet="<?php print($row['tipoCliente']); ?>" data-numeropregaodet="<?php print($row['numeroPregao']); ?>" 
                                            data-numeropedidodet="<?php print($row['numeroAf']); ?>" data-valorpedidodet="R$<?php print(number_format($row['valorPedido'], 2, ',', '.')); ?>" 
                                            data-statuscontroledet="<?php print($row['nomeStatus']); ?>" data-datacadastrodet="<?php print(crud::formataData($row['dataCadastro'])); ?>"
                                            data-datafechamento="<?php print(crud::formataData($row['dataFechamento'])); ?>"  data-dataalteracao="<?php print(crud::formataData($row['dataAlteracao'])); ?>" 
                                            data-mensagem="<?php print($row['observacao']); ?>">Detalhes</a></td>
                                        </tr>
                                    <?php
                                }
                                echo "Qtde pedidos nao atendidos:  " . $teste . " - ";
                                echo "Valor Total Pedido R$" . number_format($totalPedido, 2, ',', '.');
                            } else {
                                echo "<p class='text-danger'>Sem Pedidos Cadastrados</p>";
                            }
                            ?>
                            </tbody>
                        </table>

                    </div>
                </div>

            </div>
        </form>
    </div>
    <!-- /.row -->
</div>

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
                    <div class="form-inline">
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
                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="numeroAf" id="numeroAf" placeholder="Numero da AF" required>
                        </div>
                    </div>
                    <br>
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="text" size="33" style="text-transform: uppercase;" maxlength="40" class="form-control" name="numeroPregao" id="numeroPregao" placeholder="Numero Licitação" required>
                        </div>
                        <div class="form-group">
                            <input type="text" size="33" style="text-transform: uppercase;" maxlength="40" class="form-control" name="valorPedido" id="valorPedido" placeholder="Valor do Pedido">
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
                <button type="submit" id="salvaPedido" class="btn btn-primary">Enviar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- MODAL CRIA PEDIDO -->

<!-- /#page-wrapper -->

<?php
require_once "rodape.php";
include_once "pedidoModais.php";
?>
<script src="js/pedido.js"></script>

<script type="text/javascript">
    $(document).ready(function(e) {

        permissaoNivel();

        $("#frmCadastroPedido").on('submit', (function(e) {
            e.preventDefault();
            var table = $("#tabela").val();
            var nomeCliente = $("#nomeCliente").val();
            var valorPedido = $("#valorPedido").val();
            var statusPedido = $("#statusPedido").val();
            var numeroAF = $("#numeroAf").val();
            var mensagem = $("#mensagem").val();
            var numeroPregao = $("#numeroPregao").val();
            $.ajax({
                url: "../core/save.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#salvaPedido").html("<i class='fa fa-spinner fa-spin'></i> Enviando, aguarde...");
                    $("#salvaPedido").prop("disabled", true);
                },
                success: function(data) {
                    //   alert ("resultado data " + data);
                    if (data == 1) {
                        swal({
                                title: "OK!",
                                text: "Cadastrado com Sucesso!",
                                type: "success",
                                confirmButtonText: "Fechar",
                                closeOnConfirm: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    $('#modalCadastrarPedido').modal('hide');
                                    location.reload(table);
                                    //      window.location = "cadastro.php";
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
                                    $('#modalCadastrarPedido').modal('hide');
                                    location.reload(table);
                                }
                            });
                    }
                }
            });
        }));

        -----------------------------------------------------------      
    });

</script>