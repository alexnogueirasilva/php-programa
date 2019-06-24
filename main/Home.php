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
//Departamentos TODOS
$totalDepartamentos = crud::dataview("SELECT COUNT(*) as total from departamentos where fk_idInstituicao = '".$idInstituicao."'" );
$arrayDepartamentosTodos = $totalDepartamentos->fetchAll(PDO::FETCH_ASSOC);
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
$totalRepresentante = crud::dataview("SELECT COUNT(*) as total from cadRepresentante where fk_idInstituicao = '".$idInstituicao."'" );
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
						<h3 class="panel-title"> <span class="fa fa-user"></span> Clientes 
						</h3>
					</div>
					
					<div class="panel-body" onclick="window.location.href = 'cad_cliente.php'" style="cursor:pointer">
						<h3 id="clientes"><?php print($arrayClienteTodos[0]['total']); ?>						
					</h3>
						
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <span class="fa fa-user"></span> Contatos</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_contato.php'" style="cursor:pointer">
						<h3 id="contatos"><?php print($arrayContatosTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
						
			<div class="col-sm-3 text-center">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h3 class="panel-title"> <span class="fa fa-user"></span> Demandas</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'index_user.php'" style="cursor:pointer">
						<h3 id="demandas"><?php print($arrayDemandasTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			
			<div class="col-sm-3 text-center">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title">  <span class="fa fa-cubes"></span> Departamentos</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_dep.php'" style="cursor:pointer">
						<h3 id="Departamentos"><?php print($arrayDepartamentosTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>

			<div class="col-sm-3 text-center">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="fa fa-cubes"></span> Instituicao</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_instituicao.php'" style="cursor:pointer">
						<h3 id="instituicao"><?php print($arrayInstituicaoTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>

			<div class="col-sm-3 text-center">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="fa fa-user"></span> Pedido</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'homePedido.php'" style="cursor:pointer">
						<h3 id="pedidos"><?php print($arrayPedidoTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			<div class="col-sm-3 text-center">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="fa fa-user"></span> Representantes</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_representante.php'" style="cursor:pointer">
						<h3 id="representantes"><?php print($arrayRepresentanteTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			
			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="fa fa-hourglass-half"></span>    Sla</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_sla.php'" style="cursor:pointer">
						<h3 id="sla"><?php print($arraySlaTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>

			<div class="col-sm-3 text-center">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="fa fa-hourglass-half"></span> Status</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_status.php'" style="cursor:pointer">
						<h3 id="status"><?php print($arrayStatusTodos[0]['total']); ?></h3>
					</div>
				</div>
			</div>
			
			<div class="col-sm-3 text-center">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><span class="fa fa-user"></span> Usuarios</h3>
					</div>
					<div class="panel-body" onclick="window.location.href = 'cad_user.php'" style="cursor:pointer">
						<h3 id="usuarios"><?php print($arrayUsuariosTodos[0]['total']); ?></h3>
					</div>
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