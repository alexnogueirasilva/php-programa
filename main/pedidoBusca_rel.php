
<?php
include_once '../core/crud.php';


$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';

switch ($tipo) {
	case 'porCidade':
		$cidade = $_POST['cidade'];
		$html = '';
		//TOTAL	
		$qtdcliente = crud::dataview("SELECT COUNT(*) as total from pesquisas WHERE cidade = '" . $cidade . "'");
		$arrayCliente = $qtdcliente->fetchAll(PDO::FETCH_ASSOC);


		echo $html;

		break;

	case 'relGeral':
		$dataIni = $_POST['dataIni'];
		$dataFim = $_POST['dataFim'];
		$departamentos = $_POST['departamentos'];
		$cliente = $_POST['cliente'];
		$html = '';
		
		$Sql = "SELECT COUNT(*) as total from controlepedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus
		inner join cliente as cli on cli.codCliente = con.codCliente " ; 		
		
    	
		if (!$dataIni =="" && !$dataFim =="" ) {
            $Sql  .= " WHERE con.datacadastro BETWEEN '" . $dataIni . "' AND '" . $dataFim . "' " ;
		}		
    	if (!$departamentos =="" ) {
            $Sql  .= " AND con.codStatus=" . $departamentos ;
        }
    	if (!$cliente =="" ) {
            $Sql  .= " AND con.codCliente=" . $cliente ;
        }
		//TOTAL	
		$interDataAberto = crud::dataview($Sql);
		$arrayInterAberto = $interDataAberto->fetchAll(PDO::FETCH_ASSOC);

		//$interDataFechado = crud::dataview("SELECT COUNT(*) as total from controlepedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus  WHERE con.datacadastro BETWEEN '" . $dataIni . "' AND '" . $dataFim . "' AND con.codStatus=" . $departamentos);
		$arrayInterFechado = 0;// $interDataFechado->fetchAll(PDO::FETCH_ASSOC);

		//$interDataEmAtendimento = crud::dataview("SELECT COUNT(*) as total from controlepedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus  WHERE con.datacadastro BETWEEN '" . $dataIni . "' AND '" . $dataFim . "'  AND con.codStatus=" . $departamentos);
		$arrayInterEmAtendimento = 0;// $interDataEmAtendimento->fetchAll(PDO::FETCH_ASSOC);


		$html .= '<table class="table table-striped">
			                    	<thead>
										<tr>
											<th>Status</th>
											<th>Total</th>											
										</tr>
									</thead>
									<tbody>
										<tr>	
											<td>Fechadas</td>							
											<td id="fechadas" >' . $arrayInterFechado[0]['total'] . '</td>
											
										</tr>
										<tr>
											<td>Em Atendimento</td>							
											<td id="emAtendimento" >' . $arrayInterEmAtendimento[0]['total'] . '</td>
										</tr>
										<tr>
											<td>Abertos</td>							
											<td id="abertas" >' . $arrayInterAberto[0]['total'] . '</td>																															
										</tr>
									</tbody>                   	
				                 </table>';

		echo $html;

		break;


	case 'relGeralUsuarios':
		$dataIni = $_POST['dataIni'];
		$dataFim = $_POST['dataFim'];
		$usuarios = $_POST['usuarios'];
		$html = '';


		//TOTAL	
		$interDataAberto = crud::dataview("SELECT COUNT(*) as total from demanda WHERE data_criacao BETWEEN '" . $dataIni . "' AND '" . $dataFim . "' AND status='Aberto' AND id_usr_destino=" . $usuarios);
		$arrayInterAberto = $interDataAberto->fetchAll(PDO::FETCH_ASSOC);

		$interDataFechado = crud::dataview("SELECT COUNT(*) as total from demanda WHERE data_criacao BETWEEN '" . $dataIni . "' AND '" . $dataFim . "' AND status='Fechada' AND id_usr_destino=" . $usuarios);
		$arrayInterFechado = $interDataFechado->fetchAll(PDO::FETCH_ASSOC);

		$interDataEmAtendimento = crud::dataview("SELECT COUNT(*) as total from demanda WHERE data_criacao BETWEEN '" . $dataIni . "' AND '" . $dataFim . "' AND status='Em atendimento' AND id_usr_destino=" . $usuarios);
		$arrayInterEmAtendimento = $interDataEmAtendimento->fetchAll(PDO::FETCH_ASSOC);


		$html .= '<table class="table table-striped">
			                    	<thead>
										<tr>
											<th>Status</th>
											<th>Total</th>											
										</tr>
									</thead>
									<tbody>
										<tr>	
											<td>Fechadas</td>							
											<td id="fechadasUsuarios" >' . $arrayInterFechado[0]['total'] . '</td>
											
										</tr>
										<tr>
											<td>Em Atendimento</td>							
											<td id="emAtendimentoUsuarios" >' . $arrayInterEmAtendimento[0]['total'] . '</td>
										</tr>
										<tr>
											<td>Abertos</td>							
											<td id="abertasUsuarios" >' . $arrayInterAberto[0]['total'] . '</td>										
										</tr>
									</tbody>                   	
				                 </table>';

		echo $html;

		break;
}




?>