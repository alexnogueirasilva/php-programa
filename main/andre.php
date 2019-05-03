
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

//$totalAberto = crud::dataview("SELECT COUNT(*) as total from demanda where id_dep=2");
//$arrayAberto = $totalAberto->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Content Wrapper. Contains page content conteudo
<div class="content-wrapper">
-->
    <!-- Main content -->
    <section class="content container-fluid">
      <div class="row">
        <!-- /.col -->
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