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

$idLogado = $_SESSION['usuarioID'];
$logado         = $_SESSION['nomeUsuario'];
$emailLogado    = $_SESSION['emailUsuario'];
$instituicao    = $_SESSION['instituicaoUsuario'];

$queryDepart    = "SELECT * FROM departamentos";
$queryCliente   = "SELECT * FROM cliente";
$queryStatus   = "SELECT * FROM status";
/*
echo " Andre  $andre<br/> ";

echo " segundos  $segundos<br/> ";
echo " registro $registro<br/> ";
echo " limite $limite<br/> ";
if($logado != 1){$logado2 = 600;
    echo "<meta HTTP-EQUIV='refresh' CONTENT='$logado2;'>";//atualizacao automatica
}
*/

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
            <button class="btn btn-success waves-effect waves-light" type="button" onclick="window.location.href = 'pedidoHome.php'" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-home"></i></span>Home</button>
        </div>
        <form id="frmIndex" method="post">
            <div class="row">
                <div class="col-sm-12">
                    <div id="dado"></div>
                    <div class="white-box">
                        <div class="col-sm-6">
                            <h3>Todos Pedidos</h3>
                        </div>

                        <table id="tabela" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Licitação</th>
                                    <th>Pedido</th>
                                    <th>Valor</th>
                                    <th>Anexo</th>
                                    <th>Alterar</th>
                                    <th>Excluir</th>
                                    <th>Detalhes</th>
                                </tr>
                            <tfoot>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Licitação</th>

                                    <th>Pedido</th>
                                    <th>Valor</th>
                                    <th>Anexo</th>
                                    <th>Alterar</th>
                                    <th>Excluir</th>
                                    <th>Detalhes</th>
                                </tr>
                            </tfoot>
                            </thead>
                            <tbody>
                                <?php
                                $dados = Crud::listarPedido($idInstituicao);
                                $totalPedido = 0;
                                $teste = 0;
                                if ($dados->rowCount() > 0) {
                                    while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
                                        $valorPedido = $row['valorPedido'];

                                        $totalPedido  += $valorPedido;
                                        $teste = $teste + 1;

                                        $dataCriada = $row['dataCadastro'];
                                        $dataAtual = date('Y-m-d H:i:s');

                                        $datatime1 = new DateTime($row['dataCadastro']);
                                        $datatime2 = new DateTime($dataAtual);

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

                                            <td><a class="btn btn-primary waves-effect waves-light" id="btnAnexo" target="_blank" href="../anexos/<?php print($row['anexo']); ?>">Anexo</a></td>

                                            <td><a class="btn btn-warning waves-effect waves-light" type="button" id="btnPedidoAlterar" data-toggle="modal" data-target="#modalPedidoAlterar2" data-whatever="@getbootstrap" target="_blank" data-statusalterar="<?php print($row['codStatus']); ?>" data-idclientealterar="<?php print($row['codCliente']); ?>" data-mensagemalterar="<?php print($row['observacao']); ?>" data-codigocontrolealterar="<?php print($row['codControle']); ?>" data-numeroaf="<?php print($row['numeroAf']); ?>" data-numerolicitacao="<?php print($row['numeroPregao']); ?>" data-valorpedido="<?php print($row['valorPedido']); ?>" data-idinstituicaoalterar="<?php print($row['fk_idInstituicao']); ?>" data-anexoalterar="<?php print($row['anexo']); ?>">Alterar</a></td>
                                            <td> <a class="btn btn-danger waves-effect waves-light" type="button" id="btnExcluiPedido" data-target="#modalExluirPedido" data-whatever="@getbootstrap"  data-codigoexcluir="<?php print($row['codControle']); ?>" data-nomeexcluir="<?php print($row['nomeCliente']); ?>" data-idinstituicaoexcluir="<?php print($row['fk_idInstituicao']); ?>">Excluir</a></td>
                                            <td><a class="btn btn-success waves-effect waves-light" type="button" id="btnPedidoDetalhes" data-toggle="modal" data-target="#modalDetPedido" data-whatever="@getbootstrap" data-codigocontroledet="<?php print($row['codControle']); ?>" data-nomeclientedet="<?php print($row['nomeCliente']); ?>" data-tipoclientedet="<?php print($row['tipoCliente']); ?>" data-numeropregaodet="<?php print($row['numeroPregao']); ?>" data-numeropedidodet="<?php print($row['numeroAf']); ?>" data-valorpedidodet="R$<?php print(number_format($row['valorPedido'], 2, ',', '.')); ?>" data-statuscontroledet="<?php print($row['nomeStatus']); ?>" data-datacadastrodet="<?php print(crud::formataData($row['dataCadastro'])); ?>" data-mensagem="<?php print($row['observacao']); ?>" data-idinstituicao="<?php print($row['fk_idInstituicao']); ?>">Detalhes</a></td>
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

<!-- MODAL alterar Pedido completo-->
<div class="modal fade bs-example-modal-lg" id="modalPedidoAlterar2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Alterar Pedido</h4>
            </div>
            <div class="modal-body">
                <form id="frmAlterarPedido" action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="AlterarPedido2" name="tipo" id="tipo">
                    <input type="hidden" id="codigoControleAlterar" name="codigoControleAlterar">
                    <input type="hidden" id="subjectAlterar2" name="subjectAlterar2" value="Alteracao de Pedido">
                    <input type="hidden" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="idInstituicaoAlterar" id="idInstituicaoAlterar" placeholder="instituicao" required>
                    <input type="hidden" id="dataFechamentoPedidoAlterar" name="dataFechamentoPedidoAlterar">
                    <input type="hidden" id="dataFechamentoPedidoAlterar" name="dataFechamentoPedidoAlterar">
                    <input type="hidden" value="<?php echo $nomeUsuario; ?>" name="nomeUsuarioAlterar2" id="nomeUsuarioAlterar2">
                    <input type="hidden" value="<?php echo $dataAtual; ?>" name="dataAtual2" id="dataAtual2">
                    <div class="form-group">
                        <select class="form-control" name="idClientePedidoAlterar" id="idClientePedidoAlterar" required>
                            <option value="" selected disabled>Selecione o Cliente</option>
                            <?php
                            $selectStatus = crud::mostrarCliente($idInstituicao);
                            if ($selectStatus->rowCount() > 0) {
                                while ($row = $selectStatus->fetch(PDO::FETCH_ASSOC)) {
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
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="numeroAfPedidoAlterar" id="numeroAfPedidoAlterar" placeholder="Numero da AF" required>
                        </div>
                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="numeroLicitacaoPedidoAlterar" id="numeroLicitacaoPedidoAlterar" placeholder="Numero da licitacao" required>
                        </div>                
                    </div>
                    <br>
                    <div class="form-inline">
                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="13" class="form-control" name="valorPedidoAlterar" id="valorPedidoAlterar" placeholder="valor pedido" required>
                        </div>
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
                        
                    </div>
                    <br>                    
                    <div class="form-group">
                        <label for="message-text" class="control-label">Observação:</label>
                        <textarea name="mensagemPedidoAlterar" class="form-control" rows="3" id="mensagemPedidoAlterar"></textarea>
                    </div>
                    <input type="file" name="file" id="file">
                    <br>
                    <div class="form-group">
                        <input type="text" style="text-transform" class="form-control" name="anexoAlterar" id="anexoAlterar" readonly="readonly">
                    </div>
                    <div class="modal-footer">
                    <div class="form-group">
                        <input type="text" size="50" class="form-control" name="emailAlterar2" id="emailAlterar2" placeholder="Informe e-mail separando por virgula ">
                    </div>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                        <button type="submit" id="alteraPedido" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- MODAL altera Pedido completo-->






<!-- /#page-wrapper -->

<?php
require_once "rodape.php";
include_once "pedidoModais.php";
?>
<script src="js/pedido.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {

        permissaoNivel();

        $('#usuarioDestino').change(function() {
            var codUserDestino = $("#usuarioDestino").val();
            $.ajax({
                url: 'busca_email.php',
                type: "POST",
                data: {
                    codUserDestino: codUserDestino
                },
                success: function(data) {
                    //alert(data);
                    if (data) {
                        $('#emailDestino').val(data);
                    }
                }
            });
        });

        //Click no botao detalhas do pedido
        $(document).on("click", "#btnPedidoDetalhes", function() {
            //pegando valor das colunas da tabela e atribuindo as variaveis
            var idControle = $(this).data('codigocontroledet');
            var nomeCliente = $(this).data('nomeclientedet');
            var tipoCliente = $(this).data('tipoclientedet');
            var numeroPregao = $(this).data('numeropregaodet');
            var numeroPedido = $(this).data('numeropedidodet');
            var valorPedido = $(this).data('valorpedidodet');
            var statusControle = $(this).data('statuscontroledet');
            var dataCadastro = $(this).data('datacadastrodet');
            var mensagem = $(this).data('mensagem');
            var tempoPedido = "testes"; // $horas . ' Horas' . ' e ' . $minutos . " Minutos";

            if (status == "Fechada") {
                status = status + " - Em: " + dataFechamento;
            }
            if (mensagem == "") {
                mensagem = " Nenhuma Obserção não encontrado ";
            }
            if (tipoCliente == "M") {
                tipoCliente = "Municipal";
            } else if (tipoCliente == "E") {
                tipoCliente = "Estadual";
            } else if (tipoCliente == "F") {
                tipoCliente = "Federal";
            }
            //pegando valor das variaveis vindo da tabela e atribuindo aos id dos campos do modal para exibir
            $('#codigoDetalhes').html(idControle);
            $('#nomeClienteDetalhes').html(nomeCliente);
            $('#tipoClienteDetalhes').html(tipoCliente);
            $('#licitacaoDetalhes').html(numeroPregao);
            $('#pedidoDetalhes').html(numeroPedido);
            $('#tempoDetalhes').html(tempoPedido);
            $('#valorDetathes').html(valorPedido);
            $('#statusDetalhes').html(statusControle);
            $('#dataCriacaoDetalhes').html(dataCadastro);
            $('#mensagemDetatalhes').html(mensagem);

            //MONTA OS COMENTÁRIOS NO MODAL
            var tipo = 'busca_mensagensPedido';
            $.ajax({
                url: 'busca_mensagens.php',
                type: "POST",
                data: {
                    idControle: idControle,
                    tipo: tipo
                },
                success: function(data) {
                    //  alert(idControle);  
                    if (idControle) {
                        $('#comentariosPedido').html(data);
                    }
                }
            });
        });

    });
</script>