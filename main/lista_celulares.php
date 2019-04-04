<?php 
include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';


$logado = $_SESSION['nomeUsuario'];

$queryDepart = "SELECT * FROM departamentos";
//SQL QUE VAI MOSTRAR A LISTA DE CHAMADOS DE CADA USUÁRIO UNINDO TRÊS TABELAS - (DEMANDAS, USUÁRIOS E DEPARTAMENTOS)
$queryDemandas = 'SELECT d.id, d.mensagem, d.titulo, d.prioridade, d.data_criacao, d.status,d.anexo, u.nome, dep.nome as nome_dep FROM demanda AS d INNER JOIN usuarios AS u ON d.id_usr_destino = u.id AND id_usr_criador = '.$_SESSION['usuarioID'].' INNER JOIN departamentos AS dep ON u.id_dep = dep.id ORDER BY data_criacao ASC';

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
        <div class="col-md-12">
            <button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalCadCelular" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-plus"></i></span>Cadastrar Novo</button>                        
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
                                <th>Destinatário</th>
                                <th>Departamento</th>
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
                                        <td><?php print($row['titulo']); ?></td>
                                        <td id="status"><?php print($row['status']); ?></td>       
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


        $("#frmCadCelular").on('submit',(function(e) {
            e.preventDefault();
            
           // var table = $("#tabela").val(); 

            $.ajax({
                url: "../core/save.php",
                type: "POST",             
                data: new FormData(this), 
                contentType: false,       
                cache: false,            
                processData:false,
                 beforeSend: function(){                   
                        $("#salvaCelular").html("<i class='fa fa-spinner fa-spin'></i> Enviando, aguarde...");
                        $("#salvaCelular").prop("disabled", true);                        
                    },      
                success: function(data)
                {
                    alert(data);
                    alert("Salvo com Sucesso!");    //Redireciona
                    $('#modalCriaDemanda').modal('hide');                    
                    location.reload();
                }
            });
        }));
        


        $('#departamento').change(function(){
            var codDepart = $("#departamento").val();

            $.ajax({
                url: 'busca_funcionario.php',
                type: "POST",
                data: {codDepart : codDepart},
                success: function(data) {
                    //alert(data);
                    if (data) {

                        $('#usuarioDestino').empty().append(data);
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

