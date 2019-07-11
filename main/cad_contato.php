<?php
require_once 'cabecalho.php';
require_once '../vendor/autoload.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
include_once '../core/crudContato.php';

$acao = 1;
?>
<div class="container-fluid">
	<h1>Cadastro de Contatos</h1>
	<form id="frmContato">
		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
					<input type="text" hidden id="tipo" name="tipo" value="Salvar">
					<input type="hidden"  id="codContato" name="codContato" >
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
				<div class="form-inline">

					<div class="form-group">
						<div class="input-group">
							<label for="telefoneContato" class="control-label">Telefone </label>
							<input type="text" data-mask="(00) 0000-0000" data-mask-selectonfocus="true" class="form-control" size="28" name="telefoneContato" id="telefoneContato" placeholder="(xx) xxxx-xxxx" required value="">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<label for="celularContato" class="control-label">Celular </label>
							<input type="text" data-mask="(00) 0 0000-0000" class="form-control" size="28" name="celularContato" id="celularContato" placeholder="(xx) xxxxx-xxxx" required value="">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<label for="emailContato" class="control-label">Email </label>
							<input type="email" class="form-control" size="50" name="emailContato" id="emailContato" placeholder="email@email.com.br" required value="">
						</div>
					</div>
					<br>
				</div>
				<br>
				<button type="submit" class="btn btn-info btn-lg btn-block"  id="btnSalvar"><span class="fa fa-save"></span> Salvar</button>
			</div>
		</div>
	</form>

	<!-- LISTAR Contatos-->
	<div class="row">
		<div class="col-sm-12">
			<div class="white-box">
				<div class="col-sm-6">
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
							<th>Alterar</th>
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
							<th>Alterar</th>
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
									<td><?php print($row['fk_codCliente']); ?></td>
									<td><?php print($row['nomeContato']); ?></td>
									<td><?php print($row['emailContato']); ?></td>
									<td><?php print($row['telefoneContato']); ?></td>
									<td><?php print($row['celularContato']); ?></td>
									<td><a class="btn btn-info waves-effect waves-light" id="btnEditar" data-whatever="@getbootstrap" data-codigo="<?php print($row['nomeContato']); ?>" data-codigoacesso="<?php print($row['nomeContato']); ?>" data-nome="<?php print($row['nomeContato']); ?>" data-nomefantasia="<?php print($row['nomeContato']); ?>">Editar</a></td>
									<td><a class="btn btn-info waves-effect waves-light" id="btnLimpar" data-whatever="@getbootstrap" >Limpar</a></td>
									<td><a class="btn btn-danger waves-effect waves-light" data-target="#modalExcluir" data-whatever="@getbootstrap" id="btnExcluir" >Excluir</a></td>
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



<?php

require_once "rodape.php";
//include_once "pedidoModais.php";
?>
<script src="js/contato.js"></script>