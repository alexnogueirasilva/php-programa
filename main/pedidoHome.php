<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
//PEDIDOS CANCELADOS
$totalPedidoCancelado = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome in ('NEGADO','CANCELADO') AND con.fk_idInstituicao = '".$idInstituicao."'");
$arrayPedidoCancelados = $totalPedidoCancelado->fetchAll(PDO::FETCH_ASSOC);
//PEDIDOS TODOS
$totalTodos = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE con.fk_idInstituicao = '".$idInstituicao."' " );
$arrayPedidoTodos = $totalTodos->fetchAll(PDO::FETCH_ASSOC);

//PEDIDOS TODOS - //,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente,sta.nome as nomeStatus 
$todosPedidos = crud::dataview("SELECT DISTINCT cli.nomeCliente
FROM controlePedido as con 
inner join cliente as cli on cli.codCliente = con.codCliente 
inner join statusPedido as sta on sta.codStatus = con.codStatus WHERE con.fk_idInstituicao = '".$idInstituicao."' order by con.codControle ");
$arrayPedidos = $todosPedidos->fetchAll(PDO::FETCH_ASSOC);

$andre = crud::dataview("SELECT R.codCliente,R.nomeCliente, R.qtdePedidos FROM (
	SELECT DISTINCT c.nomeCliente, c.codCliente,
	(SELECT COUNT(con.numeroAf) AS qtde
	FROM controlePedido AS con 
	WHERE c.codCliente = con.codCliente AND con.fk_idInstituicao = '".$idInstituicao."'
	) as qtdePedidos
	FROM cliente as c WHERE c.fk_idInstituicao = '".$idInstituicao."') AS R
	 WHERE R.qtdePedidos > 0
	 ORDER BY R.qtdePedidos DESC; ");
$arrayAndre = $andre->fetchAll(PDO::FETCH_ASSOC);

$status = crud::listarStatus($idInstituicao);//("SELECT *  FROM statusPedido	 ORDER BY nome ASC; ");
$arraystatus = $status->fetchAll(PDO::FETCH_ASSOC);

//PEDIDOS EM ATENDIMENTO
$totalPedidoAtendimento = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome='ATENDIDO' AND con.fk_idInstituicao = '".$idInstituicao."'");
$arrayPedidoAtendimento = $totalPedidoAtendimento->fetchAll(PDO::FETCH_ASSOC);
//PEDIDOS ABERTAS
$totalPedidoAberto = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome not in ('ATENDIDO','CANCELADO') AND con.fk_idInstituicao = '".$idInstituicao."'");
$arrayPedidoAberto = $totalPedidoAberto->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
		<h3 class="panel-title text-center">INFORMACOES DE PEDIDOS</h3><br>
			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Recebidas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'pedido.php'" style="cursor:pointer">
						<h3 id="pedidoTodos"> <?php print($arrayPedidoTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Atendidos</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'pedidoAtendido.php'" style="cursor:pointer">
						<h3 id="pedidoAtendido"><?php print($arrayPedidoAtendimento[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">Negados</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'pedidoCancelado.php'" style="cursor:pointer">
						<h3 id="pedidoCancelado"><?php print($arrayPedidoCancelados[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<h3 class="panel-title">Pendentes</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'pedidoPendente.php'" style="cursor:pointer">
						<h3 id="pedidoPendente"><?php print($arrayPedidoAberto[0]['total']); ?></h3>
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
						<h3 class="panel-title">Status Pedido</h3>
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
			echo "['Total'," . $arrayPedidoTodos[0]['total'] . "],";
			echo "['Cancelados'," . $arrayPedidoCancelados[0]['total'] . "],";
			echo "['Pendentes'," . $arrayPedidoAberto[0]['total'] . "],";
			echo "['Atendido'," . $arrayPedidoAtendimento[0]['total'] . "],";			
			?>
		]);

		var options = {
			title: 'Pedidos Por Status',
			width: 390,
			height: 300,
			bar: {
				groupWidth: "100%"
			}
		};

		var chart = new google.visualization.PieChart(document.getElementById('graficoPedido1'));

		chart.draw(data, options);
	}

	google.charts.setOnLoadCallback(desenhaGraficoDataUser);

	function desenhaGraficoDataUser() {
		var cancelado = $('#pedidoCancelado').text();
		var pendente = $('#pedidoPendente').text();
		var atendido = $('#pedidoAtendido').text();
		var todos = $('#pedidoTodos').text();
		//	alert(atendido);

		var data = google.visualization.arrayToDataTable([
			['Task', 'Quantidade'],
			//['Element', 'Density',{role: "style"}],
			['Pendente', parseInt(pendente)],
			['Atendido', parseInt(atendido)],
			['Cancelado', parseInt(cancelado)],
			['Todos', parseInt(todos)],
		]);

		var options = {
			title: 'Pedidos Por Status',
			width: 390,
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