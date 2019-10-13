<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
$acao = 1;
$queryUsuarios = "SELECT sug.sug_id, sug.sug_tipo, sug.sug_descricao, sug.sug_status, sug.sug_usuario, sug.sug_idInstituicao, sug.sug_datacadastro, sug.sug_dataalteracao,
usr.nome, usr.id FROM sugestoes sug INNER JOIN usuarios as usr ON usr.id = sug.sug_usuario INNER JOIN departamentos as dep ON usr.id_dep = dep.id ORDER BY status ASC";
?>
<div class="container-fluid">
	<br>
		<div class="col-lg-12">

		</div>
		<!-- /.col-lg-12 -->
	</div>
<!--
	<h1>Cadastra Sugestoes</h1>
	<form id="frmSugestao">
		<div class="row">
			<div class="col-lg-12">				
					<input type="hidden" name="tipo" id="tipo" value="cadastroSugestoes">
					<input type="hidden" name="idSugestao" id="idSugestao1">
					<input type="hidden" value="< ?php echo $idInstituicao; ?>" name="idInstituicao" id="idInstituicao">
					<input type="hidden" value="< ?php echo $acao; ?>" name="acao" id="acao1">
					<input type="hidden" value="< ?php echo $dataAtual; ?>" name="dataAtual" id="dataAtual">
					<input type="hidden" value="< ?php echo $nomeUsuario; ?>" name="nomeUsuario" id="nomeUsuario">					
					<input type="hidden" value="< ?php echo $idUsuario; ?>" name="idUsuario" id="idUsuario">					
				<div class="form-group row">                                      				
						<div class="col-lg-4">
							<label class="">Tipo</label>
							<select class="form-control"  name="tipoSugestao" id="tipoSugestao1" required="true">
								<option value="">Tipo</option>
								<option value="1">1 - Desenvolvimento</option>
								<option value="2">2 - Alteração</option>
								<option value="3">3 - Correção</option>
							</select>
								<span class="form-text text-muted">Digite o tipo de sugestao</span>
						</div>
						<div class="col-lg-4">
							<label class="">Status</label>
							<select class="form-control" name="statusSugestao" id="statusSugestao1" required="true">
								<option value="">Status</option>
								<option value="1">1 - Em Analise</option>
								<option value="2">2 - Em Desenvolvimento</option>
								<option value="3">3 - Concluido</option>
								<option value="4">4 - Cancelado</option>
							</select>
								<span class="form-text text-muted">Digite o tipo de sugestao</span>
						</div>
				</div>
				
				<div class="form-group row">
					<div class="col-lg-12">
							<label for="message-text" class="control-label">Adicionar Descricao</label>
							<textarea  id="descricaoSugestao1" name="descricaoSugestao" class="form-control" rows="3" placeholder="descreva a sugestão" required></textarea>
						<span class="form-text text-muted">Digite a descrição de sugestao</span>
					</div>
				</div>
				<label for="message-text" id="informacao1" name="informacao" class="control-label"></label>
				<br>
				<button type="submit" class="btn btn-info btn-lg btn-block" id="submit"><span class="fa fa-save"></span> Salvar</button>
			</div>
				
		</div>
	</form>
