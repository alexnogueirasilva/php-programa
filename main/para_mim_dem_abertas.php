<?php 
include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i:s');
$dataMsg = date('d/m/Y - H:i');

$logado = $_SESSION['nomeUsuario'];
$idLogado = $_SESSION['usuarioID'];

$queryDepart = "SELECT * FROM departamentos";
//SQL QUE VAI MOSTRAR A LISTA DE CHAMADOS DE CADA USUÁRIO UNINDO TRÊS TABELAS - (DEMANDAS, USUÁRIOS E DEPARTAMENTOS)
$queryDemandas = 'SELECT d.id,d.mensagem,d.titulo,d.prioridade, d.ordem_servico, d.data_criacao, d.status,d.anexo, u.nome, dep.nome as nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_criador = u.id AND d.status<>"Fechada" and d.id_usr_destino = '.$_SESSION['usuarioID'].' INNER JOIN departamentos AS dep ON u.id_dep = dep.id ORDER BY data_criacao ASC';

$queryComentarios = ("SELECT hst.mensagem, hst.cod_usr_msg, us.nome FROM hst_mensagens as hst INNER JOIN demanda as dem ON hst.cod_demanda = dem.id INNER JOIN usuarios as us ON hst.cod_usr_msg=us.id AND hst.cod_demanda = 31");


