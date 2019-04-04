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

<div class="col-lg-12">                        
  <h3>Total Geral dos Status </h3>                 
</div>
<div class="col-md-6">

  <table id="tblTotaisStatus" class="table table-striped">
    <thead>
      <tr>
        <th>Status</th>
        <th>Total</th>                            
      </tr>
    </thead>
    <tbody>
      <tr>
       <td>Fechadas</td>
       <td><?php print($arrayFechada[0]['total']); ?></td>                           
     </tr>
     <tr>
      <td>Em Atendimento</td>
      <td><?php print($arrayEmAtendimento[0]['total']); ?></td>                              
    </tr>
    <tr>
      <td>Abertos</td>
      <td><?php print($arrayAberto[0]['total']); ?></td>  
    </tr>
    <tr>
      <td>Total</td>
      <td><?php echo $arrayAberto[0]['total'] + $arrayFechada[0]['total'] + $arrayEmAtendimento[0]['total']; ?></td>  
    </tr>


  </tbody>
</table>

</div>



<div class="container-fluid">
  <div class="row bg-title">
    <div class="col-lg-12">                        
      <div id="piechart" style="width: 600px; height: 300px;"></div>                    
    </div>
    <!-- /.col-lg-12 -->
  </div>
  <!-- row -->
  <div class="row">
    <div class="col-lg-12">                        
      <h3>Por departamento </h3>                 
    </div>
    <div class="col-md-6">
      <form action="">
        <div class="form-inline">
          <div class="form-group">
            <div class="input-group">
              <input type="date" class="form-control" id="dataIni" name="dataIni">
              <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="date" class="form-control" id="dataFim" name="dataFim">
              <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            </div>
          </div>
          <button id="btnBuscar" class="btn btn-success"><span class="fa fa-search"></span></button>
        </div>

        <br>
        <div class="form-group">
          <div class="input-group">
            <select class="form-control" name="departamentos" id="departamentos" required="true">
              <option value="" disabled selected>Setor</option>
              <?php
              $selectDep = crud::dataview($queryDepartamentos);
              if($selectDep->rowCount()>0){
                while($row=$selectDep->fetch(PDO::FETCH_ASSOC)){
                  ?>
                  <option value="<?php print($row['id']);?>"><?php print($row['nome']); ?></option>
                  <?php
                }
              }
              ?>
            </select>
            <span class="input-group-addon"><span class="fa fa-users"></span></span>
          </div>
        </div>
      </form>
      <div class="col-md-6" id="divBuscaPorData">


      </div>

    </div>


    <div class="row bg-title">
      <div class="col-lg-12">                        
        <div id="grafico" style="width: 600px; height: 300px;"></div>                    
      </div>
      <!-- /.col-lg-12 -->
    </div>
  </div>


  <!-- ___ -->

  <!-- row -->
  <div class="row">
    <div class="col-lg-12">                        
      <h3>Geral por Usuários</h3>                 
    </div>
    <div class="col-md-6">
            <form action="">
        <div class="form-inline">
          <div class="form-group">
            <div class="input-group">
              <input type="date" class="form-control" id="dataIniUser" name="dataIniUser">
              <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            </div>
          </div>
          <div class="form-group">
            <div class="input-group">
              <input type="date" class="form-control" id="dataFimUser" name="dataFimUser">
              <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
            </div>
          </div>
          <button id="btnBuscarUser" class="btn btn-success"><span class="fa fa-search"></button>
        </div>

        <br>
        <div class="form-group">
          <div class="input-group">
            <select class="form-control" name="usuarios" id="usuarios" required="true">
              <option value="" disabled selected>Usuário</option>
              <?php
              $selectUser = crud::dataview($queryUsuarios);
              if($selectUser->rowCount()>0){
                while($row=$selectUser->fetch(PDO::FETCH_ASSOC)){
                  ?>
                  <option value="<?php print($row['id']);?>"><?php print($row['nome']); ?></option>
                  <?php
                }
              }
              ?>
            </select>
            <span class="input-group-addon"><span class="fa fa-users"></span></span>
          </div>
        </div>
      </form>
      <div class="col-md-6" id="divBuscaPorDataUser">


      </div>

  </div>


  <div class="row bg-title">
    <div class="col-lg-12">                        
      <div id="graficoUser" style="width: 600px; height: 300px;"></div>                    
    </div>
    <!-- /.col-lg-12 -->
  </div>
