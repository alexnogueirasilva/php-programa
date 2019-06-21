<?php
require_once 'cabecalho.php';
require_once '../vendor/autoload.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';

$queryInstituicao = "SELECT * FROM instituicao ";

?>
<div class="container-fluid">
	<h1>Cadastro de Instituicao</h1>
	<form id="frmInstituicao">
		<div class="row">
			<div class="col-lg-12">
			<div class="form-group">
			 <input type="text" hidden id="tipo" name="tipo" value="cadastrarInstituicao">	
						<div class="input-group">
							<label for="nomeInstituicao" class="control-label">Nome </label>
							<input type="text" class="form-control" size="100" name="nomeInstituicao" id="nomeInstituicao" placeholder="Nome Instituicao" required value="">
							<input type="hidden" name="idInstituicao" id="idInstituicao">
							<input type="hidden" value="<?php echo $dataAtual ; ?>" name="dataAtual" id="dataAtual">
						</div>
					</div>
				<div class="form-inline">
					
					<div class="form-group">
						<div class="input-group">
							<label for="nomeFantasia" class="control-label">Nome Fantasia </label>
							<input type="text" class="form-control" size="55" name="nomeFantasia" id="nomeFantasia" placeholder="Nome Fantasia" required value="">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<label for="codigoAcesso" class="control-label">Codigo de Acesso</label>
							<input type="text" class="form-control" size="10" minlength="8" maxlength="8" name="codigoAcesso" id="codigoAcesso" placeholder="Codigo de acesso de 8 caracteres" required value="">
						</div>
					</div>
					<br>
				</div>
				<br>
				<button type="submit" class="btn btn-info btn-lg btn-block" id="btnSalvaSla"><span class="fa fa-save"></span> Salvar</button>
			</div>
		</div>
	</form>

	<!-- LISTAR cliente-->
	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<div class="col-sm-6">
					<h2>Lista de Instituicao -
						<button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalPesquisar" data-whatever="@getbootstrap"><span class="fa fa-search"></span></span>Pesquisar Instituicao</button>
					</h2>
				</div>

				<table id="tabela" class="table table-striped">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Tipo</th>
							<th>Status</th>
							<th>Alterar</th>
							<th>Alterar</th>
							<th>Excluir</th>
						</tr>
					<tfoot>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Tipo</th>
							<th>Status</th>
							<th>Alterar</th>
							<th>Alterar</th>
							<th>Excluir</th>
						</tr>
					</tfoot>
					</thead>
					<tbody>

						<?php
						$dados = crud::dataview($queryInstituicao);

						if ($dados->rowCount() > 0) {
							while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
								?>
								<tr>
									<td><?php print($row['inst_id']); ?></td>
									<td><?php print($row['inst_nome']); ?></td>
									<td><?php print($row['inst_nomeFantasia']); ?></td>
									<td><?php print(crud::formataData($row['inst_dataCadastro'])); ?></td>
									<td><a class="btn btn-info waves-effect waves-light" id="btnEditar" data-whatever="@getbootstrap" data-codigo="<?php print($row['inst_id']); ?>" data-codigoacesso="<?php print($row['inst_codigo']); ?>" data-nome="<?php print($row['inst_nome']); ?>" data-nomefantasia="<?php print($row['inst_nomeFantasia']); ?>" >Editar</a></td>
									<td><a class="btn btn-info waves-effect waves-light" id="btnLimpar" data-whatever="@getbootstrap" data-codigo="<?php print($row['inst_id']); ?>" data-id="<?php print($row['inst_codigo']); ?>" data-nome="<?php print($row['inst_nome']); ?>" data-nomefantasia="<?php print($row['inst_nomeFantasia']); ?>" data-tipoatual="<?php print($row['tipoCliente']); ?>">Limpar</a></td>

									<td><a class="btn btn-danger waves-effect waves-light" data-target="#modalExluirCliente" data-whatever="@getbootstrap" id="btnExcluiCliente" data-codigo="<?php print($row['inst_id']); ?>" data-id="<?php print($row['inst_codigo']); ?>" data-nome="<?php print($row['inst_nome']); ?>" data-nomefantasia="<?php print($row['inst_nomeFantasia']); ?>">Excluir</a></td>
								</tr>
							<?php
						}
					} else {
						echo "<p class='text-danger'>Sem informacoes cadastradas</p>";
					}
					?>

					</tbody>
				</table>
			</div>
		</div>
	</div>
	<!-- LISTAR cliente-->
