<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';

$queryDepart = "SELECT * FROM departamentos";

$queryUsuarios = "SELECT usr.id, usr.nome, usr.email, usr.nivel,usr.status,usr.id_dep, dep.nome as nome_dep FROM usuarios as usr INNER JOIN departamentos as dep ON usr.id_dep = dep.id ORDER BY status ASC";

?>
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-12">                   

		</div>
		<!-- /.col-lg-12 -->
	</div>
	
	<h1>Cadastra Usuário</h1><h4>Insira os dados do novo usuário</h4>
	<form id="cdt">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-inline">
					<div class="form-group">
						<input type="text" hidden id="tipo" value="criaUsr">					
						<div class="input-group">
							
							<input type="text" class="form-control" size="50" name="nome" id="nome" placeholder="Nome completo" required value="">
							<span class="input-group-addon"><span class="fa fa-user"></span></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<input type="email" class="form-control" size="50" id="email" name="email" placeholder="E-mail" required >
							<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
						</div>
					</div>
				</div>	
				<br>

				<div class="form-inline">
					
					<div class="form-group">
						<div class="input-group">
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
							<span class="input-group-addon"><span class="fa fa-users"></span></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<select class="form-control" name="nivelUser" id="nivelUser" required="true">
								<option value="">Nível</option>
								<option value="1">1 - Administrador</option>
								<option value="2">2 - Usuário</option>
							</select>
							<span class="input-group-addon"><span class="fa fa-signal"></span></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control" id="uPass" name="uPass" placeholder="Senha" required >
							<span class="input-group-addon"><span class="fa fa-key"></span></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control" id="uPass2" name="uPass2" placeholder="Repita a Senha" required value="">
							<span class="input-group-addon"><span class="fa fa-key"></span></span>
						</div>
					</div>					
				</div>				
				<br><br>
				<button type="submit" class="btn btn-info btn-lg btn-block" id="submit"><span class="fa fa-save"></span> Salvar</button>
			</div>

		</div>
	</form>


	<!-- LISTAGEM USUÁRIOS -->

	<div class="row">
		<div class="col-sm-12"> 
			<div class="white-box">
				<hr>

				<div class="col-sm-6"> 
					<h3>Lista de Usuário</h3>
				</div>

				<table id="tbl-user" class="table table-striped">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>E-mail</th>
							<th>Nível</th>                                
							<th>status</th>                                
							<th>Departamento</th>                                
							<th>Editar</th>                                
							<th>Excluir</th>                                
							<th>Desativar</th>                    
							<th>Ativar</th>                    
						</tr>
					</thead>
					<tbody>

						<?php
						$dados = crud::dataview($queryUsuarios);
                                       
						if($dados->rowCount()>0){
							while($row=$dados->fetch(PDO::FETCH_ASSOC)){

								?> 
								<tr>
									<td><?php print($row['id']); ?></td>
									<td><?php print($row['nome']); ?></td>       
									<td><?php print($row['email']); ?></td>       
									<td><?php print($row['nivel']); ?></td>       
									<td><?php print($row['status']); ?></td>       
									<td><?php print($row['nome_dep']); ?></td>
									<td><a class="btn btn-info waves-effect waves-light" id="btnEdita" data-toggle="modal" data-target="#modalEditaUsuario" data-whatever="@getbootstrap"
										data-codigo="<?php print($row['id']); ?>" 
										data-nome="<?php print($row['nome']); ?>"
										data-email="<?php print($row['email']); ?>"
										data-nivel="<?php print($row['nivel']); ?>"
										data-dep="<?php print($row['id_dep']); ?>"
										data-statusatual="<?php print($row['status']); ?>" 

										>Editar</a></td>

									<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalExluirUser" data-whatever="@getbootstrap" id="btnExcluiUser" data-codigo="<?php print($row['id']); ?>" data-nome="<?php print($row['nome']); ?>">Excluir</a></td>                                    
									<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalConfirmacaoDesativa" data-whatever="@getbootstrap" id="btnDesativa" data-codigo="<?php print($row['id']); ?>" data-statusatual="<?php print($row['status']); ?>" data-nome="<?php print($row['nome']); ?>">Desativar</a></td>

									<td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalConfirmacaoAtiva" data-whatever="@getbootstrap" id="btnAtiva" data-codigo="<?php print($row['id']); ?>" data-statusatual="<?php print($row['status']); ?>" data-nome="<?php print($row['nome']); ?>">Ativa</a></td>         
								</tr>
								<?php 
							}

						}else{              
							echo "<p class='text-danger'>Sem demandas abertas</p>";               
						}
						?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	
