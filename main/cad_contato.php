<?php
require_once 'cabecalho.php';
require_once '../vendor/autoload.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
include_once '../core/crudContato.php';

$acao = 1;
?>

<!-- LISTAR Contatos-->
<div class="row">	
	<div class="col-sm-12">
		<div class="white-box">
			
			<div class="col-sm-6">
			<button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalContato" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-plus"></i></span>Cadastro</button>
		<button class="btn btn-success waves-effect waves-light" type="button" onclick="window.location.href = 'Home.php'" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-home"></i></span>Home</button>
				<br>
				<h2>Lista de Contatos -
					<button class="btn btn-success waves-effect waves-light" type="button" data-toggle="modal" data-target="#modalPesquisarAndre" data-whatever="@getbootstrap"><span class="fa fa-search"></span></span>Pesquisar</button>
				</h2>
			</div>
			<table id="tabela" class="table table-striped">
				<thead>
					<tr>
						<th>Cliente</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Telefone</th>
						<th>Celular</th>
						<th>Alterar</th>
						<th>Detalhes</th>
						<th>Excluir</th>
					</tr>
				<tfoot>
					<tr>
						<th>Cliente</th>
						<th>Nome</th>
						<th>Email</th>
						<th>Telefone</th>
						<th>Celular</th>
						<th>Alterar</th>
						<th>Detalhes</th>
						<th>Excluir</th>
					</tr>
				</tfoot>
				</thead>
				<tbody>
					<?php
					if ($nivel == 1) {
						$dados = crudContato::listarContato($idInstituicao);
					} else {
						$dados = crudContato::listarContato($idInstituicao);
					}
					if ($dados->rowCount() > 0) {
						while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
							?>
							<tr>
								<td><?php print($row['nomeCliente']); ?></td>
								<td><?php print($row['nomeContato']); ?></td>
								<td><?php print($row['emailContato']); ?></td>
								<td><?php print($row['telefoneContato']); ?></td>
								<td><?php print($row['celularContato']); ?></td>
								<td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalContato" id="btnEditar" data-whatever="@getbootstrap" data-codigo="<?php print($row['codContato']); ?>" data-codcliente="<?php print($row['codCliente']); ?>" data-nome="<?php print($row['nomeContato']); ?>" data-celular="<?php print($row['celularContato']); ?>" data-telefone="<?php print($row['telefoneContato']); ?>" data-email="<?php print($row['emailContato']); ?>" data-cargosetor="<?php print($row['cargoSetor']); ?>"><span class="fa fa-pencil"></span> Editar</a></td>
								<td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalContato" id="btnDetalhes" data-whatever="@getbootstrap" data-codigo="<?php print($row['codContato']); ?>" data-codcliente="<?php print($row['codCliente']); ?>" data-nome="<?php print($row['nomeContato']); ?>" data-celular="<?php print($row['celularContato']); ?>" data-telefone="<?php print($row['telefoneContato']); ?>" data-email="<?php print($row['emailContato']); ?>" data-cargosetor="<?php print($row['cargoSetor']); ?>"><span class="fa fa-pencil"></span> Detalhes</a></td>
								<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalContato" data-whatever="@getbootstrap" id="btnExcluir" data-codigo="<?php print($row['codContato']); ?>" data-codcliente="<?php print($row['codCliente']); ?>" data-nome="<?php print($row['nomeContato']); ?>" data-celular="<?php print($row['celularContato']); ?>" data-telefone="<?php print($row['telefoneContato']); ?>" data-email="<?php print($row['emailContato']); ?>" data-cargosetor="<?php print($row['cargoSetor']); ?>" ><span class="fa fa-trash-o"></span> Excluir</a></td>
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

<!-- MODAL CADASTRAR -->
<div class="modal fade bs-example-modal-lg" id="modalContato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="exampleModalLabel1">Cadastro de Pedido</h4>
			</div>
			<div class="modal-body">
				<h1>Cadastro de Contatos</h1>
				<form id="frmContato">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<input type="text" hidden id="tipo" name="tipo" value="Salvar">
								<input type="hidden" id="codContato" name="codContato">
								<input type="hidden" value="<?php echo $idInstituicao; ?>" name="idInstituicao" id="idInstituicao">
								<input type="hidden" value="<?php echo $acao; ?>" name="acao" id="acao">
								<input type="hidden" value="<?php echo $dataAtual; ?>" name="dataAtual" id="dataAtual">
								<label for="nomeCliente" class="control-label">Nome </label>
								<input type="hidden" name="nomeCliente" id="nomeCliente">
								<select class="form-control" name="codCliente" id="codCliente" required>
									<option value="" selected disabled>Selecione o Cliente</option>
									<?php
									$selectCliente = crud::mostrarCliente($idInstituicao);
									if ($selectCliente->rowCount() > 0) {
										while ($row = $selectCliente->fetch(PDO::FETCH_ASSOC)) {
											?>
											<option value="<?php print($row['codCliente']); ?>">
												<?php print($row['nomeCliente']); ?>
											</option>
										<?php
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<label for="nomeContato" class="control-label">Nome </label>
								<input type="text" class="form-control" size="100" name="nomeContato" id="nomeContato" placeholder="Nome do contato" required value="">
							</div>
							<div class="form-group">
								<label for="Cargo/ Setor" class="control-label">Nome </label>
								<input type="text" class="form-control" size="100" name="cargoSetor" id="cargoSetor" placeholder="Cargo/ Setor"  value="">
							</div>
							<div class="form-inline">
								<div class="form-group">
									<div class="input-group">
										<label for="telefoneContato" class="control-label">Telefone </label>
										<input type="text" size="20"  data-mask="(00) 0000-0000" data-mask-selectonfocus="true" class="form-control" name="telefoneContato" id="telefoneContato" placeholder="(xx) xxxx-xxxx" required value="">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<label for="celularContato" class="control-label">Celular </label>
										<input type="text" size="20"   data-mask="(00) 0 0000-0000" class="form-control" name="celularContato" id="celularContato" placeholder="(xx) xxxxx-xxxx"  value="">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group">
										<label for="emailContato" class="control-label">Email </label>
										<input type="email" size="36"  class="form-control" name="emailContato" id="emailContato" placeholder="email@email.com.br"  value="">
									</div>
								</div>
								<br>
							</div>
							<br>
							<div class="modal-footer">
								<button type="button" class="btn btn-info waves-effect waves-light" id="btnLimpar" data-whatever="@getbootstrap"><span class="fa fa-save"></span> Limpar</button>
								<button type="button" class="btn btn-warning waves-effect" data-dismiss="modal"><span class="fa fa-trash"></span> Cancelar</button>
								<button type="submit" class="btn btn-success waves-effect waves-light" id="btnSalvar"><span class="fa fa-save"></span> Salvar</button>
							</div>
						</div>						
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- MODAL CADASTRAR -->

<?php
require_once "rodape.php";
//include_once "contatoModais.php";
include_once "pedidoModais.php";
?>

<script src="js/contato.js"></script>