?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12">                   

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- row -->
    <div class="row">
        <!-- <div class="col-md-12">
            <button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalCriaDemanda" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-plus"></i></span>Criar Demanda</button>                        
        </div> -->
        <div class="row" id="demandas">
            <div class="col-sm-12"> 

                <div class="white-box">
                    <div class="col-sm-6"> 
                        <h3>Demandas Abertas de <?php echo $logado ?>  </h3>
                    </div>
                    <div class="col-sm-6"> 
                        <a href="" id="atualizar"> <i class="fa fa-refresh"></i> Atualizar</a>
                    </div>                                
                    <table id="tabela" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Status</th>
                                <th>OS</th>
                                <th>Solicitante</th>
                                <th>Depart.</th>                                
                                <th>Data Criação</th>
                                <th>Decorridos</th>
                                <th>Anexo</th>
                                <th>Detalhes</th>
                                <th>Atender</th> 
                                <th>Fechar</th> 
                                
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $dados = crud::dataview($queryDemandas);
                                        //print_r($dados);
                            if($dados->rowCount()>0){
                                while($row=$dados->fetch(PDO::FETCH_ASSOC)){

                                    $dataCriada = $row['data_criacao'];
                                    $dataAtual = date('Y-m-d H:i:s');

                                    $datatime1 = new DateTime($row['data_criacao']);
                                    $datatime2 = new DateTime($dataAtual);

                                    $data1  = $datatime1->format('Y-m-d H:i');
                                    $data2  = $datatime2->format('Y-m-d H:i');
                                    

                                    $criada = strtotime( $data1 );
                                    $atual = strtotime( $data2 );
                                 
                                    $intervalo = ( $atual - $criada ) / 60;
                                    
                                    $horas = (int)($intervalo / 60);                                 
                                    $minutos = $intervalo%60;

                                    ?> 
                                    <tr>
                                        <td><?php print($row['titulo']); ?></td>
                                        <td id="status"><?php print($row['status']); ?></td>  
                                        <td style="text-transform: uppercase;"><?php print($row['ordem_servico']); ?></td>     
                                        <td><?php print($row['nome']); ?></td>       
                                        <td><?php print($row['nome_dep']); ?></td>       
                                       
                                        <td><?php print($row['data_criacao']); ?></td>
                                        <td><?php print($horas .' Horas'. ' e ' .$minutos." Minutos"); ?></td>
                                        <td><a class="btn btn-primary waves-effect waves-light" id="btnAnexo" target="_blank" href="../anexos/<?php print($row['anexo']);?>">Anexo</a></td>

                                        <td><a class="btn btn-success waves-effect waves-light" type="button" 
                                            id="idDemanda2" 
                                            data-toggle="modal" 
                                            data-target="#modalDetDemanda" 
                                            data-whatever="@getbootstrap"
                                            data-codigodet="<?php print($row['id']);?>"
                                            data-titulodet="<?php print($row['titulo']);?>"
                                            data-status="<?php print($row['status']); ?>"
                                            data-datacriacao="<?php print($row['data_criacao']); ?>"
                                            data-mensagem="<?php print($row['mensagem']); ?>">Detalhes</a></td>
                                           
                                            <td><a class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#modalConfirmacaoAtend" data-whatever="@getbootstrap" id="btnAtender" data-codigo="<?php print($row['id']); ?>" data-statusatual="<?php print($row['status']); ?>">Atender</a></td>
                                            <td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalConfirmacaoFecha" data-whatever="@getbootstrap" id="btnFechar" class="btn btn-danger waves-effect waves-light" data-codigo="<?php print($row['id']); ?>" data-statusatual="<?php print($row['status']); ?>">Fechar</a></td>
                                           
                                            
                                    </tr>
                                        <?php 
                                    }

                                }else{              
                                    
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


    <!-- MODAL DETALHES -->
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
                                    <td id="codigoDetalhes"></td>
                                </tr>                         
                                <tr>
                                    <td>Título</td>
                                    <td><span id="tituloDetalhes"></span></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td id="statusDet"></td>
                                </tr>
                                <tr>
                                    <td>Criado em:</td>
                                    <td id="dataCriacaoDet"></td>
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
                        <div class="col-md-12">                       
                            <form id="frmAddMensagem">
                                <input type="hidden" value="<?php echo $idLogado; ?>" name="idLogado" id="idLogado">
                                <input type="hidden" value="<?php echo $dataMsg; ?>" name="datahora" id="datahora">                          
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Adicionar Comentário: (ao adicionar uma mensagem, você colocará a demanda "Em atendimento")</label>
                                    <textarea name="mensagem" class="form-control" rows="2" id="mensagem" required></textarea>          
                                </div>
                                <button type="submit" id="addMensagem" class="btn btn-primary" >Enviar</button>
                            </form>
                            <!-- <button id="btnteste" class="btn btn-primary" >Teste</button> -->
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">              
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CONFIRMAÇÃO DE ATENDIMENTO DE DEMANDA -->
    <div class="modal fade" id="modalConfirmacaoAtend" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="headermodal">Confirmação</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="codigoDemanda" id="codigoDemanda">
                        <input type="hidden" name="statusAtual" id="statusAtual">
                        <div class="col-md-12">
                            <div id="contextoModal">
                                <h2>Você vai colocar a demanda em atendimento?</h2>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">              
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnMudaStatus" class="btn btn-primary" >Confirmar</button
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CONFIRMAÇÃO DE ATENDIMENTO DE DEMANDA -->
    <div class="modal fade" id="modalConfirmacaoFecha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="headermodal">Confirmação</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="codigoDemanda" id="codigoDemanda">
                        <input type="hidden" name="statusAtual" id="statusAtual">
                        <input type="hidden" value="<?php echo $data; ?>" name="dataAtual" id="dataAtual">
                        <div class="col-md-12">
                            <div id="contextoModal">
                                <h2>Você vai FECHAR a demanda?</h2>
                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">              
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btnFechaDemanda" class="btn btn-primary" >Confirmar</button
                    </div>
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

    $(document).ready(function(){


        permissaoNivel();
        $("#atualizar").click(function(){
            location.reload();
        });



        //MONTA O SELECT DOS FUNCIONÁRIOS DIRETO DO BANCO ----------------------------------------
        $('#departamento').change(function(){
            var codDepart = $("#departamento").val();

            $.ajax({
                url: 'busca_funcionario.php',
                type: "POST",
                data: {codDepart : codDepart},
                success: function(data) {                   
                    if (data) {
                        $('#usuarioDestino').empty().append(data);
                    } 
                }
            });

        });//MONTA O SELECT DOS FUNCIONÁRIOS DIRETO DO BANCO --------------------------------------


        //ABRE MODAL DOS DETALHES DA DEMANDA ------------------------------------------------------
        $(document).on("click", "#idDemanda2", function () {
            var id = $(this).data('codigodet');            
            var titulo = $(this).data('titulodet');
            var status = $(this).data('status');
            var dataCriacao = $(this).data('datacriacao');
            var mensagem = $(this).data('mensagem');           

            $('#codigoDetalhes').html(id);
            $('#tituloDetalhes').html(titulo);
            $('#statusDet').html(status);
            $('#dataCriacaoDet').html(dataCriacao);
            $('#mensagemDet').html(mensagem);

            //MONTA OS COMENTÁRIOS NO MODAL
            $.ajax({
                url: 'busca_mensagens.php',
                type: "POST",
                data: {id : id},
                success: function(data) {                   
                    if (data) {                            
                        $('#comentariosDemand').html(data);
                    } 
                }
            });
        }); //ABRE MODAL DOS DETALHES DA DEMANDA ------------------------------------------------------

        
        //VERIFICA SE DEMANDA TEM ANEXO --------------------------------------------------------------
        $(document).on("click", "#btnAnexo", function (e) {               
            var link = $(this).attr("href");
            if (link == '../anexos/sem_anexo.php') {
                //alert('Demanda não possui anexo!');
                $('#modalSemAnexo').modal('show');
                e.preventDefault();
            }         

        });//VERIFICA SE DEMANDA TEM ANEXO ------------------------------------------------------------


        //SETA O CÓDIGO NO MODAL PARA ATUALIZAR O STATUS ----------------------------------------------
        $(document).on("click", "#btnAtender", function () {
            var codigo = $(this).data('codigo');
            var statusAtual = $(this).data('statusatual');

            $('#codigoDemanda').val(codigo);   
            $('#statusAtual').val(statusAtual);
            $('#contextoModal').empty().append("<h2>Você colocará a demanda EM ATENDIMENTO?</h2>");

        }); //SETA O CÓDIGO NO MODAL PARA ATUALIZAR O STATUS ------------------------------------------



        //MUDA STATUS DA DEMANDA SE ELA ESTIVER ABERTA ------------------------------------------------
        $('#btnMudaStatus').click(function(){
            var tipo = "atualizaStatus";
            var codigoDemanda = $("#codigoDemanda").val();
            var status = "Em atendimento";
            var statusAtual = $("#statusAtual").val();
            //alert(statusAtual);
            if (statusAtual == "Em atendimento") {
                alert("Demanda já está Em atendimento!");
                die();
            }       

            $.ajax({
                url: '../core/save.php',
                type: "POST",
                data: {tipo : tipo, codigoDemanda : codigoDemanda, status : status},
                success: function(result) {
                    //alert(data);
                    if(result==1){
                            //alert(result);
                            alert("Atualizado com Sucesso!");
                            //$('#contextoModal').empty().append("<h2>Atualizado</h2>");
                            $('#modalConfirmacaoAtend').modal('hide');
                            window.location.reload();
                            
                        }else{                           
                            alert("Erro ao salvar");                            
                        }

                    }
                });
        }); //MUDA STATUS DA DEMANDA SE ELA ESTIVER ABERTA ------------------------------------------------



        //ADICIONA MENSAGEM À DEMANDA -----------------------------------------------------------
        $('#frmAddMensagem').submit(function(){
            var tipo = "adicionaMensagem";
            var idLogado = $("#idLogado").val();
            var datahora = $("#datahora").val();
            var codDemanda = $('#codigoDetalhes').text();
            //var status = "Em atendimento";
            var mensagem = $("#mensagem").val();
            var demandas = $("#demandas").val();


            $.ajax({
                url: '../core/save.php',
                type: "POST",
                data: {tipo : tipo, idLogado : idLogado, datahora:datahora, codDemanda : codDemanda, mensagem : mensagem},
                success: function(result) {
                    //alert(data);
                    if(result==1){                        
                        alert("Mensagem adicionada com Sucesso!");
                            //$('#contextoModal').empty().append("<h2>Atualizado</h2>");
                            //$('#modalDetDemanda').modal('hide');
                            atualizaMsg();
                            $("#mensagem").val('');
                            //location.reload();

                        }else{                           
                            alert("Erro ao salvar");                            
                        }

                    }
                });
            return false;//Evita que a página seja atualizada
        });//ADICIONA MENSAGEM À DEMANDA -----------------------------------------------------------
      


    //SETA O CÓDIGO NO MODAL PARA ATUALIZAR O STATUS -------------------------------------------------
    $(document).on("click", "#btnFechar", function () {
        var codigo = $(this).data('codigo');
        var statusAtual = $(this).data('statusatual');

        $('#codigoDemanda').val(codigo);   
        $('#statusAtual').val(statusAtual);
        $('#contextoModal').empty().append("<h2>Você pretende fechar a demanda agora?</h2>");

    });//SETA O CÓDIGO NO MODAL PARA ATUALIZAR O STATUS ------------------------------------------------


    $('#btnFechaDemanda').click(function(){
        var tipo = "fechaDemanda";
        var codigoDemanda = $("#codigoDemanda").val();
        var status = "Fechada";
        var dataFechamento = $("#dataAtual").val();

        $.ajax({
            url: '../core/save.php',
            type: "POST",
            data: {tipo : tipo, codigoDemanda : codigoDemanda, status : status, dataFechamento : dataFechamento},
            success: function(result) {
                    //alert(data);
                    if(result==1){
                            //alert(result);
                            alert("Fechado com Sucesso!");
                            //$('#contextoModal').empty().append("<h2>Atualizado</h2>");
                            $('#modalConfirmacaoFecha').modal('hide');
                            window.location.reload();
                            
                        }else{
                            //alert(result);
                            alert("Erro ao salvar");                            
                        }

                    }
                });

    });



         //BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME -----------------------------------
         $( "tr #status" ).each(function( i ) {            
            if ( $(this).text() == "Em atendimento" ) {
                //$(status).css("color", "red");
                this.style.color = "blue";
            } else if($(this).text() == "Aberto"){
              this.style.color = "green";
          }else if($(this).text() == "Fechada"){
            this.style.color = "red";
        }else{
            this.style.color = "";
        }
    });//BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME -------------------------------------



     });


        //FUNÇÃO QUE ATUALIZA AS MENSAGENS NOS DETALHES APÓS SUBMETE-LA -------------------------
        function atualizaMsg(){
            var id = $("#codigoDetalhes").text();    
            //MONTA OS COMENTÁRIOS NO MODAL
            $.ajax({
                url: 'busca_mensagens.php',
                type: "POST",
                data: {id : id},
                success: function(data) {                   
                    if (data) {                            
                        $('#comentariosDemand').html(data);
                    } 
                }
            });
            }//FUNÇÃO QUE ATUALIZA AS MENSAGENS NOS DETALHES APÓS SUBMETE-LA -------------------------




 </script>