<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
//CONTATO TODOS
$totalContatos = crud::dataview("SELECT COUNT(*) as total from contatoCliente where fk_idInstituicao = '".$idInstituicao."'" );
$arrayContatosTodos = $totalContatos->fetchAll(PDO::FETCH_ASSOC);
//DEMANDA TODOS
$totalDemandas = crud::dataview("SELECT COUNT(*) as total from demanda where fk_idInstituicao = '".$idInstituicao."'" );
$arrayDemandasTodos = $totalDemandas->fetchAll(PDO::FETCH_ASSOC);
//INSTITUICAO TODOS
$totalInstituicao = crud::dataview("SELECT COUNT(*) as total from instituicao where inst_codigo = '".$idInstituicao."'" );
$arrayInstituicaoTodos = $totalInstituicao->fetchAll(PDO::FETCH_ASSOC);
//USUARIOS TODOS
$totalUsuarios = crud::dataview("SELECT COUNT(*) as total from usuarios where fk_idInstituicao = '".$idInstituicao."'" );
$arrayUsuariosTodos = $totalUsuarios->fetchAll(PDO::FETCH_ASSOC);
//SLA TODOS
$totalSla = crud::dataview("SELECT COUNT(*) as total from tbl_sla where fk_idInstituicao = '".$idInstituicao."'" );
$arraySlaTodos = $totalSla->fetchAll(PDO::FETCH_ASSOC);
//REPRESENTANTES TODOS
$totalRepresentante = crud::dataview("SELECT COUNT(*) as total from cadrepresentante where fk_idInstituicao = '".$idInstituicao."'" );
$arrayRepresentanteTodos = $totalRepresentante->fetchAll(PDO::FETCH_ASSOC);
//STATUS TODOS
$totalStatus = crud::dataview("SELECT COUNT(*) as total from statusPedido where fk_idInstituicao = '".$idInstituicao."'" );
$arrayStatusTodos = $totalStatus->fetchAll(PDO::FETCH_ASSOC);
//CLIENTES TODOS
$totalClientes = crud::dataview("SELECT COUNT(*) as total from cliente where fk_idInstituicao = '".$idInstituicao."'" );
$arrayClienteTodos = $totalClientes->fetchAll(PDO::FETCH_ASSOC);
//PEDIDOS TODOS
$totalPedido = crud::dataview("SELECT COUNT(*) as total from controlePedido where fk_idInstituicao = '".$idInstituicao."'" );
$arrayPedidoTodos = $totalPedido->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			
			<div class="col-sm-3 text-center">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Clientes</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_cliente.php'" style="cursor:pointer">
						<h3 id="clientes"><?php print($arrayClienteTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Contatos</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_contato.php'" style="cursor:pointer">
						<h3 id="contatos"><?php print($arrayContatosTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h3 class="panel-title">Demandas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'index_user.php'" style="cursor:pointer">
						<h3 id="demandas"><?php print($arrayDemandasTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			
			<div class="col-sm-3 text-center">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">Instituicao</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_instituicao.php'" style="cursor:pointer">
						<h3 id="instituicao"><?php print($arrayInstituicaoTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>

			<div class="col-sm-3 text-center">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">Pedido</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'homePedido.php'" style="cursor:pointer">
						<h3 id="pedidos"><?php print($arrayPedidoTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<h3 class="panel-title">Representantes</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_representante.php'" style="cursor:pointer">
						<h3 id="representantes"><?php print($arrayRepresentanteTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			
			<div class="col-sm-3 text-center">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Sla</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_sla.php'" style="cursor:pointer">
						<h3 id="sla"><?php print($arraySlaTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>

			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Status</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_status.php'" style="cursor:pointer">
						<h3 id="status"><?php print($arrayStatusTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			
			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Usuarios</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_user.php'" style="cursor:pointer">
						<h3 id="usuarios"><?php print($arrayUsuariosTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>

			
		
		</div>		
		</div>
		<div class="row">

			<div class="col-md-6">
				<div class="panel-body">
					<div id="graficoPedido" style="width: 600px; height: 300px;"></div> <br>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel-body">
					<div id="graficoPedido1" style="width: 600px; height: 300px;"></div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Lista de clientes Top 5</h3>
					</div>
					<div class="panel-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Título</th>
									<th>Pedido</th>
									<th class="hidden-xs">Ações</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<a href="pedido.php"><?php print($arrayAndre[0]['nomeCliente']); ?></a>
									</td>
									<td>
										<a href="pedido.php"><a href="#"><?php print($arrayAndre[0]['qtdePedidos']); ?></a></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="pedido.php"><a href="#"><?php print($arrayAndre[1]['nomeCliente']); ?></a></a>
									</td>
									<td>
										<a href="pedido.php"><a href="#"><?php print($arrayAndre[1]['qtdePedidos']); ?></a></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="pedido.php"><a href="#"><?php print($arrayAndre[2]['nomeCliente']); ?></a></a>
									</td>
									<td>
										<a href="pedido.php"><a href="#"><?php print($arrayAndre[2]['qtdePedidos']); ?></a></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>

								</tr>
								<tr>
									<td>
										<a href="pedido.php"><a href="#"><?php print($arrayAndre[3]['nomeCliente']); ?></a></a>
									</td>
									<td>
										<a href="pedido.php"><a href="#"><?php print($arrayAndre[3]['qtdePedidos']); ?></a></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="pedido.php"><?php print($arrayAndre[4]['nomeCliente']); ?></a>
									</td>
									<td>
										<a href="pedido.php"> <?php print($arrayAndre[4]['qtdePedidos']); ?></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

			</div>
			<div class="col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Categorias</h3>
					</div>
					<div class="panel-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Nome</th>
									<th class="hidden-xs">Ações</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>									
										<a href="cad_status.php"><?php print($arraystatus[0]['nome']); ?></a>																										
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Editar</a>
									</td>
								</tr>
								<tr>
									<td>
									<a href="cad_status.php"><?php print($arraystatus[1]['nome']); ?></a>																										
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Editar</a>
									</td>
								</tr>
								<tr>
									<td>
									<a href="cad_status.php"><?php print($arraystatus[2]['nome']); ?></a>																										
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Editar</a>
									</td>
								</tr>
								<tr>
									<td>
									<a href="cad_status.php"><?php print($arraystatus[3]['nome']); ?></a>																										
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Editar</a>
									</td>
								</tr>
								<tr>
									<td>
									<a href="cad_status.php"><?php print($arraystatus[4]['nome']); ?></a>																										
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Editar</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<?php
require_once "rodape.php";
?>
<script type="text/javascript">
	google.charts.load('current', {
		'packages': ['corechart']
	});
	google.charts.setOnLoadCallback(desenhaGraficoGeral);

	function desenhaGraficoGeral() {
		var data = google.visualization.arrayToDataTable([
			['Task', 'Hours per Day'],
			<?php
			echo "['Pendentes'," . $arrayPedidoAberto[0]['total'] . "],";
			echo "['Cancelados'," . $arrayPedidoCancelados[0]['total'] . "],";
			echo "['Atendido'," . $arrayPedidoAtendimento[0]['total'] . "],";
			?>
		]);

		var options = {
			title: 'Pedidos Por Status'
		};

		var chart = new google.visualization.PieChart(document.getElementById('graficoPedido1'));

		chart.draw(data, options);
	}

	google.charts.setOnLoadCallback(desenhaGraficoDataUser);

	function desenhaGraficoDataUser() {
		var cancelado = $('#pedidoCancelado').text();
		var pendente = $('#pedidoPendente').text();
		var atendido = $('#pedidoAtendido').text();
		//	alert(atendido);

		var data = google.visualization.arrayToDataTable([
			['Task', 'Hours per Day'],
			//['Element', 'Density',{role: "style"}],
			['Pendente', parseInt(pendente)],
			['Atendido', parseInt(atendido)],
			['Cancelado', parseInt(cancelado)],

		]);

		var options = {
			title: 'Pedidos Por Status',
			width: 300,
			height: 300,
			bar: {
				groupWidth: "100%"
			},
			legend: {
				position: "none"
			}
		};

		var chart = new google.visualization.LineChart(document.getElementById('graficoPedido'));

		chart.draw(data, options);
	}
</script>