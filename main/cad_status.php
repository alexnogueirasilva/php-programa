<?php
require_once 'cabecalho.php';
require_once '../vendor/autoload.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
include_once 'Models/DAO/StatusDAO.php';
?>
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-12">

		</div>
		<!-- /.col-lg-12 -->
	</div>
	<h1>Cadastro de Status</h1><br>
	<h4>Cadastro de Status</h4>
	<form id="frmCadastroStatus">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-inline">
					<div class="form-group">
						<input type="text" hidden id="tipo" name="tipo" value="CadastroStatus">
						<div class="input-group">
							<input type="text" class="form-control" size="40" name="descricao" id="descricao" placeholder="Descrição" required>
							<span class="input-group-addon"><span class="fa fa-hourglass-half"></span></span>
						</div>
					</div>
				</div>
				<br><br>
				<button type="submit" class="btn btn-info btn-lg btn-block" id="btnSalvaStatus"><span class="fa fa-save"></span> Salvar</button>
			</div>

		</div>
	</form>
	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<hr>

				<div class="col-sm-6">
					<h3>Lista de Status</h3>
				</div>

				<table id="tabela" class="table table-striped">
					<thead>
						<tr>
							<th>Código</th>
							<th>Descrição</th>
							<th>Data Cadastro</th>
							<th>Editar</th>
							<th>Excluir</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$dados = StatusDAO::listar();
						if ($dados->rowCount() > 0) {
							while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
								?>
								<tr>
									<td><?php print($row['codStatus']); ?></td>
									<td><?php print($row['nome']); ?></td>
									<td><?php print(crud::formataData($row['dataCadastro'])); ?></td>
									<td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalEditarStatus" data-whatever="@getbootstrap" id="btnEditar" class="btn btn-danger waves-effect waves-light" data-codigo="<?php print($row['codStatus']); ?>" data-datacadastro="<?php print(crud::formataData($row['dataCadastro'])); ?>" data-descricao="<?php print($row['nome']); ?>">Editar</a></td>

									<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalDeleteStatus" data-whatever="@getbootstrap" id="btnExcluir" class="btn btn-info waves-effect waves-light" data-codigo="<?php print($row['codStatus']); ?>" data-descricao="<?php print($row['nome']); ?>">Excluir</a></td>
								</tr>
							<?php
						}
					} else {
						echo "<p class='text-danger'>Não há Status Cadastrados</p>";
					}
					?>

					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
</div>

<div class="modal fade" id="modalEditarStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Editar</h4>
			</div>
			<div class="modal-body">
				<form id="frmEditarStatus">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-inline">
								<div class="form-group">
									<input type="hidden" id="tipo" name="tipo" value="editarStatus">
									<input type="hidden" id="edtId" name="edtId">
									<div class="input-group">
										<input type="text" class="form-control" size="40" name="edtDescricao" id="edtDescricao" required>
										<span class="input-group-addon"><span class="fa fa-hourglass-half"></span></span>
									</div>
								</div>
							</div>
							<br><br>
							<button type="submit" class="btn btn-info btn-lg btn-block" id="btnEdtStatus"><span class="fa fa-save"></span> Salvar</button>
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
<!-- MODAL EXCLUIR-->
<div class="modal fade" id="modalDeleteStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Alerta</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" class="form-control" id="idStatus" name="idStatus">
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai EXCLUIR o status: <span id="ExcNomeStatus"></span>?</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success" id="btnDeleteStatus">Confirmar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

			</div>

		</div>
	</div>
</div>
<!-- MODAL EXCLUIR-->
<?php
require_once "rodape.php";
?>

<script type="text/javascript">
	$(document).ready(function() {

		permissaoNivel();
		$("#frmCadastroStatus").submit(function(e) {
			e.preventDefault();
			$.ajax({ //Função AJAX
				url: "Controller/StatusController.php", //Arquivo php
				type: "POST", //Método de envio
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {

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
									window.location = "cad_status.php";
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
									window.location = "cad_status.php";
								}
							});
					}
				}
			});
			return false; //Evita que a página seja atualizada
		});

		$(document).on("click", "#btnEditar", function() {
			var id = $(this).data('codigo');
			var desc = $(this).data('descricao');
			var dataCadastro = $(this).data('datacadastro');

			$('#edtId').val(id);
			$('#edtDescricao').val(desc);
			$('#edtDataCadastro').val(dataCadastro);

		});

		$('#frmEditarStatus').submit(function(e) {
			e.preventDefault();

			$.ajax({ //Função AJAX
				url: "Controller/StatusController.php", //Arquivo php
				type: "POST", //Método de envio
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Dados Alterados Com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_status.php";
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
									window.location = "cad_status.php";
								}
							});
					}
				}
			});
			return false;
		});

		$(document).on("click", "#btnExcluir", function() {
			var id = $(this).data('codigo');
			var desc = $(this).data('descricao');

			$('#idStatus').val(id);
			$('#ExcNomeStatus').html(desc);
			// $('#labelStatus').html("Você vai excluir cadastro do status: <strong> "+ id +" - "  +desc+"?</strong>");             
		});

		$('#btnDeleteStatus').click(function() {

			var tipo = "excluirStatus";
			var id = $('#idStatus').val();

			$.ajax({ //Função AJAX
				url: "Controller/StatusController.php", //Arquivo php
				type: "POST", //Método de envio
				tipo: "excluirStatus",
				data: {
					tipo: tipo,
					id: id
				},
				success: function(result) {
					alert(result)
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Excluído com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_status.php";
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
									window.location = "cad_status.php";
								}
							});
					}
				}
			});
			return false;
		});
	});
</script>