</div> 




</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<?php
require_once "rodape.php";
?>


<script type="text/javascript"> 

 $(document).ready(function(){
   permissaoNivel();
   $('#btnBuscar').click(function(){
    var dataIni = $('#dataIni').val();
    var dataFim = $('#dataFim').val();
    var departamentos = $('#departamentos').val();
    var tipo = "relGeral";
    

    if (dataIni > dataFim) {
      alert('Data final menor que data inicial!');
    }else{  

      if (dataIni != '' && dataFim != '' && departamentos != null){
        $.ajax({
          url: 'busca_rel.php',
          type: "POST",
          data: {tipo:tipo, dataIni:dataIni, dataFim:dataFim, departamentos:departamentos},
          success: function(data) {
                    //alert(data);
                    if (data) {
                      $('#divBuscaPorData').html(data);

                    } 
                    desenhaGraficoData();
                    google.charts.setOnLoadCallback(desenhaGraficoData);
                  }
                });
        return false
        ;      }else{
          alert("Preencha o todos os campos!")
        } 
      }
    });

   //-----------------------------------------------------------------------------------
   $('#btnBuscarUser').click(function(){
    var dataIni = $('#dataIniUser').val();
    var dataFim = $('#dataFimUser').val();
    var usuarios = $('#usuarios').val();
    var tipo = "relGeralUsuarios";
    

    if (dataIni > dataFim) {
      alert('Data final menor que data inicial!');
    }else{  

      if (dataIni != '' && dataFim != '' && usuarios != null){
        $.ajax({
          url: 'busca_rel.php',
          type: "POST",
          data: {tipo:tipo, dataIni:dataIni, dataFim:dataFim, usuarios:usuarios},
          success: function(data) {
                    //alert(data);
                    if (data) {
                      $('#divBuscaPorDataUser').html(data);

                    } 
                    desenhaGraficoDataUser();
                    google.charts.setOnLoadCallback(desenhaGraficoData);
                  }
                });
        return false
        ;      }else{
          alert("Preencha o todos os campos!")
        } 
      }
    });




 });
 

 google.charts.load('current', {'packages':['corechart']});
 google.charts.setOnLoadCallback(desenhaGraficoGeral); 

 function desenhaGraficoGeral() {

  var data = google.visualization.arrayToDataTable([
    ['Task', 'Hours per Day'],
    <?php 
    echo "['Fechados',".$arrayFechada[0]['total']."],";
    echo "['Abertos',".$arrayAberto[0]['total']."],";
    echo "['Em Atendimento',".$arrayEmAtendimento[0]['total']."],";
    ?>
    ]);

  var options = {
    title: 'Total Status Demandas'
  };

  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

  chart.draw(data, options);
}

function desenhaGraficoData() {
  var fechadas = $('#fechadas').text();
  var abertas = $('#abertas').text();
  var emAtendimento = $('#emAtendimento').text();
    //alert(fechadas);

    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],    
      ['Fechados', parseInt(fechadas)],
      ['Abertos', parseInt(abertas)],
      ['Em atendimento', parseInt(emAtendimento)],

      ]);

    var options = {
      title: 'Por Departamentos'
    };

    var chart = new google.visualization.PieChart(document.getElementById('grafico'));

    chart.draw(data, options);
  }

  function desenhaGraficoDataUser() {
  var fechadas = $('#fechadasUsuarios').text();
  var abertas = $('#abertasUsuarios').text();
  var emAtendimento = $('#emAtendimentoUsuarios').text();
    //alert(fechadas);

    var data = google.visualization.arrayToDataTable([
      ['Task', 'Hours per Day'],    
      ['Fechados', parseInt(fechadas)],
      ['Abertos', parseInt(abertas)],
      ['Em atendimento', parseInt(emAtendimento)],

      ]);

    var options = {
      title: 'Por Usuários'
    };

    var chart = new google.visualization.PieChart(document.getElementById('graficoUser'));

    chart.draw(data, options);
  }

</script>