</div>
<!-- MODAL -->
<div class="modal fade" id="modalConfirmacaoDesativa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" name="codigoUsuario" id="codigoUsuario">
					<input type="hidden" name="statusAtual" id="statusAtual">                        
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai DESATIVAR o usuário: <span id="nomeUsuario"></span>?</h2>
						</div>
					</div>
				</div>  
			</div>
			<div class="modal-footer">              
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnDesativaUsuario" class="btn btn-primary" >Confirmar</button
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL-->
<div class="modal fade" id="modalConfirmacaoAtiva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" name="codigoUsuarioAt" id="codigoUsuarioAt">
					<input type="hidden" name="statusAtualAt" id="statusAtualAt">                        
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai ATIVAR o usuário: <span id="nomeUsuarioAt"></span>?</h2>
						</div>
					</div>
				</div>  
			</div>
			<div class="modal-footer">              
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnAtivaUsuario" class="btn btn-primary" >Confirmar</button
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL EXCLUIR-->
<div class="modal fade" id="modalExluirUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" name="excIdUser" id="excIdUser">
					
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai EXCLUIR o usuário: <span id="ExcNomeUsuario"></span>?</h2>
						</div>
					</div>
				</div>  
			</div>
			<div class="modal-footer">              
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnExcluiUsuario" class="btn btn-primary" >Confirmar</button>				
			</div>
		</div>
	</div>
</div>

