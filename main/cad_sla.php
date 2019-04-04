<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';



?>
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-12">                   

		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<h1>Cadastra SLA</h1>
	<h4>Cadastro de prioridades para os chamados</h4>
	<form id="frmCadSla">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-inline">
					<div class="form-group">
						<input type="text" hidden id="tipo" name="tipo" value="cadSla">					
						<div class="input-group">
							<input type="text" class="form-control" size="40" name="descricao" id="descricao" placeholder="Descrição" required>
							<span class="input-group-addon"><span class="fa fa-hourglass-half"></span></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<input type="number" class="form-control" size="30" id="tempo" name="tempo" placeholder="Tempo Máximo" required >
							<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<select class="form-control" name="unidtempo" id="unidtempo" required>
								<option value="" selected disabled>Unidade de tempo</option>
								<option value="Minutos" >Minutos</option>
								<option value="Horas" >Horas</option>
								<option value="Dias" >Dias</option>
							</select>
						</div>
					</div>
				</div>		
				

				<br><br>
				<button type="submit" class="btn btn-info btn-lg btn-block" id="btnSalvaSla"><span class="fa fa-save"></span> Salvar</button>
			</div>

		</div>
	</form>


	<div class="row">
		<div class="col-sm-12"> 
			<div class="white-box">
				<hr>

				<div class="col-sm-6"> 
					<h3>Lista de SLAs</h3>
				</div>

				<table id="tabela" class="table table-striped">
					<thead>
						<tr>
							<th>Código</th>
							<th>Descrição</th>							                           
							<th>Tempo</th>                    
							<th>Unidade de Tempo</th>                    
							<th>Editar</th>                    
							<th>Excluir</th>                    
						</tr>
					</thead>
					<tbody>

						<?php
						$dados = crud::mostraSla();
                                       
						if($dados->rowCount()>0){
							while($row=$dados->fetch(PDO::FETCH_ASSOC)){

								?> 
								<tr>
									<td><?php print($row['id']); ?></td>
									<td><?php print($row['descricao']); ?></td>
									<td><?php print($row['tempo']); ?></td>
									<td><?php print($row['unitempo']); ?></td>
									<td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalEditSla" data-whatever="@getbootstrap" id="btnEditar" class="btn btn-danger waves-effect waves-light" 
										data-codigo="<?php print($row['id']); ?>" 
										data-desc="<?php print($row['descricao']); ?>"
										data-tempo="<?php print($row['tempo']); ?>"
										data-unitempo="<?php print($row['unitempo']); ?>"
										>Editar</a></td>
									
									<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalDeleteSla" data-whatever="@getbootstrap" id="btnExcluir" class="btn btn-info waves-effect waves-light" data-codigo="<?php print($row['id']); ?>" data-desc="<?php print($row['descricao']); ?>">Excluir</a></td>         
								</tr>
								<?php 
							}

						}else{              
							echo "<p class='text-danger'>Não há SLA cadastrados</p>";               
						}
						?>

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
</div>



<div class="modal fade" id="modalEditSla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="headermodal">Editar</h4>
                </div>
                <div class="modal-body">                    

                	<form id="frmEdtSla">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-inline">
									<div class="form-group">
										<input type="hidden" id="tipo" name="tipo" value="edtSla">
										<input type="hidden" id="edtId" name="edtId" >					
										<div class="input-group">
											<input type="text" class="form-control" size="40" name="edtDescricao" id="edtDescricao" required>
											<span class="input-group-addon"><span class="fa fa-hourglass-half"></span></span>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<input type="number" class="form-control" size="30" id="edtTempo" name="edtTempo" placeholder="Tempo Máximo" required >
											<span class="input-group-addon"><span class="fa fa-clock-o"></span></span>
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<select class="form-control" name="edtUnidtempo" id="edtUnidtempo" required>
												<option value="" selected disabled>Unidade de tempo</option>
												<option value="Minutos" >Minutos</option>
												<option value="Horas" >Horas</option>
												<option value="Dias" >Dias</option>
											</select>
										</div>
									</div>
								</div>		
								

								<br><br>
								<button type="submit" class="btn btn-info btn-lg btn-block" id="btnEdtSla"><span class="fa fa-save"></span> Salvar</button>
							</div>

						</div>
					</form>


                </div>
                <div class="modal-footer">
                	            
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteSla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" >
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="headermodal">Alerta</h4>
                </div>
                <div class="modal-body">
                    <div class="row">                       
                        <div class="col-md-12">
                            <div id="contextoModal">

                                <form id="frmDeleteDep" >							        
							          <div class="form-group">
							            <div class="input-group">
							              <input type="hidden" class="form-control" id="idSla" name="idSla">
							              <input type="hidden" class="form-control" value="excluiSla" name="tipo">
							              
							              <span class="input-group-addon" id="labelSla" style="font-size: 15px;"><span class="fa fa-users" ></span></span>
							            </div>
							          </div>							          
							          <button type="submit" class="btn btn-success" id="btnDeleteDep">Confirmar</button>
							        
    							</form>

                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                	            
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                   
                </div>
            </div>
        </div>
    </div>