</div>
</div>

<!-- MODAL pesqusiar cliente-->
<div class="modal fade bs-example-modal-lg" id="modalPesquisar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" name="codigoClienteDes" id="codigoClienteDes">
					<input type="hidden" name="statusAtualDes" id="statusAtualDes">
					<input type="hidden" value="<?php echo $idInstituicao; ?>" name="idInstituicaoDes" id="idInstituicaoDes">
					<div class="col-md-12">
						<!-- LISTAR cliente-->

						<div class="row">
							<div class="col-sm-12">
								<div class="white-box">
									<hr>

									<div class="col-sm-6">
										<h3>Lista de Instituicao</h3>
									</div>

									<table id="tabela" class="table table-striped">
										<thead>
											<tr>
												<th>Código</th>
												<th>Nome</th>
												<th>Nome fantasia</th>
												<th>Data</th>
												<th>Alterar</th>
												<th>Excluir</th>
											</tr>
										<tfoot>
											<tr>
												<th>Código</th>
												<th>Nome</th>
												<th>Nome fantasia</th>
												<th>Data</th>
												<th>Alterar</th>
												<th>Excluir</th>
											</tr>
										</tfoot>
										</thead>
										<tbody>

											<?php
											$dados = crud::dataview($queryInstituicao);

											if ($dados->rowCount() > 0) {
												while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
													?>
													<tr>
														<td><?php print($row['inst_id']); ?></td>
														<td><?php print($row['inst_nome']); ?></td>
														<td><?php print($row['inst_nomeFantasia']); ?></td>
														<td><?php print(crud::formataData($row['inst_dataCadastro'])); ?></td>
														<td><a class="btn btn-info waves-effect waves-light" id="btnEditar" data-whatever="@getbootstrap" data-codigo="<?php print($row['inst_id']); ?>" data-id="<?php print($row['inst_codigo']); ?>" data-nome="<?php print($row['inst_nome']); ?>" data-nomefantasia="<?php print($row['inst_nomeFantasia']); ?>">Editar</a></td>

														<td><a class="btn btn-danger waves-effect waves-light" data-target="#modalExluirCliente" data-whatever="@getbootstrap" id="btnExcluiCliente2" data-codigo="<?php print($row['inst_id']); ?>" data-id="<?php print($row['inst_codigo']); ?>" data-nome="<?php print($row['inst_nome']); ?>" data-nomefantasia="<?php print($row['inst_nomeFantasia']); ?>">Excluir</a></td>
													</tr>
												<?php
											}
										} else {
											echo "<p class='text-danger'>Sem informacoes cadastradas</p>";
										}
										?>

										</tbody>
									</table>

								</div>
							</div>
						</div>

						<!-- LISTAR cliente-->

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnDesativaCliente" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL pesqusiar cliente-->

<!-- MODAL desativar cliente-->
<div class="modal fade" id="modalConfirmacaoDesativa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" name="codigoClienteDes" id="codigoClienteDes">
					<input type="hidden" name="statusAtualDes" id="statusAtualDes">
					<input type="hidden" value="<?php echo $idInstituicao; ?>" name="idInstituicaoDes" id="idInstituicaoDes">
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai DESATIVAR o Cliente: <span id="nomeClienteDes"></span>?</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnDesativaCliente" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL desativar cliente-->

<!-- MODAL ativar cliete -->
<div class="modal fade" id="modalConfirmacaoAtiva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" name="codigoClienteAt" id="codigoClienteAt">
					<input type="hidden" name="statusAtualAt" id="statusAtualAt">
					<input type="hidden" value="<?php echo $idInstituicao; ?>" name="idInstituicaoAt" id="idInstituicaoAt">
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai ATIVAR o cliente: <span id="nomeClienteAt"></span>?</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnAtivaCliente" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL ativar cliete -->

