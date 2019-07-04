<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
//FECHADAS
$totalFechadas = crud::dataview("SELECT COUNT(*) AS total FROM demanda AS d
INNER JOIN usuarios AS u ON d.id_usr_destino = u.id AND  d.id_usr_criador = '".$idUsuario."'
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
 WHERE d.fk_idInstituicao = '".$idInstituicao."' AND d.status = 'Fechada'");
$arrayFechadas = $totalFechadas->fetchAll(PDO::FETCH_ASSOC);
//ABERTAS
$totalAbertas = crud::dataview("SELECT COUNT(*) AS total FROM demanda AS d
		INNER JOIN usuarios AS u ON d.id_usr_destino = u.id AND  d.id_usr_criador = '".$idUsuario."'
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
 WHERE d.fk_idInstituicao = '".$idInstituicao."' AND d.status = 'Aberto'");
$arrayAbertas = $totalAbertas->fetchAll(PDO::FETCH_ASSOC);
//EM ATENDIMENTO
$totalAtendmento = crud::dataview("SELECT COUNT(*) AS total FROM demanda AS d
		INNER JOIN usuarios AS u ON d.id_usr_destino = u.id AND  d.id_usr_criador = '".$idUsuario."'
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
 WHERE d.fk_idInstituicao = '".$idInstituicao."' AND d.status = 'Em Atendimento'");
$arrayAtendmento = $totalAtendmento->fetchAll(PDO::FETCH_ASSOC);
//TODAS
$totalTodas = crud::dataview("SELECT COUNT(*) AS total FROM demanda AS d 
INNER JOIN usuarios AS u ON d.id_usr_destino = u.id  AND  d.id_usr_criador = '".$idUsuario."'
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
WHERE d.fk_idInstituicao = '".$idInstituicao."'");
$arrayTodas = $totalTodas->fetchAll(PDO::FETCH_ASSOC);

//FECHADAS GERAL
$totalFechadasGeral = crud::dataview("SELECT COUNT(*) AS total FROM demanda AS d
INNER JOIN usuarios AS u ON d.id_usr_destino = u.id
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
 WHERE d.fk_idInstituicao = '".$idInstituicao."' AND d.status = 'Fechada'");
$arrayFechadasGeral = $totalFechadasGeral->fetchAll(PDO::FETCH_ASSOC);
//ABERTAS GERAL
$totalAbertasGeral = crud::dataview("SELECT COUNT(*) AS total FROM demanda AS d
		INNER JOIN usuarios AS u ON d.id_usr_destino = u.id
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
 WHERE d.fk_idInstituicao = '".$idInstituicao."' AND d.status = 'Aberto'");
$arrayAbertasGeral = $totalAbertasGeral->fetchAll(PDO::FETCH_ASSOC);
//EM ATENDIMENTO GERAL
$totalAtendmentoGeral = crud::dataview("SELECT COUNT(*) AS total FROM demanda AS d
		INNER JOIN usuarios AS u ON d.id_usr_destino = u.id 
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
 WHERE d.fk_idInstituicao = '".$idInstituicao."' AND d.status = 'Em Atendimento'");
$arrayAtendmentoGeral = $totalAtendmentoGeral->fetchAll(PDO::FETCH_ASSOC);
//TODAS GERAL
$totalTodasGeral = crud::dataview("SELECT COUNT(*) AS total FROM demanda AS d 
INNER JOIN usuarios AS u ON d.id_usr_destino = u.id 
		INNER JOIN departamentos AS dep ON u.id_dep = dep.id 
		INNER JOIN cliente AS cli ON cli.codCliente = d.codCliente_dem 
WHERE d.fk_idInstituicao = '".$idInstituicao."'");
$arrayTodasGeral = $totalTodasGeral->fetchAll(PDO::FETCH_ASSOC);

$andre = crud::dataview("SELECT R.codCliente,R.nomeCliente, R.qtdeDemandas FROM (
	SELECT DISTINCT c.nomeCliente, c.codCliente,
	(SELECT COUNT(*) AS qtde
	FROM demanda AS d
	WHERE c.codCliente = d.codCliente_dem AND d.fk_idInstituicao = '".$idInstituicao."'
	) as qtdeDemandas
	FROM cliente as c WHERE c.fk_idInstituicao = '".$idInstituicao."') AS R
	 WHERE R.qtdeDemandas >= 0
	 ORDER BY R.qtdeDemandas DESC;
 ");
$arrayAndre = $andre->fetchAll(PDO::FETCH_ASSOC);

$status = crud::listarStatus($idInstituicao);
$arraystatus = $status->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
		<h3 class="panel-title text-center">INFORMACOES DAS MINHAS DEMANDAS</h3><br>
			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Recebidas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'demanda.php'" style="cursor:pointer">
						<h3 id="demandaTodas"> <?php print($arrayTodas[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Em Atendimento</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'para_mim_dem_abertas.php'" style="cursor:pointer">
						<h3 id="demandaAtendimento"><?php print($arrayAtendmento[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">Fechadas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'para_mim_dem_fechadas.php'" style="cursor:pointer">
						<h3 id="demandaFechadas"><?php print($arrayFechadas[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<h3 class="panel-title">Abertas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'para_mim_dem_abertas.php'" style="cursor:pointer">
						<h3 id="demandaAbertas"><?php print($arrayAbertas[0]['total']); ?></h3>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel-body">
					<div id="graficoDemanda" style="width: 600px; height: 300px;"></div> <br>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel-body">
					<div id="graficoDemanda1" style="width: 600px; height: 300px;"></div>
				</div>
			</div>
		</div>

		<div class="container-fluid">
		<div class="row">
		<h3 class="panel-title text-center">INFORMACOES DAS GERAL DEMANDAS</h3><br>
			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Recebidas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'demanda.php'" style="cursor:pointer">
						<h3 id="demandaTodasGeral"> <?php print($arrayTodasGeral[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Em Atendimento</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'para_mim_dem_abertas.php'" style="cursor:pointer">
						<h3 id="demandaAtendimentoGeral"><?php print($arrayAtendmentoGeral[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">Fechadas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'para_mim_dem_fechadas.php'" style="cursor:pointer">
						<h3 id="demandaFechadasGeral"><?php print($arrayFechadasGeral[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<h3 class="panel-title">Abertas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'para_mim_dem_abertas.php'" style="cursor:pointer">
						<h3 id="demandaAbertasGeral"><?php print($arrayAbertasGeral[0]['total']); ?></h3>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="panel-body">
					<div id="graficoDemandaGeral" style="width: 600px; height: 300px;"></div> <br>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel-body">
					<div id="graficoDemanda1Geral" style="width: 600px; height: 300px;"></div>
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
									<th>Demanda</th>
									<th class="hidden-xs">Ações</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<a href="demanda.php"><?php print($arrayAndre[0]['nomeCliente']); ?></a>
									</td>
									<td>
										<a href="demanda.php"><a href="#"><?php print($arrayAndre[0]['qtdeDemandas']); ?></a></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="demanda.php"><a href="#"><?php print($arrayAndre[1]['nomeCliente']); ?></a></a>
									</td>
									<td>
										<a href="demanda.php"><a href="#"><?php print($arrayAndre[1]['qtdeDemandas']); ?></a></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="demanda.php"><a href="#"><?php print($arrayAndre[2]['nomeCliente']); ?></a></a>
									</td>
									<td>
										<a href="demanda.php"><a href="#"><?php print($arrayAndre[2]['qtdeDemandas']); ?></a></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>

								</tr>
								<tr>
									<td>
										<a href="demanda.php"><a href="#"><?php print($arrayAndre[3]['nomeCliente']); ?></a></a>
									</td>
									<td>
										<a href="demanda.php"><a href="#"><?php print($arrayAndre[3]['qtdeDemandas']); ?></a></a>
									</td>
									<td class="hidden-xs">
										<a class="btn btn-xs btn-info" href="#">Detalhes</a>
									</td>
								</tr>
								<tr>
									<td>
										<a href="demanda.php"><?php print($arrayAndre[4]['nomeCliente']); ?></a>
									</td>
									<td>
										<a href="demanda.php"> <?php print($arrayAndre[4]['qtdeDemandas']); ?></a>
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
	google.charts.setOnLoadCallback(desenhaGraficoPizza);

	function desenhaGraficoPizza() {
		var data = google.visualization.arrayToDataTable([
			['Task', 'Hours per Day'],
			<?php
			echo "['Total'," . $arrayTodas[0]['total'] . "],";
			echo "['Fechadas'," . $arrayFechadas[0]['total'] . "],";
			echo "['Pendentes'," . $arrayAbertas[0]['total'] . "],";
			echo "['Atendimento'," . $arrayAtendmento[0]['total'] . "],";			
			?>
		]);

		var options = {
			title: 'Minhas Demanda Por Status'
		};

		var chart = new google.visualization.PieChart(document.getElementById('graficoDemanda1'));

		chart.draw(data, options);
	}
	google.charts.setOnLoadCallback(desenhaGraficoPizzaGeral);

	function desenhaGraficoPizzaGeral() {
		var data = google.visualization.arrayToDataTable([
			['Task', 'Hours per Day'],
			<?php
			echo "['Total'," . $arrayTodasGeral[0]['total'] . "],";
			echo "['Fechadas'," . $arrayFechadasGeral[0]['total'] . "],";
			echo "['Pendentes'," . $arrayAbertasGeral[0]['total'] . "],";
			echo "['Atendimento'," . $arrayAtendmentoGeral[0]['total'] . "],";			
			?>
		]);

		var options = {
			title: 'Demandas Por Status Geral'
		};

		var chart = new google.visualization.PieChart(document.getElementById('graficoDemanda1Geral'));

		chart.draw(data, options);
	}

	google.charts.setOnLoadCallback(desenhaGraficoLinha);

	function desenhaGraficoLinha() {
		var cancelado = $('#demandaFechadas').text();
		var pendente = $('#demandaAbertas').text();
		var atendido = $('#demandaAtendimento').text();
		var todos = $('#demandaTodas').text();
		//	alert(atendido);

		var data = google.visualization.arrayToDataTable([
			['Task', 'Quantidade'],
			//['Element', 'Density',{role: "style"}],
			['Pendente', parseInt(pendente)],
			['Atendimento', parseInt(atendido)],
			['Fechada', parseInt(cancelado)],
			['Todas', parseInt(todos)],
		]);

		var options = {
			title: 'Minhas Demandas Por Status',
			width: 300,
			height: 300,
			bar: {
				groupWidth: "100%"
			},
			legend: {
				position: "none"
			}
		};
		var chart = new google.visualization.LineChart(document.getElementById('graficoDemanda'));

		chart.draw(data, options);
	}

	google.charts.setOnLoadCallback(desenhaGraficoLinhaGeral);

	function desenhaGraficoLinhaGeral() {
		var cancelado = $('#demandaFechadasGeral').text();
		var pendente = $('#demandaAbertasGeral').text();
		var atendido = $('#demandaAtendimentoGeral').text();
		var todos = $('#demandaTodasGeral').text();
		//	alert(atendido);

		var data = google.visualization.arrayToDataTable([
			['Task', 'Quantidade'],
			//['Element', 'Density',{role: "style"}],
			['Pendente', parseInt(pendente)],
			['Atendimento', parseInt(atendido)],
			['Fechada', parseInt(cancelado)],
			['Todas', parseInt(todos)],
		]);

		var options = {
			title: 'Demandas Por Status Geral',
			width: 300,
			height: 300,
			bar: {
				groupWidth: "100%"
			},
			legend: {
				position: "none"
			}
		};
		var chart = new google.visualization.LineChart(document.getElementById('graficoDemandaGeral'));

		chart.draw(data, options);
	}
</script>