<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';

$queryCliente = "SELECT * FROM cliente ";

?>
<div class="container-fluid">
	<div class="row bg-title">
		<div class="col-lg-12">

		</div>
		<!-- /.col-lg-12 -->
	</div>

	<h1>Cadastra Cliente</h1>
	<h4>Insira os dados do novo cliente</h4>
	<form id="cdt">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-inline">
					<div class="form-group">
						<input type="text" hidden id="tipo" value="criarCliente">
						<div class="input-group">

							<input type="text" class="form-control" size="70" name="cdtnomeCliente" id="cdtnomeCliente" placeholder="Nome Cliente" required value="">
							<span class="input-group-addon"><span class="fa fa-user"></span></span>
						</div>
					</div>
				</div>
				<br>
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
				<h3>Lista de Clientes</h3>
			</div>

			<table id="tbl-user" class="table table-striped">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nome</th>
						<th>Status</th>
					</tr>
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
								<td id="status"><?php print($row['status']); ?></td>
								<td>
									<a class="btn btn-info waves-effect waves-light" id="btnEdita" data-toggle="modal" data-target="#modalEditaCliente" data-whatever="@getbootstrap" data-codigo="<?php print($row['codCliente']); ?>" data-nome="<?php print($row['nomeCliente']); ?>" data-statusatual="<?php print($row['status']); ?>">Editar</a></td>

								<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalExluirCliente" data-whatever="@getbootstrap" id="btnExcluiCliente" data-codigo="<?php print($row['codCliente']); ?>" data-nome="<?php print($row['nomeCliente']); ?>" data-statusatual="<?php print($row['status']); ?>">Excluir</a></td>
								<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalConfirmacaoDesativa" data-whatever="@getbootstrap" id="btnDesativa" data-codigo="<?php print($row['codCliente']); ?>" data-statusatual="<?php print($row['status']); ?>" data-nome="<?php print($row['nomeCliente']); ?>">Desativar</a></td>

								<td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalConfirmacaoAtiva" data-whatever="@getbootstrap" id="btnAtiva" data-codigo="<?php print($row['codCliente']); ?>" data-statusatual="<?php print($row['status']); ?>" data-nome="<?php print($row['nomeCliente']); ?>">Ativa</a></td>
							</tr>
						<?php
					}
				} else {
					echo "<p class='text-danger'>Sem demandas abertas</p>";
				}
				?>

				</tbody>
			</table>
		</div>
	</div>
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
												<select class="form-control" name="edtstatus" id="edtstatus" required="true">
													<option value="">Status</option>
													<option value="A">1 - Ativado</option>
													<option value="D">2 - Desativado</option>
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
</div>
<!-- MODAL editar cliente-->

<?php
require_once "rodape.php";
?>

<script type="text/javascript">
	$(document).ready(function() {
		permissaoNivel();

		$('#cdt').submit(function() {
			var tipo = "criarCliente";
			var nomeCliente = $("#cdtnomeCliente").val();

			$.ajax({ //Função AJAX
				url: "../core/save.php", //Arquivo php
				type: "post", //Método de envio
				data: {
					tipo: tipo,
					nomeCliente: nomeCliente
				}, //Dados
				success: function(result) {
					//alert(result)
					if (result == 1) {
						alert("Cadastrado com Sucesso!");
						$("#cdtnomeCliente").val('');

						//location.href('index_usr.php')
					} else {
						alert("Erro ao salvar"); //Informa o erro
					}
				}
			});
		});

		$(document).on("click", "#btnAtiva", function() {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');
			$('#codigoClienteAt').val(id);
			$('#statusAtualAt').val(status);
			$('#nomeClienteAt').html(nome);
		});

		$(document).on("click", "#btnDesativa", function() {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');
			$('#codigoClienteDes').val(id);
			$('#statusAtualDes').val(status);
			$('#nomeClienteDes').html(nome);
		});

		$(document).on("click", "#btnExcluiCliente", function() {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var status = $(this).data('statusatual');

			$('#excIdCliente').val(id);
			$('#ExcNomeCliente').html(nome);
			$('#excStatusCliente').val(status);
		});

		$(document).on("click", "#btnEdita", function() {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var status = $(this).data('statusatual');

			$('#idcliente').val(id);
			$('#edtnome').val(nome);
			$('#edtstatus').val(status);
		});

		$('#btnExcluirCliente').click(function() {
			var tipo = "excluirCliente";
			var idCliente = $('#excIdCliente').val();
			//	var nomeCliente = $('#excnomeCliente').val();
			//	var statusCliente = $('#excStatusCliente').val();
			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					codCliente: idCliente
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
						alert(result); //teste
						alert("Erro ao excluir cliente");
					}
				}
			});
		});

		$('#btnDesativaCliente').click(function() {
			var tipo = "desativaCliente";
			var id = $('#codigoClienteDes').val();
			var status = $('#statusAtualDes').val();

			if (status == "D") {
				alert("Cliente já está desativado!");
				$('#modalConfirmacaoDesativa').modal('hide');
				die();
			}
			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					id: id
				},
				success: function(result) {
					//alert(data);
					if (result == 1) {
						//alert(result);
						//alert("Desativado com Sucesso!");
						//$('#contextoModal').empty().append("<h2>Atualizado</h2>");
						$('#modalConfirmacaoDesativa').modal('hide');
						window.location.reload();
					} else {
						//	alert(result);
						alert("Erro ao salvar");
					}
				}
			});
		});

		$('#btnAtivaCliente').click(function() {
			var tipo = "ativaCliente";
			var id = $('#codigoClienteAt').val();
			var status = $('#statusAtualAt').val();

			if (status == "A") {
				alert("Cliente já está ATIVO!");
				$('#modalConfirmacaoAtiva').modal('hide');
				die();
			}

			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					id: id
				},
				success: function(result) {
					//alert(data);
					if (result == 1) {
						//alert(result);
						//alert("Ativado com Sucesso!");
						//$('#contextoModal').empty().append("<h2>Atualizado</h2>");
						$('#modalConfirmacaoAtiva').modal('hide');
						window.location.reload();

					} else {
						//alert(result);
						alert("Erro ao salvar");
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
									window.location = "cad_cliente.php";
								}
							});

					} else {
						alert("Erro ao salvar"); //Informa o erro
					}
				}
			});

			//	return false;//Evita que a página seja atualizada
		});
		
		//BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME
		$("tr #status").each(function(i) {
			if ($(this).text() == "D") {
				this.style.color = "red";
			} else {
				this.style.color = "";
			}
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
</script>