<!-- MODAL EXCLUIR cliente-->
<div class="modal fade" id="modalExluirCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">

					<input type="hidden" name="excIdCliente" id="excIdCliente">
					<input type="hidden" name="excStatusCliente" id="excStatusCliente">
					<input type="hidden" value="<?php echo $idInstituicao; ?>" name="excidInstituicao" id="excidInstituicao">
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai EXCLUIR o Cliente: <span id="ExcNomeCliente"></span>?</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnExcluirCliente" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL EXCLUIR cliente-->

<!-- MODAL editar cliente-->
<div class="modal fade" id="modalEditaCliente" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
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
							<form id="edtcliente">
								<input type="text" hidden name="tipo" value="editaCliente">
								<input type="hidden" name="idcliente" id="idcliente">
								<input type="hidden" value="<?php echo $idInstituicao; ?>" name="editaidInstituicao" id="editaidInstituicao">
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
												<input type="text" class="form-control" size="50" name="edtnomeFantasia" id="edtnomeFantasia">
												<span class="input-group-addon"><span class="fa fa-user"></span></span>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control" size="50" name="codigoInstituicao" id="codigoInstituicao">
												<span class="input-group-addon"><span class="fa fa-user"></span></span>
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
<!-- MODAL editar cliente-->


<?php

