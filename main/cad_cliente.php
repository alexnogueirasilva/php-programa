<?php
require_once 'cabecalho.php';
require_once '../vendor/autoload.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';

$queryCliente = "SELECT * FROM cliente WHERE fk_idInstituicao =  '" . $idInstituicao . " '";

?>
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-12">

		</div>
		<!-- /.col-lg-12 -->
	</div>

	<h1>Cadastro de Clientes</h1>
	<h4>Insira os dados do novo Cliente</h4>
	<form id="cdt">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-inline">
					<div class="form-group">
						<input type="text" hidden id="tipo" name="tipo" value="criarCliente">
						<div class="input-group">
							<input type="text" class="form-control" size="70" name="cdtnomeCliente" id="cdtnomeCliente" placeholder="Nome Cliente" required value="">
							<input type="hidden" value="<?php echo $idInstituicao; ?>" name="idInstituicao" id="idInstituicao">
							<span class="input-group-addon"><span class="fa fa-user"></span></span>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" size="50" name="cdtnomeFantasiaCliente" id="cdtnomeFantasiaCliente" placeholder="Nome fantasia Cliente" required value="">
							<span class="input-group-addon"><span class="fa fa-user"></span></span>
						</div>
					</div>
					<br>
					<br>
					<div class="form-group">
						<div class="input-group">
							<select class="form-control" name="status" id="status" required="true">
								<option value="">Selecione o Status</option>
								<option value="A">1 - Ativado</option>
								<option value="D">2 - Desativado</option>
							</select>
							<span class="input-group-addon"><span class="fa fa-signal"></span></span>
						</div>

						<div class="form-group">
							<div class="input-group">
								<select class="form-control" name="cdtTipoCliente" id="cdtTipoCliente" required="true">
									<option value="">Selecione o Tipo do Cliente</option>
									<option value="Estadual">1 - Estadual</option>
									<option value="Federal">2 - Federal</option>
									<option value="Municipal">3 - Municipal</option>
									<option value="Privado">4 - Privado</option>
								</select>
							</div>
						</div>
					</div>
					<br><br>
					<button type="submit" class="btn btn-info btn-lg btn-block" id="btnSalvaCliente"><span class="fa fa-save"></span> Salvar</button>
				</div>

			</div>
	</form>

	<!-- LISTAR cliente-->
	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<hr>

				<div class="col-sm-6">
					<h3>Lista de Clientes</h3>
				</div>

				<table id="tabela" class="table table-striped">
					<thead>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Nome Fantasia</th>
							<th>Tipo</th>
							<th>Status</th>
							<th>Alterar</th>
							<th>Excluir</th>
							<th>Desativar</th>
							<th>Ativar</th>
						</tr>
					<tfoot>
						<tr>
							<th>Código</th>
							<th>Nome</th>
							<th>Nome Fantasia</th>
							<th>Tipo</th>
							<th>Status</th>
							<th>Alterar</th>
							<th>Excluir</th>
							<th>Desativar</th>
							<th>Ativar</th>
						</tr>
					</tfoot>
					</thead>
					<tbody>

						<?php
						$dados = crud::dataview($queryCliente);

						if ($dados->rowCount() > 0) {
							while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
								?>
								<tr>
									<td><?php print($row['codCliente']); ?></td>
									<td><?php print($row['nomeCliente']); ?></td>
									<td><?php print($row['nomeFantasiaCliente']); ?></td>
									<td><?php print($row['tipoCliente']); ?></td>
									<td id="status"><?php print($row['status']); ?></td>
									<td><a class="btn btn-info waves-effect waves-light" id="btnEdita" data-toggle="modal" data-target="#modalEditaCliente" data-whatever="@getbootstrap" data-codigo="<?php print($row['codCliente']); ?>" data-nome="<?php print($row['nomeCliente']); ?>" data-nomefantasia="<?php print($row['nomeFantasiaCliente']); ?>" data-statusatual="<?php print($row['status']); ?>" data-tipoatual="<?php print($row['tipoCliente']); ?>" data-idinstituicao="<?php print($row['fk_idInstituicao']); ?>">Editar</a></td>

									<td><a class="btn btn-danger waves-effect waves-light" data-target="#modalExluirCliente" data-whatever="@getbootstrap" id="btnExcluiCliente" data-codigo="<?php print($row['codCliente']); ?>" data-nome="<?php print($row['nomeCliente']); ?>" data-statusatual="<?php print($row['status']); ?>" data-idinstituicao="<?php print($row['fk_idInstituicao']); ?>">Excluir</a></td>
									<td><a class="btn btn-danger waves-effect waves-light" data-target="#modalConfirmacaoDesativa" data-whatever="@getbootstrap" id="btnDesativa" data-codigo="<?php print($row['codCliente']); ?>" data-statusatual="<?php print($row['status']); ?>" data-nome="<?php print($row['nomeCliente']); ?>" data-idinstituicao="<?php print($row['fk_idInstituicao']); ?>">Desativar</a></td>

									<td><a class="btn btn-info waves-effect waves-light" data-target="#modalConfirmacaoAtiva" data-whatever="@getbootstrap" id="btnAtiva" data-codigo="<?php print($row['codCliente']); ?>" data-statusatual="<?php print($row['status']); ?>" data-nome="<?php print($row['nomeCliente']); ?>" data-idinstituicao="<?php print($row['fk_idInstituicao']); ?>">Ativa</a></td>
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
					<input type="hidden" name="idInstituicaoDes" id="idInstituicaoDes">
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
					<input type="hidden" name="idInstituicaoAt" id="idInstituicaoAt">
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
					<input type="hidden" name="excidInstituicao" id="excidInstituicao">
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
								<input type="hidden" name="edtidInstituicao" id="edtidInstituicao">
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
												<input type="text" class="form-control" size="50" name="edtnomefantasia" id="edtnomefantasia">
												<span class="input-group-addon"><span class="fa fa-user"></span></span>
											</div>
										</div>

										<div class="form-group">
											<div class="input-group">
												<select class="form-control" name="edtstatus" id="edtstatus" required="true">
													<option value="">Status</option>
													<option value="A">1 - Ativado</option>
													<option value="D">2 - Desativado</option>
												</select>
												<span class="input-group-addon"><span class="fa fa-signal"></span></span>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<select class="form-control" name="edttipo" id="edttipo" required="true">
													<option value="">Tipo Cliente</option>
													<option value="Estadual">1 - Estadual</option>
													<option value="Federal">2 - Federal</option>
													<option value="Municipal">3 - Municipal</option>
												</select>
												<span class="input-group-addon"><span class="fa fa-signal"></span></span>
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

		$("#cdt").submit(function(e) {
			e.preventDefault();
			$.ajax({ //Função AJAX
				url: "../core/save.php", //Arquivo php
				type: "POST", //Método de envio
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					alert("resultado: " +result);		
					if (result == 1) {
						swal({
								title: "OK!",
								text: " Cadastrado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_cliente.php";
								}
							});
						$("#cdtnomeCliente").val('');
						$("#cdtnomeFantasiaCliente").val('');
						$("#cdtTipoCliente").val('');

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
									window.location = "cad_cliente.php";
								}
							});
					}
				}
			});
		});

		$(document).on("click", "#btnAtiva", function() {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');
			var idInstituicao = $(this).data('idinstituicao');
			if (status == "A") {
				alert("Cliente já está Ativo!");
			} else {
				$('#modalConfirmacaoAtiva').modal('show');
			}
			$('#codigoClienteAt').val(id);
			$('#statusAtualAt').val(status);
			$('#nomeClienteAt').html(nome);
			$('#idInstituicaoAt').val(idInstituicao);


		});

		$(document).on("click", "#btnDesativa", function() {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');
			var idInstituicao = $(this).data('idinstituicao');

			if (status == "D") {
				alert("Cliente já está Desativado!");
			} else {
				$('#modalConfirmacaoDesativa').modal('show');
			}
			$('#codigoClienteDes').val(id);
			$('#statusAtualDes').val(status);
			$('#nomeClienteDes').html(nome);
			$('#idInstituicaoDes').val(idInstituicao);
		});

		$(document).on("click", "#btnExcluiCliente", function() {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var nome1 = $(this).data('nome');
			var status = $(this).data('statusatual');
			var idInstituicao = $(this).data('idinstituicao');

			$('#excIdCliente').val(id);
			$('#ExcNomeCliente').html(nome);
			$('#excStatusCliente').val(status);
			$('#excidInstituicao').val(idInstituicao);

			$('#modalExluirCliente').modal('show');
		});

		$(document).on("click", "#btnEdita", function() {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var nomeFantasia = $(this).data('nomefantasia');
			var status = $(this).data('statusatual');
			var tipoCliente = $(this).data('tipoatual');
			var idInstituicao = $(this).data('idinstituicao');

			$('#idcliente').val(id);
			$('#edtnome').val(nome);
			$('#edtnomefantasia').val(nomeFantasia);
			$('#edtstatus').val(status);
			$('#edttipo').val(tipoCliente);
			$('#edtidInstituicao').val(idInstituicao);
			$('#modalEditaCliente').modal('show');
		});

		$('#btnExcluirCliente').click(function() {
			var tipo = "excluirCliente";
			var codCliente = $('#excIdCliente').val();
			var status = $('#excStatusCliente').val();
			var idInstituicao = $("#excidInstituicao").val();

			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					codCliente: codCliente,
					idInstituicao: idInstituicao
				},
				success: function(result) {
					//alert("resultado: "+result);			
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
			alert(id + " - " + idInstituicao);
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
			//alert(id+" - "+ idInstituicao);
			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					id: id,
					idInstituicao: idInstituicao
				},
				success: function(result) {
					//	alert("resuldado: "+result);
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
					//alert(result);
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
									window.location = "cad_cliente.php";
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
									window.location = "cad_cliente.php";
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