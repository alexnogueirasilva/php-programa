<?php 
include_once 'vrf_lgin.php';
require_once 'cabecalho.php';

date_default_timezone_set('America/Sao_Paulo');
$data = date('Y-m-d H:i:s');

//DEFINIÇÃO DO NOME DO ANEXO
$nomeAnexo = date('Y-m-d-H:i');
$novoNomeAnexo = md5($nomeAnexo);

$idLogado = $_SESSION['usuarioID'];

?>

<!-- MODAL CRIA DEMANDA -->
    <div class="modal fade bs-example-modal-lg" id="modalCriaDemanda" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel1">Criar Ocorrencia</h4>
            </div>
            <div class="modal-body">
                <form id="frmCriaDemanda" action="" method="post" enctype="multipart/form-data" >                    
                    <input type="hidden" value="criaDemanda" name="tipo" id="tipo">
                    <input type="hidden" value="<?php echo $data; ?>" name="dataAtual" id="dataAtual">
                    <input type="hidden" value="<?php echo $idLogado; ?>" name="idLogado" id="idLogado">
                    <input type="hidden" value="" name="emailDestino" id="emailDestino">
                                      
                    <div class="form-inline">                       
                        <div class="form-group">
                            <input type="text" size="50" style="text-transform: uppercase;" maxlength="40" class="form-control" name="titulo" id="titulo" placeholder="Título/Assunto" required>
                        </div>                      
                        <div class="form-group">
                            <select class="form-control" name="departamento" id="departamento" required>
                                <option value="" selected disabled>Departamento</option>
                                <?php
                                    $selectDepart = crud::dataview($queryDepart);
                                    if($selectDepart->rowCount()>0)
                                    {
                                        while($row=$selectDepart->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <option value="<?php print($row['id']);?>"><?php print($row['nome']); ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>           
                        <div class="form-group">
                            <select class="form-control" name="usuarioDestino" id="usuarioDestino" required>                               
                            
                        </select>
                        </div>
                    </div>
                    <br>
                    
                    <div class="form-inline">
                        
                        <div class="form-group">
                            <select class="form-control" name="prioridade" id="prioridade" required>
                                <option value="" selected disabled>Prioridade</option>
                                <?php
                                    $selectSla = crud::mostraSla();
                                    if($selectSla->rowCount()>0)
                                    {
                                        while($row=$selectSla->fetch(PDO::FETCH_ASSOC)){                                            
                                            echo '<option value="'.$row['id'].'">'.$row['descricao'].' - '.$row['tempo'].' '.$row['unitempo'].'</option>';                                            
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" pattern="[0-9]" size="30" maxlength="30" class="form-control" name="ordemServico" id="ordemServico" placeholder="Ordem de Serviço" style="text-transform: uppercase;">
                        </div>                      
                        <div class="form-group">
                            <select class="form-control"maxlength="50" name="nomeSolicitante" id="nomeSolicitante" required>
                                <option value="" selected disabled>Selecione o solicitante</option>
                                <?php
                                    $selectCliente = crud::mostrarCliente();
                                    if($selectCliente->rowCount()>0)
                                    {
                                        while($row=$selectCliente->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                            <option value="<?php print($row['codCliente']);?>"><?php print($row['nomeCliente']); ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Mensagem:</label>
                            <textarea name="mensagem" class="form-control" rows="5" id="mensagem" required></textarea>          
                        </div>                    
                    <input type="file" name="file" id="file">                    
            </div>
                    <div class="modal-footer">
                        <button type="submit" id="salvaDemanda" class="btn btn-primary" >Enviar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
        </div>
    </div>
</div>

<!-- MODAL CONFIRMAÇÃO DE ATENDIMENTO DE DEMANDA -->
    <div class="modal fade" id="modalSemAnexo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
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
                                <h2>Ocorrencia não possui anexo!</h2>
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

<!-- MODAL EDITA DEPARTAMENTO -->


<!-- UPLOAD DE ARQUIVOS -->
<script src="js/jquery.form.js"></script>
