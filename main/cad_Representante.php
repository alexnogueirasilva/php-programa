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

	<h1>Cadastra Representante</h1>
	<h4>Insira os dados do novo Representante</h4>
	<form id="frmCadRepresentante">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-inline">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" size="200" name="nomeRepresentante" id="nomeRepresentante" placeholder="Nome do departamento" required>
							<span class="input-group-addon"><span class="fa fa-cubes"></span></span>
						</div>
					</div>
				</div>
				<br><br>
				<button type="submit" class="btn btn-info btn-lg btn-block" id="submit"><span class="fa fa-save"></span> Salvar</button>
			</div>

		</div>
	</form>
</div>
<!-- LISTAGEM REPRESENTANTE -->

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<hr>

			<div class="col-sm-6">
				<h3>Lista de Representante</h3>
			</div>

			<table id="tbl-user" class="table table-striped">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nome</th>
						<th>Status</th>
						<th>Editar</th>
						<th>Excluir</th>
						<th>Desativar</th>
						<th>Ativar</th>
					</tr>
					<tfoot>
						<tr>
						<th>Código</th>
						<th>Nome</th>
						<th>Status</th>
						<th>Editar</th>
						<th>Excluir</th>
						<th>Desativar</th>
						<th>Ativar</th>
						</tr>
					</tfoot>
				</thead>
				<tbody>

					<?php
					$dados = crud::listarRepresentante();

					if ($dados->rowCount() > 0) {
						while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
							?>
							<tr>
								<td><?php print($row['codRepresentante']); ?></td>
								<td><?php print($row['nomeRepresentante']); ?></td>
								<td id="statusRepresentante"><?php print($row['statusRepresentante']); ?></td>
								<td><a class="btn btn-info waves-effect waves-light" id="btnEdita" data-toggle="modal" data-target="#modalEditaRepresentante" data-whatever="@getbootstrap" data-codigo="<?php print($row['codRepresentante']); ?>" data-nome="<?php print($row['nomeRepresentante']); ?>" data-statusatual="<?php print($row['statusRepresentante']); ?>">Editar</a></td>
								<td><a class="btn btn-danger waves-effect waves-light" data-target="#modalExluirRepresentante" data-whatever="@getbootstrap" id="btnExcluiRepresentante" data-codigo="<?php print($row['codRepresentante']); ?>" data-statusatual="<?php print($row['statusRepresentante']); ?>" data-nome="<?php print($row['nomeRepresentante']); ?>">Excluir</a></td>
								<td><a class="btn btn-danger waves-effect waves-light" data-target="#modalConfirmacaoDesativa" data-whatever="@getbootstrap" id="btnDesativa" data-codigo="<?php print($row['codRepresentante']); ?>" data-statusatual="<?php print($row['statusRepresentante']); ?>" data-nome="<?php print($row['nomeRepresentante']); ?>">Desativar</a></td>

								<td><a class="btn btn-info waves-effect waves-light" data-target="#modalConfirmacaoAtiva" data-whatever="@getbootstrap" id="btnAtiva" data-codigo="<?php print($row['codRepresentante']); ?>" data-statusatual="<?php print($row['statusRepresentante']); ?>" data-nome="<?php print($row['nomeRepresentante']); ?>">Ativa</a></td>
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



<!-- MODAL desativar Representante
-->
<div class="modal fade" id="modalConfirmacaoDesativa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" name="codigoRepresentanteDes" id="codigoRepresentanteDes">
					<input type="hidden" name="statusAtualDes" id="statusAtualDes">
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai DESATIVAR o Representante: <span id="nomeRepresentanteDes"></span>?</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnDesativaRepresentante" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL desativar Representante-->

<!-- MODAL ativar Representante -->
<div class="modal fade" id="modalConfirmacaoAtiva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" name="codigoRepresentanteAt" id="codigoRepresentanteAt">
					<input type="hidden" name="statusAtualAt" id="statusAtualAt">
					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai ATIVAR o Representante: <span id="nomeRepresentanteAt"></span>?</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnAtivaRepresentante" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL ativar Representante -->

<!-- MODAL EXCLUIR Representante-->
<div class="modal fade" id="modalExluirRepresentante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="headermodal">Confirmação</h4>
			</div>
			<div class="modal-body">
				<div class="row">

					<input type="hidden" name="excIdRepresentante" id="excIdRepresentante">
					<input type="hidden" name="excStatusRepresentante" id="excStatusRepresentante">

					<div class="col-md-12">
						<div id="contextoModal">
							<h2>Você vai EXCLUIR o Representante: <span id="ExcNomeRepresentante"></span>?</h2>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" id="btnExcluirRepresentante" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
</div>
<!-- MODAL EXCLUIR Representante-->

<!-- MODAL editar Representante-->
<div class="modal fade" id="modalEditaRepresentante" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2">
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

							<form id="frmEdtRepresentante">
								<input type="hidden" hidden name="tipo" value="editarRepresentante">
								<input type="hidden" name="idRepresentante" id="idRepresentante">
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
										<button type="submit" class="btn btn-info btn-md btn-block" id="alterarRepresentante"><span class="fa fa-save"></span> Salvar</button>
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
<!-- MODAL editar Representante-->

<?php
require_once "rodape.php";
?>

<script type="text/javascript">
	$(document).ready(function() {
		permissaoNivel();

		$('#frmCadRepresentante').submit(function() {
			var tipo = "cadRepresentante";
			var nomeRepresentante = $("#nomeRepresentante").val();
			$.ajax({ //Função AJAX
				url: "../core/save.php", //Arquivo php
				type: "post", //Método de envio
				data: {
					tipo: tipo,
					nomeRepresentante: nomeRepresentante
				}, //Dados
				success: function(result) {
					//alert(result)
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Cadastrado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_representante.php";
								}
							});
						$("#nomeRepresentante").val('');
					} else {
						swal({
								title: "Ops!",
								text: "Erro ao Cadastradar!",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_representante.php";
								}
							});
					}
				}
			});
			return false; //Evita que a página seja atualizada
		});

		$(document).on("click", "#btnAtiva", function() {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');
			if (status == "A") {
				alert("Representante já está Ativo!");				
			}else{
				$('#modalConfirmacaoAtiva').modal('show');
			}
			$('#codigoRepresentanteAt').val(id);
			$('#statusAtualAt').val(status);
			$('#nomeRepresentanteAt').html(nome);
		});

		$(document).on("click", "#btnDesativa", function() {
			var id = $(this).data('codigo');
			var status = $(this).data('statusatual');
			var nome = $(this).data('nome');

			if (status == "D") {
				alert("Representante já está Desativado!");
			} else {
				$('#modalConfirmacaoDesativa').modal('show');
			}
			$('#codigoRepresentanteDes').val(id);
			$('#statusAtualDes').val(status);
			$('#nomeRepresentanteDes').html(nome);

		});

		$(document).on("click", "#btnExcluiRepresentante", function() {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var status = $(this).data('statusatual');

			$('#excIdRepresentante').val(id);
			$('#ExcNomeRepresentante').html(" Codigo: " + id + " - Nome: " + nome);
			$('#excStatusRepresentante').val(status);
			$('#modalExluirRepresentante').modal('show');
		});

		$(document).on("click", "#btnEdita", function() {
			var id = $(this).data('codigo');
			var nome = $(this).data('nome');
			var status = $(this).data('statusatual');

			$('#idRepresentante').val(id);
			$('#edtnome').val(nome);
			$('#edtstatus').val(status);
			$('#modalEditaRepresentante').modal('show');
		});

		$('#btnExcluirRepresentante').click(function() {
			var tipo = "excluirRepresentante";
			var idRepresentante = $('#excIdRepresentante').val();
			var status = $('#excStatusRepresentante').val();

			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					codRepresentante: idRepresentante
				},
				success: function(result) {
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Representante Excluído com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_representante.php";
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
									window.location = "cad_representante.php";
								}
							});
					}
				}
			});
		});

		$('#btnDesativaRepresentante').click(function() {
			var tipo = "desativaRepresentante";
			var idRepresentante = $('#codigoRepresentanteDes').val();
			var status = $('#statusAtualDes').val();
			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					idRepresentante: idRepresentante
				},
				success: function(result) {
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Cadastro desativado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									//	$('#modalConfirmacaoDesativa').modal('hide');
									window.location = "cad_Representante.php";
								}
							});
					} else {
						swal({
								title: "Ops!",
								text: "Algo deu errado ao desativar o cadastro!",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_Representante.php";
								}
							});
						//	alert(result);
						//alert("Erro ao salvar");
					}
				}
			});
		});

		$('#btnAtivaRepresentante').click(function() {
			var tipo = "ativaRepresentante";
			var idRepresentante = $('#codigoRepresentanteAt').val();
			var statusRepresentante = $('#statusAtualAt').val();
						
			$.ajax({
				url: '../core/save.php',
				type: "POST",
				data: {
					tipo: tipo,
					idRepresentante: idRepresentante
				},
				success: function(result) {
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Cadastro ativado com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									//	$('#modalConfirmacaoDesativa').modal('hide');
									window.location = "cad_Representante.php";
								}
							});
					} else {
						swal({
								title: "Ops!",
								text: "Algo deu errado ao ativar o cadastro !",
								type: "error",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},
							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_Representante.php";
								}
							});
						//	alert(result);
						//alert("Erro ao salvar");
					}

				}
			});

		});

		$("#frmEdtRepresentante").submit(function(e) {
			//e.preventDefault();			
			$.ajax({ //Função AJAX
				url: "../core/save.php", //Arquivo php
				type: "POST", //Método de envio
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(result) {
					if (result == 1) {
						swal({
								title: "OK!",
								text: "Dados Editados com Sucesso!",
								type: "success",
								confirmButtonText: "Fechar",
								closeOnConfirm: false
							},

							function(isConfirm) {
								if (isConfirm) {
									window.location = "cad_representante.php";
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
									window.location = "cad_representante.php";
								}
							});
					}
				}
			});

			return false;
		});


		$(document).on("click", "#btnExcluir", function() {
			var id = $(this).data('codigo');
			var desc = $(this).data('desc');


			$('#idSla').val(id);
			$('#labelSla').html("Você vai excluir o SLA <strong>" + desc + "?</strong>");

		});

		//BUSCA TODOS OS STATUS PARA MUDAR A COR CONFORME
		$("tr #statusRepresentante").each(function(i) {
			if ($(this).text() == "D") {
				this.style.color = "white";
				this.style.background = "red";
			} else {
				this.style.color = "white";
				this.style.background = "green";
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