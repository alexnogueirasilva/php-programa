<?php
include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';

date_default_timezone_set('America/Sao_Paulo');

$logado         = $_SESSION['nomeUsuario'];
$emailLogado    = $_SESSION['emailUsuario'];
$instituicao    = $_SESSION['instituicaoUsuario'];
$queryDepart    = "SELECT * FROM departamentos";
$queryCliente   = "SELECT * FROM cliente";

echo " Andre  $andre<br/> ";

echo " segundos  $segundos<br/> ";
echo " registro $registro<br/> ";
echo " limite $limite<br/> ";
if($logado != 1){$logado2 = 600;
    echo "<meta HTTP-EQUIV='refresh' CONTENT='$logado2;'>";//atualizacao automatica
}
?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12">

        </div>
        <!-- /.col-lg-12 -->
        </div><div class="container">        
        <div id="andre"></div>
        </div>
    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalCriaDemanda" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-plus"></i></span>Criar Ocorrencia</button> 
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div id="dado"></div>
                <div class="white-box">
                    <div class="col-sm-6">
                        <h3>Demandas Criadas</h3>
                    </div>
                    <table id="tabela" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Status</th>
                                <th>OS</th>
                                <th>Destinatário</th>
                                <th>Solicitante</th>
                                <th>Depart.</th>
                                <th>Data Criação</th>
                                <th>Decorridos</th>
                                <th>Anexo</th>
                                <th>Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $dados = crud::mostraDemandas($_SESSION['usuarioID'], $idInstituicao);
                            //print_r($dados);
                            if ($dados->rowCount() > 0) {
                                while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {

                                    $dataCriada = $row['data_criacao'];
                                    $dataAtual = date('Y-m-d H:i:s');

                                    $datatime1 = new DateTime($row['data_criacao']);
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
                                        <td><?php print($row['titulo']); ?></td>
                                        <td id="status"><?php print($row['status']); ?></td>
                                        <td style="text-transform: uppercase;"> 
                                        <?php print($row['ordem_servico']); ?></td>
                                        <td><?php print($row['nome']); ?></td>
                                        <td><?php print($row['nomecliente']); ?></td>
                                        <td><?php print($row['nome_dep']); ?></td>
                                        <td><?php print(crud::formataData($row['data_criacao']));?></td>
                                        <td><?php print($horas . ' Horas' . ' e ' . $minutos . " Minutos"); ?></td>

                                        <td><a class="btn btn-primary waves-effect waves-light" id="btnAnexo" target="_blank" href="../anexos/<?php print($row['anexo']); ?>">Anexo</a></td>

                                        <td><a class="btn btn-success waves-effect waves-light" type="button" id="idDemanda2" 
                                        data-toggle="modal" data-target="#modalDetDemanda" data-whatever="@getbootstrap" 
                                        data-codigodet="<?php print($row['id']); ?>" 
                                        data-titulodet="<?php print($row['titulo']); ?>" 
                                        data-nomesolicitante="<?php print($row['nomecliente']); ?>" 
                                        data-status="<?php print($row['status']); ?>" 
                                        data-datacriacao="<?php print(crud::formataData($row['data_criacao'])); ?>" 
                                        data-datafechamento="<?php print(crud::formataData($row['data_fechamento'])); ?>" 
                                        data-mensagem="<?php print($row['mensagem']); ?>" 
                                        data-dataidinstituicao="<?php print($row['fk_idInstituicao']) ?>" >Detalhes</a></td>
                                    </tr>                                    
                                <?php
                            }
                        } else {
                            echo "<p class='text-danger'>Sem demandas abertas</p>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- /.row -->
</div>

<!-- MODAL detalhe DEMANDA -->
<div class="modal fade bs-example-modal-lg" id="modalDetDemanda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Detalhes da Demanda</h4>
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
                                <td>Reg. Empresa</td>
                                <td><span id="idInstituicaoDetalhes"></span></td>
                            </tr>
                            <tr>
                                <td>Título</td>
                                <td><span id="tituloDetalhes"></span></td>
                            </tr>
                            <tr>
                                <td>Solicitante</td>
                                <td><span id="nomeSolicitanteDetalhes"></span></td>                              
                            </tr>                            
                            <tr>
                                <td>Criado em:</td>
                                <td><span id="dataCriacaoDet"></span></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td id="statusDet"></td>
                            </tr>
                            <tr>
                                <td>Mensagem</td>
                                <td id="mensagemDet"></td>
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
            </div>
        </div>
    </div>
</div>
</div>
<!-- /#page-wrapper -->

<?php
require_once "rodape.php";
include_once "modais.php";
?>

<script type="text/javascript">
    $(document).ready(function(e) {

        permissaoNivel();

        $("#frmCriaDemanda").on('submit', (function(e) {
            e.preventDefault();
            var table = $("#tabela").val();

            $.ajax({
                url: "../core/save.php",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $("#salvaDemanda").html("<i class='fa fa-spinner fa-spin'></i> Enviando, aguarde...");
                    $("#salvaDemanda").prop("disabled", true);
                },
                success: function(data) { 
                   alert(data);                                                 
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
                                    $('#modalCriaPedido').modal('hide');
                                    location.reload(table);
                                    //      window.location = "cadastro.php";
                                }
                            });
                    }else{
                        alert("Erro ao salvar "); 
                        $('#modalCriaDemanda').modal('hide');
                                    location.reload(table);
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

        /* testanto inclusao de cliente no modal criar demanda */
        /*   $('#nomeSolicitante').change(function(){
            var nomeSolicitante = $("#nomeSolicitante").val();

            $.ajax({
                url: 'busca_cliente.php',
                type: "POST",
                data: {nomeSolicitante : nomeSolicitante},
                success: function(data) {
                    //alert(data);
                    if (data) {

                        $('#nomeSolicitante').val(data);
                    } 
                }
            });
            
        });*/

        //PEGA O CODIGO E O NOME DO DEPARTAMENTO AO CICAR NO BOTÃO DE RESERVAR
        $(document).on("click", "#idDemanda2", function() {
            var id = $(this).data('codigodet');
            var titulo = $(this).data('titulodet');
            var nomeSolicitante = $(this).data('nomesolicitante');
            var status = $(this).data('status');
            var dataCriacao = $(this).data('datacriacao');
            var dataFechamento = $(this).data('datafechamento');
            var mensagem = $(this).data('mensagem');
            var idInstituicao = $(this).data('dataidinstituicao');            
            if(status == "Fechada"){
            status = status +" - Em: " + dataFechamento;
            }
            $('#codigoDetalhes').html(id);
            $('#tituloDetalhes').html(titulo);
            $('#nomeSolicitanteDetalhes').html(nomeSolicitante);
            $('#statusDet').html(status);
            $('#idInstituicaoDetalhes').html(idInstituicao);
            $('#dataCriacaoDet').html(dataCriacao);
            $('#mensagemDet').html(mensagem);

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
                $('#modalSemAnexo').modal('show');
                e.preventDefault();
            }

        }); //VERIFICA SE DEMANDA TEM ANEXO ------------------------------------------------------------      
    });
     //BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME
     $("tr #status").each(function(i) {
            if ($(this).text() == "Em atendimento") {
                //$(status).css("color", "red");
                this.style.background = "blue";//cor do fundo
                this.style.color = "White";//cor da fonte
            } else if ($(this).text() == "Aberto") {
                this.style.color = "White";//cor da fonte
                this.style.background = "green";//cor do fundo
            } else if ($(this).text() == "Fechada") {
                this.style.color = "White";//cor da fonte
                this.style.background = "red";//cor do fundo
            } else {
                this.style.color = "";
            }
        });
        // Função responsável por atualizar as frases        
       /* function atualizar(){                       
            $.ajax({url: 'busca_mensagens.php',
                type: "POST", 
                
                success:function (andre) {  
                  //  alert (andre);      
                    $('#andre').html('<i>' + andre['mensagem'] + '</i><br />');               
                }
                });
        }
 
// Definindo intervalo que a função será chamada
setInterval("atualizar()", 100000);

// Quando carregar a página
$(function() {
    // Faz a primeira atualização
    atualizar();
});*/

</script>