<?php

require_once "rodape.php";
?>

<script type="text/javascript">
	$(document).ready(function(){
		
		permissaoNivel();
		$("#frmCadSla").submit(function(e){
            e.preventDefault();
			
			
			$.ajax({ //Função AJAX
					url:"../core/save.php",			//Arquivo php
					type:"POST",				//Método de envio
					data: new FormData(this),
					contentType: false,       
                	cache: false,            
                	processData:false,
					success: function (result){	
		   				//alert(result)
		   				if(result==1){	
		   					swal({
								title: "OK!",
								text: "SLA Cadastrado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},

							function(isConfirm){
								if (isConfirm) {
										window.location = "cad_sla.php";
									}
							});

		   					

		   				}else{
		                	alert("Erro ao salvar");		//Informa o erro
		                		}
		                	}
		                });

				return false;//Evita que a página seja atualizada
			});

		 $(document).on("click", "#btnEditar", function () {
		        var id = $(this).data('codigo');
		        var desc = $(this).data('desc');
		        var tempo = $(this).data('tempo');
		        var unitempo = $(this).data('unitempo');
		         
		            
		        $('#edtId').val(id);
		        $('#edtDescricao').val(desc);            
		        $('#edtTempo').val(tempo);            
		        $('#edtUnidtempo').val(unitempo);
            
        });

		 $('#frmEdtSla').submit(function(e){
		 	e.preventDefault();	
			
			$.ajax({ //Função AJAX
					url:"../core/save.php",			//Arquivo php
					type:"POST",				//Método de envio
					data: new FormData(this),
					contentType: false,       
                	cache: false,            
                	processData:false,
					success: function (result){	
		   				//alert(result)
		   				if(result==1){
		   					swal({
								title: "OK!",
								text: "Dados Editados com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},

							function(isConfirm){
								if (isConfirm) {
										window.location = "cad_sla.php";
									}
							});

		   				}else{
		                	swal({
								title: "Ops!",
								text: "Algo deu errado!",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},

							function(isConfirm){
								if (isConfirm) {
										window.location = "cad_sla.php";
									}
							});
		                }
		            }
		    });

				return false;
			});


		  $(document).on("click", "#btnExcluir", function () {
		        var id = $(this).data('codigo');
		        var desc = $(this).data('desc');
		        
		            
		        $('#idSla').val(id);
		        $('#labelSla').html("Você vai excluir o SLA <strong>"+desc+"?</strong>");            
            
        });


		$('#frmDeleteDep').submit(function(){
						
			
			$.ajax({ //Função AJAX
					url:"../core/save.php",			//Arquivo php
					type:"POST",				//Método de envio
					data: new FormData(this),
					contentType: false,       
                	cache: false,            
                	processData:false,
                	success: function (result){	
		   				//alert(result)
		   				if(result==1){
		   					swal({
								title: "OK!",
								text: "SLA Excluído com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},

							function(isConfirm){
								if (isConfirm) {
										window.location = "cad_sla.php";
									}
							});

		   				}else{
		                	swal({
								title: "Ops!",
								text: "Algo deu errado!",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},

							function(isConfirm){
								if (isConfirm) {
										window.location = "cad_sla.php";
									}
							});
		                }
		            }
		    });

				return false;
			});


	});
</script>