-->

	<!-- LISTAGEM USUÁRIOS -->

	<div class="row">
		<div class="col-sm-12">		
		<button class="btn btn-success waves-effect waves-light" id="btnCadastrar" type="button" data-toggle="modal" data-target="#modalContato" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-plus"></i></span>Cadastro</button>
		<button class="btn btn-success waves-effect waves-light" type="button" onclick="window.location.href = 'Home.php'" data-whatever="@getbootstrap"><span class="btn-label"><i class="fa fa-home"></i></span>Home</button>
				<hr>
			<div class="white-box">
				<div class="col-sm-6">
					<h3>Lista de Sugestoes</h3>
				</div>

				<table id="tbl-user" class="table table-striped">
					<thead>
						<tr>
							<th>Código</th>
							<th>Tipo</th>
							<th>Status</th>
							<th>Usuário</th>
							<th>Data</th>							
							<th>Editar</th>
							<th>Detalhes</th>
							<th>Excluir</th>
						</tr>
					<tfoot>
						<tr>
							<th>Código</th>
							<th>Tipo</th>
							<th>Status</th>
							<th>Usuário</th>
							<th>Data</th>
							<th>Editar</th>
							<th>Detalhes</th>
							<th>Excluir</th>
						</tr>
					</tfoot>
					</thead>
					<tbody>
						<?php
						$dados = crud::listarSugestoes($idInstituicao);

						//$dados = crud::dataview($queryUsuarios);
						if ($dados->rowCount() > 0) {
							while ($row = $dados->fetch(PDO::FETCH_ASSOC)) {
								?>
								<tr>
									<td><?php print($row['sug_id']); ?></td>
									<td><?php print($row['sug_tipo']); ?></td>
									<td id="status"><?php print($row['sug_status']); ?></td>
									<td><?php print($row['nome']); ?></td>
									<td><?php print(crud::formataData($row['sug_dataalteracao'])); ?></td>
									<td><a class="btn btn-warning waves-effect waves-light"  data-toggle="modal" data-target="#modalContato" id="btnEditar" data-whatever="@getbootstrap" data-idsugestao="<?php print($row['sug_id']); ?>" data-idusuario="<?php print($row['id']); ?>" data-nomeusuario="<?php print($row['nome']); ?>" data-datacadastro="<?php print(crud::formataData($row['sug_datacadastro'])); ?>" 
									data-dataalteracao="<?php print(crud::formataData($row['sug_dataalteracao'])); ?>" data-descricaosugestao="<?php print($row['sug_descricao']); ?>" data-instituicao="<?php print($row['sug_idInstituicao']); ?>" data-tiposugestao="<?php print($row['sug_tipo']); ?>"  data-statussugestao="<?php print($row['sug_status']); ?>"><span class="fa fa-pencil"></span>Editar</a></td>
									<td><a class="btn btn-info waves-effect waves-light" data-toggle="modal" data-target="#modalContato" id="btnDetalhes" data-whatever="@getbootstrap" data-idsugestao="<?php print($row['sug_id']); ?>" data-idusuario="<?php print($row['id']); ?>"  data-nomeusuario="<?php print($row['nome']); ?>" data-datacadastro="<?php print(crud::formataData($row['sug_datacadastro'])); ?>" 
									data-dataalteracao="<?php print(crud::formataData($row['sug_dataalteracao'])); ?>" data-descricaosugestao="<?php print($row['sug_descricao']); ?>" data-instituicao="<?php print($row['sug_idInstituicao']); ?>" data-tiposugestao="<?php print($row['sug_tipo']); ?>"  data-statussugestao="<?php print($row['sug_status']); ?>"><span class="fa fa-pencil"></span>Detalhes</a></td>
									
									<td><a class="btn btn-danger waves-effect waves-light" data-toggle="modal" data-target="#modalContato" id="btnExcluir" data-whatever="@getbootstrap" data-idsugestao="<?php print($row['sug_id']); ?>" data-idusuario="<?php print($row['id']); ?>"  data-nomeusuario="<?php print($row['nome']); ?>" data-datacadastro="<?php print(crud::formataData($row['sug_datacadastro'])); ?>" 
									data-dataalteracao="<?php print(crud::formataData($row['sug_dataalteracao'])); ?>" data-descricaosugestao="<?php print($row['sug_descricao']); ?>" data-instituicao="<?php print($row['sug_idInstituicao']); ?>" data-tiposugestao="<?php print($row['sug_tipo']); ?>"  data-statussugestao="<?php print($row['sug_status']); ?>"><span class="fa fa-trash-o"></span>Excluir</a></td>
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


<!-- MODAL CADASTRAR -->
<div class="modal fade bs-example-modal-lg" id="modalContato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<center><h4 class="modal-title" id="titulo" ><span  id="exampleModalLabel1" style="font-size: 15px;"></span></h4>  </center>
			</div>
			<div class="modal-body">		
			<center><h3>Cadastro de Sugestoes</h3></center>
				<form id="frmSugestoes">
					<div class="row">
						<div class="col-lg-12">
							<input type="hidden" name="tipo" id="tipo" value="cadastroSugestoes">
							<input type="hidden" name="idSugestao" id="idSugestao">
							<input type="hidden" value="<?php echo $idInstituicao; ?>" name="idInstituicao" id="idInstituicao">
							<input type="hidden" value="<?php echo $acao; ?>" name="acao" id="acao">
							<input type="hidden" value="<?php echo $dataAtual; ?>" name="dataAtual" id="dataAtual">
							<input type="hidden" value="<?php echo $nomeUsuario; ?>" name="nomeUsuario" id="nomeUsuario">					
							<input type="hidden" value="<?php echo $idUsuario; ?>" name="idUsuario" id="idUsuario">					
							<div class="form-group row">                                      				
									<div class="col-lg-6">
										<label class="">Tipo</label>
										<select class="form-control"  name="tipoSugestao" id="tipoSugestao" required="true">
											<option value="">Tipo</option>
											<option value="Desenvolvimento">1 - Desenvolvimento</option>
											<option value="Alteração">2 - Alteração</option>
											<option value="Correção">3 - Correção</option>
										</select>
											<span class="form-text text-muted">Digite o tipo de sugestao</span>
									</div>
									<div class="col-lg-6">
										<label class="">Status</label>
										<select class="form-control" name="statusSugestao" id="statusSugestao" required="true">
											<option value="">Status</option>
											<option value="Em Analise">1 - Em Analise</option>
											<option value="Em Desenvolvimento">2 - Em Desenvolvimento</option>
											<option value="Concluido">3 - Concluido</option>
											<option value="Cancelado">4 - Cancelado</option>
										</select>
											<span class="form-text text-muted">Digite o tipo de sugestao</span>
									</div>
								</div>
							
							<div class="form-group row">
								<div class="col-lg-12">
										<label for="message-text" class="control-label">Adicionar Descricao</label>
										<textarea  id="descricaoSugestao" name="descricaoSugestao" class="form-control" rows="3" placeholder="descreva a sugestão" required></textarea>
									<span class="form-text text-muted">Digite a descrição de sugestao</span>
								</div>
							</div>
							<br>
							<span class="input-group-addon" name="informacao" id="informacao" style="font-size: 15px;"><span class="fa fa-users"></span></span>
							<div class="modal-footer">
								<button type="button" class="btn btn-info waves-effect waves-light" id="btnLimpar" data-whatever="@getbootstrap"><span class="fa fa-save"></span> Limpar</button>
								<button type="button" class="btn btn-warning waves-effect" data-dismiss="modal" id="btnCancelar"><span class="fa fa-trash"></span> Cancelar</button>
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
?>
<script src="js/sugestoes.js"></script>
