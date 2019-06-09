<?php
require_once 'cabecalho.php';
include_once 'vrf_lgin.php';
include_once '../core/crud.php';
//PEDIDOS CANCELADOS
$totalPedidoCancelado = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome='CANCELADO'");
$arrayPedidoCancelados = $totalPedidoCancelado->fetchAll(PDO::FETCH_ASSOC);
//PEDIDOS TODOS
$totalTodos = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus");
$arrayPedidoTodos = $totalTodos->fetchAll(PDO::FETCH_ASSOC);

//PEDIDOS TODOS - //,con.dataCadastro,con.numeroPregao, con.numeroAf, con.codStatus, con.valorPedido,con.anexo,con.observacao, cli.nomeCliente, cli.tipoCliente,sta.nome as nomeStatus 
$todosPedidos = crud::dataview("SELECT DISTINCT cli.nomeCliente
FROM controlePedido as con 
inner join cliente as cli on cli.codCliente = con.codCliente 
inner join statusPedido as sta on sta.codStatus = con.codStatus order by con.codControle ");
$arrayPedidos = $todosPedidos->fetchAll(PDO::FETCH_ASSOC);

$andre = crud::dataview("SELECT R.codCliente,R.nomeCliente, R.qtdePedidos FROM (
	SELECT DISTINCT c.nomeCliente, c.codCliente,
	(SELECT COUNT(con.numeroAf) AS qtde
	FROM controlePedido AS con 
	WHERE c.codCliente = con.codCliente 
	) as qtdePedidos
	FROM cliente as c) AS R
	 WHERE R.qtdePedidos > 0
	 ORDER BY R.qtdePedidos DESC; ");
$arrayAndre = $andre->fetchAll(PDO::FETCH_ASSOC);




//PEDIDOS EM ATENDIMENTO
$totalPedidoAtendimento = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome='ATENDIDO'");
$arrayPedidoAtendimento = $totalPedidoAtendimento->fetchAll(PDO::FETCH_ASSOC);
//PEDIDOS ABERTAS
$totalPedidoAberto = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome not in ('ATENDIDO','CANCELADO')");
$arrayPedidoAberto = $totalPedidoAberto->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-4 text-center">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title">Recebidas</h3>
							</div>
							<div class="panel-body" onclick="window.location.href = 'pedido.php'" style="cursor:pointer">
								<h3><?php print($arrayPedidoTodos[0]['total']); ?></h3>							
							</div>
						</div>
					</div>
					<div class="col-sm-4 text-center">
						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title">Atendidos</h3>
							</div>
							<div class="panel-body" onclick="window.location.href = 'pedidoAtendido.php'" style="cursor:pointer" >
								<h3><?php print($arrayPedidoAtendimento[0]['total']); ?></h3>							
							</div>
						</div>
					</div>
					<div class="col-sm-4 text-center">
						<div class="panel panel-danger">
							<div class="panel-heading">
								<h3 class="panel-title">Negadas</h3>
							</div>
							<div class="panel-body" onclick="window.location.href = 'pedidoCancelado.php'" style="cursor:pointer">
								<h3><?php print($arrayPedidoCancelados[0]['total']); ?></h3>
								</div>
						</div>
					</div>
					<div class="col-sm-4 text-center">
						<div class="panel panel-yellow">
							<div class="panel-heading">
								<h3 class="panel-title">Pendentes</h3>
							</div>
							<div class="panel-body" onclick="window.location.href = 'pedidoPendente.php'" style="cursor:pointer">
								<h3><?php print($arrayPedidoAberto[0]['total']); ?></h3>
								</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Ultimas Páginas</h3>
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
						<div class="panel panel-warning">
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
												<a href="#">Pregões Eletrônico</a>
											</td>
											<td class="hidden-xs">
												<a class="btn btn-xs btn-warning" href="#">Editar</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="#">Pregões Presencias</a>
											</td>
											<td class="hidden-xs">
												<a class="btn btn-xs btn-warning" href="#">Editar</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="#">Database</a>
											</td>
											<td class="hidden-xs">
												<a class="btn btn-xs btn-warning" href="#">Editar</a>
											</td>
										</tr>
										<tr>
											<td>
												<a href="#">Mobile</a>
											</td>
											<td class="hidden-xs">
												<a class="btn btn-xs btn-warning" href="#">Editar</a>
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