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
	
	<h1>Cadastra Departamento</h1>
	<h4>Insira os dados do Departamento</h4>
	<form id="frmCadDep">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-inline">
					<div class="form-group">						
						<div class="input-group">
							<input type="text" class="form-control" size="200" name="nomeDep" id="nomeDep" placeholder="Nome do departamento" required >
							<span class="input-group-addon"><span class="fa fa-cubes"></span></span>
						</div>
					</div>					
				</div>				
				<br><br>
				<button type="submit" class="btn btn-info btn-lg btn-block" id="submit"><span class="fa fa-save"></span> Salvar</button>
			</div>

		</div>
	</form>
		<div class="row">
		<div class="col-sm-12"> 
			<div class="white-box">
				<hr>

				<div class="col-sm-6"> 
					<h3>Lista de Departamentos</h3>
				</div>

				<table id="tabela" class="table table-striped">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>							                           
							<th>Editar</th>                    
							<th>Excluir</th>                    
						</tr>
					</thead>
					<tbody>

						<?php
						$dados = crud::mostraDep();
                                       
						if($dados->rowCount()>0){
							while($row=$dados->fetch(PDO::FETCH_ASSOC)){

								?> 
								<tr>
									<td><?php print($row['id']); ?></td>
									<td><?php print($row['nome']); ?></td>
									<td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalEditDep" data-whatever="@getbootstrap" id="btnEditar" class="btn btn-danger waves-effect waves-light" data-codigo="<?php print($row['id']); ?>" data-nome="<?php print($row['nome']); ?>">Editar</a></td>
									
									<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalDeleteDep" data-whatever="@getbootstrap" id="btnExcluir" class="btn btn-info waves-effect waves-light" data-codigo="<?php print($row['id']); ?>" data-nome="<?php print($row['nome']); ?>">Excluir</a></td>         
								</tr>
								<?php 
							}

						}else{              
							echo "<p class='text-danger'>Não departamentos cadastrados</p>";               
						}
						?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>

<div class="modal fade" id="modalEditDep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
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

                                <form method="post" id="frmEdtDep" >							        
							          <div class="form-group">
							            <div class="input-group">
							              <input type="hidden" class="form-control" id="idDep" name="idDep">
							              <input type="text" class="form-control" id="edtNomeDep" name="edtNomeDep" required>
							              <span class="input-group-addon"><span class="fa fa-users"></span></span>
							            </div>
							          </div>							          
							          <button type="submit" class="btn btn-success" id="btnEditDep">Salvar</button>
							        
    							</form>

                            </div>
                        </div>
                    </div>  
                </div>
                <div class="modal-footer">
                	            
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                   
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteDep" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
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

                                <form method="post" id="frmDeleteDep" >							        
							          <div class="form-group">
							            <div class="input-group">
							              <input type="hidden" class="form-control" id="idDep" name="idDep">
							              
							              <span class="input-group-addon" id="labelDep" style="font-size: 15px;"><span class="fa fa-users" ></span></span>
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
		$('#frmCadDep').submit(function(){
			var tipo = "cadDep";		
			var nomeDep = $("#nomeDep").val();
			
			$.ajax({ //Função AJAX
					url:"../core/save.php",			//Arquivo php
					type:"post",				//Método de envio
					data: {tipo:tipo, nomeDep:nomeDep},	//Dados
					success: function (result){	
		   				//alert(result)
		   				if(result==1){	
		   					swal({
								title: "OK!",
								text: "Departamento Cadastrado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},

							function(isConfirm){
								if (isConfirm) {
										window.location = "cad_dep.php";
									}
							});

		   					$("#nomeDep").val(''); 

		   				}else{
		                	alert("Erro ao salvar");		//Informa o erro
		                		}
		                	}
		                });

				return false;//Evita que a página seja atualizada
			});

		 $(document).on("click", "#btnEditar", function () {
		        var id = $(this).data('codigo');
		        var nome = $(this).data('nome');
		         
		            
		        $('#idDep').val(id);
		        $('#edtNomeDep').val(nome);            
            
        });

		 $('#frmEdtDep').submit(function(){
			var tipo = "EditDep";		
			var id = $('#idDep').val();
			var nomeDep = $('#edtNomeDep').val();
			
			$.ajax({ //Função AJAX
					url:"../core/save.php",			//Arquivo php
					type:"post",				//Método de envio
					data: {tipo:tipo, id:id, nomeDep:nomeDep},	//Dados
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
										window.location = "cad_dep.php";
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
										window.location = "cad_dep.php";
									}
							});
		                }
		            }
		    });

				return false;
			});

		  $(document).on("click", "#btnExcluir", function () {
		        var id = $(this).data('codigo');
		        var nome = $(this).data('nome');		         
		            
		        $('#idDep').val(id);
		        $('#labelDep').html("Você vai excluir o departamento <strong>"+nome+"?</strong>");            
            
        });


		$('#frmDeleteDep').submit(function(){
			var tipo = "deleteDep";		
			var id = $('#idDep').val();
			
			
			$.ajax({ //Função AJAX
					url:"../core/save.php",			//Arquivo php
					type:"post",				//Método de envio
					data: {tipo:tipo, id:id},	//Dados
					success: function (result){	
		   				//alert(result)
		   				if(result==1){
		   					swal({
								title: "OK!",
								text: "Departamento Excluído com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},

							function(isConfirm){
								if (isConfirm) {
										window.location = "cad_dep.php";
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
										window.location = "cad_dep.php";
									}
							});
		                }
		            }
		    });

				return false;
			});


	});
</script>