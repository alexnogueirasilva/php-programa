
<?php 
include_once 'vrf_lgin.php';
require_once 'cabecalho.php';
include_once '../core/crud.php';

$logado = $_SESSION['nomeUsuario'];
$id = $_SESSION['usuarioID'];
//$totalFechada = "SELECT COUNT(*) as total from demanda where status='Fechada'";
$queryDepartamentos = "SELECT * FROM departamentos ORDER BY nome ASC"; 
$queryUsuarios = "SELECT id, nome FROM usuarios where status='Ativo' ORDER BY nome ASC"; 

//DEMANDAS FECHADAS
$totalFechada = crud::dataview("SELECT COUNT(*) as total from demanda where status='Fechada'");
$arrayFechada = $totalFechada->fetchAll(PDO::FETCH_ASSOC);
//DEMANDAS EM ATENDIMENTO
$totalEmAtendimento = crud::dataview("SELECT COUNT(*) as total from demanda where status='Em atendimento'");
$arrayEmAtendimento = $totalEmAtendimento->fetchAll(PDO::FETCH_ASSOC);
//DEMANTAS ABERTAS
$totalAberto = crud::dataview("SELECT COUNT(*) as total from demanda where status='Aberto'");
$arrayAberto = $totalAberto->fetchAll(PDO::FETCH_ASSOC);

//PEDIDOS CANCELADOS
$totalPedidoCancelado = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome='CANCELADO'");
$arrayPedidoCancelados = $totalPedidoCancelado->fetchAll(PDO::FETCH_ASSOC);
//PEDIDOS TODOS
$totalTodos = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus");
$arrayPedidoTodos = $totalTodos->fetchAll(PDO::FETCH_ASSOC);
//PEDIDOS EM ATENDIMENTO
$totalPedidoAtendimento = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome='ATENDIDO'");
$arrayPedidoAtendimento = $totalPedidoAtendimento->fetchAll(PDO::FETCH_ASSOC);
//PEDIDOS ABERTAS
$totalPedidoAberto = crud::dataview("SELECT COUNT(*) as total from controlePedido as con inner join statusPedido as sta on sta.codStatus = con.codStatus where sta.nome not in ('ATENDIDO','CANCELADO')");
$arrayPedidoAberto = $totalPedidoAberto->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Content Wrapper. Contains page content conteudo
<div class="content-wrapper">
-->

  <!-- Main content -->
  <section class="content container-fluid">
      <div class="row">
      <h1>Pedidos</h1>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-mail" onclick="window.location.href = 'pedido.php'" style="cursor:pointer">         
            <span class="info-box-icon bg-red">
              <i class="ion ion-ios-chatboxes"></i>
            </span>
  
            <div class="info-box-content">
              <span class="info-box-text">Abertas</span>
              <span class="info-box-number"><?php print($arrayPedidoAberto[0]['total']); ?></span>              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
   <!-- /.col -->
   <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-mail" onclick="window.location.href = 'pedido.php'" style="cursor:pointer">         
            <span class="info-box-icon bg-green">
              <i class="ion ion-ios-chatboxes"></i>
            </span>
  
            <div class="info-box-content">
              <span class="info-box-text">Total</span>
              <span class="info-box-number"><?php print($arrayPedidoTodos[0]['total']); ?></span>              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" onclick="window.location.href = 'pedido.php'" style="cursor:pointer">         
            <span class="info-box-icon bg-red">
              <i class="ion ion-ios-email"></i>
            </span>
  
            <div class="info-box-content">
              <span class="info-box-text">Cancelados</span>
              <span class="info-box-number"><?php print($arrayPedidoCancelados[0]['total']); ?></span>              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" onclick="window.location.href = 'pedido.php'" style="cursor:pointer">         
            <span class="info-box-icon bg-green">
              <i class="ion ion-ios-email"></i>
            </span>
  
            <div class="info-box-content">
              <span class="info-box-text">Atendidos</span>
              <span class="info-box-number"><?php print($arrayPedidoAtendimento[0]['total']); ?></span>              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      
         <!-- /.info-box -->
          <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
        </div>
    </section>
    <!-- /.content 





    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row">
        <!-- /.col -->
        <h1>Ocorrencias</h1>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-mail" onclick="window.location.href = 'para_mim_dem_abertas.php'" style="cursor:pointer">         
            <span class="info-box-icon bg-red">
              <i class="ion ion-ios-chatboxes"></i>
            </span>
  
            <div class="info-box-content">
              <span class="info-box-text">Abertas</span>
              <span class="info-box-number"><?php print($arrayAberto[0]['total']); ?></span>              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
  
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box" onclick="window.location.href = 'para_mim_dem_fechadas.php'" style="cursor:pointer">         
            <span class="info-box-icon bg-blue">
              <i class="ion ion-ios-email"></i>
            </span>
  
            <div class="info-box-content">
              <span class="info-box-text">Fechadas</span>
              <span class="info-box-number"><?php print($arrayFechada[0]['total']); ?></span>              
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      
         <!-- /.info-box -->
          <!-- fix for small devices only -->
      <div class="clearfix visible-sm-block"></div>
        </div>
    </section>
    <!-- /.content 
  </div> -->
  <!-- /.content-wrapper -->


<?php
require_once "rodape.php";
include_once "modais.php";
?>