require_once "rodape.php";
?>
<script type="text/javascript">
	$(document).ready(function() {
		permissaoNivel();
		$("#frmInstituicao").submit(function(e) {
			e.preventDefault();			
			$.ajax({ //Função AJAX
				url: "../core/save.php", //Arquivo php
				type: "POST", //Método de envio				
				data: new FormData(this),
				tipo:tipo,
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {
					alert("resultado: " +data);				
					if (data == 1) {
						swal({
								title: "OK!",
								text: " Cadastrado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_instituicao.php";
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
									window.location = "cad_instituicao.php";
								}
							});						
					}
				}
			});
			
		});
		$(document).on("click", "#btnLimpar", function() {
			limparCampos();
			$("#codigoAcesso").prop("disabled", false); 		
		});
		$(document).on("click", "#btnEditar", function() {
			//limparCampos();		
			var codigo 		 = $(this).data('codigo');
			var nome 		 = $(this).data('nome');
			var nomeFantasia = $(this).data('nomefantasia');
			var codigoAcesso = $(this).data('codigoacesso');
			
			$("#codigoAcesso").prop("disabled", true); 
			$('#idInstituicao').val(codigo);
			$('#codigoAcesso').val(codigoAcesso);
			$('#nomeInstituicao').val(nome);
			$('#nomeFantasia').val(nomeFantasia);
			
		});
		function limparCampos() {
			$("#codigoAcesso").val('');
			$("#idInstituicao").val('');
			$("#nomeInstituicao").val('');
			$('#nomeFantasia').val('');
			$('#nome').val('');
		}
		$(document).on("click", "#btnAtiva", function() {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');
			if (status == "A") {
				alert("Cliente já está Ativo!");
			} else {
				$('#modalConfirmacaoAtiva').modal('show');
			}
			$('#codigoClienteAt').val(id);
			$('#statusAtualAt').val(status);
			$('#nomeClienteAt').html(nome);


		});

		$(document).on("click", "#btnDesativa", function() {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');

			if (status == "D") {
				alert("Cliente já está Desativado!");
			} else {
				$('#modalConfirmacaoDesativa').modal('show');
			}
			$('#codigoClienteDes').val(id);
			$('#statusAtualDes').val(status);
			$('#nomeClienteDes').html(nome);

		});

		$(document).on("click", "#btnExcluiCliente2", function() {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var nome1 = $(this).data('nome');
			var status = $(this).data('statusatual');

			$('#excIdCliente').val(id);
			$('#ExcNomeCliente').html(nome);
			$('#excStatusCliente').val(status);
			$('#modalPesquisar').modal('hide');
			$('#modalExluirCliente').modal('show');
		});
		$(document).on("click", "#btnExcluiCliente", function() {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var nome1 = $(this).data('nome');
			var status = $(this).data('statusatual');

			$('#excIdCliente').val(id);
			$('#ExcNomeCliente').html(nome);
			$('#excStatusCliente').val(status);
			$('#modalExluirCliente').modal('show');
		});

		$(document).on("click", "#btnEditar", function() {
			//limparCampos();		
			var codigo 		 = $(this).data('codigo');
			var nome 		 = $(this).data('nome');
			var nomeFantasia = $(this).data('nomefantasia');
		
			$('#idInstituicao').val(codigo);
			$('#nomeInstituicao').val(nome);
			$('#nomeFantasia').val(nomeFantasia);
			
		});
		$(document).on("click", "#btnEditar", function() {
			var id = $(this).data('codigo');
			var codigo = $(this).data('id');
			var nome = $(this).data('nome');
			var nomeFantasia = $(this).data('nomefantasia');
			var status = $(this).data('statusatual');
			var tipoCliente = $(this).data('tipoatual');

			$('#idcliente').val(id);
			$('#cdtCodigo').val(codigo);
			$('#cdtnomeCliente').val(nome);
			$('#edtnome').val(nome);
			$('#cdtnomeFantasiaCliente').val(nomeFantasia);
			$('#edtstatus').val(status);
			$('#edttipo').val(tipoCliente);
			$('#modalPesquisar').modal('hide');
		});

		$('#btnExcluirCliente').click(function() {
			var tipo = "excluirCliente";
			var idCliente = $('#excIdCliente').val();
			var status = $('#excStatusCliente').val();
			var idInstituicao = $("#excidInstituicao").val();
			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					codCliente: idCliente,
					idInstituicao: idInstituicao
				},
				success: function(result) { //alert(result);			
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Cliente Excluído com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_cliente.php";
								}
							});
					} else {
						swal({
								title: "Ops!",
								text: "Algo deu errado ao excluir! ",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_cliente.php";
								}
							});
					}
				}
			});
		});

		$('#btnDesativaCliente').click(function() {
			var tipo = "desativaCliente";
			var id = $('#codigoClienteDes').val();
			var status = $('#statusAtualDes').val();
			var idInstituicao = $("#idInstituicaoDes").val();
			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					id: id,
					idInstituicao: idInstituicao
				},
				success: function(result) {
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Clinte desativado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									//	$('#modalConfirmacaoDesativa').modal('hide');
									window.location = "cad_cliente.php";
								}
							});
					} else {
						swal({
								title: "Ops!",
								text: "Algo deu errado ao desativar o cliente!",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_cliente.php";
								}
							});
						//	alert(result);
						//alert("Erro ao salvar");
					}
				}
			});
		});

		$('#btnAtivaCliente').click(function() {
			var tipo = "ativaCliente";
			var id = $('#codigoClienteAt').val();
			var status = $('#statusAtualAt').val();
			var idInstituicao = $("#idInstituicaoAt").val();
			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					id: id,
					idInstituicao: idInstituicao
				},
				success: function(result) {
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Clinte ativado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									//	$('#modalConfirmacaoDesativa').modal('hide');
									window.location = "cad_cliente.php";
								}
							});
					} else {
						swal({
								title: "Ops!",
								text: "Algo deu errado ao ativar o cliente!",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_cliente.php";
								}
							});
						//	alert(result);
						//alert("Erro ao salvar");
					}

				}
			});

		});

		$('#edtcliente').submit(function() {
			$.ajax({ //Função AJAX
				url: "../core/save.php",
				type: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Cliente editado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_instituicao.php";
								}
							});
					} else {
						swal({
								title: "Ops!",
								text: "Algo deu errado ao editar cliente!",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_instituicao.php";
								}
							});
					}
				}
			});
			return false; //Evita que a página seja atualizada
		});


		$("#tbl-user").DataTable({
			//TRADUÇÃO DATATABLE
			"oLanguage": {
				"sProcessing": "Processando...",
				"sLengthMenu": "Mostrar _MENU_ registros",
				"sZeroRecords": "Não foram encontrados resultados",
				"sInfo": "",
				"sInfoEmpty": "",
				"sInfoFiltered": "",
				"sInfoPostFix": "",
				"sSearch": "Buscar:",
				"sUrl": "",
				"oPaginate": {
					"sFirst": "Primeiro",
					"sPrevious": "Anterior",
					"sNext": "Seguinte",
					"sLast": "Último"
				}
			}
		});
	});
	//BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME
	$("tr #status").each(function(i) {
		if ($(this).text() == "D") {
			this.style.color = "white";
			this.style.background = "red";
		} else {
			this.style.color = "white";
			this.style.background = "green";
		}
	});
</script>