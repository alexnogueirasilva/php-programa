<?php 
include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';


$logado = $_SESSION['nomeUsuario'];

$queryDepart = "SELECT * FROM departamentos";
//SQL QUE VAI MOSTRAR A LISTA DE CHAMADOS DE CADA USUÁRIO UNINDO TRÊS TABELAS - (DEMANDAS, USUÁRIOS E DEPARTAMENTOS)
$queryDemandas = 'SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.ordem_servico, d.data_criacao, d.status, d.anexo, u.nome, d.id_usr_criador, dep.nome AS nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_criador = u.id INNER JOIN departamentos AS dep ON d.id_dep = dep.id ORDER BY data_criacao ASC';

//print_r($queryDemandas);
?>

<div class="container-fluid">
    <div class="row bg-title">
        <div class="col-lg-12">                   
            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- row -->
    <div class="row">
       
        <div class="row">
            <div class="col-sm-12"> 
                <div id="dado"></div>
                <div class="white-box">
                    <div class="col-sm-6"> 
                        <h3>Todas demandas criadas</h3>
                    </div>
                    
                    <table id="tabela" class="table table-striped">
                        <thead>
                            <tr>                                
                                <th>Status</th>
                                <th>OS</th>
                                <th>Criador</th>                               
                                <th>Para Dep.</th>
                                <th>Prioridade</th>
                                <th>Data Criação</th>
                                <th>Anexo</th>
                                <th>Detalhes</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $dados = crud::dataview($queryDemandas);
                                        //print_r($dados);
                            if($dados->rowCount()>0){
                                while($row=$dados->fetch(PDO::FETCH_ASSOC)){

                                    ?> 
                                    <tr>                                       
                                        <td id="status"><?php print($row['status']); ?></td>
                                        <td style="text-transform: uppercase;"s><?php print($row['ordem_servico']); ?></td>  
                                        <td><?php print($row['nome']); ?></td>
                                        <td><?php print($row['nome_dep']); ?></td>       
                                        <td><?php print($row['prioridade']); ?></td>       
                                        <td><?php print($row['data_criacao']); ?></td>

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
                                            data-mensagem="<?php print($row['mensagem']); ?>"
                                            >Detalhes</a></td>                    
                                        </tr>
                                        <?php 
                                    }
                                    
                                }else{              
                                        //echo "<p class='text-danger'>Sem demandas abertas</p>";               
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


    <!-- MODAL CRIA DEMANDA -->
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

    $(document).ready(function (e) {

        permissaoNivel();
   

    //PEGA O CODIGO E O NOME DO BAIRRO AO CICAR NO BOTÃO DE RESERVAR
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
            
        });

    //VERIFICA SE DEMANDA TEM ANEXO --------------------------------------------------------------
        $(document).on("click", "#btnAnexo", function (e) {               
            var link = $(this).attr("href");
            if (link == '../anexos/sem_anexo.php') {
                //alert('Demanda não possui anexo!');
                $('#modalSemAnexo').modal('show');
                e.preventDefault();
            }         

        });//VERIFICA SE DEMANDA TEM ANEXO ------------------------------------------------------------

    
    
    //BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME
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
    });

    


});

</script>

