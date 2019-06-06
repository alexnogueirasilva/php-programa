<?php

//use main\Controller\PedidoController;

include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';

date_default_timezone_set('America/Bahia');
$data = date('Y-m-d H:i:s');
//DEFINIÇÃO DO NOME DO ANEXO
$nomeAnexo = date('Y-m-d-H:i');
$novoNomeAnexo = md5($nomeAnexo);

$idLogado = $_SESSION['usuarioID'];
$logado         = $_SESSION['nomeUsuario'];
$emailLogado    = $_SESSION['emailUsuario'];
$instituicao    = $_SESSION['instituicaoUsuario'];
$queryDepart    = "SELECT * FROM departamentos";
$queryCliente   = "SELECT * FROM cliente";
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
            
        </div>
<form id="frmIndex" method="post">
        <div class="row">
            <div class="col-sm-12">
                <div id="dado"></div>
                <div class="white-box">
                    <div class="col-sm-6">
                        <h3>Pedidos Cadastrados</h3>
                    </div>
                                                   
                    <table id="tabela" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Licitação</th>
                                <th>Pedido</th>
                                <th>Valor</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Decorridos</th>
                                <th>Anexo</th>
                                <th>Alterar</th>
                                <th>Detalhes</th>
                            </tr>
                            <tfoot>
                            <tr>
                                <th>Cliente</th>
                                <th>Licitação</th>
                                <th>Pedido</th>
                                <th>Valor</th>
                                <th>Data</th>
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
                            $totalPedidoPendetes = crud::totalPedidoPendetes();                     
                            $totalPedidoCancelados = crud::totalPedidoCancelados();                     
                            $totalPedidoAtendidos = crud::totalPedidoAtendidos();  

                          /*  if(isset($_POST['scales'])){
                            $dados = crud::listarPedido(); 
                            echo "Todos pedidos! <br/>";
                            
                         }else {                            
                           
                            echo "Pedido Estaduais! <br/>";
                            //echo "Todos pedidos!";
                           // echo "Todos pedidos totalPedidoPendetes! ". $totalPedidoPendetes;   
                           // echo "Valor Total Pedido R$" . $totalPedidoPendetes;
                            
                           // echo "Todos pedidos totalPedidoCancelados! ". $totalPedidoCancelados;                     
                           // echo "Todos pedidos totalPedidoAtendidos! " . $totalPedidoAtendidos; 
                        }      */                                                      
                        $dados = crud::listarPedidoNaoAtendCanc(); 
                        $totalPedido = '';
                        $qtdePedido = 0;
                            if ($dados->rowCount() > 0) {
                                while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {

                                    $dataCriada = $row['dataCadastro'];
                                    $dataAtual = date('Y-m-d H:i:s');  
                                    

                                    $valorPedido = $row['valorPedido'];
                                    
                                    $totalPedido  += $valorPedido;
                                    
                                    $qtdePedido = $qtdePedido + 1;

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
                                        <td><?php print($row['numeroPregao']); ?></td>
                                        <td><?php print($row['numeroAf']); ?></td>
                                        <td> R$<?php print(number_format($row['valorPedido'],2,',','.')); ?></td>
                                        <td><?php print(crud::formataData($row['dataCadastro'])); ?></td>
                                        <td id="statusControle"><?php print($row['nomeStatus']); ?></td>
                                        <td><?php print($horas . ' Hs' . ' e ' . $minutos . " M"); ?></td>

                                        <td><a class="btn btn-primary waves-effect waves-light" id="btnAnexo" target="_blank" href="../anexos/<?php print($row['anexo']); ?>">Anexo</a></td>
                                        <td><a class="btn btn-primary waves-effect waves-light" type="button" id="btnPedidoAlterar" data-toggle="modal" data-target="#modalPedidoAlterar" data-whatever="@getbootstrap" target="_blank" data-statusalterar="<?php print($row['nomeStatus']); ?>" data-codigocontrolealterar="<?php print($row['codControle']); ?>">Alterar</a></td>
                                        <td><a class="btn btn-success waves-effect waves-light" type="button" id="btnPedidoDetalhes" data-toggle="modal" data-target="#modalDetPedido" data-whatever="@getbootstrap" 
                                        data-codigocontroledet="<?php print($row['codControle']); ?>" data-nomeclientedet="<?php print($row['nomeCliente']); ?>" 
                                        data-numeropregaodet="<?php print($row['numeroPregao']); ?>" data-numeropedidodet="<?php print($row['numeroAf']); ?>" 
                                        data-valorpedidodet="<?php print($row['valorPedido']); ?>" data-statuscontroledet="<?php print($row['nomeStatus']); ?>" 
                                        data-datacadastrodet="<?php print(crud::formataData($row['dataCadastro'])); ?>" data-mensagem="<?php print($row['observacao']); ?>">Detalhes</a></td>
                                    </tr>
                                <?php                               
                            }
                            echo "<p class='text-danger'> " . " Valor Total Pedido R$" . number_format($totalPedido,2,',','.') . " - " ."Quantidade Pedidos " . $qtdePedido ."</p>";
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
                    <input type="hidden" value="<?php echo $data; ?>" name="dataCadastro" id="dataCadastro">
                    <div class="form-inline">
                        <div class="form-group">
                            <select class="form-control" name="nomeCliente" id="nomeCliente" required>
                                <option value="" selected disabled>Selecione o Cliente</option>
                                <?php
                                $selectCliente = crud::mostrarCliente();
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
                                $selectStatus = crud::listarStatus();
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
                            <tbody id="comentariosDemand">
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-default" data-target="#modalCadastrarPedido" data-dismiss="modal">Alterar</button>
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

<!-- MODAL alterar  Pedido-->
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
                   <!--   <input type="text" id="codigoControleAlterar" name="codigoControleAlterar"size="33" style="text-transform: uppercase;" maxlength="40" class="form-control"  placeholder="Valor do Pedido"> -->
                    <div class="form-group">
                        <select class="form-control" name="statusPedido" id="statusPedido" required>
                            <option value="" selected disabled>Selecione o Status</option>
                            <?php
                            $selectStatus = crud::listarStatus();
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
                    <div class="form-group">
                        <label for="message-text" class="control-label">Observação:</label>
                        <textarea name="mensagemAlterar" class="form-control" rows="3" id="mensagemAlterar"></textarea>
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
<!-- MODAL altera Pedido-->


</div>
<!-- /#page-wrapper -->

<?php
require_once "rodape.php";
include_once "modais.php";
?>

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
            var dataCadastro = $("#dataCadastro").val();
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
                       alert ("resultado data " + data);
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
        
        $("#frmIndex").on('submit', (function(e) {
            e.preventDefault();
            var table = $("#tabela").val();
            
            location.reload(table);
        }));


        $(document).on("click", "#btnPedidoAlterar", function () {
            var codigoControle = $(this).data('codigocontrolealterar');
            var statusSlterar = $(this).data('statusalterar');
           // var statusAtual = $(this).data('statusatual');
          //  var emailSolicitante = $(this).data('emailsolicitante');

            $('#codigoControleAlterar').val(codigoControle);   
            $('#statusPedido').html(codigoControle);   
        //    $('#statusAtual').val(statusAtual);
    //        $('#emailSolicitante').val(emailSolicitante);
          //  $('#contextoModal').empty().append("<h2>Você colocará a demanda EM ATENDIMENTO?</h2>");

        }); //SETA O CÓDIGO NO MODAL PARA ATUALIZAR O STATUS ------------------------------------------

        $("#frmAlterarPedido").on('submit', (function(e) {
            e.preventDefault();
            var table = $("#tabela").val();
            var codigoControle = $("#codigoControleAlterar").val();
            var mensagemAlterar = $("#mensagemAlterar").val();
           // var codigoControle = $(this).data('codigocontrolealterar');
            var statusPedido = $("#statusPedido").val();
            //   var mensagem = $("#mensagem").val();
          //  $('#codigoControleAlterar').html(codigoControle);
           //alert("codigo: " + codigoControle + " status do pedido " + statusPedido+" mensagem" + mensagemAlterar);
            $.ajax({
                url: "../core/save.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#alteraPedido").html("<i class='fa fa-spinner fa-spin'></i> Enviando, aguarde...");
                    $("#alteraPedido").prop("disabled", true);
                },
                success: function(data) {
                   // alert ("resultado data " + data);
                    if (data == 1) {
                        swal({
                                title: "OK!",
                                text: "Alterado com Sucesso!",
                                type: "success",
                                confirmButtonText: "Fechar",
                                closeOnConfirm: false
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                 $('#modalPedidoAlterar').modal('hide');
                                    location.reload(table);
                                    //window.location = "cadastro.php";
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
                                    $('#modalPedidoAlterar').modal('hide');
                                    location.reload(table);
                                }
                            });
                    }
                }
            });
        }));

        $('#departamento').change(function() {
            var codDepart = $("#departamento").val();
            $.ajax({
                url: 'busca_funcionario.php',
                type: "POST",
                data: {
                    codDepart: codDepart
                },
                success: function(data) {
                    //alert(data);
                    if (data) {

                        $('#usuarioDestino').empty().append(data);
                    }
                }
            });
        });

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
            //pegando valor das variaveis vindo da tabela e atribuindo aos id dos campos do modal para exibir
            $('#codigoDetalhes').html(idControle);
            $('#nomeClienteDetalhes').html(nomeCliente);
            $('#licitacaoDetalhes').html(numeroPregao);
            $('#pedidoDetalhes').html(numeroPedido);
            $('#tempoDetalhes').html(tempoPedido);
            $('#valorDetathes').html(valorPedido);
            $('#statusDetalhes').html(statusControle);
            $('#dataCriacaoDetalhes').html(dataCadastro);
            $('#mensagemDetatalhes').html(mensagem);

            //MONTA OS COMENTÁRIOS NO MODAL
            $.ajax({
                url: 'busca_mensagens.php',
                type: "POST",
                tipo: "busca_mensagens",
                data: {
                    id: id
                },
                success: function(data) {
                    if (data) {
                        $('#comentariosDemand').html(data);
                    }
                }
            });
        });       

        //VERIFICA SE DEMANDA TEM ANEXO --------------------------------------------------------------
        $(document).on("click", "#btnAnexo", function(e) {
            var link = $(this).attr("href");
            if (link == '../anexos/sem_anexo.php') {
                //alert('Demanda não possui anexo!');
                $('#modalPedidoSemAnexo').modal('show');
                e.preventDefault();
            }

        }); //VERIFICA SE DEMANDA TEM ANEXO ------------------------------------------------------------      
    });
    //BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME
    $("tr #statusControle").each(function(i) {
        if ($(this).text() == "RECEPCIONADO" || $(this).text() == "LIBERADO PARCIALMENTE") {
            //$(status).css("color", "red");
            this.style.background = "blue"; //cor do fundo
            this.style.color = "White"; //cor da fonte
        } else if ($(this).text() == "ATENDIDO") {
            this.style.color = "White"; //cor da fonte
            this.style.background = "green"; //cor do fundo
        } else if ($(this).text() == "PENDENTE") {
            this.style.color = "White"; //cor da fonte
            this.style.background = "red"; //cor do fundo
        } else {
            this.style.color = "";
        }
    });
</script>