<!-- MODAL-->
<div class="modal fade" id="modalEditaUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Editar</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					
					<div class="col-md-12">
						<div id="contextoModal">					

							<form id="edtuser">
								<input type="text" hidden name="tipo" value="editaUsr">					
								<input type="hidden" name="iduser" id="iduser">									
								<div class="row">
									<div class="col-lg-12">
										
											<div class="form-group">												
												<div class="input-group">
													<input type="text" class="form-control" size="50" name="edtnome" id="edtnome">
													<span class="input-group-addon"><span class="fa fa-user"></span></span>
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													<input type="email" class="form-control" size="50" id="edtemail" name="edtemail">
													<span class="input-group-addon"><span class="fa fa-envelope"></span></span>
												</div>
											</div>
										
										

										<div class="form-inline">
											
											<div class="form-group">
												<div class="input-group">
													<select class="form-control" width="100" name="edtdepartamento" id="edtdepartamento" required>
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
													<span class="input-group-addon"><span class="fa fa-users"></span></span>
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													<select class="form-control" name="edtnivelUser" id="edtnivelUser" required="true">
														<option value="">Nível</option>
														<option value="1">1 - Administrador</option>
														<option value="2">2 - Usuário</option>
													</select>
													<span class="input-group-addon"><span class="fa fa-signal"></span></span>
												</div>
											</div>
										</div>
										<br>
											<div class="form-group">
												<div class="input-group">
													<input type="password" class="form-control" id="edtPass" name="edtPass" placeholder="Senha" required >
													<span class="input-group-addon"><span class="fa fa-key"></span></span>
												</div>
											</div>
											<div class="form-group">
												<div class="input-group">
													<input type="password" class="form-control" id="edtPass2" name="edtPass2" placeholder="Repita a Senha" required value="">
													<span class="input-group-addon"><span class="fa fa-key"></span></span>
												</div>
											</div>

										<button type="submit" class="btn btn-info btn-md btn-block" id="submit"><span class="fa fa-save"></span> Salvar</button>

										</div>				
										<br><br>
									</div>

								
							</form>


						</div>
					</div>
				</div>  
			</div>
			<div class="modal-footer">              
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				
				</div>
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
		
		$('#cdt').submit(function(){
			var tipo = "cadUsuario";		
			var nome = $("#nome").val();
			var email = $("#email").val();
			var dep = $("#departamento").val();
			var nivel = $("#nivelUser").val();
			var pass = $("#uPass").val();
			var pass2 = $("#uPass2").val();


			if (pass == pass2) {
			$.ajax({ //Função AJAX
					url:"../core/save.php",			//Arquivo php
					type:"post",				//Método de envio
					data: {tipo:tipo, nome:nome, email:email, nivel:nivel, dep:dep, pass:pass},	//Dados
					success: function (result){	
		   				//alert(result)
		   				if(result==1){	
		   					alert("Cadastrado com Sucesso!");
		   					$("#nome").val('');		                			
		   					$("#email").val('');
		   					$("#nivel").val('');
		   					$("#uPass").val('');
		   					$("#uPass2").val('');
		   					$("#departamento").val('');
		   					$("#nivelUser").val('');

		                			//location.href('index_usr.php')
		                		}else{
		                			alert("Erro ao salvar");		//Informa o erro
		                		}
		                	}
		                });
		}else{
			alert("Senhas não são iguais!");
		}
				return false;//Evita que a página seja atualizada
			});


		$(document).on("click", "#btnDesativa", function () {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');
			$('#codigoUsuario').val(id);          
			$('#statusAtual').val(status);          
			$('#nomeUsuario').html(nome);

		});

		$(document).on("click", "#btnAtiva", function () {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');
			$('#codigoUsuarioAt').val(id);          
			$('#statusAtualAt').val(status);          
			$('#nomeUsuarioAt').html(nome);

		});

		$(document).on("click", "#btnExcluiUser", function () {
			var id = $(this).data('codigo');			
			var nome = $(this).data('nome');

			$('#excIdUser').val(id);
			$('#ExcNomeUsuario').html(nome);

		});

		$(document).on("click", "#btnEdita", function () {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var email = $(this).data('email');
			var nivel = $(this).data('nivel');
			var id_dep = $(this).data('dep');
			
			$('#iduser').val(id);          
			$('#edtnome').val(nome);          
			$('#edtemail').val(email);          
			$('#edtdepartamento').val(id_dep);
			$('#edtnivelUser').val(nivel);

		});

		$('#btnExcluiUsuario').click(function(){
			var tipo = "excluiUsuario";
			var idUser = $('#excIdUser').val();
			


			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {tipo : tipo, idUser : idUser},
				success: function(result) {
                    //alert(data);
                    if(result==1){
                       
                    	swal({
							title: "OK!",
							text: "Usuário Excluído com Sucesso!",
							type: "success",
							confirmButtonText: "Fechar",
							closeOnConfirm: false
						},

						function(isConfirm){
							if (isConfirm) {
									window.location = "cad_user.php";
								}
						});
                            
                            
	                }else{
	                    //alert(result);
	                    alert("Erro ao salvar");                            
	                }

                    }
                });

		});


		$('#btnDesativaUsuario').click(function(){
			var tipo = "desativaUsuario";
			var id = $('#codigoUsuario').val();
			var status = $('#statusAtual').val();

			 if (status == "Desativado") {
                alert("Usuário já está desativado!");
                die();
            } 

			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {tipo : tipo, id : id},
				success: function(result) {
                    //alert(data);
                    if(result==1){
                            //alert(result);
                            //alert("Desativado com Sucesso!");
                            //$('#contextoModal').empty().append("<h2>Atualizado</h2>");
                            $('#modalConfirmacaoDesativa').modal('hide');
                            window.location.reload();
                            
                        }else{
                            //alert(result);
                            alert("Erro ao salvar");                            
                        }

                    }
                });

		});

		$('#btnAtivaUsuario').click(function(){
			var tipo = "ativaUsuario";
			var id = $('#codigoUsuarioAt').val();
			var status = $('#statusAtualAt').val();

			 if (status == "Ativo") {
                alert("Usuário já está ATIVO!");
                die();
            }

			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {tipo : tipo, id : id},
				success: function(result) {
                    //alert(data);
                    if(result==1){
                            //alert(result);
                            //alert("Ativado com Sucesso!");
                            //$('#contextoModal').empty().append("<h2>Atualizado</h2>");
                            $('#modalConfirmacaoDesativa').modal('hide');
                            window.location.reload();
                            
                        }else{
                            //alert(result);
                            alert("Erro ao salvar");                            
                        }

                    }
                });

		});

		$('#edtuser').submit(function(){
			
			var pass = $("#edtPass").val();
			var pass2 = $("#edtPass2").val();


			if (pass == pass2) {
				$.ajax({ //Função AJAX
						url: "../core/save.php",
		                type: "POST",             
		                data: new FormData(this), 
		                contentType: false,
		                cache: false,
		                processData:false,
						success: function (result){
			   				//alert(result)
			   				if(result==1){
			   					swal({
									title: "OK!",
									text: "Usuário editado com Sucesso!",
									type: "success",
									confirmButtonText: "Fechar",
									closeOnConfirm: false
								},

								function(isConfirm){
									if (isConfirm) {
											window.location = "cad_user.php";
										}
								});
			                		
	                		}else{
	                			alert("Erro ao salvar");		//Informa o erro
	                		}
			            }
			        });
			}else{

				alert("Senhas não são iguais!");
			}
				return false;//Evita que a página seja atualizada
		});


		$("#tbl-user").DataTable({
               //TRADUÇÃO DATATABLE
                "oLanguage": {
                    "sProcessing":   "Processando...",
                    "sLengthMenu":   "Mostrar _MENU_ registros",
                    "sZeroRecords":  "Não foram encontrados resultados",
                    "sInfo":         "",
                    "sInfoEmpty":    "",
                    "sInfoFiltered": "",
                    "sInfoPostFix":  "",
                    "sSearch":       "Buscar:",
                    "sUrl":          "",
                    "oPaginate": {
                        "sFirst":    "Primeiro",
                        "sPrevious": "Anterior",
                        "sNext":     "Seguinte",
                        "sLast":     "Último"
                    }
                }
            });


	});
</Script>